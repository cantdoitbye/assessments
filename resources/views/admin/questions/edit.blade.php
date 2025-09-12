@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.assessments.index') }}">Assessments</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.questions.index', $assessment) }}">{{ $assessment->title }}</a></li>
                <li class="breadcrumb-item active">Edit Question</li>
            </ol>
        </nav>
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title fw-bold">Edit Question</h1>
            <div class="btn-group">
                <a href="{{ route('admin.options.index', [$assessment, $question]) }}" class="btn btn-outline-info">
                    <i class="bi bi-list-ul me-2"></i>Manage Options
                </a>
                <a href="{{ route('admin.questions.index', $assessment) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Question Details</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.questions.update', [$assessment, $question]) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="question_text" class="form-label">Question Text <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('question_text') is-invalid @enderror" 
                                  id="question_text" name="question_text" rows="3" 
                                  placeholder="Enter your question">{{ old('question_text', $question->question_text) }}</textarea>
                        @error('question_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="type" class="form-label">Question Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                            <option value="true_false" {{ old('type', $question->type) == 'true_false' ? 'selected' : '' }}>True/False</option>
                            <option value="likert_3" {{ old('type', $question->type) == 'likert_3' ? 'selected' : '' }}>Likert Scale (1-3)</option>
                            <option value="likert_5" {{ old('type', $question->type) == 'likert_5' ? 'selected' : '' }}>Likert Scale (1-5)</option>
                            <option value="likert_7" {{ old('type', $question->type) == 'likert_7' ? 'selected' : '' }}>Likert Scale (1-7)</option>
                            <option value="multiple_choice" {{ old('type', $question->type) == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                            <option value="situational_choice" {{ old('type', $question->type) == 'situational_choice' ? 'selected' : '' }}>Situational Choice</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($question->options->count() > 0)
                            <div class="form-text text-warning">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Changing type may affect existing options
                            </div>
                        @endif
                    </div>
                    
                    <div class="mb-4">
                        <label for="order" class="form-label">Order/Position <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('order') is-invalid @enderror" 
                               id="order" name="order" value="{{ old('order', $question->order) }}" 
                               min="1" placeholder="Question order">
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Update Question
                        </button>
                        <a href="{{ route('admin.questions.index', $assessment) }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Question Info</h6>
            </div>
            <div class="card-body">
                <div class="row g-3 text-center">
                    <div class="col-6">
                        <div class="p-2 bg-light rounded">
                            <div class="h5 text-primary mb-0">{{ $question->options->count() }}</div>
                            <small class="text-muted">Options</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 bg-light rounded">
                            <div class="h5 text-info mb-0">#{{ $question->order }}</div>
                            <small class="text-muted">Position</small>
                        </div>
                    </div>
                </div>
                <hr>
                <small class="text-muted">
                    <i class="bi bi-tag me-1"></i>
                    Type: {{ $question->type_display }}
                </small>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if(in_array($question->type, ['multiple_choice', 'situational_choice']) || $question->options->count() == 0)
                        <a href="{{ route('admin.options.create', [$assessment, $question]) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle me-2"></i>Add Option
                        </a>
                    @endif
                    <a href="{{ route('admin.options.index', [$assessment, $question]) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-list-ul me-2"></i>Manage Options
                    </a>
                </div>
            </div>
        </div>

        @if($question->options->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Current Options</h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach($question->options->take(3) as $option)
                        <div class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>{{ $option->option_text }}</span>
                                @if($option->value)
                                    <code class="small">{{ $option->value }}</code>
                                @endif
                            </div>
                            @if($option->scoring && collect($option->scoring)->sum() > 0)
                                <div class="mt-1">
                                    @foreach($option->scoring as $code => $score)
                                        @if($score > 0)
                                            <span class="badge bg-primary badge-sm">{{ $code }}:+{{ $score }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                    @if($question->options->count() > 3)
                        <div class="list-group-item px-0 py-2 text-center">
                            <small class="text-muted">... and {{ $question->options->count() - 3 }} more</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection