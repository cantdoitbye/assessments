<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
   

    public function index(Assessment $assessment)
    {
        $questions = $assessment->questions()->with('options')->get();
        return view('admin.questions.index', compact('assessment', 'questions'));
    }

    public function create(Assessment $assessment)
    {
        return view('admin.questions.create', compact('assessment'));
    }

    public function store(Request $request, Assessment $assessment)
    {
        $request->validate([
            'question_text' => 'required|string',
            'type' => 'required|in:true_false,likert_3,likert_5,likert_7,multiple_choice,situational_choice',
            'order' => 'required|integer|min:0',
        ]);

        $question = $assessment->questions()->create($request->all());

        // Auto-generate options for structured types
        if (in_array($question->type, ['true_false', 'likert_3', 'likert_5', 'likert_7'])) {
            $question->generateDefaultOptions();
            
            return redirect()->route('admin.options.index', [$assessment, $question])
                ->with('success', 'Question created with default options. Please configure scoring.');
        }

        return redirect()->route('admin.questions.index', $assessment)
            ->with('success', 'Question created successfully.');
    }

    public function edit(Assessment $assessment, Question $question)
    {
        return view('admin.questions.edit', compact('assessment', 'question'));
    }

    public function update(Request $request, Assessment $assessment, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string',
            'type' => 'required|in:true_false,likert_3,likert_5,likert_7,multiple_choice,situational_choice',
            'order' => 'required|integer|min:0',
        ]);

        $question->update($request->all());

        return redirect()->route('admin.questions.index', $assessment)
            ->with('success', 'Question updated successfully.');
    }

    public function destroy(Assessment $assessment, Question $question)
    {
        $question->delete();

        return redirect()->route('admin.questions.index', $assessment)
            ->with('success', 'Question deleted successfully.');
    }
}