<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\UserAssessment;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function show(Assessment $assessment)
    {
        if ($assessment->status !== 'active') {
            abort(404);
        }

        return view('assessments.show', compact('assessment'));
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

    private function complete(Assessment $assessment)
    {
        $session = session()->get('assessment_' . $assessment->id);
        
        // Calculate scores
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

        // Save to database
        $userAssessment = UserAssessment::create([
            'user_id' => auth()->id(),
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

        return redirect()->route('assessments.result', $userAssessment);
    }

    public function result(UserAssessment $userAssessment)
    {
        $resultCategory = $userAssessment->assessment->resultCategories()
            ->where('name', $userAssessment->final_result)
            ->first();

        return view('assessments.result', compact('userAssessment', 'resultCategory'));
    }
}
