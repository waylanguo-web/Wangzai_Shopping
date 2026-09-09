<div>
    <div class="card">
        @include('livewire.admin.partials._alerts')
        <div class="card-header py-3">
            <div class="row align-items-center m-0">
                <div class="col-md-6">
                    <h5 class="mb-0">{{ __('Payment Proof Review') }}</h5>
                </div>
                <div class="col-md-3 ms-auto">
                    <select class="form-select" wire:model.live="filter">
                        <option value="pending">{{ __('Pending Review') }}</option>
                        <option value="approved">{{ __('Approved') }}</option>
                        <option value="rejected">{{ __('Rejected') }}</option>
                        <option value="all">{{ __('Show all') }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($proofs->isEmpty())
                <div class="text-center py-5 text-muted">{{ __('No payment proofs found.') }}</div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Order ID') }}</th>
                                <th>{{ __('Buyer') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Proof Image') }}</th>
                                <th>{{ __('Uploaded At') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proofs as $proof)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.details', $proof->order_id) }}" class="text-primary">
                                            #{{ $proof->order_id }}
                                        </a>
                                    </td>
                                    <td>{{ $proof->order->user->name ?? '-' }}</td>
                                    <td>${{ $proof->order->total_price }}</td>
                                    <td>
                                        <a href="{{ Storage::url($proof->image_path) }}" target="_blank">
                                            <img src="{{ Storage::url($proof->image_path) }}" width="80rem" class="img-thumbnail">
                                        </a>
                                    </td>
                                    <td>{{ $proof->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @if ($proof->status == 'pending')
                                            <span class="badge rounded-pill bg-warning">{{ __('Pending') }}</span>
                                        @elseif($proof->status == 'approved')
                                            <span class="badge rounded-pill bg-success">{{ __('Approved') }}</span>
                                            <small class="text-muted d-block">{{ $proof->reviewed_at ? $proof->reviewed_at->format('Y-m-d H:i') : '' }}</small>
                                        @elseif($proof->status == 'rejected')
                                            <span class="badge rounded-pill bg-danger">{{ __('Rejected') }}</span>
                                            <small class="text-muted d-block">{{ $proof->reject_reason }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($proof->status == 'pending')
                                            <button wire:click="approveProof({{ $proof->id }})" class="btn btn-sm btn-success mb-1">
                                                <i class="bi bi-check-lg"></i> {{ __('Approve') }}
                                            </button>
                                            <div class="mt-1">
                                                <input type="text" class="form-control form-control-sm @error('reject_reason') is-invalid @enderror"
                                                    placeholder="{{ __('Reject reason...') }}" wire:model="reject_reason">
                                                @error('reject_reason')
                                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                                <button wire:click="rejectProof({{ $proof->id }})" class="btn btn-sm btn-danger mt-1">
                                                    <i class="bi bi-x-lg"></i> {{ __('Reject') }}
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $proofs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>