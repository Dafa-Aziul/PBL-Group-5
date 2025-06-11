<?php

namespace App\Livewire\Sparepart;

use App\Livewire\Forms\GudangForm;
use App\Models\Gudang;
use App\Models\Sparepart;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Detail Data Sparepart')]
class Show extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $search = '';
    public $id;
    public $sparepart;
    public GudangForm $form;

    public function mount($id)
    {
        $this->sparepart = Sparepart::find($id);
    }

    public function resetForm()
    {
        $this->form->reset(); // Mereset semua properti di GudangForm
    }

    public function updateGudang()
    {
        // Validasi langsung dari form
        $this->form->validate();

        // Ambil data sparepart
        $sparepart = Sparepart::findOrFail($this->sparepart->id);

        // Cek stok saat aktivitas keluar
        if ($this->form->aktivitas === 'keluar' && $sparepart->stok < $this->form->jumlah) {
            $this->addError('form.jumlah', 'Stok tidak mencukupi untuk aktivitas keluar.');
            return;
        }

        // Simpan monitoring ke tabel gudangs melalui relasi (menggunakan fungsi simpan di form)
        $this->form->simpan($sparepart);

        // Update stok sparepart
        if ($this->form->aktivitas === 'masuk') {
            $sparepart->stok += $this->form->jumlah;
        } else {
            $sparepart->stok -= $this->form->jumlah;
        }

        $sparepart->save();
        $this->sparepart = $sparepart->refresh();

        // Feedback dan reset form
        session()->flash('success', 'Monitoring berhasil ditambahkan dan stok diperbarui!');
        $this->form->resetForm();
        $this->closePaymentModal();
    }


    public function closePaymentModal()
    {
        $this->dispatch('hide-modal');
    }


    public function render()
    {
        return view('livewire.sparepart.show', [
            'sparepart' => $this->sparepart, 'gudangs' => $this->sparepart->gudangs()->paginate($this->perPage),
        ]);
    }
}
