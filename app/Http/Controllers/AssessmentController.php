<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentCode;
use App\Models\UserAssessment;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function show(Assessment $assessment, Request $request)
    {
        if ($assessment->status !== 'active') {
            abort(404);
        }

         // Check if assessment requires access code
        if ($assessment->activeAssessmentCodes()->exists()) {
            // If no code provided or invalid code, show code entry form
            if (!$request->has('access_code') || !$this->validateAccessCode($request->access_code, $assessment)) {
                return view('assessments.access-code', compact('assessment'));
            }
            
            // Store valid code in session for this assessment
            session()->put('valid_access_code_' . $assessment->id, $request->access_code);
        }

        return view('assessments.show', compact('assessment'));
    }

    public function verifyCode(Request $request, Assessment $assessment)
    {
        $request->validate([
              'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|max:255',
            'access_code' => 'required|string'
        ]);

       
        $code = AssessmentCode::findValidCode($request->access_code, $assessment->id);

        if (!$code) {
            return back()->withErrors([
                'access_code' => 'Invalid or expired access code.'
            ])->withInput();
        }

          // Store user info in session for later use when completing assessment
        session()->put('user_info_' . $assessment->id, [
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
        ]);

        // Redirect to assessment with code parameter
        return redirect()->route('assessments.show', [
            'assessment' => $assessment,
            'access_code' => $request->access_code
        ]);
    }

    public function start(Assessment $assessment)
    {
        $firstQuestion = $assessment->questions()->first();
        
        if (!$firstQuestion) {
            return redirect()->route('assessments.show', $assessment)
                ->with('error', 'This assessment has no questions yet.');
        }

        // Start new assessment session
        session()->put('assessment_' . $assessment->id, [
            'current_question' => 1,
            'answers' => [],
            'started_at' => now(),
        ]);

        return redirect()->route('assessments.question', [$assessment, 1]);
    }

    public function question(Assessment $assessment, $questionNumber)
    {
        $session = session()->get('assessment_' . $assessment->id);
        
        if (!$session || $questionNumber != $session['current_question']) {
            return redirect()->route('assessments.show', $assessment);
        }

        $question = $assessment->questions()->where('order', $questionNumber)->first();
        
        if (!$question) {
            abort(404);
        }

        $totalQuestions = $assessment->questions()->count();

        return view('assessments.question', compact('assessment', 'question', 'questionNumber', 'totalQuestions'));
    }

    public function answer(Request $request, Assessment $assessment, $questionNumber)
    {
        $request->validate([
            'option_id' => 'required|exists:options,id',
        ]);

        $session = session()->get('assessment_' . $assessment->id, []);
        
        // Store answer
        $session['answers'][$questionNumber] = $request->option_id;
        
        $totalQuestions = $assessment->questions()->count();
        
        if ($questionNumber < $totalQuestions) {
            // Next question
            $session['current_question'] = $questionNumber + 1;
            session()->put('assessment_' . $assessment->id, $session);
            
            return redirect()->route('assessments.question', [$assessment, $questionNumber + 1]);
        } else {
            // Complete assessment
            session()->put('assessment_' . $assessment->id, $session);
            return $this->complete($assessment);
        }
    }

      private function validateAccessCode(string $code, Assessment $assessment): bool
    {
        $codeModel = AssessmentCode::findValidCode($code, $assessment->id);
        return $codeModel !== null;
    }
    // private function complete(Assessment $assessment)
    // {
    //     $session = session()->get('assessment_' . $assessment->id);
    //             $userInfo = session()->get('user_info_' . $assessment->id, []);

        
    //     // Calculate scores
    //     $categoryScores = [];
    //     $categories = $assessment->resultCategories;
        
    //     // Initialize scores
    //     foreach ($categories as $category) {
    //         $categoryScores[$category->name] = 0;
    //     }

    //     // Calculate scores from answers
    //     foreach ($session['answers'] as $questionNumber => $optionId) {
    //         $option = \App\Models\Option::find($optionId);
    //         if ($option && $option->score_map) {
    //             foreach ($option->score_map as $category => $score) {
    //                 if (isset($categoryScores[$category])) {
    //                     $categoryScores[$category] += $score;
    //                 }
    //             }
    //         }
    //     }

    //     // Find dominant category
    //     $finalResult = array_keys($categoryScores, max($categoryScores))[0];

    //     // Save to database
    //     $userAssessment = UserAssessment::create([
    //         'user_id' => auth()->id(),
    //         'user_name' => $userInfo['user_name'] ?? null,
    //         'user_email' => $userInfo['user_email'] ?? null,
    //         'assessment_id' => $assessment->id,
    //         'result_json' => $categoryScores,
    //         'final_result' => $finalResult,
    //     ]);

    //     // Save individual answers
    //     foreach ($session['answers'] as $questionNumber => $optionId) {
    //         \App\Models\UserAnswer::create([
    //             'user_assessment_id' => $userAssessment->id,
    //             'question_id' => $assessment->questions()->where('order', $questionNumber)->first()->id,
    //             'option_id' => $optionId,
    //         ]);
    //     }

    //     // Clear session
    //     session()->forget('assessment_' . $assessment->id);
    //             session()->forget('user_info_' . $assessment->id);

    //     return redirect()->route('assessments.result', $userAssessment);
    // }

    private function complete(Assessment $assessment)
{
    $session = session()->get('assessment_' . $assessment->id);
    $userInfo = session()->get('user_info_' . $assessment->id, []);

    // SPECIAL HANDLING FOR BRAIN DOMINANCE TEST
    if ($assessment->slug === 'brain-dominance-test') {
        $leftScore = 0;
        $rightScore = 0;
        
        // Calculate left and right brain scores
        foreach ($session['answers'] as $questionNumber => $optionId) {
            $option = \App\Models\Option::find($optionId);
            if ($option && $option->score_map) {
                $leftScore += $option->score_map['Left'] ?? 0;
                $rightScore += $option->score_map['Right'] ?? 0;
            }
        }
        
        // Determine category based on scoring rules
        if ($leftScore >= 24) {
            $finalResult = 'Strong Left-Brain';
        } elseif ($leftScore >= 18) {
            $finalResult = 'Moderate Left-Brain';
        } elseif ($leftScore >= 14 && $rightScore >= 14) {
            $finalResult = 'Balanced/Whole-Brain';
        } elseif ($rightScore >= 18) {
            $finalResult = 'Moderate Right-Brain';
        } else {
            $finalResult = 'Strong Right-Brain';
        }
        
        $categoryScores = [
            'Left' => $leftScore,
            'Right' => $rightScore
        ];
        
    } 
    // SPECIAL HANDLING FOR TEMPERAMENT BLOCKS TO CREATIVITY
    elseif ($assessment->slug === 'temperament-blocks-creativity') {
        $categoryScores = [
            'AA' => 0,
            'C' => 0,
            'R/S' => 0,
            'FF' => 0,
            'SS' => 0,
            'RM' => 0,
            'T' => 0,
        ];
        
        // Calculate raw scores for each category
        foreach ($session['answers'] as $questionNumber => $optionId) {
            $option = \App\Models\Option::find($optionId);
            if ($option && $option->score_map) {
                foreach ($option->score_map as $category => $score) {
                    if (isset($categoryScores[$category])) {
                        $categoryScores[$category] += $score;
                    }
                }
            }
        }
        
        // Convert to percentages based on reference tables
        $percentageScores = [];
        $interpretations = [];
        
        foreach ($categoryScores as $category => $rawScore) {
            if ($category === 'SS') {
                // SS has different percentage table (10 questions, max 40)
                $percentageScores[$category] = $this->getSSPercentage($rawScore);
            } else {
                // Other categories (5 questions each, max 20)
                $percentageScores[$category] = $this->getStandardPercentage($rawScore);
            }
            
            // Get interpretation based on percentage
            $interpretations[$category] = $this->getInterpretation($percentageScores[$category]);
        }
        
        // Store both raw scores and percentages
        $categoryScores = [
            'raw' => $categoryScores,
            'percentages' => $percentageScores,
            'interpretations' => $interpretations
        ];
        
        // Final result is the category with highest percentage (for summary)
        $maxPercentage = max($percentageScores);
        $finalResult = array_search($maxPercentage, $percentageScores);
        
    }
    else {
        // STANDARD SCORING FOR ALL OTHER ASSESSMENTS
        $categoryScores = [];
        $categories = $assessment->resultCategories;
        
        // Initialize scores
        foreach ($categories as $category) {
            $categoryScores[$category->name] = 0;
        }

        // Calculate scores from answers
        foreach ($session['answers'] as $questionNumber => $optionId) {
            $option = \App\Models\Option::find($optionId);
            if ($option && $option->score_map) {
                foreach ($option->score_map as $category => $score) {
                    if (isset($categoryScores[$category])) {
                        $categoryScores[$category] += $score;
                    }
                }
            }
        }

        // Find dominant category
        $finalResult = array_keys($categoryScores, max($categoryScores))[0];
    }

    // Save to database
    $userAssessment = UserAssessment::create([
        'user_id' => auth()->id(),
        'user_name' => $userInfo['user_name'] ?? null,
        'user_email' => $userInfo['user_email'] ?? null,
        'assessment_id' => $assessment->id,
        'result_json' => $categoryScores,
        'final_result' => $finalResult,
    ]);

    // Save individual answers
    foreach ($session['answers'] as $questionNumber => $optionId) {
        \App\Models\UserAnswer::create([
            'user_assessment_id' => $userAssessment->id,
            'question_id' => $assessment->questions()->where('order', $questionNumber)->first()->id,
            'option_id' => $optionId,
        ]);
    }

    // Clear session
    session()->forget('assessment_' . $assessment->id);
    session()->forget('user_info_' . $assessment->id);

    return redirect()->route('assessments.result', $userAssessment);
}




    public function result(UserAssessment $userAssessment)
    {
        $resultCategory = $userAssessment->assessment->resultCategories()
            ->where('name', $userAssessment->final_result)
            ->first();


               // Custom view for conflict management
    if ($userAssessment->assessment->slug === 'conflict-management-style') {
        return view('assessments.conflict-result', compact('userAssessment', 'resultCategory'));
    }

    // Custom view for brain dominance
    if ($userAssessment->assessment->slug === 'brain-dominance-test') {
        return view('assessments.brain-result', compact('userAssessment', 'resultCategory'));
    }

     // Custom view for temperament blocks
    if ($userAssessment->assessment->slug === 'temperament-blocks-creativity') {
        return view('assessments.temperament-result', compact('userAssessment'));
    }

            

        return view('assessments.result', compact('userAssessment', 'resultCategory'));
    }


    /**
 * Get percentage for standard categories (AA, C, R/S, FF, RM, T)
 * Max score: 20 (5 questions × 4 points)
 */
private function getStandardPercentage($score)
{
    $percentageTable = [
        5 => 0, 6 => 7, 7 => 13, 8 => 20, 9 => 27, 10 => 33,
        11 => 40, 12 => 47, 13 => 53, 14 => 60, 15 => 67, 16 => 73,
        17 => 80, 18 => 87, 19 => 93, 20 => 100
    ];
    
    return $percentageTable[$score] ?? 0;
}

/**
 * Get percentage for SS (Starved Sensibility)
 * Max score: 40 (10 questions × 4 points)
 */
private function getSSPercentage($score)
{
    $percentageTable = [
        10 => 0, 11 => 3, 12 => 7, 13 => 10, 14 => 15, 15 => 17,
        16 => 20, 17 => 23, 18 => 27, 19 => 30, 20 => 33, 21 => 37,
        22 => 40, 23 => 43, 24 => 47, 25 => 50, 26 => 53, 27 => 57,
        28 => 60, 29 => 63, 30 => 67, 31 => 70, 32 => 73, 33 => 77,
        34 => 80, 35 => 83, 36 => 87, 37 => 90, 38 => 93, 39 => 97,
        40 => 100
    ];
    
    return $percentageTable[$score] ?? 0;
}

/**
 * Get interpretation label based on percentage
 */
private function getInterpretation($percentage)
{
    if ($percentage >= 60) return 'Very High';
    if ($percentage >= 40) return 'High';
    if ($percentage >= 25) return 'Average';
    if ($percentage >= 15) return 'Low';
    return 'Very Low';
}
}
