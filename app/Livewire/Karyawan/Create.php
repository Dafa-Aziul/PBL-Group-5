<?php

namespace App\Livewire\Karyawan;

use App\Livewire\Forms\KaryawanForm;
use App\Models\User;
use App\Models\Karyawan;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

#[Title('Tambah Data Karyawan Baru')]
class Create extends Component
{
    use WithFileUploads;

    public KaryawanForm $form;
    public $users;
    #[Validate('required|unique:karyawans,user_id')]
    public $user_id;

    public function mount()
    {
        $this->form = new KaryawanForm($this, []);
        $this->form->status = 'aktif'; // default status
        $this->users = User::all();
    }

    public function updatedUserId($value)
    {
        $user = User::find($value);
        if ($user) {
            $this->form->nama = $user->name;
            $this->form->jabatan = $user->role ?? '';
        }
    }

    public function submit()
    {
        // Pastikan nilai user_id dimasukkan ke dalam objek form
        $this->form->user_id = $this->user_id;

        // Debug untuk melihat semua isi form (termasuk user_id sekarang)

        // Validasi semua input termasuk user_id dari form
        $validated = $this->form->validate();
        // dd($validated); // Debug untuk melihat data yang divalidasi
        if ($this->form->foto) {
            $path = $this->form->foto->store('images/profile', 'public');
            $validated['foto'] = basename($path);
        }

        Karyawan::create($validated);

        return redirect()->route('karyawan.view')->with('success', 'Karyawan berhasil ditambahkan!');
    }


    public function render()
    {
        return view('livewire.karyawan.create', [
            'users' => $this->users
        ]);
    }
}
