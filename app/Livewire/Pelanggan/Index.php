<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pelanggan;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $search = '';


    public function updatingSearch()
    {
        $this->resetPage(); // Kembali ke halaman 1 saat pencarian berubah
    }

    public function redirectToDetail($id)
    {
        $this->dispatch('redirect-to-detail', id: $id);
    }
    public function render()
    {
        $pelanggans = Pelanggan::search($this->search)->paginate($this->perPage);
        return view('livewire.pelanggan.index',  compact('pelanggans'));
    }
}
