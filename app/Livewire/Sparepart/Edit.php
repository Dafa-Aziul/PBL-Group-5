<?php

namespace App\Livewire\Sparepart;

use App\Livewire\Forms\SparepartForm;
use App\Models\Sparepart;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    public $sparepart;
    public SparepartForm $form;

    public function mount($id)
    {
        $this->sparepart = Sparepart::findOrFail($id);
        $this->form->fillFormModel($this->sparepart);
        $this->form->harga = $this->form->harga ?? 0; // <-- aman
        // $this->dispatchBrowserEvent('formatHargaAwal', ['harga' => $sparepart->harga]);
    }


    public function update()
    {
        $validated = $this->form->validate();

        if ($this->form->foto) {
            // Simpan file baru
            $path = $this->form->foto->store('images/sparepart', 'public');
            $filename = basename($path);
            $validated['foto'] = 'images/sparepart/' . $filename;
            // Hapus foto lama jika ada
            if ($this->sparepart->foto && Storage::disk('public')->exists($this->sparepart->foto)) {
                Storage::disk('public')->delete($this->sparepart->foto);
            }
        } else {
            unset($validated['foto']); // Jangan update kalau tidak ada foto baru
        }

        $this->sparepart->update($validated);

        return redirect()->route('sparepart.view')->with('success', 'Data berhasil diperbarui');
    }

    public function render()
    {
        return view('livewire.sparepart.edit', ['sparepart' => $this->sparepart]);
    }
}
