<?php

namespace App\Livewire\JenisKendaraan;

use App\Models\JenisKendaraan;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Component;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $search = '';
    public function render()
    {
        // $jenis_kendaraans = JenisKendaraan::search($this->search);
        // return view('livewire.jenis-kendaraan.index', compact('jenis_kendaraans'));
        return view('livewire.jenis-kendaraan.index', [
            'jenis_kendaraans' => JenisKendaraan::search($this->search)->paginate($this->perPage),
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Kembali ke halaman 1 saat pencarian berubah
    }

    public function delete($id)
    {
        $jenis_kendaraan = JenisKendaraan::findOrFail($id);
        $jenis_kendaraan->delete();
        return session()->flash('success', 'Jenis Kendaraan berhasil dihapus.');
    }
}
