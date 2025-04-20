<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggans = pelanggan::all(); 
        return view ('pelanggan.pelanggan', compact('pelanggans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        return view ('pelanggan.createPelanggan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       // Validasi input untuk memastikan semua field valid
        $validated = $request->validate([
            'nama_pelanggan'    => 'required|string|max:255',
            'email'             => 'required|email|unique:pelanggans,email',
            'no_telp'           => 'required|string|max:15',
            'alamat'            => 'required|string',
            'no_polisi'         => 'required|string|max:20',
            'jenis_kendaraan'   => 'required|in:Mobil,Truk,Pick Up,Bus,Minibus',
            'model'             => 'required|string|max:50',
            'ket'               => 'required|in:Pribadi,Perusahaan',  // Validasi ENUM
        ]);

        // Simpan data ke database (created_at & updated_at otomatis diisi oleh Laravel)
        Pelanggan::create($validated);

        // Redirect kembali ke halaman daftar dengan pesan sukses
        return redirect('/pelanggan')->with('success', 'Data Berhasil Dimasukkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pelanggan=Pelanggan::findOrFail($id);
        return view ('pelanggan.editPelanggan', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $pelanggan = $pelanggan;
        $pelanggan -> update($request->all());
        return redirect ('/pelanggan')->with('succes','Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        Pelanggan::destroy($id);
        return redirect ('/pelanggan');
    }
}
