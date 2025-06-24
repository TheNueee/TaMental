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
        $konsultasi = Konsultasi::create([
            'client_id' => Auth::id(),
            'professional_id' => $r->professional_id,
            'layanan_id' => $layanan->id,
            'scheduled_at' => $r->scheduled_at,
            'status' => 'scheduled',
            'meeting_link' => $meetingLink,
            'notes' => $r->notes,
        ]);
        return redirect()->route('client.konsultasi.detail', $konsultasi)->with('success', 'Konsultasi berhasil dibuat!');
    }
    // Riwayat janji client
    public function index()
    {
        $konsultasis = Konsultasi::with('layanan', 'professional')
            ->where('client_id', Auth::id())
            ->get();
        // Update status konsultasi yang sudah lewat
        foreach ($konsultasis as $konsultasi) {
            $this->updateConsultationStatus($konsultasi);
        }
        // Refresh data setelah update status dan urutkan berdasarkan waktu janji terdekat
        $konsultasis = Konsultasi::with('layanan', 'professional')
            ->where('client_id', Auth::id())
            ->orderByRaw("
                CASE 
                    WHEN status = 'scheduled' THEN 1 
                    WHEN status = 'completed' THEN 2 
                    WHEN status = 'cancelled' THEN 3 
                    ELSE 4 
                END,
                ABS(TIMESTAMPDIFF(SECOND, scheduled_at, NOW()))
            ")
            ->get();

        // Reschedule
        foreach ($konsultasis as $konsultasi) {
            $konsultasi->can_modify = $this->canModifyConsultation($konsultasi);
        }
        return view('client.konsultasi.index', compact('konsultasis'));
    }
    // Halaman detail konsultasi
    public function detail(Konsultasi $konsultasi)
    {
        if (Auth::id() !== $konsultasi->client_id) {
            abort(403);
        }
        // Update status jika diperlukan
        $konsultasi = $this->updateConsultationStatus($konsultasi);
        // Cek apakah bisa dimodifikasi
        $canModify = $this->canModifyConsultation($konsultasi);
        return view('client.konsultasi.detail', compact('konsultasi', 'canModify'));
    }
    // Halaman edit Konsultasi
    public function edit(Konsultasi $konsultasi)
    {
        if (Auth::id() !== $konsultasi->client_id)
            abort(403);
        // Update status jika diperlukan
        $konsultasi = $this->updateConsultationStatus($konsultasi);
        // Cek apakah bisa dimodifikasi - jika tidak bisa, redirect langsung tanpa peringatan
        if (!$this->canModifyConsultation($konsultasi)) {
            return redirect()->route('client.konsultasi.detail', $konsultasi)->with('error', 'Konsultasi tidak dapat dijadwal ulang karena sudah kurang dari 6 jam.');
        }
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
        return redirect()->route('client.konsultasi.detail', $Konsultasi)->with('success', 'Jadwal berhasil diubah.');
    }
    // Batalkan janji
    public function destroy(Konsultasi $Konsultasi)
    {
        if (Auth::id() !== $Konsultasi->client_id)
            abort(403);
        // Update status jika diperlukan
        $Konsultasi = $this->updateConsultationStatus($Konsultasi);
        if (!$this->canModifyConsultation($Konsultasi)) {
            return redirect()->route('client.konsultasi.show', $Konsultasi)
                ->with('error', 'Konsultasi tidak dapat dibatalkan karena sudah melewati batas waktu atau status tidak memungkinkan.');
        }
        $Konsultasi->update(['status' => 'cancelled']);
        return redirect()->route('client.konsultasi.index')->with('success', 'Janji berhasil dibatalkan.');
    }
    // Method untuk update status konsultasi otomatis
    private function updateConsultationStatus($konsultasi)
    {
        $now = now();
        $scheduledTime = $konsultasi->scheduled_at;
        $endTime = $scheduledTime->addMinutes($konsultasi->layanan->duration_minutes);
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
        $sixHoursBefore = $scheduledTime->subHours(6);
        if ($now->gt($sixHoursBefore)) {
            return false;
        }
        return true;
    }
}