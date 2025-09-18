@extends('admin.layout.app')

@section('title', $assessment->title . ' - Submissions')
@section('page-title')
    {{ $assessment->title }}
    <small class="text-muted">- Submissions</small>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-clipboard-check display-4 text-primary mb-2"></i>
                <h5 class="card-title">{{ $assessment->questions()->count() }}</h5>
                <p class="card-text text-muted">Total Questions</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-people display-4 text-info mb-2"></i>
                <h5 class="card-title">{{ $submissions->total() }}</h5>
                <p class="card-text text-muted">Total Submissions</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-tags display-4 text-warning mb-2"></i>
                <h5 class="card-title">{{ $assessment->resultCategories()->count() }}</h5>
                <p class="card-text text-muted">Categories</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-activity display-4 text-success mb-2"></i>
                <h5 class="card-title">{{ ucfirst($assessment->status) }}</h5>
                <p class="card-text text-muted">Status</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col">
        <a href="{{ route('admin.assessments.export', $assessment) }}" class="btn btn-success">
            <i class="bi bi-download me-1"></i>
            Export CSV
        </a>
        <a href="{{ route('admin.assessments.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to List
        </a>
    </div>
</div>

@if($submissions->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-inbox display-1 text-muted mb-3"></i>
            <h5 class="text-muted">No submissions yet</h5>
            <p class="text-muted">Submissions will appear here once users complete the assessment.</p>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Recent Submissions</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>USER</th>
                        <th>FINAL RESULT</th>
                        <th>SCORES</th>
                        <th>COMPLETED</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($submissions as $submission)
                        <tr>
                            <td>
                                <div>
                                    <strong class="text-dark">{{ $submission->user->name ?? 'Guest User' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $submission->user->email ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $submission->final_result }}</span>
                            </td>
                            <td>
                                <div class="small">
                                    @foreach($submission->result_json as $category => $score)
                                        <span class="badge bg-light text-dark me-1 mb-1">
                                            {{ Str::limit($category, 15) }}: {{ $score }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <small class="text-muted">{{ $submission->created_at->format('M j, Y H:i') }}</small>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($submissions->hasPages())
            <div class="card-footer">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>
@endif
@endsection