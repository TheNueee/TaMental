<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengujianDass21;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\User;

class PengujianController extends Controller
{
    public function pengujianDisclaimer(): View
    {
        return view('disclaimer');
    }

    public function pengujianDass21(Request $request)
    {
        $pertanyaan = $this->getPertanyaan();

        if ($request->isMethod('post')) {
            $request->validate([
                'jawaban' => 'required|array|size:21',
                'jawaban.*' => 'required|integer|min:0|max:3'
            ], [
                'jawaban.size' => 'Semua 21 pertanyaan harus dijawab.',
                'jawaban.required' => 'Semua pertanyaan harus dijawab.',
                'jawaban.*.required' => 'Semua pertanyaan harus dijawab.',
            ]);

            $jawaban = $request->input('jawaban');
            $skor = $this->hitungSkor($jawaban);

            if (Auth::guest()) {
                session([
                    'hasil_guest' => [
                        'kategori_depresi' => $this->kategoriDepresi($skor['depresi']),
                        'kategori_kecemasan' => $this->kategoriKecemasan($skor['kecemasan']),
                        'kategori_stres' => $this->kategoriStres($skor['stres']),
                    ]
                ]);

                return redirect()->route('hasil');
            } else {
                $pengujian = PengujianDass21::create([
                    'user_id' => Auth::id(),
                    'nama' => Auth::user()->name,
                    'skor_depresi' => $skor['depresi'],
                    'skor_kecemasan' => $skor['kecemasan'],
                    'skor_stres' => $skor['stres'],
                ]);

                return redirect()->route('hasil', ['id' => $pengujian->id])
                    ->with('success', 'Pengujian berhasil disimpan.');
            }
        }

        return view('pengujiandass21', [
            'pertanyaan' => $pertanyaan,
        ]);
    }

    public function index(): RedirectResponse
    {
        return redirect()->route('disclaimer');
    }

    public function hasil(Request $request, $id = null)
    {
        $show_recommendation = false;
        $rekomendasi_profesional = [];

        if (Auth::guest()) {
            $hasil = session('hasil_guest');

            if (!$hasil) {
                return redirect()->route('pengujiandass21')
                    ->with('error', 'Hasil tidak tersedia. Silakan lakukan pengujian terlebih dahulu.');
            }

            session()->forget('hasil_guest');

            $kategori_depresi = $hasil['kategori_depresi'];
            $kategori_kecemasan = $hasil['kategori_kecemasan'];
            $kategori_stres = $hasil['kategori_stres'];

            if (
                in_array($kategori_depresi, ['Parah', 'Sangat Parah']) ||
                in_array($kategori_kecemasan, ['Parah', 'Sangat Parah']) ||
                in_array($kategori_stres, ['Parah', 'Sangat Parah'])
            ) {
                $show_recommendation = true;
                $rekomendasi_profesional = User::where('role', 'professional')
                    ->inRandomOrder()
                    ->take(3)
                    ->get();
            }

            return view('hasil', [
                'model' => null,
                'kategori_depresi' => $kategori_depresi,
                'kategori_kecemasan' => $kategori_kecemasan,
                'kategori_stres' => $kategori_stres,
                'is_guest' => true,
                'show_recommendation' => $show_recommendation,
                'rekomendasi_profesional' => $rekomendasi_profesional,
            ]);
        }

        if (!$id) {
            return redirect()->route('pengujiandass21')
                ->with('error', 'ID pengujian tidak valid.');
        }

        $model = PengujianDass21::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$model) {
            return redirect()->route('client.pengujian.riwayat')
                ->with('error', 'Data hasil pengujian tidak ditemukan atau tidak diizinkan.');
        }

        $kategori_depresi = $model->kategori_depresi;
        $kategori_kecemasan = $model->kategori_kecemasan;
        $kategori_stres = $model->kategori_stres;

        if (
            in_array($kategori_depresi, ['Parah', 'Sangat Parah']) ||
            in_array($kategori_kecemasan, ['Parah', 'Sangat Parah']) ||
            in_array($kategori_stres, ['Parah', 'Sangat Parah'])
        ) {
            $show_recommendation = true;
            $rekomendasi_profesional = User::where('role', 'professional')
                ->inRandomOrder()
                ->take(3)
                ->get();
        }

        return view('hasil', [
            'model' => $model,
            'kategori_depresi' => $kategori_depresi,
            'kategori_kecemasan' => $kategori_kecemasan,
            'kategori_stres' => $kategori_stres,
            'is_guest' => false,
            'show_recommendation' => $show_recommendation,
            'rekomendasi_profesional' => $rekomendasi_profesional,
        ]);
    }

    public function riwayat(): View
    {
        if (Auth::guest()) {
            abort(403, 'Halaman hanya dapat diakses oleh pengguna yang login.');
        }

        $pengujian = PengujianDass21::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('client.pengujian.riwayat', [
            'pengujian' => $pengujian,
        ]);
    }

    public function lihat($id): View
    {
        $pengujian = PengujianDass21::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$pengujian) {
            abort(404, 'Data tidak ditemukan atau akses ditolak.');
        }

        return view('client.pengujian.lihat', [
            'pengujian' => $pengujian,
            'kategoriDepresi' => $this->kategoriDepresi($pengujian->skor_depresi),
            'kategoriKecemasan' => $this->kategoriKecemasan($pengujian->skor_kecemasan),
            'kategoriStres' => $this->kategoriStres($pengujian->skor_stres),
        ]);
    }

    public function hapus($id): RedirectResponse
    {
        $model = PengujianDass21::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$model) {
            abort(404, 'Data tidak ditemukan atau akses ditolak.');
        }

        $model->delete();

        return redirect()->route('client.pengujian.riwayat')
            ->with('success', 'Riwayat pengujian berhasil dihapus.');
    }

    private function getPertanyaan(): array
    {
        return [
            "Saya merasa bahwa diri saya menjadi marah karena hal-hal sepele.",
            "Saya merasa bahwa diri saya menjadi panik.",
            "Saya merasa bibir saya sering kering.",
            "Saya sama sekali tidak dapat merasakan perasaan positif.",
            "Saya mengalami kesulitan bernafas.",
            "Saya sepertinya tidak kuat lagi untuk melakukan suatu kegiatan.",
            "Saya cenderung bereaksi berlebihan terhadap suatu situasi.",
            "Saya merasa goyah.",
            "Saya merasa sulit untuk bersantai.",
            "Saya merasa sangat cemas dan merasa lega jika semua ini berakhir.",
            "Saya merasa tidak ada hal yang dapat diharapkan di masa depan.",
            "Saya menemukan diri saya mudah merasa kesal.",
            "Saya merasa telah menghabiskan banyak energi untuk merasa cemas.",
            "Saya merasa sedih dan tertekan.",
            "Saya menjadi tidak sabar saat mengalami penundaan.",
            "Saya merasa lemas seperti mau pingsan.",
            "Saya merasa kehilangan minat akan segala hal.",
            "Saya merasa tidak berharga sebagai manusia.",
            "Saya merasa mudah tersinggung.",
            "Saya berkeringat secara berlebihan tanpa alasan fisik.",
            "Saya merasa takut tanpa alasan jelas.",
        ];
    }

    private function hitungSkor(array $jawaban): array
    {
        $skor_depresi = 0;
        $skor_kecemasan = 0;
        $skor_stres = 0;

        $soal_depresi = [3, 5, 10, 13, 16, 17, 21];
        $soal_kecemasan = [2, 4, 7, 9, 15, 19, 20];
        $soal_stres = [1, 6, 8, 11, 12, 14, 18];

        foreach ($jawaban as $i => $val) {
            $nomor_soal = $i + 1;
            if (in_array($nomor_soal, $soal_depresi)) {
                $skor_depresi += $val;
            } elseif (in_array($nomor_soal, $soal_kecemasan)) {
                $skor_kecemasan += $val;
            } elseif (in_array($nomor_soal, $soal_stres)) {
                $skor_stres += $val;
            }
        }

        return [
            'depresi' => $skor_depresi * 2,
            'kecemasan' => $skor_kecemasan * 2,
            'stres' => $skor_stres * 2,
        ];
    }

    private function kategoriDepresi(int $skor): string
    {
        if ($skor <= 9)
            return 'Normal';
        if ($skor <= 13)
            return 'Ringan';
        if ($skor <= 20)
            return 'Sedang';
        if ($skor <= 27)
            return 'Parah';
        return 'Sangat Parah';
    }

    private function kategoriKecemasan(int $skor): string
    {
        if ($skor <= 7)
            return 'Normal';
        if ($skor <= 9)
            return 'Ringan';
        if ($skor <= 14)
            return 'Sedang';
        if ($skor <= 19)
            return 'Parah';
        return 'Sangat Parah';
    }

    private function kategoriStres(int $skor): string
    {
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
