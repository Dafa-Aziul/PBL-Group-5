<?php

namespace App\Livewire\Sparepart;

use App\Models\Sparepart;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $search = '';
    public array $stokInput = [];



    public function updatingSearch()
    {
        $this->resetPage(); // Kembali ke halaman 1 saat pencarian berubah
    }

    public function delete($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->delete();
        return session()->flash('success', 'sparepart berhasil dihapus.');
    }

    public function render()
    {
        $spareparts = Sparepart::search($this->search)->paginate($this->perPage);
        return view('livewire.sparepart.index', compact('spareparts'));
    }

}
