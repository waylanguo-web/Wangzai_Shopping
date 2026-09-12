<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use App\Mail\DeliverProductMail;
use Illuminate\Support\Facades\Mail;

class OrderDetailsComponent extends Component
{
    public $order_id, $buyer_name, $buyer_email, $buyer_phone, $status, $orderItems = [], $total_price, $payment_method, $payment_number, $payment_transaction_id, $delivery_mail;
    public $payment_status;
    public $delivery_details;
    public $mail_title;
    public $tracking_number;

    public function mount($id)
    {
        $order = Order::find($id);
        if ($order) {
            $this->order_id = $order->id;
            $this->buyer_name = $order->user->name;
            $this->buyer_email = $order->user->email;
            $this->buyer_phone = $order->user->phone_number;
            $this->status = $order->status;
            $this->orderItems = $order->orderItems;
            $this->total_price = $order->total_price;
            $this->payment_method = $order->payment_method;
            $this->payment_number = $order->payment_number;
            $this->payment_transaction_id = $order->payment_transaction_id;
            $this->payment_status = $order->payment_status;
            $this->tracking_number = $order->tracking_number;
        }
    }
    public function save_order_details()
    {
        $order = Order::find($this->order_id);
        if ($order) {
            if ($this->status == 'shipped' && trim($this->tracking_number) === '') {
                $this->addError('tracking_number', __('Tracking number is required to ship.'));
                return;
            }
            $order->update([
                'status' => $this->status
            ]);
            return redirect()->route('admin.orders')->with('success', __('Order status updated successfully.'));
        }
    }

    public function deliver()
    {
        $order = Order::find($this->order_id);
        if ($order && $order->payment_status != 'paid') {
            return redirect()->route('admin.orders.details', $this->order_id)
                ->with('error', __('Cannot deliver: payment is not confirmed yet.'));
        }

        if (trim($this->tracking_number) === '') {
            $this->addError('tracking_number', __('Tracking number is required to ship.'));
            return;
        }

        $mail_data = [
            'user_name' => $this->buyer_name,
            'product' => $this->delivery_mail,
            'title' => $this->mail_title,
            'order_id' => $this->order_id
        ];
        if (Mail::to($this->buyer_email)->send(new DeliverProductMail($mail_data))) {
            Order::find($this->order_id)
                ->update([
                    'status' => 'shipped',
                    'tracking_number' => $this->tracking_number
                ]);
            return redirect()->route('admin.orders')->with('success', __('Product shipped successfully.'));
        } else {
            return redirect()->route('admin.orders')->with('error', __('Something went wrong.'));
        }

    }

    public function confirmDelivered()
    {
        $order = Order::find($this->order_id);
        if (!$order || $order->status != 'shipped') {
            return redirect()->route('admin.orders.details', $this->order_id)
                ->with('error', __('Cannot confirm delivery: order is not shipped yet.'));
        }
        $order->update(['status' => 'delivered']);
        return redirect()->route('admin.orders')->with('success', __('Order confirmed as delivered.'));
    }
    public function render()
    {
        $order = Order::with('paymentProofs.reviewer')->find($this->order_id);
        return view('livewire.admin.order-details-component', ['order' => $order])->layout('components.layouts.admin');
    }
}
