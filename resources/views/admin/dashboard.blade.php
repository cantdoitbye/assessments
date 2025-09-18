@extends('admin.layout.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="bi bi-clipboard-check display-4 me-3"></i>
                    <div>
                        <h5 class="card-title">{{ $total_assessments }}</h5>
                        <p class="card-text">Total Assessments</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="bi bi-people display-4 me-3"></i>
                    <div>
                        <h5 class="card-title">{{ $total_submissions }}</h5>
                        <p class="card-text">Total Submissions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="bi bi-calendar-day display-4 me-3"></i>
                    <div>
                        <h5 class="card-title">{{ $recent_submissions->where('created_at', '>=', today())->count() }}</h5>
                        <p class="card-text">Today's Submissions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="bi bi-calendar-week display-4 me-3"></i>
                    <div>
                        <h5 class="card-title">{{ $recent_submissions->where('created_at', '>=', now()->startOfWeek())->count() }}</h5>
                        <p class="card-text">This Week</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Assessment Performance</h6>
            </div>
            <div class="card-body">
                @if($assessment_stats->isEmpty())
                    <p class="text-muted text-center py-3">No assessment data available</p>
                @else
                    @foreach($assessment_stats as $assessment)
                        <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div>
                                <h6 class="mb-1">{{ Str::limit($assessment->title, 35) }}</h6>
                                <small class="text-muted">{{ $assessment->slug }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-primary">{{ $assessment->user_assessments_count }} submissions</span>
                                <br>
                                <a href="{{ route('admin.assessments.show', $assessment) }}" 
                                   class="btn btn-sm btn-outline-primary mt-1">View</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.assessments.index') }}" class="btn btn-sm btn-primary">
                    View all assessments <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Recent Submissions</h6>
            </div>
            <div class="card-body">
                @if($recent_submissions->isEmpty())
                    <p class="text-muted text-center py-3">No recent submissions</p>
                @else
                    @foreach($recent_submissions as $submission)
                        <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div>
                                <h6 class="mb-1">{{ $submission->user->name ?? 'Guest User' }}</h6>
                                <small class="text-muted">{{ Str::limit($submission->assessment->title, 30) }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success">{{ $submission->final_result }}</span>
                                <br>
                                <small class="text-muted">{{ $submission->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- <div class="col-md-4">
                        <a href="{{ route('admin.assessments.create') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="bi bi-plus-circle display-6 d-block mb-2"></i>
                            <strong>Create Assessment</strong>
                            <br>
                            <small>Add a new assessment</small>
                        </a>
                    </div> --}}
                    <div class="col-md-4">
                        <a href="{{ route('admin.assessments.index') }}" class="btn btn-outline-success w-100 py-3">
                            <i class="bi bi-gear display-6 d-block mb-2"></i>
                            <strong>Manage Assessments</strong>
                            <br>
                            <small>View and edit assessments</small>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/assessments/assertiveness-self-assessment" class="btn btn-outline-info w-100 py-3">
                            <i class="bi bi-eye display-6 d-block mb-2"></i>
                            <strong>Preview Assessment</strong>
                            <br>
                            <small>Test user experience</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection