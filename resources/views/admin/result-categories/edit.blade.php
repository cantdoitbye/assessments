@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.assessments.index') }}">Assessments</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.result-categories.index', $assessment) }}">{{ $assessment->title }}</a></li>
                <li class="breadcrumb-item active">Edit Category</li>
            </ol>
        </nav>
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title fw-bold">Edit Result Category</h1>
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
                <form method="POST" action="{{ route('admin.result-categories.update', [$assessment, $resultCategory]) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $resultCategory->name) }}" 
                               placeholder="e.g., Assertive, Passive, Systematic">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="code" class="form-label">Category Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" 
                               id="code" name="code" value="{{ old('code', $resultCategory->code) }}" 
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
                                  placeholder="Describe what this category represents...">{{ old('description', $resultCategory->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="order" class="form-label">Display Order <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('order') is-invalid @enderror" 
                               id="order" name="order" value="{{ old('order', $resultCategory->order) }}" 
                               min="1" placeholder="Order for display">
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Update Category
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
                <h6 class="mb-0">Current Values</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <small class="text-muted">Current Name:</small><br>
                        <strong>{{ $resultCategory->name }}</strong>
                    </div>
                    <div class="col-12">
                        <small class="text-muted">Current Code:</small><br>
                        <code class="bg-primary text-white px-2 py-1 rounded">{{ $resultCategory->code }}</code>
                    </div>
                    <div class="col-12">
                        <small class="text-muted">Current Order:</small><br>
                        <span class="badge bg-light text-dark">#{{ $resultCategory->order }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Warning</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Changing the code will affect all existing option scoring configurations in this assessment.
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