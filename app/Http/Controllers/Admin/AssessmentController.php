<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
   public function index()
    {
        $assessments = Assessment::withCount(['questions', 'userAssessments'])->get();
        return view('admin.assessments.index', compact('assessments'));
    }

    public function show(Assessment $assessment)
    {
        $submissions = $assessment->userAssessments()
            ->with('user')
            ->latest()
            ->paginate(20);
            
        return view('admin.assessments.show', compact('assessment', 'submissions'));
    }

    public function export(Assessment $assessment)
    {
        $submissions = $assessment->userAssessments()->with('user')->get();
        
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $assessment->slug . '-results.csv',
        ];

        $callback = function() use ($submissions) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, ['ID', 'User', 'Email', 'Final Result', 'Scores', 'Completed At']);
            
            foreach ($submissions as $submission) {
                fputcsv($file, [
                    $submission->id,
                    $submission->user->name ?? 'Guest',
                    $submission->user->email ?? 'N/A',
                    $submission->final_result,
                    json_encode($submission->result_json),
                    $submission->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}