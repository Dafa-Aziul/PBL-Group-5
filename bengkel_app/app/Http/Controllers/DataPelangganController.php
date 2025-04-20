<?php

namespace App\Http\Controllers;
use App\Models\DataPelanggan;
use App\Models\User;

use Illuminate\Http\Request;

class DataPelangganController extends Controller
{
    public function index()
    {
        $dataPelanggan = DataPelanggan::all();
        return view('data_pelanggan.index', compact('dataPelanggan'));
    }

    public function create()
    {
        $users = User::all();
        return view('data_pelanggan.create', compact('users'));
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

        DataPelanggan::create($request->all());
        return redirect()->route('data-pelanggan.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // $data = DataPelanggan::findOrFail($id);
        // $users = User::all();
        // return view('data_pelanggan.edit', compact('data', 'users'));
        $pelanggan = DataPelanggan::findOrFail($id);
        $users = User::all(); // kalau kamu perlu juga data user untuk dropdown misalnya

        return view('data_pelanggan.edit', compact('pelanggan', 'users'));
    }

    public function update(Request $request, $id)
    {
        $data = DataPelanggan::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('data-pelanggan.index')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy($id)
    {
        DataPelanggan::destroy($id);
        return back()->with('success', 'Data berhasil dihapus!');
    }
}
