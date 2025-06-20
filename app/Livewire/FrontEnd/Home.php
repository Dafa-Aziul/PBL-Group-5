<?php

namespace App\Livewire\FrontEnd;

use App\Models\Konten;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[layout('layouts.guest')]
#[Title('CV. Razka Pratama - Bengkel Truk & Mobil Profesional')]
class Home extends Component
{
    public function render()
    {
        $kontens = Konten::with('penulis')
            ->where('status', 'terbit') // hanya konten dengan status "terbit"
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('livewire.front-end.home', compact('kontens'));
    }
}
