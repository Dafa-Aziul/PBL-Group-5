<?php

namespace App\Livewire\Penjualan;

use App\Livewire\Forms\PenjualanForm;
use App\Models\Gudang;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Penjualan;
use App\Models\Sparepart;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Tambah Penjualan Baru')]
class Create extends Component
{
    public $pelanggans;
    public PenjualanForm $form;
    public $spareparts;
    public $selectedSparepartId = '';
    public $jumlahSparepart = '';
    public $sparepartList = [];
    public $totalSparepart = 0;
    public $editIndex = null;
    public $editJumlah = null;
    public float $total_diskon = 0;
    public $editStok = 0;

    public $konfirmasiSparepart = [
        'sparepart_id' => null,
        'nama' => '',
        'stok' => 0,
        'jumlah' => 0,
        'harga' => 0,
    ];

    public $isProcessing = false;
    protected $listeners = [
        'modal-closed' => 'handleModalClosed',
        'modalOpened' => 'handleModalOpened'
    ];


    public function mount()
    {
        $this->pelanggans = Pelanggan::all();
        $this->spareparts = Sparepart::all();

        $this->form->kasir_id = Auth::id();
        $this->hitungTotal(); // hitung dulu grand_total sparepart agar pajak & grand_total benar
    }


    public function hitungTotal()
    {
        // Total harga semua sparepart
        $this->totalSparepart = collect($this->sparepartList)->sum('sub_total');

        // Simpan subtotal awal
        $this->form->sub_total = $this->totalSparepart;

        // Hitung diskon (dalam persen)
        $diskonPersen = floatval($this->form->diskon ?? 0);
        $this->total_diskon = $this->form->sub_total * ($diskonPersen / 100);

        // Hitung subtotal setelah diskon
        $subtotalSetelahDiskon = $this->form->sub_total - $this->total_diskon;

        // Pajak 11% dari subtotal setelah diskon
        $this->form->pajak = round(0.11 * $subtotalSetelahDiskon, 2);

        // Grand total = subtotal setelah diskon + pajak
        $this->form->grand_total = round($subtotalSetelahDiskon + $this->form->pajak);
    }



    public function modalOpened()
    {
        $this->isProcessing = false;
    }
    public function handleModalOpened()
    {
        $this->isProcessing = false;
    }

    public function handleModalClosed()
    {
        $this->reset(['editIndex', 'editJumlah']);
        $this->isProcessing = false;
    }

    public function openEditModal($index)
    {
        if ($this->isProcessing) return;

        $this->isProcessing = true;
        $this->editIndex = $index;
        $this->editJumlah = $this->sparepartList[$index]['jumlah'];

        $sparepartId = $this->sparepartList[$index]['sparepart_id'];
        $this->editStok = Sparepart::find($sparepartId)?->stok ?? 0;

        $this->dispatch('open-edit-modal');
    }

    public function closeEditModal()
    {
        $this->dispatch('hide-edit-jumlah-modal');
    }

    public function updateJumlah()
    {
        $this->validate([
            'editJumlah' => 'required|integer|min:1',
        ]);

        if ($this->editJumlah > $this->editStok) {
            $this->addError('editJumlah', 'Jumlah melebihi stok tersedia (' . $this->editStok . ').');
            return;
        }

        $this->sparepartList[$this->editIndex]['jumlah'] = $this->editJumlah;
        $this->sparepartList[$this->editIndex]['sub_total'] = $this->editJumlah * $this->sparepartList[$this->editIndex]['harga'];

        $this->hitungTotal(); // Jangan lupa hitung ulang total
        $this->closeEditModal(); // Tutup modal
    }

    public function konfirmasiTambah()
    {
        if (!$this->konfirmasiSparepart) return;

        $data = $this->konfirmasiSparepart;

        $this->sparepartList[] = [
            'sparepart_id' => $data['sparepart_id'],
            'nama' => $data['nama'],
            'jumlah' => $data['jumlah'],
            'harga' => $data['harga'],
            'sub_total' => $data['harga'] * $data['jumlah'],
        ];

        $this->reset(['selectedSparepartId', 'jumlahSparepart', 'konfirmasiSparepart']);
        $this->hitungTotal();
        $this->dispatch('hide-modal-konfirmasi');
        $this->dispatch('reset-select2');
    }


    public function addSparepart()
    {
        $this->validate([
            'selectedSparepartId' => 'required|exists:spareparts,id',
            'jumlahSparepart' => 'required|integer|min:1',
        ], [
            'selectedSparepartId.required' => 'Sparepart harus dipilih.',
            'selectedSparepartId.exists' => 'Sparepart tidak valid.',
            'jumlahSparepart.required' => 'Jumlah tidak boleh kosong.',
            'jumlahSparepart.integer' => 'Jumlah harus berupa angka.',
            'jumlahSparepart.min' => 'Jumlah minimal 1.',
        ]);

        $sparepart = Sparepart::find($this->selectedSparepartId);


        // Cek apakah jumlah yang diminta melebihi stok

        // Cek duplikasi sparepart
        if (collect($this->sparepartList)->contains('sparepart_id', $sparepart->id)) {
            return $this->addError('selectedSparepartId', 'Sparepart ini sudah ditambahkan.');
        }

        // Validasi stok kosong
        if ($sparepart->stok <= 0) {
            return $this->addError('selectedSparepartId', 'Stok sparepart ini sudah habis.');
        }

        // Validasi jumlah melebihi stok
        if ($this->jumlahSparepart > $sparepart->stok) {
            return $this->addError('jumlahSparepart', 'Jumlah melebihi stok tersedia (' . $sparepart->stok . ').');
        }

        // Konfirmasi jika stok rendah
        if ($sparepart->stok <= 10) {
            $this->konfirmasiSparepart = [
                'sparepart_id' => $sparepart->id,
                'nama' => $sparepart->nama,
                'stok' => $sparepart->stok,
                'jumlah' => $this->jumlahSparepart,
                'harga' => $sparepart->harga,
            ];

            return $this->dispatch('open-modal-konfirmasi', [
                'nama' => $sparepart->nama,
                'stok' => $sparepart->stok,
                'jumlah' => $this->jumlahSparepart,
            ]);
        }


        $this->sparepartList[] = [
            'sparepart_id' => $sparepart->id,
            'nama' => $sparepart->nama,
            'jumlah' => $this->jumlahSparepart,
            'harga' => $sparepart->harga,
            'sub_total' => $sparepart->harga * $this->jumlahSparepart,
        ];

        $this->reset(['selectedSparepartId', 'jumlahSparepart']);
        $this->hitungTotal();
        $this->dispatch('reset-select2');
    }

    public function removeSparepart($index)
    {
        unset($this->sparepartList[$index]);
        $this->sparepartList = array_values($this->sparepartList);
        $this->hitungTotal();
    }

    public function updatedFormDiskon($value)
    {
        // Jika kosong, kembalikan ke 0
        if ($value === null || $value === '') {
            $this->form->diskon = 0;
        } else {
            // Buang angka nol di depan, tapi biarkan jika hanya 0
            $cleaned = ltrim($value, '0');
            $this->form->diskon = $cleaned === '' ? 0 : intval($cleaned);
        }

        // Panggil ulang perhitungan total
        $this->hitungTotal();
    }

    public function store()
    {
        $validated = $this->form->validate();
        $this->validate([
            'sparepartList' => 'required|array|min:1',
        ]);
        $transaksi = Transaksi::create($validated);

        foreach ($this->sparepartList as $sparepart) {
            $penjualan = Penjualan::create([
                'transaksi_id' => $transaksi->id,
                'sparepart_id' => $sparepart['sparepart_id'],
                'harga' => $sparepart['harga'],
                'jumlah' => $sparepart['jumlah'],
                'sub_total' => $sparepart['sub_total'],
            ]);

            // dd($penjualan);

            Gudang::create([
                'sparepart_id' => $sparepart['sparepart_id'],
                'aktivitas' => 'keluar',
                'jumlah' => $sparepart['jumlah'],
                'keterangan' => sprintf(
                    'Penggunaan sparepart "%s" sebanyak %d pcs pada Penjualan: #%s oleh Pelanggan: %s',
                    $sparepart['nama'],
                    $sparepart['jumlah'],
                    $transaksi->kode_transaksi,
                    optional($transaksi->pelanggan)->nama ?? '-'
                ),
            ]);
        }
        if ($validated['status_pembayaran'] === 'lunas') {
            Pembayaran::create([
                'transaksi_id' => $transaksi->id,
                'tanggal_bayar' => now(),
                'jumlah_bayar' => $transaksi->grand_total,
                'status_pembayaran' => 'lunas',
                'ket' => 'Pembayaran otomatis saat transaksi dibuat',
            ]);
        }

        session()->flash('success', 'Penjualan berhasil dibuat.');
        $this->dispatch('chartUpdated');
        return $this->redirect(route('penjualan.view'), navigate: true);
    }

    public function render()
    {
        return view('livewire.penjualan.create');
    }
}
