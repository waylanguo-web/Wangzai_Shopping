<?php

namespace App\Livewire\User;

use App\Models\Order;
use App\Models\PaymentProof;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class UploadProofComponent extends Component
{
    use WithFileUploads;

    public $order_id;
    public $order;
    public $proof_image;
    public $currency_symbol;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
        $this->order = Order::find($order_id);

        if (!$this->order || $this->order->user_id != auth()->id()) {
            return redirect()->route('user.home');
        }

        if (!in_array($this->order->payment_status, ['unpaid', 'rejected'])) {
            return redirect()->route('user.profile');
        }

        $this->currency_symbol = optional(\App\Models\Setting::first())->currency_unicode;
    }

    public function uploadProof()
    {
        $this->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imageName = Carbon::now()->timestamp . '-' . Str::random(8) . '.' . $this->proof_image->getClientOriginalExtension();
        $imagePath = $this->proof_image->storeAs('payment-proofs', $imageName, 'public');

        PaymentProof::create([
            'order_id' => $this->order_id,
            'image_path' => $imagePath,
            'status' => 'pending',
        ]);

        $this->order->update(['payment_status' => 'pending_review']);

        session()->flash('success', __('Payment proof uploaded successfully. We will review it shortly.'));
        return redirect()->route('user.profile');
    }

    public function render()
    {
        return view('livewire.user.upload-proof-component')->layout('components.layouts.app');
    }
}