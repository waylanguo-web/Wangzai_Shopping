<div>
    <section class="checkout product footer-padding">
        <div class="container">
            @include('livewire.user.partials._alerts')
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header py-3 bg-transparent">
                            <h5 class="mb-0">{{ __('Upload Payment Proof') }} - {{ __('Order') }} #{{ $order->id }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="border p-3 rounded">
                                <div class="mb-3">
                                    <h6>{{ __('Order Summary') }}</h6>
                                    <hr>
                                    @foreach ($order->orderItems as $item)
                                        <p>{{ $item->product->name }} - {{ $item->subscription->name }} x{{ $item->quantity }} : {{ $currency_symbol }}{{ $item->price }}</p>
                                    @endforeach
                                    <hr>
                                    <p class="fw-bold">{{ __('Total') }}: {{ $currency_symbol }}{{ $order->total_price }}</p>
                                    <p>{{ __('Payment Method') }}: {{ $order->payment_method }}</p>
                                </div>

                                <div class="alert alert-info">
                                    {{ __('Please upload a screenshot of your payment. We will verify it and process your order.') }}
                                </div>

                                <form wire:submit.prevent="uploadProof">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Payment Screenshot') }} *</label>
                                        <input type="file" class="form-control @error('proof_image') is-invalid @enderror"
                                            wire:model="proof_image" accept="image/jpeg,image/png,image/jpg">
                                        @error('proof_image')
                                            <span class="invalid-feedback"> {{ $message }}</span>
                                        @enderror
                                        @if ($proof_image)
                                            <div class="mt-2">
                                                <img src="{{ $proof_image->temporaryUrl() }}" width="200rem" class="img-thumbnail">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary px-4" wire:loading.attr="disabled">{{ __('Upload Proof') }}</button>
                                        <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>