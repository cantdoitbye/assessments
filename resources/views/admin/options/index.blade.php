@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.assessments.index') }}">Assessments</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.questions.index', $assessment) }}">{{ $assessment->title }}</a></li>
                <li class="breadcrumb-item active">Question Options</li>
            </ol>
        </nav>
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="page-title fw-bold">Options for Question</h1>
                <p class="text-muted mb-0">{{ $question->question_text }}</p>
            </div>
            <div class="btn-group">
                <a href="{{ route('admin.options.create', [$assessment, $question]) }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add Option
                </a>
                <a href="{{ route('admin.questions.index', $assessment) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Questions
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Options ({{ $options->count() }})</h5>
                    <div>
                        <span class="badge bg-light text-dark">{{ $question->type_display }}</span>
                        @if($assessment->resultCategories->count() == 0)
                            <a href="{{ route('admin.result-categories.index', $assessment) }}" class="btn btn-sm btn-warning ms-2">
                                <i class="bi bi-exclamation-triangle me-1"></i>Setup Categories
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($options->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Order</th>
                                    <th>Option Text</th>
                                    @if(in_array($question->type, ['true_false', 'likert_3', 'likert_5', 'likert_7']))
                                        <th>Value</th>
                                    @endif
                                    <th>Category Scoring</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($options as $option)
                                    <tr>
                                        <td>
                                            <span class="badge bg-light text-dark">#{{ $option->order }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $option->option_text }}</strong>
                                        </td>
                                        @if(in_array($question->type, ['true_false', 'likert_3', 'likert_5', 'likert_7']))
                                        <td>
                                            @if($option->value)
                                                <code class="bg-secondary text-white px-2 py-1 rounded">{{ $option->value }}</code>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        @endif
                                        <td>
                                            @if($option->scoring && count($option->scoring) > 0)
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach($option->scoring as $categoryCode => $score)
                                                        @if($score > 0)
                                                            @php
                                                                $category = $assessment->resultCategories->where('code', $categoryCode)->first();
                                                            @endphp
                                                            @if($category)
                                                                <span class="badge bg-primary">{{ $category->code }}: +{{ $score }}</span>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    @if(collect($option->scoring)->sum() == 0)
                                                        <span class="text-muted">No scoring</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">No scoring configured</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.options.edit', [$assessment, $question, $option]) }}" 
                                                   class="btn btn-outline-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.options.destroy', [$assessment, $question, $option]) }}" 
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
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-list-ul display-1 text-muted"></i>
                        <h4 class="mt-3 text-muted">No options found</h4>
                        <p class="text-muted">Add your first option to get started.</p>
                        <a href="{{ route('admin.options.create', [$assessment, $question]) }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Add Option
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($assessment->resultCategories->count() > 0 && $options->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Scoring Summary for "{{ $question->question_text }}"</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Option</th>
                                @foreach($assessment->resultCategories as $category)
                                    <th class="text-center">{{ $category->code }}<br><small class="text-muted">{{ $category->name }}</small></th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($options as $option)
                                <tr>
                                    <td><strong>{{ $option->option_text }}</strong></td>
                                    @foreach($assessment->resultCategories as $category)
                                        <td class="text-center">
                                            @php
                                                $score = $option->scoring[$category->code] ?? 0;
                                            @endphp
                                            @if($score > 0)
                                                <span class="badge bg-success">+{{ $score }}</span>
                                            @else
                                                <span class="text-muted">0</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if($assessment->resultCategories->count() == 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="alert alert-info">
            <h6><i class="bi bi-info-circle me-2"></i>Setup Required</h6>
            <p class="mb-2">To enable proper scoring for this assessment, you need to create result categories first.</p>
            <a href="{{ route('admin.result-categories.index', $assessment) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-tags me-1"></i>Create Result Categories
            </a>
        </div>
    </div>
</div>
@endif
@endsection