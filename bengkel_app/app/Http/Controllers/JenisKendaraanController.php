<?php

namespace App\Http\Controllers;
use App\Models\JenisKendaraan;
use Illuminate\Http\Request;

class JenisKendaraanController extends Controller
{
    public function index() {
        $jenisKendaraans = JenisKendaraan::all();
        return view('jenis_kendaraan.index', compact('jenisKendaraans'));
    }

    public function create() {
        return view('jenis_kendaraan.create');
    }

    public function store(Request $request) {
        JenisKendaraan::create($request->all());
        return redirect()->route('jenis_kendaraan.index');
    }

    public function edit($id)
    {
        $jenisKendaraan = JenisKendaraan::findOrFail($id);
        return view('jenis_kendaraan.edit', compact('jenisKendaraan'));
    }
    
    public function update(Request $request, $id) {
        $jenis = JenisKendaraan::findOrFail($id);
        $jenis->update($request->all());
        return redirect()->route('jenis_kendaraan.index');
    }

    public function destroy($id)
    {
        $jenis = JenisKendaraan::findOrFail($id);
        $jenis->delete();

        return redirect()->route('jenis_kendaraan.index')->with('success', 'Data berhasil dihapus');
    }

}
