<?php

namespace App\Livewire\Jasa;

use App\Livewire\Forms\JasaForm;
use App\Models\Jasa;
use App\Models\JenisKendaraan;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Memperbarui Data Jasa')]
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

        return redirect()->route('jasa.view')->with('success','Data berhasil diperbarui');
    }

    public function render()
    {
        return view('livewire.jasa.edit',[
            'jasa' => $this->jasa, 'jenis_kendaraan' => JenisKendaraan::all()
        ]);
    }
}
