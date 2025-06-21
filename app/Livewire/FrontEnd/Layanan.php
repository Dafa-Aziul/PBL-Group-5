<?php

namespace App\Livewire\FrontEnd;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[layout('layouts.guest')]
#[title('Layanan Unggulan Kami')]
class Layanan extends Component
{
    public function render()
    {
        return view('livewire.front-end.layanan');
    }
}
