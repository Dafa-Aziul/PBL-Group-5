<?php

namespace App\Livewire\FrontEnd;

use App\Models\Konten;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[layout('layouts.guest')]
class Home extends Component
{
    public function render()
    {
        $kontens = Konten::with('penulis')->orderBy('created_at', 'desc')->take(6)->get(); // ambil max 6 konten
        return view('livewire.front-end.home', compact('kontens'));
    }
}
