<div>
    <div class="card">
        @include('livewire.admin.partials._alerts')
        <div class="card-body">
            <form wire:submit.prevent="save_order_details" class="row">

                <div class="col-md-5">
                    <h5 class="text-center">{{ __('Buyer Details') }}</h5>
                    <hr>
                    {{ __('Buyer Name :') }} <span class="text-primary">{{ $buyer_name }}</span>
                    <hr>
                    {{ __('Buyer Email :') }} <span class="text-primary">{{ $buyer_email }}</span>
                    <hr>
                    {{ __('Buyer Phone :') }} <span class="text-primary">{{ $buyer_phone }}</span>
                    <hr>
                    {{ __('Payment Method :') }} <span class="text-danger">{{ $payment_method }}</span>
                    <hr>
                    @if ($payment_number)
                        {{ __('Payment Number :') }} <span class="text-danger">{{ $payment_number }}</span>
                        <hr>
                    @endif
                    @if ($payment_transaction_id)
                        {{ __('Transaction ID :') }} <span class="text-danger">{{ $payment_transaction_id }}</span>
                        <hr>
                    @endif
                    {{ __('Payment Status :') }}
                    @php
                        $psLabels = [
                            'unpaid' => ['text' => __('Unpaid'), 'class' => 'bg-warning'],
                            'pending_review' => ['text' => __('Pending Review'), 'class' => 'bg-info'],
                            'paid' => ['text' => __('Paid'), 'class' => 'bg-success'],
                            'rejected' => ['text' => __('Rejected'), 'class' => 'bg-danger'],
                        ];
                        $ps = $psLabels[$payment_status] ?? ['text' => $payment_status, 'class' => 'bg-secondary'];
                    @endphp
                    <span class="badge rounded-pill {{ $ps['class'] }}">{{ $ps['text'] }}</span>
                    <hr>
                    <h6 class="text-warning mt-2">{{ __('Shipping Address') }}</h6>
                    @if ($order->shipping_name)
                        <p class="mb-1"><strong>{{ $order->shipping_name }}</strong></p>
                        <p class="mb-1">{{ $order->shipping_phone }}</p>
                        <p class="mb-1">{{ $order->shipping_address }}</p>
                        <p class="mb-1">{{ $order->shipping_city }} {{ $order->shipping_postal_code }}</p>
                    @else
                        <p class="text-muted">{{ __('No shipping address provided') }}</p>
                    @endif
                </div>
                <div class="vr"></div>
                <div class="col-md-5">
                    <h5 class="text-center">{{ __('Order Details') }}</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p>{{ __('Product Name') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p>{{ __('Quantity') }}</p>
                        </div>
                    </div>
                    <hr>
                    @foreach ($orderItems as $orderItem)
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-info">{{ $orderItem->product->name }} -
                                    {{ $orderItem->subscription->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p>x{{ $orderItem->quantity }}</p>
                            </div>
                        </div>
                        <hr>
                    @endforeach

                    @if ($order->paymentProofs->isNotEmpty())
                        <h6 class="text-warning">{{ __('Payment Proofs') }}</h6>
                        <div class="row">
                            @foreach ($order->paymentProofs as $proof)
                                <div class="col-md-4 mb-2">
                                    <a href="{{ Storage::url($proof->image_path) }}" target="_blank">
                                        <img src="{{ Storage::url($proof->image_path) }}" class="img-thumbnail" width="120rem">
                                    </a>
                                    <small class="d-block">
                                        @if ($proof->status == 'pending')
                                            <span class="badge bg-warning">{{ __('Pending') }}</span>
                                        @elseif($proof->status == 'approved')
                                            <span class="badge bg-success">{{ __('Approved') }}</span>
                                        @elseif($proof->status == 'rejected')
                                            <span class="badge bg-danger">{{ __('Rejected') }}</span>
                                            <small class="text-muted d-block">{{ $proof->reject_reason }}</small>
                                        @endif
                                        <span class="text-muted">{{ $proof->created_at->format('Y-m-d H:i') }}</span>
                                    </small>
                                </div>
                            @endforeach
                        </div>
                        <hr>
                    @endif
                </div>
                <hr>

                @if ($payment_status == 'paid' && $status == 'ordered')
                    <div class="col-md-12">
                        <label for="delivery_mail_title" class="form-label">{{ __('Delivery Mail Title') }}</label>
                        <input type="text" class="form-control" id="delivery_mail_title" wire:model="mail_title" placeholder="{{ __('Mail Title') }}">
                    </div>
                    <div class="col-md-12 mt-2" wire:ignore>
                        <label for="delivery_mail" class="form-label">{{ __('Delivery Details') }}</label>
                        <textarea id="delivery_mail" wire:model="delivery_details"></textarea>
                        <button type="button" wire:click="deliver" class="btn btn-primary mt-1 mb-2">{{ __('Confirm Shipment') }}</button>
                    </div>
                @elseif($status == 'shipped')
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            {{ __('Order is in transit. Click below to confirm delivery.') }}
                        </div>
                        <button type="button" wire:click="confirmDelivered" class="btn btn-success">
                            <i class="bi bi-check-lg"></i> {{ __('Confirm Delivered') }}
                        </button>
                    </div>
                @elseif($status == 'delivered')
                    <div class="col-md-12">
                        <div class="alert alert-success">
                            {{ __('Order has been delivered.') }}
                        </div>
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="alert alert-warning">
                            {{ __('Shipment is locked until payment is confirmed (status must be Paid).') }}
                            @if ($payment_status == 'pending_review')
                                <a href="{{ route('admin.payment-review') }}" class="alert-link">{{ __('Go to Payment Review') }}</a>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="col-md-12 mt-3">
                    <label for="order_status" class="form-label">{{ __('Order Status') }}</label>
                    <select class="form-select" wire:model="status">
                        <option value="ordered">{{ __('Ordered') }}</option>
                        <option value="shipped">{{ __('Shipping') }}</option>
                        <option value="delivered">{{ __('Delivered') }}</option>
                        <option value="cancelled">{{ __('Cancelled') }}</option>
                    </select>
                </div>
                <div class="col-md-4 mt-2">
                    <button type="submit" class="btn btn-dark">{{ __('Save Status') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@script
    <script>
        $('#delivery_mail').summernote({
            placeholder: 'Netflix Account 1 : email : example@gmail.com , password : 000000, info : Please Dont share the credentials with anyone. and it\'s a 1 display account.',
            tabsize: 2,
            height: 300,
            callbacks: {
                onChange: function(contents, $editable) {
                    @this.set('delivery_mail', contents);
                }
            }
        });
    </script>
@endscript
