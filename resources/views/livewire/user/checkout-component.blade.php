<div>
    <section class="checkout product footer-padding">
        <div class="container">
            @include('livewire.user.partials._alerts')
            <div class="checkout-section">
                <div class="row gy-5">
                    <div class="col-lg-6">
                        <div class="checkout-wrapper">
                            <div class="account-section billing-section">
                                <h5 class="wrapper-heading">{{ __('Billing Details') }}</h5>
                                <div class="review-form">
                                    <div class=" account-inner-form">
                                        <div class="review-form-name">
                                            <label for="name" class="form-label">{{ __('Name*') }}</label>
                                            <input type="text" id="name" class="form-control" placeholder="{{ __('Full Name') }}"
                                                wire:model="name">
                                        </div>
                                    </div>
                                    <div class=" account-inner-form">
                                        <div class="review-form-name">
                                            <label for="email" class="form-label">{{ __('Email*') }}</label>
                                            <input type="email" id="email" class="form-control"
                                                placeholder="user@gmail.com" wire:model="email">
                                        </div>
                                        <div class="review-form-name">
                                            <label for="phone" class="form-label">{{ __('Phone*') }}</label>
                                            <input type="tel" id="phone" class="form-control"
                                                placeholder="+000000000000" wire:model="phone_number">
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-3">
                                <h6 class="wrapper-heading">{{ __('Shipping Address') }}</h6>
                                <div class="review-form mt-2">
                                    <div class="account-inner-form">
                                        <div class="review-form-name">
                                            <label for="shipping_name" class="form-label">{{ __('Recipient Name*') }}</label>
                                            <input type="text" id="shipping_name" class="form-control @error('shipping_name') is-invalid @enderror"
                                                placeholder="{{ __('Full Name') }}" wire:model="shipping_name">
                                            @error('shipping_name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="account-inner-form">
                                        <div class="review-form-name">
                                            <label for="shipping_phone" class="form-label">{{ __('Recipient Phone*') }}</label>
                                            <input type="tel" id="shipping_phone" class="form-control @error('shipping_phone') is-invalid @enderror"
                                                placeholder="+000000000000" wire:model="shipping_phone">
                                            @error('shipping_phone')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="account-inner-form">
                                        <div class="review-form-name">
                                            <label for="shipping_address" class="form-label">{{ __('Detailed Address*') }}</label>
                                            <input type="text" id="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror"
                                                placeholder="{{ __('Street, building, room...') }}" wire:model="shipping_address">
                                            @error('shipping_address')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class=" account-inner-form">
                                        <div class="review-form-name">
                                            <label for="shipping_city" class="form-label">{{ __('City*') }}</label>
                                            <input type="text" id="shipping_city" class="form-control @error('shipping_city') is-invalid @enderror"
                                                placeholder="{{ __('City') }}" wire:model="shipping_city">
                                            @error('shipping_city')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="review-form-name">
                                            <label for="shipping_postal_code" class="form-label">{{ __('Postal Code*') }}</label>
                                            <input type="text" id="shipping_postal_code" class="form-control @error('shipping_postal_code') is-invalid @enderror"
                                                placeholder="000000" wire:model="shipping_postal_code">
                                            @error('shipping_postal_code')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="checkout-wrapper">
                            <div class="account-section billing-section">
                                <h5 class="wrapper-heading">{{ __('Order Summary') }}</h5>
                                <div class="order-summery">
                                    <div class="subtotal product-total">
                                        <h5 class="wrapper-heading">{{ __('PRODUCT') }}</h5>
                                        <h5 class="wrapper-heading">{{ __('Unit Price') }}</h5>
                                        <h5 class="wrapper-heading">{{ __('Total Price') }}</h5>
                                    </div>
                                    <hr>
                                    <div class="subtotal product-total">
                                        <ul class="product-list">

                                            @foreach ($cartItems as $item)
                                                <li>
                                                    <div class="product-info">
                                                        <h5 class="wrapper-heading">{{ $item->product->name }} - {{ $item->subscription->name }}
                                                            X{{ $item->quantity }}</h5>
                                                        <p class="paragraph">
                                                            {{ Str::limit($item->product->description, 30) }}</p>
                                                    </div>
                                                    <div class="price">
                                                        <h5 class="wrapper-heading">
                                                            {{$currency_symbol}}{{ $item->subscription->sale_price ?? $item->subscription->regular_price }}
                                                        </h5>
                                                    </div>
                                                    <div class="price">
                                                        <h5 class="wrapper-heading">
                                                            {{$currency_symbol}}{{ ($item->subscription->sale_price ?? $item->subscription->regular_price) * $item->quantity }}
                                                        </h5>
                                                    </div>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                    <hr>
                                    <div class="subtotal total">
                                        <h5 class="wrapper-heading">{{ __('TOTAL') }}</h5>
                                        <h5 class="wrapper-heading price">{{$currency_symbol}}{{ $total_price }}</h5>
                                    </div>
                                    <div class="subtotal payment-type">
                                        <h5 class="wrapper-heading">{{ __('Payment Type') }}</h5>
                                        <div class="payment-type-inner pb-1">

                                            @foreach ($paymentMethods as $method)
                                                <div class="payment-type-item">
                                                    <input type="radio" id="{{ $method->name }}" name="payment"
                                                        wire:model.live="payment_method" value="{{ $method->name }}">
                                                    <label for="{{ $method->name }}" class="form-label"
                                                        style="font-size: 1.26rem;">{{ $method->name }} :
                                                        @if ($method->type == 'qr')
                                                            <span class="text-primary">{{ __('Scan QR to pay') }}</span>
                                                        @else
                                                            <span class="text-success">{{ $method->number }}</span> :
                                                            <span class="text-danger">   ->{{ $method->note }}</span>
                                                        @endif
                                                    </label>
                                                </div>
                                            @endforeach

                                            @if ($selectedPaymentType == 'qr' && $selectedQrImage)
                                                <div class="m-3 text-center">
                                                    <h6 class="text-warning">{{ __('Scan the QR code below to pay') }}</h6>
                                                    <img src="{{ Storage::url($selectedQrImage) }}" width="200rem" class="img-thumbnail d-block mx-auto">
                                                    <p class="text-muted small mt-1">{{ __('After payment, click "Place Order Now" then upload the payment screenshot.') }}</p>
                                                </div>
                                            @else
                                                <div class="m-3">
                                                    <label for="payment_number" class="form-label" style="font-size: 1.4rem;">{{ __('Your Account') }}
                                                        {{ $payment_method }} {{ __('Number*') }}</label>
                                                    <input type="tel" id="payment_number"
                                                        class="form-control @error('payment_number') is-invalid @enderror"
                                                        placeholder="+000000000000" wire:model="payment_number" style="width: 20rem; height: 3rem; font-size: 1.2rem;">
                                                    @error('payment_number')
                                                        <span class="invalid-feedback"> {{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="m-3">
                                                    <label for="payment_transaction_id" class="form-label" style="font-size: 1.4rem;">{{ __('Transaction ID*') }}</label>
                                                    <input type="text" id="payment_transaction_id"
                                                        class="form-control @error('payment_transaction_id') is-invalid @enderror"
                                                        placeholder="F9UHDS645FFSD" wire:model="payment_transaction_id" style="width: 20rem; height: 3rem; font-size: 1.2rem;">
                                                    @error('payment_transaction_id')
                                                        <span class="invalid-feedback"> {{ $message }}</span>
                                                    @enderror
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <a href="javascript:;" wire:click="placeOrder" class="shop-btn" wire:loading.attr="disabled">{{ __('Place Order Now') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
