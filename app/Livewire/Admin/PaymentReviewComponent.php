<?php

namespace App\Livewire\Admin;

use App\Models\PaymentProof;
use Livewire\Component;

class PaymentReviewComponent extends Component
{
    public $reject_reason;
    public $filter = 'pending';

    public function approveProof($id)
    {
        $proof = PaymentProof::find($id);
        if (!$proof) {
            session()->flash('error', __('Something went wrong.'));
            return;
        }
        $proof->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);
        $proof->order->update(['payment_status' => 'paid']);
        session()->flash('success', __('Payment proof approved. Order is now paid.'));
    }

    public function rejectProof($id)
    {
        $this->validate([
            'reject_reason' => 'required',
        ]);

        $proof = PaymentProof::find($id);
        if (!$proof) {
            session()->flash('error', __('Something went wrong.'));
            return;
        }
        $proof->update([
            'status' => 'rejected',
            'reject_reason' => $this->reject_reason,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);
        $proof->order->update(['payment_status' => 'rejected']);
        $this->reject_reason = '';
        session()->flash('success', __('Payment proof rejected. User can re-upload.'));
    }

    public function updatedFilter()
    {
        $this->reject_reason = '';
    }

    public function render()
    {
        $query = PaymentProof::with('order.user')->latest();
        if ($this->filter == 'pending') {
            $query->where('status', 'pending');
        } elseif ($this->filter == 'approved') {
            $query->where('status', 'approved');
        } elseif ($this->filter == 'rejected') {
            $query->where('status', 'rejected');
        }
        $proofs = $query->paginate(15);
        return view('livewire.admin.payment-review-component', ['proofs' => $proofs])->layout('components.layouts.admin');
    }
}