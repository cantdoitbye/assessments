@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title fw-bold">Assessments</h1>
            <a href="{{ route('admin.assessments.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Create Assessment
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($assessments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Questions</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assessments as $assessment)
                                    <tr>
                                        <td>
                                            <strong>{{ $assessment->title }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ Str::limit($assessment->description, 60) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $assessment->questions_count }} questions</span>
                                        </td>
                                        <td>
                                            @if($assessment->status === 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $assessment->created_at->format('M d, Y') }}</small>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.assessments.show', $assessment) }}" 
                                                   class="btn btn-outline-info" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.questions.index', $assessment) }}" 
                                                   class="btn btn-outline-primary" title="Questions">
                                                    <i class="bi bi-question-circle"></i>
                                                </a>
                                                <a href="{{ route('admin.assessments.edit', $assessment) }}" 
                                                   class="btn btn-outline-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.assessments.destroy', $assessment) }}" 
                                                      class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $assessments->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-journal-text display-1 text-muted"></i>
                        <h4 class="mt-3 text-muted">No assessments found</h4>
                        <p class="text-muted">Create your first assessment to get started.</p>
                        <a href="{{ route('admin.assessments.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Create Assessment
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection