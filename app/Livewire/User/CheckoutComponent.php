<?php

namespace App\Livewire\User;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Setting;
use Livewire\Component;
use App\Models\OrderItem;
use App\Models\PaymentSetting;
use Mail;

class CheckoutComponent extends Component
{
    public $user;
    public $name, $email, $phone_number;
    public $shipping_name, $shipping_phone, $shipping_address, $shipping_city, $shipping_postal_code;
    public $cartItems;
    public $total_price;

    public $payment_method, $payment_number, $payment_transaction_id;

    public $paymentMethods;
    public $currency_symbol;
    public $selectedPaymentType = 'transfer';
    public $selectedQrImage = null;

    public function mount()
    {
        $this->user = auth()->user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone_number = $this->user->phone_number;
        $this->shipping_name = $this->user->name;
        $this->shipping_phone = $this->user->phone_number;
        $this->cartItems = Cart::where('user_id', $this->user->id)->get();
        $this->total_price = $this->cartItems->sum(function ($item) {
            return ($item->subscription->sale_price ?? $item->subscription->regular_price) * $item->quantity;
        });
        $this->paymentMethods = PaymentSetting::where('enabled', true)->get();
        $this->currency_symbol = optional(Setting::first())->currency_unicode;
    }

    public function updatedPaymentMethod($value)
    {
        $method = PaymentSetting::where('name', $value)->first();
        if ($method) {
            $this->selectedPaymentType = $method->type;
            $this->selectedQrImage = $method->qr_image;
        }
    }

    public function placeOrder()
    {
        if($this->cartItems->count() == 0) {
            session()->flash('error', __('Your cart is empty.'));
            return;
        }

        $method = PaymentSetting::where('name', $this->payment_method)->first();
        $isQr = $method && $method->type == 'qr';

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'payment_method' => 'required',
            'shipping_name' => 'required',
            'shipping_phone' => 'required',
            'shipping_address' => 'required',
            'shipping_city' => 'required',
            'shipping_postal_code' => 'required',
        ];

        if (!$isQr) {
            $rules['payment_number'] = 'required|numeric';
            $rules['payment_transaction_id'] = 'required';
        }

        $validatedData = $this->validate($rules);

        $paymentStatus = $isQr ? 'unpaid' : 'pending_review';

        $order = Order::create([
            'user_id' => $this->user->id,
            'total_price' => $this->total_price,
            'status' => 'ordered',
            'payment_method' => $this->payment_method,
            'payment_number' => $this->payment_number ?? '',
            'payment_transaction_id' => $this->payment_transaction_id ?? '',
            'payment_status' => $paymentStatus,
            'shipping_name' => $this->shipping_name,
            'shipping_phone' => $this->shipping_phone,
            'shipping_address' => $this->shipping_address,
            'shipping_city' => $this->shipping_city,
            'shipping_postal_code' => $this->shipping_postal_code,
        ]);

        if ($order) {
            foreach ($this->cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'subscription_id' => $item->subscription->id,
                    'quantity' => $item->quantity,
                    'price' => $item->subscription->sale_price ?? $item->subscription->regular_price,
                ]);
                $item->product->stock -= $item->quantity;
                $item->product->increment('sold_count', $item->quantity);
                $item->product->save();
            }
        }

        Cart::where('user_id', $this->user->id)->delete();
        $this->cartItems = [];
        $this->total_price = 0;

        $setting = Setting::first();
        if ($setting && $setting->email) {
            Mail::to($setting->email)->send(new \App\Mail\NewOrderNotifyMail([
                'subject' => 'new order notification',
                'email' => $this->user->email,
                'name' => $this->user->name,
                'order_id' => $order->id,
            ]));
        }

        if ($isQr) {
            return redirect()->route('user.upload-proof', ['order_id' => $order->id])
                ->with('success', __('Order has been placed successfully. Please upload your payment proof.'));
        }

        session()->flash('success', __('Order has been placed successfully.'));
    }

    public function render()
    {
        return view('livewire.user.checkout-component');
    }
}
