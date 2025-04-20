<?php

namespace App\Http\Controllers;

use App\Models\jenisLayanan;
use Illuminate\Http\Request;

class JenisLayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenis_layanans = jenislayanan::all(); 
        return view ('layanan.jenisLayanan', compact('jenis_layanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('layanan.createJenisLayanan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $harga = $request->input('harga');
        $harga = str_replace(['Rp', '.', ','], ['', '', '.'], $harga);  // Menghapus simbol "Rp" dan mengganti koma menjadi titik

        $validate=$request->validate([
            'nama_layanan' => 'required|string',
            'estimasi_pengerjaan' => 'required|string',
            'jenis_kendaraan' => 'required|string',
            'deskripsi' => 'required|string',
        ]);
        
        $validate['harga'] = $harga;
        JenisLayanan::create($validate);
        return redirect('/layanan')->with('succes','Data Berhasil Dimasukan');
    }

    /**
     * Display the specified resource.
     */
    public function show(jenisLayanan $jenisLayanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jenislayanan=JenisLayanan::findOrFail($id);
        return view ('layanan.editJenisLayanan', compact('jenislayanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $jenislayanan = JenisLayanan::findOrFail($id);
        $jenislayanan -> update($request->all());
        return redirect ('/layanan')->with('succes','Data Berhasil Diupdate');
        

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        JenisLayanan::destroy($id);
        return redirect ('/layanan');
    }
}
