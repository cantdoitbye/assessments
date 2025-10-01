@extends('admin.layout.app')

@section('title', 'Sub Admins Management')
@section('page-title', 'Sub Admins Management')

@section('content')
<div class="row mb-3">
    <div class="col">
        <a href="{{ route('admin.sub-admins.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Create New Sub Admin
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($subAdmins->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-person-x display-1 text-muted mb-3"></i>
            <h5 class="text-muted">No sub admins yet</h5>
            <p class="text-muted">Create sub admins to help manage the system.</p>
            <a href="{{ route('admin.sub-admins.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                Create Sub Admin
            </a>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">All Sub Admins</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>ROLE</th>
                        <th>CREATED AT</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subAdmins as $subAdmin)
                        <tr>
                            <td>
                                <div>
                                    <strong class="text-dark">{{ $subAdmin->name }}</strong>
                                </div>
                            </td>
                            <td>{{ $subAdmin->email }}</td>
                            <td>
                                <span class="badge bg-info">Sub Admin</span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $subAdmin->created_at->format('M d, Y') }}</small>
                            </td>
                            <td>
                                <a href="{{ route('admin.sub-admins.edit', $subAdmin) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.sub-admins.destroy', $subAdmin) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this sub admin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($subAdmins->hasPages())
            <div class="card-footer">
                {{ $subAdmins->links() }}
            </div>
        @endif
    </div>
@endif
@endsection