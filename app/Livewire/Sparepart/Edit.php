<?php

namespace App\Livewire\Sparepart;

use App\Livewire\Forms\SparepartForm;
use App\Models\Sparepart;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Attributes\Title;

#[Title('Memperbarui Data Sparepart')]
class Edit extends Component
{
    use WithFileUploads;
    public $sparepart;
    public SparepartForm $form;

    public function mount($id): void
    {
        $this->sparepart = Sparepart::findOrFail($id);
        $this->form->fillFormModel($this->sparepart);
        $this->form->harga = $this->form->harga ?? 0;
    }

    public function update()
    {
        $validated = $this->form->validate();

        if ($this->form->foto) {
            $validated['foto'] = $this->handlePhotoUpdate($this->form->foto, $this->sparepart->foto);
        } else {
            unset($validated['foto']);
        }

        $this->sparepart->update($validated);

        return redirect()->route('sparepart.view')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Handle upload dan hapus foto lama jika ada.
     */
    protected function handlePhotoUpdate($newPhoto, ?string $oldPhotoPath): string
    {
        // Simpan foto baru
        $path = $newPhoto->store('images/sparepart', 'public');
        $filename = basename($path);

        // Hapus foto lama jika ada
        if ($oldPhotoPath && Storage::disk('public')->exists($oldPhotoPath)) {
            Storage::disk('public')->delete($oldPhotoPath);
        }

        return $filename;
    }
    public function render()
    {
        return view('livewire.sparepart.edit', ['sparepart' => $this->sparepart]);
    }
}
