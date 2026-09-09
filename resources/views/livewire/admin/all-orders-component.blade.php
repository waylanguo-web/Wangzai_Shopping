<div>
    <div class="card">
        @include('livewire.admin.partials._alerts')
        <div class="card-header py-3">
            <div class="row align-items-center m-0">
                <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
                    <select class="form-select">
                        <option>{{ __('All category') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <select class="form-select">
                        <option>{{ __('Status') }}</option>
                        <option>{{ __('Active') }}</option>
                        <option>{{ __('Disabled') }}</option>
                        <option>{{ __('Show all') }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Order ID') }}</th>
                            <th>{{ __('Buyer Name') }}</th>
                            <th>{{ __('Total Amount') }}</th>
                            <th>{{ __('TrX ID') }}</th>
                            <th>{{ __('Payment Method') }}</th>
                            <th>{{ __('Payment Number') }}</th>
                            <th>{{ __('Ordered On') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td class="productlist">
                                    <h6 class="mb-0 product-title">{{ $order->id }}</h6>
                                </td>
                                <td>
                                    <span>{{ $order->user->name }}</span>
                                </td>
                                <td>
                                    <span>{{ $order->total_price }}</span>
                                </td>
                                <td>
                                    <span>{{ $order->payment_transaction_id }}</span>
                                </td>
                                <td>
                                    <span>{{ $order->payment_method }}</span>
                                </td>
                                <td>
                                    <span>{{ $order->payment_number }}</span>
                                </td>
                                <td>
                                    <span>{{ $order->created_at->formatLocalized('%B %d, %Y, %H:%M:%S') }}</span>
                                </td>
                                <td>
                                    @php
                                        $dsLabels = \App\Models\Order::displayStatusLabels();
                                        $ds = $order->display_status;
                                        $label = $dsLabels[$ds] ?? ['text' => $ds, 'class' => 'bg-secondary'];
                                    @endphp
                                    <span class="badge rounded-pill {{ $label['class'] }}">{{ __($label['text']) }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3 fs-6">
                                        <a href="javascript:;" wire:click="viewOrderDetails({{ $order->id }})"
                                            class="text-primary">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <nav class="float-end mt-4" aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item disabled"><a class="page-link" href="#">{{ __('Previous') }}</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">{{ __('Next') }}</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
