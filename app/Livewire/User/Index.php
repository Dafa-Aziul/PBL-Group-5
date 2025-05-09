<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    
    protected $paginationTheme = 'bootstrap';
    
    public $perPage = 5;
    public $search ='';
    public $attempts = 0; // Counter percobaan password
    public $password_confirmation = '';
    public function render()
    {
        return view('livewire.user.index', [
            'users' => User::search($this->search)->paginate($this->perPage),
        ]);
    }
    public function updatingSearch()
    {
        $this->resetPage(); // Kembali ke halaman 1 saat pencarian berubah
    }

    public function delete($id)
    {   
        // Validasi input tidak kosong
        $this->password_confirmation = trim($this->password_confirmation);
        
        if (empty($this->password_confirmation)) {
            session()->flash('message', 'Password tidak boleh kosong.');
            return;
        }
    
        // Cek batas percobaan
        if ($this->attempts >= 3) {
            session()->flash('message', 'Anda telah melebihi batas percobaan password!');
            return redirect()->route('user.view');
        }
    
        // Verifikasi password admin
        if (!Hash::check($this->password_confirmation, Auth::user()->password)) {
            $this->attempts++; // Tambah counter percobaan
            $remainingAttempts = 3 - $this->attempts;
            
            session()->flash('message', 'Password tidak sesuai. Percobaan ' . $this->attempts . '/3');
            $this->reset('password_confirmation');
            
            if ($this->attempts >= 3) {
                session()->flash('error', 'Anda telah melebihi batas percobaan password! Akses ditolak.');
                return redirect()->route('user.view');
            }
            return;
        }
    
        // Jika password benar, lanjutkan proses delete
        try {
            $user = User::findOrFail($id);
            $user->delete();
            session()->flash('success', 'User berhasil dihapus.');
            $this->password_confirmation = NULL;
            $this->attempts = 0;
            $this->emit('modal:close');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}
