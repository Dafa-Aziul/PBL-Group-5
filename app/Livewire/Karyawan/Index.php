<?php

namespace App\Livewire\Karyawan;

use App\Models\Karyawan;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Daftar Data Karyawan')]
class Index extends Component
{
    use WithPagination;
    public $perPage = 5;
    protected $paginationTheme = 'bootstrap';

    public $search;

    public function updatingSearch()
    {
        $this->resetPage(); // Kembali ke halaman 1 saat pencarian berubah
    }

    public function delete($id)
    {
        $user = Karyawan::findOrFail($id);
        $user->delete();
        return session()->flash('success','Data Karyawan Berhasil Dihapus');
    }

    public function render()
    {
        $karyawans = Karyawan::with('user')
        ->where(function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('role', 'like', '%' . $this->search . '%');
                })
                ->orWhere('nama', 'like', '%' . $this->search . '%')
                ->orWhere('jabatan', 'like', '%' . $this->search . '%')
                ->orWhere('alamat', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%')
                ->orWhere('no_hp', 'like', '%' . $this->search . '%')
                ->orWhereDate('tgl_masuk', $this->search);
            })
            ->paginate($this->perPage);

        return view('livewire.karyawan.index', compact('karyawans'));
    }

}
