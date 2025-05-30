<?php

namespace App\Livewire\Sparepart;

use App\Livewire\Forms\GudangForm;
use App\Models\Gudang;
use App\Models\Sparepart;
use Livewire\Component;

class Show extends Component
{
    public $id;
    public $sparepart;
    public GudangForm $form;

    public function mount($id)
    {
        $this->sparepart = Sparepart::find($id);
    }

    public function updateGudang()
    {
        $data = $this->form->validate();
        $data['sparepart_id'] = $this->sparepart->id;

        $sparepart = Sparepart::findOrFail( $this->sparepart->id);

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
        $this->sparepart = $sparepart->refresh();
        session()->flash('success', 'Monitoring berhasil ditambahkan dan stok diperbarui!');
        $this->closePaymentModal();
    }

    public function closePaymentModal()
    {
        $this->dispatch('hide-modal');
    }


    public function render()
    {

        return view('livewire.sparepart.show', [
            'sparepart' => $this->sparepart,
        ]);
    }
}
