<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // Assuming you have a User model

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all users from the database
        $users = User::all();

        // Return the view with the users data
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate=$request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:owner,admin,montir',
            
        ]);
        $validate['password'] = bcrypt('bengkel123');
        User::create($validate);
        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $currentUser = Auth::user();
        $targetUser = User::findOrFail($id);

        // Fungsi untuk membandingkan level role
        $roleLevels = [
            'owner' => 3,
            'admin' => 2,
            'montir' => 1,
            'pelanggan' => 0
        ];

        $currentRoleLevel = $roleLevels[$currentUser->role] ?? -1;
        $targetRoleLevel = $roleLevels[$targetUser->role] ?? -1;

        // Cek izin hapus
        if ($currentRoleLevel <= $targetRoleLevel) {
            return redirect()->back()->with('gagal', 'Anda tidak memiliki izin untuk menghapus user ini.');
        }else if ($currentUser->id == $targetUser->id) {
            return redirect()->back()->with('gagal', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }else{
            $targetUser->delete();
            return redirect()->back()->with('success', 'User berhasil dihapus.');
        }
    }
}
