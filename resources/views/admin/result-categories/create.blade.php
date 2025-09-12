@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.assessments.index') }}">Assessments</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.result-categories.index', $assessment) }}">{{ $assessment->title }}</a></li>
                <li class="breadcrumb-item active">Create Category</li>
            </ol>
        </nav>
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title fw-bold">Create Result Category</h1>
            <a href="{{ route('admin.result-categories.index', $assessment) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Categories
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Category Details</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.result-categories.store', $assessment) }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" 
                               placeholder="e.g., Assertive, Passive, Systematic">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="code" class="form-label">Category Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" 
                               id="code" name="code" value="{{ old('code') }}" 
                               placeholder="e.g., ASSE, PASS, SYS" maxlength="10" style="text-transform: uppercase;">
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Short code for scoring calculations (max 10 characters)</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="Describe what this category represents...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="order" class="form-label">Display Order <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('order') is-invalid @enderror" 
                               id="order" name="order" value="{{ old('order', $assessment->resultCategories()->count() + 1) }}" 
                               min="1" placeholder="Order for display">
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Create Category
                        </button>
                        <a href="{{ route('admin.result-categories.index', $assessment) }}" class="btn btn-outline-secondary">
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
                    <small class="text-muted">Current Categories:</small>
                    <span class="badge bg-primary">{{ $assessment->resultCategories()->count() }}</span>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Category Examples</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Assertiveness Test:</strong>
                    <ul class="list-unstyled ms-3 mt-1">
                        <li><small><code>ASSE</code> - Assertive</small></li>
                        <li><small><code>PASS</code> - Passive</small></li>
                        <li><small><code>AGGR</code> - Aggressive</small></li>
                        <li><small><code>PAGG</code> - Passive Aggressive</small></li>
                    </ul>
                </div>
                <div class="mb-3">
                    <strong>Decision Style:</strong>
                    <ul class="list-unstyled ms-3 mt-1">
                        <li><small><code>SYS</code> - Systematic</small></li>
                        <li><small><code>INT</code> - Intuitive</small></li>
                        <li><small><code>DEP</code> - Dependent</small></li>
                        <li><small><code>AVO</code> - Avoidant</small></li>
                        <li><small><code>SPO</code> - Spontaneous</small></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('code').addEventListener('input', function() {
    this.value = this.value.toUpperCase();
});
</script>
@endsection