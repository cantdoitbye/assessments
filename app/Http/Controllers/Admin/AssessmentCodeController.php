<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentCode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class AssessmentCodeController extends Controller
{
    public function index(Assessment $assessment)
    {
        $codes = $assessment->assessmentCodes()
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.assessments.codes', compact('assessment', 'codes'));
    }

    public function storeCode(Request $request, Assessment $assessment)
    {
        $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                'alpha_num',
                Rule::unique('assessment_codes', 'code')
            ],
            'description' => 'nullable|string|max:255',
            'max_usage' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $assessment->assessmentCodes()->create([
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'max_usage' => $request->max_usage,
            'expires_at' => $request->expires_at,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Access code created successfully!'
        ]);
    }

    public function toggleCode(AssessmentCode $code)
    {
        $code->update(['is_active' => !$code->is_active]);

        return response()->json([
            'success' => true,
            'status' => $code->is_active,
            'message' => 'Code status updated successfully!'
        ]);
    }

    public function destroyCode(AssessmentCode $code)
    {
        $code->delete();

        return response()->json([
            'success' => true,
            'message' => 'Access code deleted successfully!'
        ]);
    }
}
