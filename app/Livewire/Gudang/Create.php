<?php

namespace App\Livewire\Gudang;

use App\Livewire\Forms\GudangForm;
use App\Models\Gudang;
use App\Models\Sparepart;
use Livewire\Component;

class Create extends Component
{
    public $sparepart_id;
    public GudangForm $form;


    public function mount($id){
        $this->sparepart_id = $id;
    }
    public function submit()
    {
        $data = $this->form->validate();
        $data['sparepart_id'] = $this->sparepart_id;

        $sparepart = Sparepart::findOrFail($this->sparepart_id);

        // Cek stok saat aktivitas keluar
        if ($data['aktivitas'] === 'keluar' && $sparepart->stok < $data['jumlah']) {
            $this->addError('form.jumlah', 'Stok tidak mencukupi untuk aktivitas keluar.');
            return;
        }

        // Simpan monitoring
        Gudang::create($data);

        // Update stok sparepart
        if ($data['aktivitas'] === 'masuk') {
            $sparepart->stok += $data['jumlah'];
        } else {
            $sparepart->stok -= $data['jumlah'];
        }
        $sparepart->save();

        session()->flash('success', 'Monitoring berhasil ditambahkan dan stok diperbarui!');
        return redirect()->route('sparepart.show', ['id'=>$sparepart->id])->with('wire:navigate', true);
    }

    public function render()
    {
        $sparepart = Sparepart::findOrFail($this->sparepart_id);
        return view('livewire.gudang.create', compact('sparepart'));
    }
}
