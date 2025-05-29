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

    public function render()
    {
        $kontens = Konten::with('penulis')
            ->where(function ($query) {
                $search = $this->search; // misal $this->search adalah properti Livewire
                $query->where('judul', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%")
                    ->orWhere('isi', 'like', "%{$search}%")
                    ->orWhereHas('penulis', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
            })
            ->orderByDesc('created_at')
            ->paginate($this->perPage);
        return view('livewire.konten.index', compact('kontens'));
    }
}
