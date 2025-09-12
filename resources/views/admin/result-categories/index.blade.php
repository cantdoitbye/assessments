@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.assessments.index') }}">Assessments</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.assessments.show', $assessment) }}">{{ $assessment->title }}</a></li>
                <li class="breadcrumb-item active">Result Categories</li>
            </ol>
        </nav>
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="page-title fw-bold">Result Categories</h1>
                <p class="text-muted mb-0">Manage scoring categories for "{{ $assessment->title }}"</p>
            </div>
            <div class="btn-group">
                <a href="{{ route('admin.result-categories.create', $assessment) }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add Category
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
            <div class="card-header">
                <h5 class="mb-0">Categories ({{ $categories->count() }})</h5>
            </div>
            <div class="card-body">
                @if($categories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Order</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>
                                            <span class="badge bg-light text-dark">#{{ $category->order }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $category->name }}</strong>
                                        </td>
                                        <td>
                                            <code class="bg-primary text-white px-2 py-1 rounded">{{ $category->code }}</code>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ Str::limit($category->description, 50) ?? '—' }}</span>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.result-categories.edit', [$assessment, $category]) }}" 
                                                   class="btn btn-outline-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.result-categories.destroy', [$assessment, $category]) }}" 
                                                      class="d-inline" onsubmit="return confirm('Are you sure? This will affect all scoring configurations.')">
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
                        <i class="bi bi-tags display-1 text-muted"></i>
                        <h4 class="mt-3 text-muted">No result categories found</h4>
                        <p class="text-muted">Add categories like "Assertive", "Passive", "Systematic" etc.</p>
                        <a href="{{ route('admin.result-categories.create', $assessment) }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Add First Category
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($categories->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Quick Examples</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Assertiveness Assessment</h6>
                        <ul class="list-unstyled">
                            <li><code>PASS</code> - Passive (Flight)</li>
                            <li><code>AGGR</code> - Aggressive (Attack)</li>
                            <li><code>PAGG</code> - Passive Aggressive (Manipulation)</li>
                            <li><code>ASSE</code> - Assertive (Harmony)</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Decision-Making Style</h6>
                        <ul class="list-unstyled">
                            <li><code>SYS</code> - Systematic</li>
                            <li><code>INT</code> - Intuitive</li>
                            <li><code>DEP</code> - Dependent</li>
                            <li><code>AVO</code> - Avoidant</li>
                            <li><code>SPO</code> - Spontaneous</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection