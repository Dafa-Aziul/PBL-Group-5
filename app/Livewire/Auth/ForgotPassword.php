<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[layout('layouts.auth')]
#[Title('Lupa Password')]
class ForgotPassword extends Component
{
    public string $email = '';

    public function sendPasswordResetLink()
    {
         $this->validate([
        'email' => 'required|email|exists:users,email',
        ]);

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('status', 'Link reset telah dikirim ke email Anda.');
        } else {
            $this->addError('email', __($status));
        }

    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
