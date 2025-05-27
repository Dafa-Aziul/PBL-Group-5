<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.guest')]
#[Title('Login')]
class Login extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = False;

    public function login()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        // Ambil user, pastikan belum di-soft delete
        $user = User::where('email', $this->email)
                    ->whereNull('deleted_at')
                    ->first();

        // Validasi user dan password
        if (!$user || !Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remember)) {
            throw ValidationException::withMessages([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        return redirect()->route('dashboard')->with('wire:navigate', true);
    }
    // public function login()
    // {
    //     $this->validate([
    //         'email' => 'required|email|exists:users,email',
    //         'password' => 'required',
    //     ]);
    //     // Perform login logic here
    //     // For example, using Laravel's Auth facade:
    //     if (Auth::attempt([
    //         'email' => $this->email,
    //         'password' => $this->password,
    //     ], $this->remember)) {
    //         return redirect()->route('dashboard')->with('wire:navigate', true);
    //     }
    //     throw ValidationException::withMessages([
    //         'email' => 'The provided credentials do not match our records.',
    //     ]);
    // }
    public function render()
    {
        return view('livewire.auth.login');
    }
}
