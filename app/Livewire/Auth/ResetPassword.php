<?php

namespace App\Livewire\Auth;

use \Livewire\Attributes\Title;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[layout('layouts.guest')]
#[Title('Reset Password')]
class ResetPassword extends Component
{
    public string $email = '';
    public string $token = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function resetPassword()
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status))->with('wire:navigate', true); 
        } else {
            $this->addError('email', __($status));
        }
    }
    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
