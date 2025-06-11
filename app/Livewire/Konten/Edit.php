<?php

namespace App\Livewire\Konten;

use App\Livewire\Forms\KontenForm;
use App\Models\Konten;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Memperbarui Data Konten')]
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

            $gambarPath = $this->form->foto_konten->store('konten/gambar', 'public');
            $validated['foto_konten'] = basename($gambarPath);
        } else {
            // Pakai gambar lama jika tidak ada upload baru
            $validated['foto_konten'] = $this->form->gambar_lama;
        }

        if ($this->form->video_konten) {
            if ($this->form->video_lama && Storage::disk('public')->exists('konten/video/' . $this->form->video_lama)) {
                Storage::disk('public')->delete('konten/video/' . $this->form->video_lama);
            }

            $videoPath = $this->form->video_konten->store('konten/video', 'public');
            $validated['video_konten'] = basename($videoPath);
        } else {
            // Pakai video lama jika tidak ada upload baru
            $validated['video_konten'] = $this->form->video_lama;
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
