<?php

namespace App\Livewire\FrontEnd;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[layout('layouts.guest')]
class Layanan extends Component
{
    public function render()
    {
        return view('livewire.front-end.layanan');
    }
}
