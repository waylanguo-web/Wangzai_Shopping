<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class RegisterComponent extends Component
{
    public $full_name, $email, $phone, $password, $confirm_password;
    public function register()
    {
        $validatedData = $this->validate([
            'full_name' => 'required|min:6',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric',
            'password' => 'required|min:6|same:confirm_password',
            'confirm_password' => 'required|min:6',
        ]);

        $user = new User();
        $user->name = $this->full_name;
        $user->email = $this->email;
        $user->phone_number = $this->phone;
        $user->password = Hash::make($this->password);
        if ($user->save()) {
            return redirect()->route('login')->with('success', __('Registration was successful, Please login to your account.'));
        } else {
            session()->flash('error', __('Something went wrong! Please try again.'));
        }
    }
    public function render()
    {
        return view('livewire.user.register-component');
    }
}
