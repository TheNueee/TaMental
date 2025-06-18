<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PengujianDass21;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProfessionalController extends Controller
{
    public function daftarKlien()
    {
        $klien = User::whereHas('pengujian')->get();
        return view('professional.klien.index', compact('klien'));
    }

    public function detailKlien($id)
    {
        $klien = User::with('pengujian')->findOrFail($id);

        $pengujian7HariTerakhir = $klien->pengujian->where('created_at', '>=', Carbon::now()->subDays(7));

        $avg = [
            'nilai_depresi' => $pengujian7HariTerakhir->avg('nilai_depresi'),
            'nilai_kecemasan' => $pengujian7HariTerakhir->avg('nilai_kecemasan'),
            'nilai_stres' => $pengujian7HariTerakhir->avg('nilai_stres'),
        ];

        function kategori($skor, $jenis)
        {
            if ($jenis === 'depresi') {
                if ($skor <= 9)
                    return 'Normal';
                if ($skor <= 13)
                    return 'Ringan';
                if ($skor <= 20)
                    return 'Sedang';
                if ($skor <= 27)
                    return 'Parah';
                return 'Sangat Parah';
            } elseif ($jenis === 'kecemasan') {
                if ($skor <= 7)
                    return 'Normal';
                if ($skor <= 9)
                    return 'Ringan';
                if ($skor <= 14)
                    return 'Sedang';
                if ($skor <= 19)
                    return 'Parah';
                return 'Sangat Parah';
            } else { // stres
                if ($skor <= 14)
                    return 'Normal';
                if ($skor <= 18)
                    return 'Ringan';
                if ($skor <= 25)
                    return 'Sedang';
                if ($skor <= 33)
                    return 'Parah';
                return 'Sangat Parah';
            }
        }

        $rataKategori = [
            'depresi' => kategori($avg['nilai_depresi'], 'depresi'),
            'kecemasan' => kategori($avg['nilai_kecemasan'], 'kecemasan'),
            'stres' => kategori($avg['nilai_stres'], 'stres'),
        ];

        $latest = $klien->pengujian->sortByDesc('created_at')->first();


        $latestKonsultasi = Konsultasi::where('client_id', $klien->id)
            ->where('professional_id', auth()->id())
            ->where('status', 'scheduled')
            ->orderByDesc('scheduled_at')
            ->first();

        return view('professional.klien.detail', compact(
            'klien',
            'pengujian7HariTerakhir',
            'rataKategori',
            'latest',
            'latestKonsultasi'
        ));
    }

    public function myClients()
    {
        if (!Auth::user()->isProfessional())
            abort(403);

        $konsultasis = Konsultasi::with('client', 'layanan')
            ->where('professional_id', Auth::id())
            ->orderBy('scheduled_at', 'asc')
            ->get();

        return view('professional.konsultasi.index', compact('konsultasis'));
    }

    public function editNotes($id)
    {
        $Konsultasi = Konsultasi::findOrFail($id);
        if ($Konsultasi->user_id !== Auth::id()) {
            abort(403);
        }
        return view('klien.notes', compact('Konsultasi'));
    }

    public function updateNotes(Request $request, $id)
    {
        $Konsultasi = Konsultasi::findOrFail($id);
        if ($Konsultasi->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'notes' => 'nullable|string',
        ]);

        $Konsultasi->notes = $request->notes;
        $Konsultasi->save();

        return redirect()->route('Konsultasis.notes.edit', $Konsultasi->id)->with('success', 'Catatan berhasil disimpan.');
    }

    public function daftarProfessional()
    {
        // Ambil semua user dengan role professional
        $professionals = User::where('role', 'professional')->get();
        return view('daftarprofesional', compact('professionals'));
    }
}
