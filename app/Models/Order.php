<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=['status','total_price','user_id', 'payment_method', 'payment_number', 'payment_transaction_id', 'payment_status', 'shipping_name', 'shipping_phone', 'shipping_address', 'shipping_city', 'shipping_postal_code', 'tracking_number'];

    public function getDisplayStatusAttribute()
    {
        if ($this->status == 'cancelled') {
            return 'cancelled';
        }
        if ($this->status == 'delivered') {
            return 'delivered';
        }
        if ($this->status == 'shipped') {
            return 'shipping';
        }
        if ($this->payment_status == 'unpaid') {
            return 'unpaid';
        }
        if ($this->payment_status == 'rejected') {
            return 'rejected';
        }
        if ($this->payment_status == 'pending_review') {
            return 'pending_review';
        }
        if ($this->payment_status == 'paid' && in_array($this->status, ['ordered', 'processing'])) {
            return 'pending_shipment';
        }
        return 'unknown';
    }

    public static function displayStatusLabels()
    {
        return [
            'unpaid' => ['text' => 'Unpaid', 'class' => 'bg-warning'],
            'pending_review' => ['text' => 'Pending Review', 'class' => 'bg-info'],
            'pending_shipment' => ['text' => 'Pending Shipment', 'class' => 'bg-primary'],
            'shipping' => ['text' => 'Shipping', 'class' => 'bg-primary'],
            'delivered' => ['text' => 'Delivered', 'class' => 'bg-success'],
            'rejected' => ['text' => 'Rejected', 'class' => 'bg-danger'],
            'cancelled' => ['text' => 'Cancelled', 'class' => 'bg-danger'],
        ];
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentProofs()
    {
        return $this->hasMany(PaymentProof::class);
    }

    public function latestProof()
    {
        return $this->hasOne(PaymentProof::class)->latestOfMany();
    }
}
