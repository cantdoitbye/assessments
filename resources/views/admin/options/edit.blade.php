@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.assessments.index') }}">Assessments</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.questions.index', $assessment) }}">{{ $assessment->title }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.options.index', [$assessment, $question]) }}">Options</a></li>
                <li class="breadcrumb-item active">Edit Option</li>
            </ol>
        </nav>
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title fw-bold">Edit Option with Scoring</h1>
            <a href="{{ route('admin.options.index', [$assessment, $question]) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Options
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Option Details</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.options.update', [$assessment, $question, $option]) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="option_text" class="form-label">Option Text <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('option_text') is-invalid @enderror" 
                               id="option_text" name="option_text" value="{{ old('option_text', $option->option_text) }}" 
                               placeholder="Enter option text">
                        @error('option_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    @if(in_array($question->type, ['true_false', 'likert_3', 'likert_5', 'likert_7']))
                    <div class="mb-3">
                        <label for="value" class="form-label">Option Value</label>
                        <input type="text" class="form-control @error('value') is-invalid @enderror" 
                               id="value" name="value" value="{{ old('value', $option->value) }}" 
                               placeholder="e.g., true, false, 1, 2, 3">
                        @error('value')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">For structured question types (true/false: 'true'/'false', likert: '1','2','3')</div>
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="order" class="form-label">Display Order <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('order') is-invalid @enderror" 
                               id="order" name="order" value="{{ old('order', $option->order) }}" 
                               min="1" placeholder="Option order">
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Scoring Section -->
                    @if($assessment->resultCategories->count() > 0)
                    <div class="mb-4">
                        <label class="form-label">Category Scoring <span class="text-danger">*</span></label>
                        <div class="card">
                            <div class="card-header">
                                <small class="text-muted">Configure how much this option contributes to each category</small>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    @foreach($assessment->resultCategories as $category)
                                    <div class="col-md-6">
                                        <label for="scoring_{{ $category->code }}" class="form-label">
                                            <code>{{ $category->code }}</code> - {{ $category->name }}
                                        </label>
                                        <input type="number" class="form-control" 
                                               id="scoring_{{ $category->code }}" 
                                               name="scoring[{{ $category->code }}]" 
                                               value="{{ old('scoring.' . $category->code, $option->scoring[$category->code] ?? 0) }}" 
                                               min="0" max="10" step="1">
                                        <div class="form-text">Points added to {{ $category->name }} (0-10)</div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        No result categories found. <a href="{{ route('admin.result-categories.index', $assessment) }}">Create categories first</a> to enable scoring.
                    </div>
                    @endif
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" @if($assessment->resultCategories->count() == 0) disabled @endif>
                            <i class="bi bi-check-circle me-2"></i>Update Option
                        </button>
                        <a href="{{ route('admin.options.index', [$assessment, $question]) }}" class="btn btn-outline-secondary">
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
                <h6 class="mb-0">Current Scoring</h6>
            </div>
            <div class="card-body">
                @if($option->scoring && count($option->scoring) > 0)
                    <div class="row g-2">
                        @foreach($option->scoring as $categoryCode => $score)
                            @php
                                $category = $assessment->resultCategories->where('code', $categoryCode)->first();
                            @endphp
                            @if($category)
                            <div class="col-6">
                                <small class="text-muted">{{ $category->name }}:</small><br>
                                <span class="badge bg-primary">{{ $score }} points</span>
                            </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No scoring configured yet.</p>
                @endif
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Question Context</h6>
            </div>
            <div class="card-body">
                <h6 class="mb-2">{{ $question->question_text }}</h6>
                <span class="badge bg-light text-dark">{{ $question->type_display }}</span>
                @if($option->value)
                    <br><small class="text-muted">Value: <code>{{ $option->value }}</code></small>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection