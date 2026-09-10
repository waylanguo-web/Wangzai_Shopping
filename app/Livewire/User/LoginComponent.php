<?php

namespace App\Livewire\User;

use Livewire\Component;

class LoginComponent extends Component
{
    public $email, $password, $loginError;

    public function login()
    {
        $this->loginError = null;

        $validatedData = $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect()->route('user.home');
        } else {
            $this->loginError = __('Invalid email or password.');
        }
    }
    public function render()
    {
        return view('livewire.user.login-component');
    }
}
