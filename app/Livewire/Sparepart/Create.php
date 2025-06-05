<?php

namespace App\Livewire\Sparepart;

use Livewire\Attributes\Validate;
use App\Livewire\Forms\SparepartForm;
use App\Models\Sparepart;
use Livewire\WithFileUploads;
use Livewire\Component;

class Create extends Component
{
    use WithFileUploads;

    public SparepartForm $form;

    #[Validate('required|unique:spareparts,kode|string|max:255')]
    public string $kode = '';


    public function submit()
    {
        // Default harga ke 0 jika tidak diisi
        $this->form->harga = $this->form->harga ?? 0;

        // Validasi
        $formData = $this->form->validate();
        $this->validateOnly('kode');

        // Proses upload foto
        if ($this->form->foto) {
            $formData['foto'] = $this->storePhoto($this->form->foto);
        }

        // Simpan ke database
        $data = array_merge(['kode' => $this->kode], $formData);
        Sparepart::create($data);

        session()->flash('success', 'Sparepart berhasil ditambahkan!');
        return redirect()->route('sparepart.view')->with('wire:navigate', true);
    }

    protected function storePhoto($foto): string
    {
        $path = $foto->store('images/sparepart', 'public');
        return basename($path);
    }

    public function render()
    {
        return view('livewire.sparepart.create');
    }
}
