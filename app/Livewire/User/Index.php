<?php

namespace App\Livewire\User;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Daftar Data User')]
class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $search = '';
    public $attempts = 0; // Counter percobaan password
    public $password_confirmation = '';

    public function updatingSearch()
    {
        $this->resetPage(); // Kembali ke halaman 1 saat pencarian berubah
    }

    // Method publik untuk delete user, handling flow
    public function delete($id)
    {
        $this->password_confirmation = trim($this->password_confirmation);

        if (!$this->validatePasswordNotEmpty()) return;
        if (!$this->checkAttemptsLimit()) return;
        if (!$this->verifyPassword()) return;

        // Tidak boleh menghapus akun sendiri
        if (Auth::id() == $id) {
            $this->flashMessage('Anda tidak dapat menghapus akun Anda sendiri.', 'error');
            $this->resetDeleteState();
            $this->dispatch('closeConfirmPasswordModal', $id);
            return; // <-- WAJIB return agar proses berhenti
        }

        // Tidak boleh menghapus akun owner
        $user = User::find($id);
        if ($user && $user->role === 'owner') {
            $this->flashMessage('Anda tidak dapat menghapus akun dengan role owner.', 'error');
            $this->resetDeleteState();
            $this->dispatch('closeConfirmPasswordModal', $id);
            return; // <-- WAJIB return agar proses berhenti
        }

        $this->performDelete($id);
        $this->password_confirmation = null; // Reset password confirmation setelah sukses
    }


    // Validasi password tidak boleh kosong
    private function validatePasswordNotEmpty(): bool
    {
        if (empty($this->password_confirmation)) {
            $this->flashMessage('Password tidak boleh kosong.', 'message');
            return false;
        }
        return true;
    }

    // Cek apakah sudah melewati batas percobaan
    private function checkAttemptsLimit(): bool
    {
        if ($this->attempts >= 3) {
            $this->flashMessage('Anda telah melebihi batas percobaan password!', 'message');
            return false;
        }
        return true;
    }

    // Verifikasi password, tambah attempts jika salah
    private function verifyPassword(): bool
    {
        if (!Hash::check($this->password_confirmation, Auth::user()->password)) {
            $this->attempts++;
            $this->reset('password_confirmation');

            $remaining = 3 - $this->attempts;
            $this->flashMessage("Password tidak sesuai. Percobaan {$this->attempts}/3", 'message');

            if ($this->attempts >= 3) {
                $this->flashMessage('Anda telah melebihi batas percobaan password! Akses ditolak.', 'error');
            }
            return false;
        }
        return true;
    }

    // Proses hapus user dan update status karyawan terkait
    private function performDelete(int $id): void
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            $this->updateKaryawanStatus($id);

            $this->resetDeleteState();
            $this->flashMessage('User berhasil dihapus.', 'success');

            $this->dispatch('closeConfirmPasswordModal', $id);
        } catch (\Exception $e) {
            $this->flashMessage('Gagal menghapus user: ' . $e->getMessage(), 'error');
        }
    }

    // Update status karyawan yang terkait dengan user
    private function updateKaryawanStatus(int $userId): void
    {
        $karyawan = Karyawan::where('user_id', $userId)->first();
        if ($karyawan) {
            $karyawan->update(['status' => 'tidak aktif']);
        }
    }

    // Reset state yang terkait dengan delete & password confirmation
    private function resetDeleteState(): void
    {
        $this->password_confirmation = null;
        $this->attempts = 0;
    }

    // Helper untuk flash message ke session
    private function flashMessage(string $message, string $type = 'message'): void
    {
        session()->flash($type, $message);
    }

    public function render()
    {
        $users = User::search($this->search)->paginate($this->perPage);
        return view('livewire.user.index', compact('users'));
    }
}
