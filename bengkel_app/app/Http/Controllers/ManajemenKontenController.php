<?php

namespace App\Http\Controllers;

use App\Models\ManajemenKonten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManajemenKontenController extends Controller
{
    public function index()
    {
        $contents = ManajemenKonten::latest()->paginate(10);
        return view('backend.ManajemenKonten.index', compact('contents'));
    }

    public function create()
    {
        return view('backend.ManajemenKonten.create');
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'judul'         => 'required|max:150',
    //         'isi'           => 'required',
    //         'kategori'      => 'required|max:50',
    //         'tanggal_terbit'=> 'required|date',
    //         'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //         'video'         => 'nullable|mimes:mp4,avi,3gp,mov,mpeg|max:10000',
    //         'status'        => 'required|in:draft,terbit,arsip',
    //         'penulis'       => 'required|max:100',
    //     ]);

    //     // // Handle upload gambar
    //     // if ($request->hasFile('gambar')) {
    //     //     $gambarPath = $request->file('gambar')->store('public/uploads/gambar');
    //     //     $validated['gambar'] = basename($gambarPath);
    //     // }

    //     // // Handle upload video
    //     // if ($request->hasFile('video')) {
    //     //     $videoPath = $request->file('video')->store('public/uploads/video');
    //     //     $validated['video'] = basename($videoPath);
    //     // }

    //      ManajemenKonten::create($validated);

    //     $content = new ManajemenKonten;
    //     $content->judul = $request->judul;
    //     $content->kategori = $request->kategori;
    
    //     if ($request->hasFile('gambar')) {
    //         $content->gambar = $request->file('gambar')->store('uploads/gambar', 'public');
    //     }
    
    //     if ($request->hasFile('video')) {
    //         $content->video = $request->file('video')->store('uploads/video', 'public');
    //     }
    
    //     $content->save();

    //     return redirect()->route('manajemen-konten.index')->with('success', 'Konten berhasil ditambahkan.');
    // }

    public function store(Request $request)
{
    $validated = $request->validate([
        'judul'         => 'required|max:150',
        'isi'           => 'required',
        'kategori'      => 'required|max:50',
        'tanggal_terbit'=> 'required|date',
        'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'video'         => 'nullable|mimes:mp4,avi,3gp,mov,mpeg|max:10000',
        'status'        => 'required|in:draft,terbit,arsip',
        'penulis'       => 'required|max:100',
    ]);

    // Buat instance baru
    $content = new ManajemenKonten;
    $content->judul = $validated['judul'];
    $content->isi = $validated['isi'];
    $content->kategori = $validated['kategori'];
    $content->tanggal_terbit = $validated['tanggal_terbit'];
    $content->status = $validated['status'];
    $content->penulis = $validated['penulis'];

    // Simpan gambar jika ada
    if ($request->hasFile('gambar')) {
        $gambarPath = $request->file('gambar')->store('uploads/gambar', 'public');
        $content->gambar = basename($gambarPath);
    }

    // Simpan video jika ada
    if ($request->hasFile('video')) {
        $videoPath = $request->file('video')->store('uploads/video', 'public');
        $content->video = basename($videoPath);
    }

    $content->save();

    return redirect()->route('manajemen-konten.index')->with('success', 'Konten berhasil ditambahkan.');
}


    public function edit($id)
    {
        $content = ManajemenKonten::findOrFail($id);
        return view('backend.ManajemenKonten.edit', compact('content'));
    }

    // public function update(Request $request, $id)


    // {
    //     $content = ManajemenKonten::findOrFail($id);

    //     $validated = $request->validate([
    //         'judul'         => 'required|max:150',
    //         'isi'           => 'required',
    //         'kategori'      => 'required|max:50',
    //         'tanggal_terbit'=> 'required|date',
    //         'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //         'video'         => 'nullable|mimes:mp4,avi,3gp,mov,mpeg|max:10000',
    //         'status'        => 'required|in:draft,terbit,arsip',
    //         'penulis'       => 'required|max:100',
    //     ]);

    //     // Update gambar jika ada upload baru
    //     if ($request->hasFile('gambar')) {
    //         if ($content->gambar) {
    //             Storage::delete('public/uploads/gambar/' . $content->gambar);
    //         }
    //         $gambarPath = $request->file('gambar')->store('public/uploads/gambar');
    //         $validated['gambar'] = basename($gambarPath);
    //     }

    //     // Update video jika ada upload baru
    //     if ($request->hasFile('video')) {
    //         if ($content->video) {
    //             Storage::delete('public/uploads/video/' . $content->video);
    //         }
    //         $videoPath = $request->file('video')->store('public/uploads/video');
    //         $validated['video'] = basename($videoPath);
    //     }

    //     $content->update($validated);

    //     return redirect()->route('manajemen-konten.index')->with('success', 'Konten berhasil diperbarui.');
    // }

    public function update(Request $request, $id)
{
    $content = ManajemenKonten::findOrFail($id);

    $validated = $request->validate([
        'judul'         => 'required|max:150',
        'isi'           => 'required',
        'kategori'      => 'required|max:50',
        'tanggal_terbit'=> 'required|date',
        'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'video'         => 'nullable|mimes:mp4,avi,3gp,mov,mpeg|max:10000',
        'status'        => 'required|in:draft,terbit,arsip',
        'penulis'       => 'required|max:100',
    ]);

    // Update manual tiap field, agar bisa handle gambar/video secara konsisten
    $content->judul = $validated['judul'];
    $content->isi = $validated['isi'];
    $content->kategori = $validated['kategori'];
    $content->tanggal_terbit = $validated['tanggal_terbit'];
    $content->status = $validated['status'];
    $content->penulis = $validated['penulis'];

    // Update gambar jika ada upload baru
    if ($request->hasFile('gambar')) {
        if ($content->gambar && Storage::exists('public/uploads/gambar/' . $content->gambar)) {
            Storage::delete('public/uploads/gambar/' . $content->gambar);
        }
        $gambarPath = $request->file('gambar')->store('uploads/gambar', 'public');
        $content->gambar = basename($gambarPath);
    }

    // Update video jika ada upload baru
    if ($request->hasFile('video')) {
        if ($content->video && Storage::exists('public/uploads/video/' . $content->video)) {
            Storage::delete('public/uploads/video/' . $content->video);
        }
        $videoPath = $request->file('video')->store('uploads/video', 'public');
        $content->video = basename($videoPath);
    }

    $content->save();

    return redirect()->route('manajemen-konten.index')->with('success', 'Konten berhasil diperbarui.');
}


    public function destroy($id)
    {
        $content = ManajemenKonten::findOrFail($id);

        if ($content->gambar) {
            Storage::delete('public/uploads/gambar/' . $content->gambar);
        }
        if ($content->video) {
            Storage::delete('public/uploads/video/' . $content->video);
        }

        $content->delete();

        return redirect()->route('manajemen-konten.index')->with('success', 'Konten berhasil dihapus.');
    }
}
