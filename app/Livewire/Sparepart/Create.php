<?php

namespace App\Livewire\Sparepart;

use Livewire\Attributes\Validate;
use App\Livewire\Forms\SparepartForm;
use App\Models\Sparepart;
use Livewire\WithFileUploads;
use Livewire\Component;

class Create extends Component
{
    use WithFileUploads; // ✅ WAJIB ditambahkan

    public SparepartForm $form;

    #[Validate('required|unique:spareparts,kode|string|max:255')]
    public string $kode = '';


    public function submit(){
        // Validasi hanya properti kode di komponen ini
        $this->form->harga = $this->form->harga ?? 0;

        // Validasi form (SparepartForm)
        $validated = $this->form->validate();

        // Validasi kode unik dari komponen ini
        $validatedKode = $this->validateOnly('kode');

        // Simpan foto jika ada
        if ($this->form->foto) {
            $path = $this->form->foto->store('images/sparepart', 'public');
            $filename = basename($path);
            $validated['foto'] = 'images/sparepart/' . $filename;
        }

        // Gabungkan kode + form
        $data = array_merge(['kode' => $this->kode], $validated);
        Sparepart::create($data);

        session()->flash('success', 'Sparepart berhasil ditambahkan!');
        return redirect()->route('sparepart.view')->with('wire:navigate', true);
    }

    public function render()
    {
        return view('livewire.sparepart.create');
    }
}
