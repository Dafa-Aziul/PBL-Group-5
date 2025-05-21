<?php

namespace App\Livewire\Konten;

use App\Livewire\Forms\KontenForm;
use App\Models\Konten;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Component;

class Edit extends Component
{
    use WithFileUploads;
    public Konten $konten;
    public KontenForm $form;

    public function mount($id)
    {
        $this->konten = Konten::findOrFail($id);
        $this->form->fillFromModel($this->konten);
    }

    public function update()
    {
        $validated = $this->form->validate();

        if ($this->form->foto_konten) {
            if ($this->form->gambar_lama && Storage::disk('public')->exists('konten/gambar/' . $this->form->gambar_lama)) {
                Storage::disk('public')->delete('konten/gambar/' . $this->form->gambar_lama);
            }

            $path = $this->form->foto_konten->store('konten/gambar', 'public');
            $validated['foto_konten'] = basename($path);
        }

        if ($this->form->video_konten) {
            if ($this->form->video_lama && Storage::disk('public')->exists('konten/video/' . $this->form->video_lama)) {
                Storage::disk('public')->delete('konten/video/' . $this->form->video_lama);
            }

            $path = $this->form->video_konten->store('konten/video', 'public');
            $validated['video_konten'] = basename($path);
        }

        $this->konten->update($validated);

        session()->flash('success', 'Konten berhasil diperbarui!');
        return redirect()->route('konten.view');
    }


    public function render()
    {
        return view('livewire.konten.edit');
    }
}
