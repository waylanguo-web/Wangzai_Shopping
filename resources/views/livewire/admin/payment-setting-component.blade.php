<div>
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                @include('livewire.admin.partials._alerts')
                <div class="card-header py-3 bg-transparent">
                    <h5 class="mb-0">{{ __('Payment Settings') }}</h5>
                </div>
                <div class="card-body">
                    <div class="border p-3 rounded">
                        <form wire:submit.prevent="SavePayment" class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">{{ __('Payment Type') }}</label>
                                <select class="form-select" wire:model="type">
                                    <option value="transfer">{{ __('Transfer (Bank/Mobile)') }}</option>
                                    <option value="qr">{{ __('Scan QR (WeChat/Alipay)') }}</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">{{ __('Account Org. Name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Bkash/Nagad/WeChat/Alipay..." wire:model="name">
                                @error('name')
                                    <span class="invalid-feedback"> {{ $message }}</span>
                                @enderror
                            </div>

                            @if ($type == 'transfer')
                                <div class="col-12">
                                    <label class="form-label">{{ __('Account Number') }}</label>
                                    <input type="tel" class="form-control @error('number') is-invalid @enderror"
                                        placeholder="+0000000000" wire:model="number">
                                    @error('number')
                                        <span class="invalid-feedback"> {{ $message }}</span>
                                    @enderror
                                </div>
                            @else
                                <div class="col-12">
                                    <label class="form-label">{{ __('QR Code Image') }}</label>
                                    <input type="file" class="form-control @error('qr_image') is-invalid @enderror"
                                        wire:model="qr_image">
                                    @error('qr_image')
                                        <span class="invalid-feedback"> {{ $message }}</span>
                                    @enderror
                                    @if ($old_qr_image)
                                        <div class="mt-2">
                                            <img src="{{ Storage::url($old_qr_image) }}" width="120rem" class="img-thumbnail">
                                            <small class="text-muted d-block">{{ __('Current QR code (upload new to replace)') }}</small>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div class="col-12">
                                <label class="form-label">{{ __('Note') }}</label>
                                <input type="text" class="form-control @error('note') is-invalid @enderror"
                                    placeholder="{{ __('Please Send money or cash-in, its personal account...') }}"
                                    wire:model="note">
                                @error('note')
                                    <span class="invalid-feedback"> {{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="enabled"
                                        wire:model="enabled">
                                    <label class="form-check-label" for="enabled">
                                        {{ __('Enabled') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary px-4">{{ __('Add Setting') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('Payment Method') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Number / QR') }}</th>
                                    <th>{{ __('Note') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($payments as $payment)
                                    <tr>
                                        <td class="productlist">
                                            <h6 class="mb-0 product-title">{{$payment->name}}</h6>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill bg-info">{{ $payment->type == 'qr' ? __('QR') : __('Transfer') }}</span>
                                        </td>
                                        <td class="productlist">
                                            @if ($payment->type == 'qr' && $payment->qr_image)
                                                <img src="{{ Storage::url($payment->qr_image) }}" width="50rem" class="img-thumbnail">
                                            @else
                                                <h6 class="mb-0 product-title">{{$payment->number}}</h6>
                                            @endif
                                        </td>
                                        <td class="productlist">
                                            <h6 class="mb-0 product-title">{{$payment->note}}</h6>
                                        </td>
                                        <td>
                                            @if ($payment->enabled)
                                                <span class="badge rounded-pill bg-success">{{ __('Active') }}</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">{{ __('Disabled') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 fs-6">
                                                <a href="javascript:;" wire:click="editePaymentMethod({{$payment->id}})"
                                                    class="text-warning" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title=""
                                                    data-bs-original-title="{{ __('Edit info') }}" aria-label="Edit"><i
                                                        class="bi bi-pencil-fill"></i></a>
                                                <a href="javascript:;" wire:click="deletePaymentMethod({{$payment->id}})"
                                                    class="text-danger" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title=""
                                                    data-bs-original-title="{{ __('Delete') }}" aria-label="Delete"><i
                                                        class="bi bi-trash-fill"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
