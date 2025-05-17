<?php

namespace App\Livewire\Karyawan;

use App\Livewire\Forms\KaryawanForm;
use App\Models\User;
use App\Models\Karyawan;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public KaryawanForm $form;
    public $users;

    public function mount()
    {
        $this->form = new KaryawanForm($this, []);
        $this->form->status = 'aktif'; // default status
        $this->users = User::all();
    }

    public function updatedFormUserId($value)
    {
        $user = User::find($value);
        if ($user) {
            $this->form->nama = $user->name;
            $this->form->jabatan = $user->role ?? '';
        }
    }

    public function submit()
    {
        $validated = $this->form->validate();

        if ($this->form->foto) {
            // Pastikan ini adalah TemporaryUploadedFile
            $filename = $this->form->foto->store('foto', 'public');
            $validated['foto'] = $filename;
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
