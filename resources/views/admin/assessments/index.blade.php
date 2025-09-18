@extends('admin.layout.app')

@section('title', 'Manage Assessments')
@section('page-title', 'Manage Assessments')

@section('content')
<div class="row mb-3">
    <div class="col">
        <a href="{{ route('admin.assessments.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Create Assessment
        </a>
    </div>
</div>

@if($assessments->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-clipboard-x display-1 text-muted mb-3"></i>
            <h5 class="text-muted">No assessments yet</h5>
            <p class="text-muted">Get started by creating your first assessment.</p>
            <a href="{{ route('admin.assessments.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                Create Assessment
            </a>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">All Assessments</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ASSESSMENT</th>
                        <th>QUESTIONS</th>
                        <th>SUBMISSIONS</th>
                        <th>STATUS</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assessments as $assessment)
                        <tr>
                            <td>
                                <div>
                                    <strong class="text-dark">{{ $assessment->title }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $assessment->slug }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $assessment->questions_count }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $assessment->user_assessments_count }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $assessment->status === 'active' ? 'badge-status-active' : 'badge-status-inactive' }}">
                                    {{ ucfirst($assessment->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.assessments.show', $assessment) }}" 
                                       class="btn btn-outline-primary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.assessments.edit', $assessment) }}" 
                                       class="btn btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('admin.assessments.export', $assessment) }}" 
                                       class="btn btn-outline-success" title="Export">
                                        <i class="bi bi-download"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection