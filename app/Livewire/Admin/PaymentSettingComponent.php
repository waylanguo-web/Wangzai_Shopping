<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PaymentSetting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PaymentSettingComponent extends Component
{
    use WithFileUploads;

    public $name, $note, $number, $type, $qr_image, $old_qr_image, $enabled;

    public $isUpdateMode = false;
    public $updatePayment_id;

    public function mount()
    {
        $this->type = 'transfer';
        $this->enabled = true;
    }

    private function emptyField()
    {
        $this->name = '';
        $this->note = '';
        $this->number = '';
        $this->type = 'transfer';
        $this->qr_image = '';
        $this->old_qr_image = '';
        $this->enabled = true;
    }

    public function SavePayment()
    {
        $rules = [
            'name' => 'required',
            'note' => 'required',
            'type' => 'required|in:transfer,qr',
            'enabled' => 'boolean',
        ];
        if ($this->type == 'transfer') {
            $rules['number'] = 'required';
        } else {
            $rules['number'] = 'nullable';
            if (!$this->isUpdateMode) {
                $rules['qr_image'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
            } else {
                $rules['qr_image'] = 'nullable|image|mimes:jpeg,png,jpg|max:2048';
            }
        }

        $validatedData = $this->validate($rules);

        if ($this->isUpdateMode) {
            $payment = PaymentSetting::find($this->updatePayment_id);
            $payment->name = $this->name;
            $payment->note = $this->note;
            $payment->number = $this->number;
            $payment->type = $this->type;
            $payment->enabled = $this->enabled;
            if ($this->qr_image) {
                if ($payment->qr_image) {
                    @unlink('storage/' . $payment->qr_image);
                }
                $qrName = Carbon::now()->timestamp . '-' . Str::random(8) . '.' . $this->qr_image->getClientOriginalExtension();
                $payment->qr_image = $this->qr_image->storeAs('payment-qr', $qrName, 'public');
            }
            $payment->save();
            $this->isUpdateMode = false;
            $this->emptyField();
            session()->flash('success', __('Payment method updated successfully.'));
        } else {
            $payment = new PaymentSetting();
            $payment->name = $this->name;
            $payment->note = $this->note;
            $payment->number = $this->number;
            $payment->type = $this->type;
            $payment->enabled = $this->enabled;
            if ($this->qr_image) {
                $qrName = Carbon::now()->timestamp . '-' . Str::random(8) . '.' . $this->qr_image->getClientOriginalExtension();
                $payment->qr_image = $this->qr_image->storeAs('payment-qr', $qrName, 'public');
            }
            if ($payment->save()) {
                $this->emptyField();
                session()->flash('success', __('Payment method added successfully.'));
            } else {
                session()->flash('error', __('Something went wrong.'));
            }
        }
    }

    public function editePaymentMethod($id)
    {
        $payment = PaymentSetting::find($id);
        $this->updatePayment_id = $id;
        $this->name = $payment->name;
        $this->note = $payment->note;
        $this->number = $payment->number;
        $this->type = $payment->type;
        $this->old_qr_image = $payment->qr_image;
        $this->enabled = $payment->enabled;
        $this->isUpdateMode = true;
    }

    public function deletePaymentMethod($id)
    {
        $payment = PaymentSetting::find($id);
        if ($payment->qr_image) {
            @unlink('storage/' . $payment->qr_image);
        }
        if ($payment->delete()) {
            session()->flash('success', __('Payment method deleted successfully.'));
        } else {
            session()->flash('error', __('Something went wrong.'));
        }
    }

    public function render()
    {
        $payments = PaymentSetting::all();
        return view('livewire.admin.payment-setting-component', ['payments' => $payments])->layout('components.layouts.admin');
    }
}
