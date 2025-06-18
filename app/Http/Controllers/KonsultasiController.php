<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\layanan;
use App\Models\Konsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonsultasiController extends Controller
{
    // Halaman form booking
    public function showBookingPage($professionalId)
    {
        $professional = User::findOrFail($professionalId);

        if (!$professional->isProfessional()) {
            abort(404);
        }

        // Ambil layanan yang dimiliki oleh professional tersebut
        $layanans = Layanan::where('professional_id', $professional->id)->get();
        return view('client.konsultasi.booking', compact('professional', 'layanans'));
    }

    // Simpan Konsultasi
    public function store(Request $r)
    {
        $r->validate([
            'professional_id' => 'required|exists:users,id',
            'layanan_id' => 'required|exists:layanans,id',
            'scheduled_at' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);

        // Cek tabrakan jadwal
        if (
            Konsultasi::where('professional_id', $r->professional_id)
                ->where('scheduled_at', $r->scheduled_at)
                ->where('status', 'scheduled')
                ->exists()
        ) {
            return back()->withErrors(['scheduled_at' => 'Waktu ini sudah dipesan, silakan pilih waktu lain.']);
        }

        $layanan = Layanan::find($r->layanan_id);
        $meetingLink = 'https://meet.jit.si/' . uniqid('konsul-');

        Konsultasi::create([
            'client_id' => Auth::id(),
            'professional_id' => $r->professional_id,
            'layanan_id' => $layanan->id,
            'scheduled_at' => $r->scheduled_at,
            'status' => 'scheduled',
            'meeting_link' => $meetingLink,
            'notes' => $r->notes,
        ]);

        return redirect()->route('client.konsultasi.index')->with('success', 'Konsultasi berhasil dibuat!');
    }

    // Riwayat janji client
    public function index()
    {
        $konsultasis = Konsultasi::with('layanan', 'professional')
            ->where('client_id', Auth::id())
            ->orderBy('scheduled_at', 'desc')
            ->get();

        return view('client.konsultasi.index', compact('konsultasis'));
    }

    // Halaman edit Konsultasi
    public function edit(Konsultasi $konsultasi)
    {
        if (Auth::id() !== $konsultasi->client_id)
            abort(403);

        return view('client.konsultasi.edit', compact('konsultasi'));
    }

    // Update Konsultasi
    public function update(Request $r, Konsultasi $Konsultasi)
    {
        if (Auth::id() !== $Konsultasi->client_id)
            abort(403);

        $r->validate(['scheduled_at' => 'required|date|after:now']);

        // Cek bentrok
        if (
            Konsultasi::where('professional_id', $Konsultasi->professional_id)
                ->where('scheduled_at', $r->scheduled_at)
                ->where('id', '!=', $Konsultasi->id)
                ->where('status', 'scheduled')
                ->exists()
        ) {
            return back()->withErrors(['scheduled_at' => 'Waktu ini sudah dipesan.']);
        }

        $Konsultasi->update(['scheduled_at' => $r->scheduled_at]);

        return redirect()->route('client.konsultasi.index')->with('success', 'Jadwal berhasil diubah.');
    }

    // Batalkan janji
    public function destroy(Konsultasi $Konsultasi)
    {
        if (Auth::id() !== $Konsultasi->client_id)
            abort(403);

        $Konsultasi->update(['status' => 'cancelled']);

        return redirect()->route('client.konsultasi.index')->with('success', 'Janji berhasil dibatalkan.');
    }

}
