<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Form;

class AbsensiForm extends Form
{
    use WithFileUploads;
    #[Validate('required|date')]
    public string $tanggal;

    #[Validate('nullable|date_format:H:i')]
    public ?string $jam_masuk = null;

    #[Validate('nullable|date_format:H:i')]
    public ?string $jam_keluar = null;

    #[Validate('nullable|image|max:2048')] // max 2MB
    public $foto_masuk;

    #[Validate('nullable|image|max:2048')]
    public $foto_keluar;

    #[Validate('nullable|image|max:2048')]
    public $bukti_tidak_hadir;

    #[Validate('nullable|in:hadir,terlambat,izin,sakit,alpha,lembur')]
    public string $status;

    #[Validate('nullable|string|max:255')]
    public string $keterangan = '';

    public $type;

    public function rules()
    {
        return [
            'foto_masuk' => $this->type === 'check-in' ? 'required|image|max:2048' : 'nullable',
            'foto_keluar' => $this->type === 'check-out' ? 'required|image|max:2048' : 'nullable',
            'bukti_tidak_hadir' => $this->type === 'tidak-hadir' ? 'required|image|max:2048' : 'nullable',
        ];
    }
}
