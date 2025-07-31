<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,user,superadmin',
        ]);
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);
        return redirect()->route('user.index')->with('success', 'User berhasil didaftarkan!');
    }

    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('user', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user_lihat', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        if (auth()->user()->role === 'admin' && $user->role === 'superadmin') {
            return redirect()->route('user.index')->with('error', 'Anda tidak punya akses untuk mengedit Super Admin. Silakan hubungi Tim IT Pkb Mempawah.');
        }
        return view('user_edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if (auth()->user()->role === 'admin' && $user->role === 'superadmin') {
            return redirect()->route('user.index')->with('error', 'Anda tidak punya akses untuk mengedit Super Admin. Silakan hubungi Tim IT Pkb Mempawah.');
        }
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user,superadmin',
        ]);
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }
        $user->update($validated);
        return redirect()->route('user.index')->with('success', 'User berhasil diupdate!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (auth()->user()->role === 'admin' && $user->role === 'superadmin') {
            return redirect()->route('user.index')->with('error', 'Anda tidak punya akses untuk menghapus Super Admin. Silakan hubungi Tim IT Pkb Mempawah.');
        }
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus!');
    }
} 