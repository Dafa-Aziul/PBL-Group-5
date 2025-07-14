<?php

namespace App\Livewire\User;

use App\Livewire\Forms\UserForm;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Tambah User Baru')]
class Create extends Component
{
    public UserForm $form;
    public $attempts = 0; // Counter percobaan password
    public $password_confirmation = '';
    public $showModal = false;


    function validateInput()
    {
        $this->form->validate();
        $this->dispatch('open-confirm-password-modal');
        return $this->form->all();
    }

    public function submit()
    {
        $this->password_confirmation = trim($this->password_confirmation);

        if (empty($this->password_confirmation)) {
            return $this->fail('Password tidak boleh kosong.');
        }

        if ($this->attempts >= 3) {
            return $this->fail('Anda telah melebihi batas percobaan password!', true);
        }

        if (!Hash::check($this->password_confirmation, Auth::user()->password)) {
            $this->attempts++;
            $this->reset('password_confirmation');

            if ($this->attempts >= 3) {
                return $this->fail('Anda telah melebihi batas percobaan password!', true);
            }

            return $this->fail('Password tidak sesuai. Percobaan ' . $this->attempts . '/3');
        }

        try {
            $validated = $this->validateInput();

            // Tambahkan password default jika kosong
            if (empty($validated['password'])) {
                $validated['password'] = bcrypt('Bengkel@2025!');
            } else {
                $validated['password'] = bcrypt($validated['password']);
            }

            $user = User::create($validated);

            Karyawan::create([
                'user_id' => $user->id,
                'nama' => $validated['name'],
                'jabatan' => $validated['role'] ?? '',
                'status' => 'aktif', // default status
            ]);
            event(new Registered($user));
            session()->flash('success', 'User berhasil ditambahkan!');
            return redirect()->route('user.view');
        } catch (\Exception $e) {
            return $this->fail('Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    protected function fail($message, $redirect = false)
    {
        session()->flash('message', $message);
        session()->flash('error', $message);
        return $redirect ? redirect()->route('user.view') : null;
    }

    public function render()
    {
        return view('livewire.user.create');
    }
}
