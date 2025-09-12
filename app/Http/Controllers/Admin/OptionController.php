<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
   

    public function index(Assessment $assessment, Question $question)
    {
        $options = $question->options()->get();
        return view('admin.options.index', compact('assessment', 'question', 'options'));
    }

    public function create(Assessment $assessment, Question $question)
    {
        return view('admin.options.create', compact('assessment', 'question'));
    }

    public function store(Request $request, Assessment $assessment, Question $question)
    {
        $request->validate([
            'option_text' => 'required|string|max:255',
            'value' => 'nullable|string|max:50',
            'order' => 'required|integer|min:1',
            'scoring' => 'required|array',
            'scoring.*' => 'integer|min:0|max:10',
        ]);

        // Ensure we have scoring for all categories
        $categoryScoring = [];
        foreach ($assessment->resultCategories as $category) {
            $categoryScoring[$category->code] = (int) ($request->scoring[$category->code] ?? 0);
        }

        $question->options()->create([
            'option_text' => $request->option_text,
            'value' => $request->value,
            'order' => $request->order,
            'scoring' => $categoryScoring,
        ]);

        return redirect()->route('admin.options.index', [$assessment, $question])
            ->with('success', 'Option created successfully with scoring configuration.');
    }

    public function edit(Assessment $assessment, Question $question, Option $option)
    {
        return view('admin.options.edit', compact('assessment', 'question', 'option'));
    }

    public function update(Request $request, Assessment $assessment, Question $question, Option $option)
    {
        $request->validate([
            'option_text' => 'required|string|max:255',
            'value' => 'nullable|string|max:50',
            'order' => 'required|integer|min:1',
            'scoring' => 'required|array',
            'scoring.*' => 'integer|min:0|max:10',
        ]);

        // Ensure we have scoring for all categories
        $categoryScoring = [];
        foreach ($assessment->resultCategories as $category) {
            $categoryScoring[$category->code] = (int) ($request->scoring[$category->code] ?? 0);
        }

        $option->update([
            'option_text' => $request->option_text,
            'value' => $request->value,
            'order' => $request->order,
            'scoring' => $categoryScoring,
        ]);

        return redirect()->route('admin.options.index', [$assessment, $question])
            ->with('success', 'Option updated successfully.');
    }

    public function destroy(Assessment $assessment, Question $question, Option $option)
    {
        $option->delete();

        return redirect()->route('admin.options.index', [$assessment, $question])
            ->with('success', 'Option deleted successfully.');
    }

    /**
     * Quick action to configure scoring for auto-generated options
     */
    public function quickScore(Assessment $assessment, Question $question)
    {
        $options = $question->options()->orderBy('order')->get();
        
        if ($options->isEmpty()) {
            return redirect()->route('admin.options.index', [$assessment, $question])
                ->with('error', 'No options found to configure scoring.');
        }

        return view('admin.options.quick-score', compact('assessment', 'question', 'options'));
    }

    /**
     * Save quick scoring configuration
     */
    public function saveQuickScore(Request $request, Assessment $assessment, Question $question)
    {
        $request->validate([
            'options' => 'required|array',
            'options.*.scoring' => 'required|array',
            'options.*.scoring.*' => 'integer|min:0|max:10',
        ]);

        foreach ($request->options as $optionId => $optionData) {
            $option = $question->options()->find($optionId);
            if ($option) {
                // Ensure we have scoring for all categories
                $categoryScoring = [];
                foreach ($assessment->resultCategories as $category) {
                    $categoryScoring[$category->code] = (int) ($optionData['scoring'][$category->code] ?? 0);
                }
                
                $option->update(['scoring' => $categoryScoring]);
            }
        }

        return redirect()->route('admin.options.index', [$assessment, $question])
            ->with('success', 'Scoring configuration saved for all options.');
    }
}