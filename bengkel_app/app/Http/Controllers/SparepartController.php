<?php

namespace App\Http\Controllers;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spareparts = Sparepart::all();
        return view('sparepart.index', compact('spareparts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sparepart.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input harga untuk memastikan hanya angka yang diterima
        $harga = $request->input('harga');
        $harga = str_replace(['Rp', '.', ','], ['', '', '.'], $harga);  // Menghapus simbol "Rp" dan mengganti koma menjadi titik

        // Validasi input
        $validate = $request->validate([
            'nama' => 'required|max:255',
            'merk' => 'required|max:255',
            'satuan' => 'required|max:50',
            'stok' => 'required|integer|min:0',
            'model_kendaraan' => 'required|max:255',
            'keterangan' => 'nullable|max:500',
        ], [
            'nama.required' => 'Nama Sparepart tidak boleh kosong',
            'nama.max' => 'Nama Sparepart maksimal 255 karakter',
            'merk.required' => 'Merk tidak boleh kosong',
            'merk.max' => 'Merk maksimal 255 karakter',
            'satuan.required' => 'Satuan tidak boleh kosong',
            'satuan.max' => 'Satuan maksimal 50 karakter',
            'stok.required' => 'stok tidak boleh kosong',
            'stok.integer' => 'stok harus berupa angka',
            'stok.min' => 'stok minimal 0',
            'model_kendaraan.required' => 'Model kendaraan tidak boleh kosong',
            'model_kendaraan.max' => 'Model kendaraan maksimal 255 karakter',
            'keterangan.max' => 'Keterangan maksimal 500 karakter',
        ]);
        $validate['harga'] = $harga;
        Sparepart::create($validate);
        return redirect()->route('sparepart.index')->with('success', 'Data Sparepart Berhasil Ditambahkan');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sparepart = Sparepart::findOrFail($id);
        return view('sparepart.edit', compact('sparepart'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $harga = $request->input('harga');
        $harga = str_replace(['Rp', '.', ','], ['', '', '.'], $harga);
        // Validasi seperti biasa
       // Memasukkan harga yang sudah dibersihkan ke dalam validasi
        $validate = $request->validate([
            'nama' => 'required|max:255',
            'merk' => 'required|max:255',
            'satuan' => 'required|max:50',
            'stok' => 'required|integer|min:0',
            'model_kendaraan' => 'required|max:255',
            'keterangan' => 'nullable|max:500',
        ], [
            'nama.required' => 'Nama Sparepart tidak boleh kosong',
            'nama.max' => 'Nama Sparepart maksimal 255 karakter',
            'merk.required' => 'Merk tidak boleh kosong',
            'merk.max' => 'Merk maksimal 255 karakter',
            'satuan.required' => 'Satuan tidak boleh kosong',
            'satuan.max' => 'Satuan maksimal 50 karakter',
            'stok.required' => 'Stok tidak boleh kosong',
            'stok.integer' => 'Stok harus berupa angka',
            'stok.min' => 'Stok minimal 0',
            'harga.required' => 'Harga tidak boleh kosong',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga minimal 0',
            'model_kendaraan.required' => 'Model kendaraan tidak boleh kosong',
            'model_kendaraan.max' => 'Model kendaraan maksimal 255 karakter',
            'keterangan.max' => 'Keterangan maksimal 500 karakter',
        ]);

        // Menambahkan harga yang sudah dibersihkan ke dalam array $validate
        $validate['harga'] = $harga; // Memastikan harga yang sudah dibersihkan digunakan

        
        // Hanya update jika ada perubahan
        $sparepart->fill($validate);
        if ($sparepart->isDirty()) {
            $sparepart->save();
            return redirect()->route('sparepart.index')->with('success', 'Data berhasil diperbarui.');
        } else {
            return redirect()->route('sparepart.index')->with('info', 'Tidak ada perubahan data.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->delete();
        return redirect()->route('sparepart.index')->with('success', 'Data Sparepart Berhasil Dihapus');
    }
}
