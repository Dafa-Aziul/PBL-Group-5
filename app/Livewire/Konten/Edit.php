<?php

namespace App\Livewire\Konten;

use App\Livewire\Forms\KontenForm;
use App\Models\Konten;
use Livewire\Component;

class Edit extends Component
{
    public Konten $konten;
    public KontenForm $form;

    public function mount($id)
    {
        $this->konten = Konten::findOrFail($id);
        $this->form->fillFromModel($this->konten);
    }

    public function update()
    {
        $validated = $this->form->validate();
        $this->konten->update($validated);

        // session()->flash('message', 'Data berhasil diperbarui!');
        return redirect()->route('konten.view')->with('success', 'Data berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.konten.edit');
    }
}
