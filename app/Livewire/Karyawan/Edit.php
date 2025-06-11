<?php

namespace App\Livewire\Karyawan;

use App\Livewire\Forms\KaryawanForm;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

#[Title('Perbarui Data Karyawan')]
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
            // Simpan file dengan nama yang di-hash ke folder 'foto'
            $path = $this->form->foto->store('images/profile', 'public');

            // Ambil hanya nama file-nya saja (tanpa folder 'foto/')
            $filename = basename($path);

            // Simpan ke database hanya nama file-nya
            $validated['foto'] = $filename;

            // Hapus foto lama jika ada
            if ($this->karyawan->foto) {
                Storage::disk('public')->delete($this->karyawan->foto);
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
