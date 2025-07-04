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
        $this->validateOnly('user_id');

        $validated = $this->form->validate();
        if ($this->form->foto) {
            // Simpan file dengan nama yang di-hash ke folder 'foto'
            $path = $this->form->foto->store('images/profile', 'public');

            // Ambil hanya nama file-nya saja (tanpa folder 'foto/')
            $filename = basename($path);

            // Simpan ke database hanya nama file-nya
            $validated['foto'] = $filename;
        }

        $validated['user_id'] = $this->user_id;

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
