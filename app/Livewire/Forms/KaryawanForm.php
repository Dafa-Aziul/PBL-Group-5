<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class KaryawanForm extends Form
{
    #[Validate('required|int|max:255')]
    public $user_id = '';

    #[Validate('required|string|max:255')]
    public $nama = '';

    #[Validate('required|string|max:255')]
    public $jabatan = '';

    #[Validate('required|string|max:255')]
    public $no_hp = '';

    #[Validate('required|string|max:255')]
    public $alamat = '';

    #[Validate('required|date|max:255')]
    public $tgl_masuk = '';

    #[Validate('required|string|in:aktif,tidak aktif')]
    public $status = 'aktif';  // default aktif

    // Properti untuk upload foto baru (nullable)
    #[Validate('nullable|image|max:2048')]
    public $foto;

    // Properti untuk menyimpan nama file foto lama dari DB
    public $foto_lama = null;


    /**
     * Isi form dari model karyawan yang sudah ada
     */
    public function fillFormModel($karyawan)
    {
        $this->user_id = $karyawan->user_id;
        $this->nama = $karyawan->nama;
        $this->jabatan = $karyawan->jabatan;
        $this->no_hp = $karyawan->no_hp;
        $this->alamat = $karyawan->alamat;
        $this->tgl_masuk = $karyawan->tgl_masuk?->format('Y-m-d');
        $this->status = $karyawan->status;

        // Jangan assign ke $foto yang untuk file upload,
        // tapi simpan nama file lama di properti foto_lama
        $this->foto_lama = $karyawan->foto;
    }
}