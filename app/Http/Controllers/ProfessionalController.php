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
    public function daftarKlien(Request $request)
    {
        // Ambil hanya klien yang pernah berkonsultasi dengan profesional ini
        $klienIds = Konsultasi::where('professional_id', Auth::id())
            ->distinct()
            ->pluck('client_id');

        $klienQuery = User::where('role', 'client')
            ->whereIn('id', $klienIds)
            ->with([
                'pengujian' => function ($query) {
                    $query->latest();
                }
            ]);

        $klien = $klienQuery->get();

        // Ambil data konsultasi untuk setiap klien dengan status
        foreach ($klien as $k) {
            $k->konsultasi_data = Konsultasi::where('client_id', $k->id)
                ->where('professional_id', Auth::id())
                ->latest()
                ->get();

            // Tambahkan status konsultasi untuk filtering
            $k->konsultasi_scheduled = $k->konsultasi_data->where('status', 'scheduled');
            $k->konsultasi_completed = $k->konsultasi_data->where('status', 'completed');
            $k->konsultasi_cancelled = $k->konsultasi_data->where('status', 'cancelled');

            // Status untuk filter
            $k->has_scheduled = $k->konsultasi_scheduled->count() > 0;
            $k->has_completed = $k->konsultasi_completed->count() > 0;
            $k->has_cancelled = $k->konsultasi_cancelled->count() > 0;
        }

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

        // PERBAIKAN: Ambil semua konsultasi dengan notes yang ada, bukan hanya yang scheduled
        $konsultasiWithNotes = Konsultasi::where('client_id', $klien->id)
            ->where('professional_id', auth()->id())
            ->whereNotNull('notes')
            ->where('notes', '!=', '')
            ->orderByDesc('created_at')
            ->get();

        // Ambil konsultasi terbaru dengan notes
        $latestKonsultasi = $konsultasiWithNotes->first();

        return view('professional.klien.detail', compact(
            'klien',
            'pengujian7HariTerakhir',
            'rataKategori',
            'latest',
            'latestKonsultasi',
            'konsultasiWithNotes' // Tambahkan ini untuk semua riwayat notes
        ));
    }

    // Method untuk index jadwal konsultasi profesional (diperbaiki)
    public function myClients(Request $request)
    {
        if (!Auth::user()->isProfessional())
            abort(403);

        $konsultasis = Konsultasi::with('client', 'layanan')
            ->where('professional_id', Auth::id())
            ->get();

        // Update status konsultasi yang sudah lewat
        foreach ($konsultasis as $konsultasi) {
            $this->updateConsultationStatus($konsultasi);
        }

        // Refresh data setelah update status dan urutkan berdasarkan waktu janji terdekat
        $query = Konsultasi::with('client', 'layanan')
            ->where('professional_id', Auth::id());

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $konsultasis = $query->orderByRaw("
                CASE 
                    WHEN status = 'scheduled' THEN 1 
                    WHEN status = 'completed' THEN 2 
                    WHEN status = 'cancelled' THEN 3 
                    ELSE 4 
                END,
                ABS(TIMESTAMPDIFF(SECOND, scheduled_at, NOW()))
            ")
            ->get();

        // Cek apakah bisa modify untuk setiap konsultasi
        foreach ($konsultasis as $konsultasi) {
            $konsultasi->can_modify = $this->canModifyConsultation($konsultasi);
        }

        return view('professional.konsultasi.index', compact('konsultasis'));
    }

    // Method untuk halaman detail konsultasi
    public function detailKonsultasi(Konsultasi $konsultasi)
    {
        if (Auth::id() !== $konsultasi->professional_id) {
            abort(403);
        }

        // Update status jika diperlukan
        $konsultasi = $this->updateConsultationStatus($konsultasi);

        // Cek apakah bisa dimodifikasi
        $canModify = $this->canModifyConsultation($konsultasi);

        return view('professional.konsultasi.detail', compact('konsultasi', 'canModify'));
    }

    // Method untuk halaman edit konsultasi
    public function editKonsultasi(Konsultasi $konsultasi)
    {
        if (Auth::id() !== $konsultasi->professional_id)
            abort(403);

        // Update status jika diperlukan
        $konsultasi = $this->updateConsultationStatus($konsultasi);

        // Cek apakah bisa dimodifikasi - jika tidak bisa, redirect langsung tanpa peringatan
        if (!$this->canModifyConsultation($konsultasi)) {
            return redirect()->route('professional.konsultasi.detail', $konsultasi)->with('error', 'Konsultasi tidak dapat dijadwal ulang karena sudah kurang dari 6 jam.');
        }

        return view('professional.konsultasi.edit', compact('konsultasi'));
    }

    // Method untuk update konsultasi
    public function updateKonsultasi(Request $request, Konsultasi $konsultasi)
    {
        if (Auth::id() !== $konsultasi->professional_id)
            abort(403);

        $request->validate(['scheduled_at' => 'required|date|after:now']);

        // Cek bentrok
        if (
            Konsultasi::where('professional_id', $konsultasi->professional_id)
                ->where('scheduled_at', $request->scheduled_at)
                ->where('id', '!=', $konsultasi->id)
                ->where('status', 'scheduled')
                ->exists()
        ) {
            return back()->withErrors(['scheduled_at' => 'Waktu ini sudah dipesan.']);
        }

        $konsultasi->update(['scheduled_at' => $request->scheduled_at]);

        return redirect()->route('professional.konsultasi.detail', $konsultasi)->with('success', 'Jadwal berhasil diubah.');
    }

    // Method untuk hapus/batalkan konsultasi
    public function destroyKonsultasi(Konsultasi $konsultasi)
    {
        if (Auth::id() !== $konsultasi->professional_id)
            abort(403);

        // Update status jika diperlukan
        $konsultasi = $this->updateConsultationStatus($konsultasi);

        if (!$this->canModifyConsultation($konsultasi)) {
            return redirect()->route('professional.konsultasi.detail', $konsultasi)
                ->with('error', 'Konsultasi tidak dapat dibatalkan karena sudah melewati batas waktu atau status tidak memungkinkan.');
        }

        $konsultasi->update(['status' => 'cancelled']);

        return redirect()->route('professional.konsultasi.index')->with('success', 'Janji berhasil dibatalkan.');
    }

    // Method untuk update status konsultasi otomatis
    private function updateConsultationStatus($konsultasi)
    {
        $now = now();
        $scheduledTime = $konsultasi->scheduled_at;
        $endTime = $scheduledTime->copy()->addMinutes($konsultasi->layanan->duration_minutes);

        // Jika waktu sudah lewat dari jadwal + durasi, mark sebagai completed
        if ($now->gt($endTime) && $konsultasi->status === 'scheduled') {
            $konsultasi->update(['status' => 'completed']);
        }

        return $konsultasi;
    }

    // Method untuk cek apakah konsultasi bisa di-reschedule/cancel
    private function canModifyConsultation($konsultasi)
    {
        $now = now();
        $scheduledTime = $konsultasi->scheduled_at;

        // Tidak bisa modify jika status bukan scheduled
        if ($konsultasi->status !== 'scheduled') {
            return false;
        }

        // Tidak bisa modify jika kurang dari 6 jam sebelum jadwal
        $sixHoursBefore = $scheduledTime->copy()->subHours(6);
        if ($now->gt($sixHoursBefore)) {
            return false;
        }

        return true;
    }

    // Method untuk mendapatkan detail klien via AJAX
    public function getClientDetail($id)
    {
        $klien = User::with('pengujian')->findOrFail($id);

        // Pastikan klien ini pernah konsultasi dengan profesional yang sedang login
        $hasConsultation = Konsultasi::where('client_id', $klien->id)
            ->where('professional_id', Auth::id())
            ->exists();

        if (!$hasConsultation) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

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

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $klien->id,
                'name' => $klien->name,
                'email' => $klien->email,
                'photo' => $klien->photo,
                'created_at' => $klien->created_at->format('d M Y'),
                'rata_kategori' => $rataKategori,
                'latest_test' => $latest ? [
                    'nilai_depresi' => $latest->nilai_depresi,
                    'nilai_kecemasan' => $latest->nilai_kecemasan,
                    'nilai_stres' => $latest->nilai_stres,
                    'created_at' => $latest->created_at->format('d M Y H:i')
                ] : null,
                'pengujian_count' => $klien->pengujian->count(),
                'avg_scores' => $avg
            ]
        ]);
    }

    // PERBAIKAN: Method edit notes yang sudah diperbaiki
    public function editNotes($id)
    {
        $konsultasi = Konsultasi::findOrFail($id);

        // PERBAIKAN: Ganti user_id dengan client_id dan professional_id
        if ($konsultasi->client_id !== Auth::id() && $konsultasi->professional_id !== Auth::id()) {
            abort(403);
        }

        return view('klien.notes', compact('konsultasi'));
    }

    // PERBAIKAN: Method update notes yang sudah diperbaiki
    public function updateNotes(Request $request, $id)
    {
        $konsultasi = Konsultasi::findOrFail($id);

        // PERBAIKAN: Ganti user_id dengan client_id dan professional_id
        if ($konsultasi->client_id !== Auth::id() && $konsultasi->professional_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'notes' => 'nullable|string',
        ]);

        $konsultasi->notes = $request->notes;
        $konsultasi->save();

        return redirect()->route('konsultasis.notes.edit', $konsultasi->id)->with('success', 'Catatan berhasil disimpan.');
    }

    public function daftarProfessional()
    {
        // Ambil semua user dengan role professional beserta relasi professional dan licenses
        $professionals = User::where('role', 'professional')
            ->with(['professional.licenses'])
            ->get();

        return view('daftarprofesional', compact('professionals'));
    }

    /**
     * Get professional detail for AJAX requests (optional for future enhancement)
     */
    public function getProfessionalDetail($id)
    {
        $professional = User::where('role', 'professional')
            ->with(['professional.licenses'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $professional->id,
                'name' => $professional->name,
                'email' => $professional->email,
                'photo' => $professional->photo,
                'str_number' => $professional->professional->str_number ?? null,
                'spesialisasi' => $professional->professional->spesialisasi ?? null,
                'pengalaman_tahun' => $professional->professional->pengalaman_tahun ?? null,
                'bio' => $professional->professional->bio ?? null,
                'licenses' => $professional->professional->licenses->map(function ($license) {
                    return [
                        'id' => $license->id,
                        'nama' => $license->nama,
                        'nomor' => $license->nomor,
                        'tanggal_terbit' => $license->tanggal_terbit,
                        'tanggal_expired' => $license->tanggal_expired,
                        'deskripsi' => $license->deskripsi,
                    ];
                }) ?? []
            ]
        ]);
    }
}