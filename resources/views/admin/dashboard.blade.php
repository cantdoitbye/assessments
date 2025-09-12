@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title fw-bold">Dashboard</h1>
            <span class="text-muted">Welcome back, {{ auth()->user()->name }}!</span>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Stats Cards -->
    <div class="col-md-6 col-xl-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-white-50">Total Assessments</h6>
                        <h2 class="mb-0">{{ \App\Models\Assessment::count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-journal-text fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-xl-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-white-50">Active Assessments</h6>
                        <h2 class="mb-0">{{ \App\Models\Assessment::where('status', 'active')->count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-check-circle fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-xl-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-white-50">Total Questions</h6>
                        <h2 class="mb-0">{{ \App\Models\Question::count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-question-circle fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-xl-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-white-50">Total Options</h6>
                        <h2 class="mb-0">{{ \App\Models\Option::count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-list-ul fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Assessments</h5>
            </div>
            <div class="card-body">
                @php
                    $recent_assessments = \App\Models\Assessment::with('questions')->latest()->take(5)->get();
                @endphp
                
                @if($recent_assessments->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recent_assessments as $assessment)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $assessment->title }}</h6>
                                    <small class="text-muted">{{ $assessment->questions_count }} questions</small>
                                </div>
                                <div>
                                    {!! $assessment->status_badge !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">No assessments yet. <a href="{{ route('admin.assessments.create') }}">Create your first assessment</a></p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.assessments.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Create Assessment
                    </a>
                    <a href="{{ route('admin.assessments.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-journal-text me-2"></i>View All Assessments
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection