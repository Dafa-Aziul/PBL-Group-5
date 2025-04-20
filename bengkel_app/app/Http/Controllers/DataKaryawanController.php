<?php

namespace App\Http\Controllers;
use App\Models\DataKaryawan;
use App\Models\User;

use Illuminate\Http\Request;

class DataKaryawanController extends Controller
{
    public function index()
    {
        $dataKaryawan = DataKaryawan::all();
        return view('karyawan.index', compact('dataKaryawan'));
    }

    public function create()
    {
        $users = User::all();
        return view('karyawan.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'email' => 'required|email',
            'nama' => 'required',
            'jabatan' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|in:Aktif,Nonaktif'
        ]);

        DataKaryawan::create($request->all());
        return redirect()->route('karyawan.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // $data = DataKaryawan::findOrFail($id);
        // $users = User::all();
        // return view('data_karyawan.edit', compact('data', 'users'));
        $karyawan = DataKaryawan::findOrFail($id);
        $users = User::all(); // kalau kamu perlu juga data user untuk dropdown misalnya

        return view('karyawan.edit', compact('karyawan', 'users'));
    }

    public function update(Request $request, $id)
    {
        $data = DataKaryawan::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('karyawan.index')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy($id)
    {
        DataKaryawan::destroy($id);
        return back()->with('success', 'Data berhasil dihapus!');
    }
}
