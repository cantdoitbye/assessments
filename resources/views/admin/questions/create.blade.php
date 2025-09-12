@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.assessments.index') }}">Assessments</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.questions.index', $assessment) }}">{{ $assessment->title }}</a></li>
                <li class="breadcrumb-item active">Create Question</li>
            </ol>
        </nav>
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title fw-bold">Create Question</h1>
            <a href="{{ route('admin.questions.index', $assessment) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Questions
            </a>
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
                <form method="POST" action="{{ route('admin.questions.store', $assessment) }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="question_text" class="form-label">Question Text <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('question_text') is-invalid @enderror" 
                                  id="question_text" name="question_text" rows="3" 
                                  placeholder="Enter your question">{{ old('question_text') }}</textarea>
                        @error('question_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="type" class="form-label">Question Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                            <option value="">Select question type</option>
                            <option value="true_false" {{ old('type') == 'true_false' ? 'selected' : '' }}>True/False</option>
                            <option value="likert_3" {{ old('type') == 'likert_3' ? 'selected' : '' }}>Likert Scale (1-3)</option>
                            <option value="likert_5" {{ old('type') == 'likert_5' ? 'selected' : '' }}>Likert Scale (1-5)</option>
                            <option value="likert_7" {{ old('type') == 'likert_7' ? 'selected' : '' }}>Likert Scale (1-7)</option>
                            <option value="multiple_choice" {{ old('type') == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                            <option value="situational_choice" {{ old('type') == 'situational_choice' ? 'selected' : '' }}>Situational Choice</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Structured types (True/False, Likert) will auto-generate options</div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="order" class="form-label">Order/Position <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('order') is-invalid @enderror" 
                               id="order" name="order" value="{{ old('order', $assessment->questions()->count() + 1) }}" 
                               min="1" placeholder="Question order">
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">This determines the order in which questions appear in the assessment.</div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Create Question
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
                <h6 class="mb-0">Assessment Info</h6>
            </div>
            <div class="card-body">
                <h6 class="mb-2">{{ $assessment->title }}</h6>
                <p class="text-muted small">{{ Str::limit($assessment->description, 100) }}</p>
                <hr>
                <div class="d-flex justify-content-between">
                    <small class="text-muted">Current Questions:</small>
                    <span class="badge bg-primary">{{ $assessment->questions()->count() }}</span>
                </div>
                <div class="d-flex justify-content-between mt-1">
                    <small class="text-muted">Result Categories:</small>
                    <span class="badge bg-info">{{ $assessment->resultCategories()->count() }}</span>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Question Types</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <strong>True/False:</strong><br>
                        <small class="text-muted">Binary choice questions. Auto-generates True/False options.</small>
                    </li>
                    <li class="mb-2">
                        <strong>Likert Scales:</strong><br>
                        <small class="text-muted">Rating scales (1-3, 1-5, 1-7). Auto-generates numbered options.</small>
                    </li>
                    <li class="mb-2">
                        <strong>Multiple Choice:</strong><br>
                        <small class="text-muted">Custom options. You'll create options manually.</small>
                    </li>
                    <li class="mb-2">
                        <strong>Situational Choice:</strong><br>
                        <small class="text-muted">Scenario-based with custom response options.</small>
                    </li>
                </ul>
            </div>
        </div>

        @if($assessment->resultCategories()->count() == 0)
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0 text-warning">Setup Required</h6>
            </div>
            <div class="card-body">
                <p class="small text-muted">Create result categories first to enable scoring configuration.</p>
                <a href="{{ route('admin.result-categories.index', $assessment) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-tags me-1"></i>Create Categories
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
document.getElementById('type').addEventListener('change', function() {
    const structuredTypes = ['true_false', 'likert_3', 'likert_5', 'likert_7'];
    const helpText = document.querySelector('.form-text');
    
    if (structuredTypes.includes(this.value)) {
        helpText.innerHTML = 'This type will auto-generate options. You can configure scoring afterwards.';
        helpText.className = 'form-text text-info';
    } else {
        helpText.innerHTML = 'You will need to create options manually for this question type.';
        helpText.className = 'form-text';
    }
});
</script>
@endsection