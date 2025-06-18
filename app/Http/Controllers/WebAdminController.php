<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Layanan;
use Illuminate\Support\Facades\Hash;

class WebAdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function indexProfessional()
    {
        $professionals = User::where('role', 'professional')->get();
        return view('admin.professionals.index', compact('professionals'));
    }

    public function createProfessional()
    {
        return view('admin.professionals.create');
    }

    public function storeProfessional(Request $r)
    {
        $r->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $r->name,
            'email' => $r->email,
            'role' => 'professional',
            'password' => Hash::make($r->password),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.professionals.index')->with('success', 'Professional berhasil dibuat.');
    }

    public function editProfessional(User $professional)
    {
        return view('admin.professionals.edit', compact('professional'));
    }

    public function updateProfessional(Request $r, User $professional)
    {
        $r->validate([
            'name' => 'required|string',
            'email' => "required|email|unique:users,email,{$professional->id}",
            'password' => 'nullable|string|min:6',
        ]);

        $professional->name = $r->name;
        $professional->email = $r->email;
        if ($r->password) {
            $professional->password = Hash::make($r->password);
        }
        $professional->save();

        return redirect()->route('admin.professionals.index')->with('success', 'Professional berhasil diperbarui.');
    }

    public function destroyProfessional(User $professional)
    {
        $professional->delete();
        return redirect()->route('admin.professionals.index')->with('success', 'Professional berhasil dihapus.');
    }

    // === LAYANAN ===
    public function indexLayanan()
    {
        $layanans = Layanan::with('professional')->get();

        $groupedlayanans = $layanans->groupBy(function ($item) {
            return $item->professional->name ?? 'Tanpa Nama Profesional';
        });

        return view('admin.layanans.index', compact('groupedlayanans'));
    }

    public function createLayanan()
    {
        $professionals = User::where('role', 'professional')->get();
        return view('admin.layanans.create', compact('professionals'));
    }

    public function storeLayanan(Request $r)
    {
        $r->validate([
            'professional_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'duration_minutes' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        Layanan::create($r->all());
        return redirect()->route('admin.layanans.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function editLayanan(Layanan $layanan)
    {
        $professionals = User::where('role', 'professional')->get();
        return view('admin.layanans.edit', compact('layanan', 'professionals'));
    }

    public function updateLayanan(Request $r, Layanan $layanan)
    {
        $r->validate([
            'professional_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'duration_minutes' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $layanan->update($r->all());
        return redirect()->route('admin.layanans.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroyLayanan(Layanan $layanan)
    {
        $layanan->delete();
        return redirect()->route('admin.layanans.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
