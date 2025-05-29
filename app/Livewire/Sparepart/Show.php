<?php

namespace App\Livewire\Sparepart;

use App\Models\Sparepart;
use Livewire\Component;

class Show extends Component
{
    public $id;
    public $sparepart;

    public function mount($id)
    {
        $this->sparepart = Sparepart::find($id);
    }


    public function render()
    {

        return view('livewire.sparepart.show', [
            'sparepart' => $this->sparepart,
        ]);
    }
}
