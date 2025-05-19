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
        // $this->sparepart = Sparepart::with('monitoring_spareparts')->findOrFail($id);
        $this->sparepart = Sparepart::find($id);
    }

    public function goToShow($id)
    {
        return redirect()->route('sparepart.show', ['id' => $id]);
    }


    public function render()
    {

        // $sparepart = Sparepart::findOrFail($this->id);
        // return view('livewire.sparepart.show', compact('sparepart'));
         return view('livewire.sparepart.show', [
        'sparepart' => $this->sparepart,
    ]);
    }
}
