<?php

namespace App\Livewire\User;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Create extends Component
{
    public UserForm $form;
    public $attempts = 0; // Counter percobaan password
    public $password_confirmation='';
    public $showModal = false;

    function validateInput(){
        $this->form->validate();
        $this->showModal = true;
        return $this->form->all();
    }
    
    public function submit()
    {
        // Trim whitespace dari input
        $this->password_confirmation = trim($this->password_confirmation);
        
        // Validasi input tidak kosong
        if (empty($this->password_confirmation)) {
            session()->flash('message', 'Password tidak boleh kosong.');
            return;
        }

        // Cek batas percobaan (harus di awal)
        if ($this->attempts == 3) {
            session()->flash('message', 'Anda telah melebihi batas percobaan password!');
            return redirect()->route('user.view');
        }

        // Verifikasi password admin
        if (Hash::check($this->password_confirmation, Auth::user()->password)) {
            $validated = $this->validateInput();
            
            // Password default yang lebih aman
            $validated['password'] = $validated['password'] 
                ? bcrypt($validated['password'])
                : bcrypt('password'); // Gunakan random string
            
            try {
                $user = User::create($validated);
                event(new Registered($user));
                
                session()->flash('success', 'User berhasil ditambahkan!');
                return redirect()->route('user.view');
            } catch (\Exception $e) {
                session()->flash('message', 'Gagal menambahkan user: '.$e->getMessage());
            }
        } 
        else {
            $this->attempts++; // Tambah counter percobaan
            session()->flash('message', 'Password tidak sesuai. Percobaan ' . $this->attempts . '/3');
            $this->reset('password_confirmation');
            
            // Jika melebihi batas setelah increment
            if ($this->attempts == 3) {
                session()->flash('message', 'Anda telah melebihi batas percobaan password!');
                session()->flash('error', 'gagal menambahkan user: Anda telah melebihi batas percobaan password!');
                return redirect()->route('user.view');
                // Tambahkan delay atau lockout period jika perlu
            }
        }
    }

    // public function submit()
    // {
    //     if (Hash::check($this->password_confirmation, Auth::user()->password)) { 
    //         $validated = $this->validateInput();
            
    //         // Password default jika kosong
    //         $validated['password'] = $validated['password']
    //         ? bcrypt($validated['password'])
    //         : bcrypt('password');
    //         $user=User::create($validated);
            
    //         event(new Registered($user));
            
    //         session()->flash('success', 'User berhasil ditambahkan!');
    //         return redirect()->route('user.view')->with('wire:navigate', true);
    //     } else {
    //         // Increment jumlah percobaan password
    //         session()->flash('message', 'Password tidak sesuai. Coba lagi.');
    //         $this->reset('password_confirmation');   
    //     }
    // }
    public function render()
    {
        return view('livewire.user.create');
    }
}
