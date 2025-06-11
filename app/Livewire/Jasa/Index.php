<?php

namespace App\Livewire\Jasa;

use App\Models\Jasa;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Daftar Data Jasa')]
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

    public function render()
    {
        $jasas = Jasa::search($this->search)->paginate($this->perPage);
        return view('livewire.jasa.index', compact('jasas'));
    }

    public function delete($id)
    {
        $jasa = Jasa::findOrFail($id);
        $jasa->delete();
        return session()->flash('success', 'Jenis Jasa berhasil dihapus.');
    }
}
