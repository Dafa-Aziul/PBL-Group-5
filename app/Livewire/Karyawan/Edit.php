<?php

namespace App\Livewire\Karyawan;

use App\Livewire\Forms\KaryawanForm;
use App\Models\Karyawan;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Karyawan $karyawan;
    public KaryawanForm $form;
    public $users;

    public function mount($id)
    {
        $this->karyawan = Karyawan::findOrFail($id);
        $this->users = User::all();

        // Inisialisasi form
        $this->form = new KaryawanForm($this, []);
        $this->form->fillFormModel($this->karyawan);
    }

    public function updatedFormUserId($value)
    {
        $user = User::find($value);
        if ($user) {
            $this->form->nama = $user->name;
            $this->form->jabatan = $user->role ?? '';
        }
    }

    public function update()
    {
        $validated = $this->form->validate();

        if ($this->form->foto) {
            // Simpan file baru
            $filename = $this->form->foto->store('foto', 'public');
            $validated['foto'] = $filename;

            // Hapus foto lama jika ada
            if ($this->karyawan->foto) {
                \Storage::disk('public')->delete($this->karyawan->foto);
            }
        } else {
            unset($validated['foto']); // Jangan update kalau tidak ada foto baru
        }

        $this->karyawan->update($validated);

        session()->flash('success', 'Data berhasil diperbarui!');
        return redirect()->route('karyawan.view');
    }

    public function render()
    {
        return view('livewire.karyawan.edit', [
            'karyawan' => $this->karyawan,
            'users' => $this->users,
        ]);
    }
}
