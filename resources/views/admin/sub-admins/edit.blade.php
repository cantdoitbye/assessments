@extends('admin.layout.app')

@section('title', 'Edit Sub Admin')
@section('page-title')
    Edit Sub Admin
    <small class="text-muted">- {{ $subAdmin->name }}</small>
@endsection

@section('content')
<div class="row mb-3">
    <div class="col">
        <a href="{{ route('admin.sub-admins.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Sub Admins
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Sub Admin Details</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.sub-admins.update', $subAdmin) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $subAdmin->name) }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $subAdmin->email) }}"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3">Change Password</h6>
                    <p class="text-muted small">Leave blank to keep the current password</p>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Minimum 8 characters</small>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation">
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.sub-admins.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            Update Sub Admin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-person-badge me-2"></i>Account Information
                </h6>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-2">
                        <strong>Role:</strong>
                        <span class="badge bg-info ms-1">Sub Admin</span>
                    </li>
                    <li class="mb-2">
                        <strong>Created:</strong> {{ $subAdmin->created_at->format('M d, Y') }}
                    </li>
                    <li class="mb-2">
                        <strong>Last Updated:</strong> {{ $subAdmin->updated_at->format('M d, Y') }}
                    </li>
                </ul>
            </div>
        </div>

        <div class="card bg-light mt-3">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-info-circle me-2"></i>Password Info
                </h6>
                <ul class="small mb-0">
                    <li>Leave password fields empty to keep current password</li>
                    <li>New password must be at least 8 characters</li>
                    <li>Both password fields must match</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection