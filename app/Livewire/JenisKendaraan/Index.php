<?php

namespace App\Livewire\JenisKendaraan;

use App\Models\JenisKendaraan;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Component;

class Index extends Component
{

    use WithPagination;
    public $perPage = 5;
    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        // $jenis_kendaraans = JenisKendaraan::all();
        $jenis_kendaraans = JenisKendaraan::where('nama_jenis', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);
        return view('livewire.jenis-kendaraan.index',compact('jenis_kendaraans'));
    }
    use WithPagination, WithoutUrlPagination;

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
