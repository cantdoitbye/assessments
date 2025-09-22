{{-- resources/views/admin/assessments/codes.blade.php --}}
@extends('admin.layout.app')

@section('title', 'Access Codes - ' . $assessment->title)
@section('page-title')
    {{ $assessment->title }}
    <small class="text-muted">- Access Codes</small>
@endsection

@push('styles')
<style>
.code-badge {
    font-family: 'Courier New', monospace;
    font-weight: bold;
    font-size: 1.1em;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
.spin {
    animation: spin 1s linear infinite;
}
</style>
@endpush

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCodeModal">
            <i class="bi bi-plus-circle me-1"></i>
            Add Access Code
        </button>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('admin.assessments.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Assessments
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center bg-primary text-white">
            <div class="card-body">
                <h4 class="card-title">{{ $assessment->assessmentCodes()->count() }}</h4>
                <p class="card-text">Total Codes</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-success text-white">
            <div class="card-body">
                <h4 class="card-title">{{ $assessment->assessmentCodes()->where('is_active', true)->count() }}</h4>
                <p class="card-text">Active Codes</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-info text-white">
            <div class="card-body">
                <h4 class="card-title">{{ $assessment->assessmentCodes()->sum('usage_count') }}</h4>
                <p class="card-text">Total Usage</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-warning text-white">
            <div class="card-body">
                <h4 class="card-title">{{ $assessment->assessmentCodes()->where('expires_at', '!=', null)->where('expires_at', '<', now())->count() }}</h4>
                <p class="card-text">Expired Codes</p>
            </div>
        </div>
    </div>
</div>

@if($assessment->assessmentCodes()->count() == 0)
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-key display-1 text-muted mb-3"></i>
            <h5 class="text-muted">No access codes yet</h5>
            <p class="text-muted">Create access codes to control who can take this assessment.</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCodeModal">
                <i class="bi bi-plus-circle me-1"></i>
                Add First Code
            </button>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Access Codes Management</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="codesTable">
                <thead>
                    <tr>
                        <th>CODE</th>
                        <th>DESCRIPTION</th>
                        <th>USAGE</th>
                        <th>EXPIRES</th>
                        <th>STATUS</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assessment->assessmentCodes()->orderByDesc('created_at')->get() as $code)
                        <tr id="code-row-{{ $code->id }}">
                            <td>
                                <span class="badge bg-dark code-badge">{{ $code->code }}</span>
                            </td>
                            <td>
                                <div>
                                    {{ $code->description ?: 'No description' }}
                                    <br>
                                    <small class="text-muted">Created {{ $code->created_at->format('M j, Y') }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold">{{ $code->usage_count }}</span>
                                @if($code->max_usage)
                                    / {{ $code->max_usage }}
                                    <br>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar" style="width: {{ ($code->usage_count / $code->max_usage) * 100 }}%"></div>
                                    </div>
                                @else
                                    <small class="text-muted">(Unlimited)</small>
                                @endif
                            </td>
                            <td>
                                @if($code->expires_at)
                                    @if($code->expires_at->isPast())
                                        <span class="text-danger fw-bold">Expired</span>
                                        <br>
                                        <small class="text-muted">{{ $code->expires_at->format('M j, Y H:i') }}</small>
                                    @else
                                        <span class="text-success">{{ $code->expires_at->format('M j, Y H:i') }}</span>
                                        <br>
                                        <small class="text-muted">{{ $code->expires_at->diffForHumans() }}</small>
                                    @endif
                                @else
                                    <span class="text-muted">Never</span>
                                @endif
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input status-toggle" type="checkbox" 
                                           {{ $code->is_active ? 'checked' : '' }}
                                           data-code-id="{{ $code->id }}">
                                    <label class="form-check-label">
                                        <span class="status-text-{{ $code->id }}">{{ $code->is_active ? 'Active' : 'Inactive' }}</span>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-danger btn-sm" 
                                        onclick="deleteCode({{ $code->id }})" title="Delete Code">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

<!-- Add Code Modal -->
<div class="modal fade" id="addCodeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Access Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addCodeForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="code" class="form-label">Access Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="code" name="code" 
                               placeholder="e.g., DEMO2024" maxlength="50" required>
                        <div class="form-text">Only letters and numbers allowed. Will be converted to uppercase.</div>
                        <div class="invalid-feedback"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" 
                               placeholder="e.g., Demo users, Training session">
                        <div class="invalid-feedback"></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="max_usage" class="form-label">Usage Limit</label>
                            <input type="number" class="form-control" id="max_usage" name="max_usage" 
                                   min="1" placeholder="Unlimited">
                            <div class="form-text">Leave blank for unlimited usage</div>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="expires_at" class="form-label">Expiry Date</label>
                            <input type="datetime-local" class="form-control" id="expires_at" name="expires_at">
                            <div class="form-text">Leave blank for no expiry</div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>
                        Create Code
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
$(document).ready(function() {
    // Auto-uppercase code input
    $('#code').on('input', function() {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    });

    // Handle form submission
    $('#addCodeForm').on('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        
        // Show loading
        submitBtn.prop('disabled', true).html('<i class="bi bi-circle-notch spin me-1"></i>Creating...');
        
        $.ajax({
            url: '{{ route("admin.assessments.store-code", $assessment) }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#addCodeModal').modal('hide');
                    // Add new row to table or reload page
                    location.reload();
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(field) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field).siblings('.invalid-feedback').text(errors[field][0]);
                    });
                } else {
                    alert('An error occurred. Please try again.');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Handle status toggle
    $('.status-toggle').on('change', function() {
        const codeId = $(this).data('code-id');
        const isChecked = $(this).is(':checked');
        const toggle = $(this);
        
        $.ajax({
            url: '{{ route("admin.assessments.toggle-code", $assessment) }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                code_id: codeId
            },
            success: function(response) {
                if (response.success) {
                    $(`.status-text-${codeId}`).text(response.status ? 'Active' : 'Inactive');
                } else {
                    // Revert toggle
                    toggle.prop('checked', !isChecked);
                }
            },
            error: function() {
                // Revert toggle
                toggle.prop('checked', !isChecked);
                alert('Error updating status. Please try again.');
            }
        });
    });

    // Reset modal form when closed
    $('#addCodeModal').on('hidden.bs.modal', function() {
        $('#addCodeForm')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');
    });
});

function deleteCode(codeId) {
    if (confirm('Are you sure you want to delete this access code? This action cannot be undone.')) {
        $.ajax({
            url: '{{ route("admin.assessments.delete-code", $assessment) }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE',
                code_id: codeId
            },
            success: function(response) {
                if (response.success) {
                    $(`#code-row-${codeId}`).fadeOut(300, function() {
                        $(this).remove();
                        // Check if table is empty and show empty state
                        if ($('#codesTable tbody tr').length === 0) {
                            location.reload();
                        }
                    });
                }
            },
            error: function() {
                alert('Error deleting code. Please try again.');
            }
        });
    }
}
</script>
@endpush
@endsection
