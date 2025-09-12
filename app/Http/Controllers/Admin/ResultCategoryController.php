<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\ResultCategory;
use Illuminate\Http\Request;

class ResultCategoryController extends Controller
{
   

    public function index(Assessment $assessment)
    {
        $categories = $assessment->resultCategories()->orderBy('order')->get();
        return view('admin.result-categories.index', compact('assessment', 'categories'));
    }

    public function create(Assessment $assessment)
    {
        return view('admin.result-categories.create', compact('assessment'));
    }

    public function store(Request $request, Assessment $assessment)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:result_categories,code,NULL,id,assessment_id,' . $assessment->id,
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
        ]);

        $assessment->resultCategories()->create($request->all());

        return redirect()->route('admin.result-categories.index', $assessment)
            ->with('success', 'Result category created successfully.');
    }

    public function edit(Assessment $assessment, ResultCategory $resultCategory)
    {
        return view('admin.result-categories.edit', compact('assessment', 'resultCategory'));
    }

    public function update(Request $request, Assessment $assessment, ResultCategory $resultCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:result_categories,code,' . $resultCategory->id . ',id,assessment_id,' . $assessment->id,
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
        ]);

        $resultCategory->update($request->all());

        return redirect()->route('admin.result-categories.index', $assessment)
            ->with('success', 'Result category updated successfully.');
    }

    public function destroy(Assessment $assessment, ResultCategory $resultCategory)
    {
        $resultCategory->delete();

        return redirect()->route('admin.result-categories.index', $assessment)
            ->with('success', 'Result category deleted successfully.');
    }
}