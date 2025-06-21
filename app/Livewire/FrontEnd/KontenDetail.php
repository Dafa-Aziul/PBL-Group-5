<?php

namespace App\Livewire\FrontEnd;

use App\Models\Konten;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[layout('layouts.guest')]
#[Title('Berita & Promosi Bengkel')]
class KontenDetail extends Component
{
    public $konten;

    public function mount($id)
    {
        $this->konten = Konten::with('penulis.user')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.front-end.konten-detail');
    }
}
