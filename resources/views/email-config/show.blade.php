@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">👁️ Email Configuration Details</h3>
                    <p class="text-muted mb-0">View configuration details for {{ $emailConfiguration->email_address }}</p>
                </div>

                <div class="card-body">
                    <!-- Status Badge -->
                    <div class="text-center mb-4">
                        @if($emailConfiguration->is_active)
                            <span class="badge bg-success fs-6 px-3 py-2">
                                <i class="fas fa-check-circle me-2"></i>Active Configuration
                            </span>
                        @else
                            <span class="badge bg-danger fs-6 px-3 py-2">
                                <i class="fas fa-pause-circle me-2"></i>Inactive Configuration
                            </span>
                        @endif
                    </div>

                    <!-- Configuration Details -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-tag text-primary me-2"></i>Email Type
                                    </h6>
                                    <p class="card-text">
                                        <span class="badge bg-info fs-6">
                                            {{ ucwords(str_replace('_', ' ', $emailConfiguration->email_type)) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-clock text-warning me-2"></i>Frequency
                                    </h6>
                                    <p class="card-text">
                                        <span class="badge bg-secondary fs-6">
                                            {{ ucfirst($emailConfiguration->frequency) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-envelope text-success me-2"></i>Email Address
                                    </h6>
                                    <p class="card-text">
                                        <strong>{{ $emailConfiguration->email_address }}</strong>
                                        <button class="btn btn-sm btn-outline-secondary ms-2" 
                                                onclick="copyToClipboard('{{ $emailConfiguration->email_address }}')"
                                                title="Copy email address">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($emailConfiguration->recipient_name)
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-user text-info me-2"></i>Recipient Name
                                    </h6>
                                    <p class="card-text">{{ $emailConfiguration->recipient_name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Timestamps -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-calendar-plus me-2"></i>Created
                                    </h6>
                                    <p class="card-text">
                                        <strong>{{ $emailConfiguration->created_at->format('M d, Y') }}</strong><br>
                                        <small class="text-muted">{{ $emailConfiguration->created_at->format('H:i:s') }}</small>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-warning">
                                <div class="card-body text-center">
                                    <h6 class="card-title text-warning">
                                        <i class="fas fa-calendar-edit me-2"></i>Last Updated
                                    </h6>
                                    <p class="card-text">
                                        <strong>{{ $emailConfiguration->updated_at->format('M d, Y') }}</strong><br>
                                        <small class="text-muted">{{ $emailConfiguration->updated_at->format('H:i:s') }}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email Type Description -->
                    <div class="alert alert-info mt-4">
                        <h6><i class="fas fa-info-circle me-2"></i>About This Email Type:</h6>
                        @switch($emailConfiguration->email_type)
                            @case('budget_report')
                                <p class="mb-0">This email address will receive comprehensive budget utilization reports showing allocated amounts, spending, and remaining balances across all categories. Reports are sent automatically based on the configured frequency.</p>
                                @break
                            @case('expense_notification')
                                <p class="mb-0">This email address will receive real-time notifications when expenses are submitted for approval, including details about the expense amount, category, and submitter information.</p>
                                @break
                            @case('system_alerts')
                                <p class="mb-0">This email address will receive important system notifications including maintenance updates, security alerts, and other critical system information.</p>
                                @break
                            @case('payment_updates')
                                <p class="mb-0">This email address will receive updates about payment processing, including payment approvals, rejections, and status changes for invoices and expense settlements.</p>
                                @break
                            @default
                                <p class="mb-0">This email configuration is set up for {{ ucwords(str_replace('_', ' ', $emailConfiguration->email_type)) }} notifications.</p>
                        @endswitch
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('email-config.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                        
                        <div>
                            <!-- Toggle Status -->
                            <form action="{{ route('email-config.toggle-status', $emailConfiguration) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="btn {{ $emailConfiguration->is_active ? 'btn-warning' : 'btn-success' }} me-2">
                                    <i class="fas {{ $emailConfiguration->is_active ? 'fa-pause' : 'fa-play' }} me-2"></i>
                                    {{ $emailConfiguration->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            
                            <!-- Edit -->
                            <a href="{{ route('email-config.edit', $emailConfiguration) }}" class="btn btn-primary me-2">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            
                            <!-- Delete -->
                            <form action="{{ route('email-config.destroy', $emailConfiguration) }}" method="POST" 
                                  style="display: inline;" 
                                  onsubmit="return confirm('Are you sure you want to delete this email configuration? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    
    .alert {
        border-radius: 8px;
    }
    
    .badge {
        font-size: 0.9em;
    }
    
    .card.bg-light {
        border: 1px solid #dee2e6;
    }
</style>
@endpush

@push('scripts')
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show success message
            const button = event.target.closest('button');
            const originalIcon = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check text-success"></i>';
            button.classList.add('btn-success');
            button.classList.remove('btn-outline-secondary');
            
            setTimeout(function() {
                button.innerHTML = originalIcon;
                button.classList.remove('btn-success');
                button.classList.add('btn-outline-secondary');
            }, 2000);
        }, function(err) {
            console.error('Could not copy text: ', err);
            alert('Failed to copy email address');
        });
    }
</script>
@endpush