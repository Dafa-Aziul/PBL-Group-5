<?php

namespace App\Livewire\Sparepart;

use App\Livewire\Forms\SparepartForm;
use App\Models\Sparepart;
use Livewire\Component;

class Edit extends Component
{
    public $sparepart;
    public SparepartForm $form;

   public function mount($id)
    {
        $this->sparepart = Sparepart::findOrFail($id);
        $this->form->fillFormModel($this->sparepart);
        $this->form->harga = $this->form->harga ?? 0; // <-- aman
        // $this->dispatchBrowserEvent('formatHargaAwal', ['harga' => $sparepart->harga]);
    }


    public function update()
    {
        $validated = $this->form->validate();
        $this->sparepart->update($validated);

        return redirect()->route('sparepart.view')->with('succes','Data berhasil diperbarui');
    }

    public function render()
    {
        return view('livewire.sparepart.edit', ['sparepart'=>$this->sparepart]);
    }
}
