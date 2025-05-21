<?php

namespace App\Livewire\Konten;

use App\Models\Konten;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'bootstrap';
        
    public $perPage = 5;
    public $search = '';
    public function render()
    {
        // $jenis_kendaraans = JenisKendaraan::search($this->search);
        // return view('livewire.konten.index', compact('kontens'));
        return view('livewire.konten.index', [
            'kontens' => Konten::search($this->search)->paginate($this->perPage),
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Kembali ke halaman 1 saat pencarian berubah
    }

    public function delete($id)
    {
        $jenis_kendaraan = Konten::findOrFail($id);
        $jenis_kendaraan->delete();
        return session()->flash('success', 'Konten berhasil dihapus.');
    }
}