<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\UserAssessment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'admin']);
    // }

    public function dashboard()
    {

          $stats = [
            'total_assessments' => Assessment::count(),
            'total_submissions' => UserAssessment::count(),
            'recent_submissions' => UserAssessment::with(['user', 'assessment'])
                ->latest()
                ->take(10)
                ->get(),
            'assessment_stats' => Assessment::withCount('userAssessments')
                ->orderByDesc('user_assessments_count')
                ->take(5)
                ->get(),
        ];
        return view('admin.dashboard', $stats);
    }
}