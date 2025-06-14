<?php

namespace App\Livewire\FrontEnd;

use App\Models\Karyawan;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[layout('layouts.guest')]
class About extends Component
{
    public function render()
    {
        $karyawans = Karyawan::with('user')->get();
        return view('livewire.front-end.about', compact('karyawans'));
    }
}
