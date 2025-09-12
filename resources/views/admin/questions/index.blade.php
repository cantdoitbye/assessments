@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.assessments.index') }}">Assessments</a></li>
                <li class="breadcrumb-item active">{{ $assessment->title }} - Questions</li>
            </ol>
        </nav>
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title fw-bold">Questions for "{{ $assessment->title }}"</h1>
            <div class="btn-group">
                <a href="{{ route('admin.questions.create', $assessment) }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add Question
                </a>
                <a href="{{ route('admin.assessments.show', $assessment) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Assessment
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($questions->count() > 0)
                    @foreach($questions as $question)
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Question #{{ $question->order }}</h6>
                                        <small class="text-muted">{{ $question->type_display }}</small>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.options.index', [$assessment, $question]) }}" 
                                           class="btn btn-outline-info" title="Manage Options">
                                            <i class="bi bi-list-ul me-1"></i>Options ({{ $question->options->count() }})
                                        </a>
                                        <a href="{{ route('admin.questions.edit', [$assessment, $question]) }}" 
                                           class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.questions.destroy', [$assessment, $question]) }}" 
                                              class="d-inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="mb-3">{{ $question->question_text }}</p>
                                
                                @if($question->options->count() > 0)
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h6 class="text-muted mb-2">Options:</h6>
                                            <div class="list-group list-group-flush">
                                                @foreach($question->options as $option)
                                                    <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-0">
                                                        <span>{{ $option->option_text }}</span>
                                                        <div>
                                                            <span class="badge bg-primary me-2">Score: {{ number_format($option->score, 2) }}</span>
                                                            @if($option->trait)
                                                                <span class="badge bg-secondary">{{ $option->trait }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-center">
                                                <a href="{{ route('admin.options.create', [$assessment, $question]) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-plus me-1"></i>Add Option
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-3">
                                        <p class="text-muted mb-2">No options added yet.</p>
                                        <a href="{{ route('admin.options.create', [$assessment, $question]) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-plus-circle me-1"></i>Add First Option
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-question-circle display-1 text-muted"></i>
                        <h4 class="mt-3 text-muted">No questions found</h4>
                        <p class="text-muted">Add your first question to get started.</p>
                        <a href="{{ route('admin.questions.create', $assessment) }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Add Question
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection