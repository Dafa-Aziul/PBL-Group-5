<?php

namespace App\Livewire\Konten;

use App\Livewire\Forms\KontenForm;
use App\Models\Konten;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads; // Tambahkan ini
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Tambah Konten Baru')]
class Create extends Component
{
    use WithFileUploads;

    public KontenForm $form;

    public function submit()
    {
        // dd($this->form);
        $validated = $this->form->validate();

        $gambarPath = null;
        $videoPath = null;

        if ($this->form->foto_konten) {
            $gambarPath = $this->form->foto_konten->store('konten/gambar', 'public');
            $gambarPath = basename($gambarPath);
        }

        if ($this->form->video_konten) {
            $videoPath = $this->form->video_konten->store('konten/video', 'public');
            $videoPath = basename($videoPath);
        }

        Konten::create([
            ...$validated,
            'foto_konten' => $gambarPath,
            'video_konten' => $videoPath,
            'penulis_id' => Auth::id(),
        ]);

        session()->flash('success', 'Konten berhasil ditambahkan.');
        return redirect()->route('konten.view');
    }

    public function render()
    {
        return view('livewire.konten.create');
    }
}
