<?php

namespace App\Livewire\Jasa;

use App\Livewire\Forms\JasaForm;
use App\Models\Jasa;
use App\Models\JenisKendaraan;
use Livewire\Component;

class Edit extends Component
{
    public $jasa;
    public JasaForm $form;
    

    public function mount($id)
    {
        $this->jasa = Jasa::findOrFail($id);
        $this->form->fillFormModel($this->jasa);
    }
    
    public function update()
    {
        $validated = $this->form->validate();
        $this->jasa->update($validated);

        return redirect()->route('jasa.view')->with('succes','Data berhasil diperbarui');
    }
   
    public function render()
    {
        return view('livewire.jenis-jasa.edit',[
            'jasa' => $this->jasa, 'jenis_kendaraan' => JenisKendaraan::all()
        ]);
    }
}
