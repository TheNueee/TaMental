<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengujianDass21;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class TestingApiController extends Controller
{
    /**
     * Get pertanyaan untuk pengujian DASS-21
     */
    public function getPertanyaan(): JsonResponse
    {
        $pertanyaan = [
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

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil diambil',
            'data' => [
                'pertanyaan' => $pertanyaan,
                'total_pertanyaan' => count($pertanyaan),
                'instruksi' => 'Jawab setiap pertanyaan dengan skala 0-3 (0: Tidak pernah, 1: Kadang-kadang, 2: Sering, 3: Sangat sering)'
            ]
        ]);
    }

    /**
     * Submit jawaban pengujian DASS-21
     */
    public function submitPengujian(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'jawaban' => 'required|array|size:21',
                'jawaban.*' => 'required|integer|min:0|max:3'
            ], [
                'jawaban.size' => 'Semua 21 pertanyaan harus dijawab.',
                'jawaban.required' => 'Semua pertanyaan harus dijawab.',
                'jawaban.*.required' => 'Semua pertanyaan harus dijawab.',
                'jawaban.*.integer' => 'Jawaban harus berupa angka.',
                'jawaban.*.min' => 'Jawaban minimum adalah 0.',
                'jawaban.*.max' => 'Jawaban maksimum adalah 3.',
            ]);

            $jawaban = $request->input('jawaban');
            $skor = $this->hitungSkor($jawaban);

            // Tentukan kategori berdasarkan skor
            $kategori = [
                'depresi' => $this->kategoriDepresi($skor['depresi']),
                'kecemasan' => $this->kategoriKecemasan($skor['kecemasan']),
                'stres' => $this->kategoriStres($skor['stres'])
            ];

            $hasil = [
                'skor' => $skor,
                'kategori' => $kategori,
                'interpretasi' => $this->getInterpretasi($kategori),
                'tanggal_pengujian' => now()->format('Y-m-d H:i:s')
            ];

            // Jika user login, simpan ke database
            if (Auth::check()) {
                $pengujian = PengujianDass21::create([
                    'user_id' => Auth::id(),
                    'nama' => Auth::user()->name,
                    'skor_depresi' => $skor['depresi'],
                    'skor_kecemasan' => $skor['kecemasan'],
                    'skor_stres' => $skor['stres'],
                ]);

                $hasil['id'] = $pengujian->id;
                $hasil['tersimpan'] = true;
            } else {
                $hasil['tersimpan'] = false;
                $hasil['catatan'] = 'Hasil tidak tersimpan karena pengguna belum login';
            }

            return response()->json([
                'success' => true,
                'message' => 'Pengujian berhasil diselesaikan',
                'data' => $hasil
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses pengujian',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get riwayat pengujian user
     */
    public function getRiwayat(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User harus login untuk melihat riwayat'
            ], 401);
        }

        $perPage = $request->get('per_page', 10);
        $pengujian = PengujianDass21::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $data = $pengujian->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'skor' => [
                    'depresi' => $item->skor_depresi,
                    'kecemasan' => $item->skor_kecemasan,
                    'stres' => $item->skor_stres
                ],
                'kategori' => [
                    'depresi' => $this->kategoriDepresi($item->skor_depresi),
                    'kecemasan' => $this->kategoriKecemasan($item->skor_kecemasan),
                    'stres' => $this->kategoriStres($item->skor_stres)
                ],
                'tanggal' => $item->created_at->format('Y-m-d H:i:s'),
                'tanggal_readable' => $item->created_at->diffForHumans()
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Riwayat pengujian berhasil diambil',
            'data' => $data,
            'pagination' => [
                'current_page' => $pengujian->currentPage(),
                'last_page' => $pengujian->lastPage(),
                'per_page' => $pengujian->perPage(),
                'total' => $pengujian->total(),
                'from' => $pengujian->firstItem(),
                'to' => $pengujian->lastItem()
            ]
        ]);
    }

    /**
     * Get detail pengujian berdasarkan ID
     */
    public function getDetail($id): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User harus login untuk melihat detail pengujian'
            ], 401);
        }

        $pengujian = PengujianDass21::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$pengujian) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengujian tidak ditemukan atau akses ditolak'
            ], 404);
        }

        $kategori = [
            'depresi' => $this->kategoriDepresi($pengujian->skor_depresi),
            'kecemasan' => $this->kategoriKecemasan($pengujian->skor_kecemasan),
            'stres' => $this->kategoriStres($pengujian->skor_stres)
        ];

        return response()->json([
            'success' => true,
            'message' => 'Detail pengujian berhasil diambil',
            'data' => [
                'id' => $pengujian->id,
                'nama' => $pengujian->nama,
                'skor' => [
                    'depresi' => $pengujian->skor_depresi,
                    'kecemasan' => $pengujian->skor_kecemasan,
                    'stres' => $pengujian->skor_stres
                ],
                'kategori' => $kategori,
                'interpretasi' => $this->getInterpretasi($kategori),
                'tanggal' => $pengujian->created_at->format('Y-m-d H:i:s'),
                'tanggal_readable' => $pengujian->created_at->diffForHumans()
            ]
        ]);
    }

    /**
     * Hapus riwayat pengujian
     */
    public function hapusPengujian($id): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User harus login untuk menghapus pengujian'
            ], 401);
        }

        $pengujian = PengujianDass21::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$pengujian) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengujian tidak ditemukan atau akses ditolak'
            ], 404);
        }

        $pengujian->delete();

        return response()->json([
            'success' => true,
            'message' => 'Riwayat pengujian berhasil dihapus'
        ]);
    }

    /**
     * Hitung skor berdasarkan jawaban
     */
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

    /**
     * Tentukan kategori depresi berdasarkan skor
     */
    private function kategoriDepresi(int $skor): string
    {
        if ($skor <= 9) return 'Normal';
        if ($skor <= 13) return 'Ringan';
        if ($skor <= 20) return 'Sedang';
        if ($skor <= 27) return 'Parah';
        return 'Sangat Parah';
    }

    /**
     * Tentukan kategori kecemasan berdasarkan skor
     */
    private function kategoriKecemasan(int $skor): string
    {
        if ($skor <= 7) return 'Normal';
        if ($skor <= 9) return 'Ringan';
        if ($skor <= 14) return 'Sedang';
        if ($skor <= 19) return 'Parah';
        return 'Sangat Parah';
    }

    /**
     * Tentukan kategori stres berdasarkan skor
     */
    private function kategoriStres(int $skor): string
    {
        if ($skor <= 14) return 'Normal';
        if ($skor <= 18) return 'Ringan';
        if ($skor <= 25) return 'Sedang';
        if ($skor <= 33) return 'Parah';
        return 'Sangat Parah';
    }

    /**
     * Get interpretasi hasil berdasarkan kategori
     */
    private function getInterpretasi(array $kategori): array
    {
        $interpretasi = [];

        foreach ($kategori as $jenis => $level) {
            switch ($level) {
                case 'Normal':
                    $interpretasi[$jenis] = "Tingkat {$jenis} Anda dalam rentang normal.";
                    break;
                case 'Ringan':
                    $interpretasi[$jenis] = "Anda mengalami {$jenis} tingkat ringan. Disarankan untuk lebih memperhatikan kesehatan mental.";
                    break;
                case 'Sedang':
                    $interpretasi[$jenis] = "Anda mengalami {$jenis} tingkat sedang. Pertimbangkan untuk berkonsultasi dengan profesional.";
                    break;
                case 'Parah':
                    $interpretasi[$jenis] = "Anda mengalami {$jenis} tingkat parah. Sangat disarankan untuk segera berkonsultasi dengan profesional kesehatan mental.";
                    break;
                case 'Sangat Parah':
                    $interpretasi[$jenis] = "Anda mengalami {$jenis} tingkat sangat parah. Segera cari bantuan profesional kesehatan mental.";
                    break;
            }
        }

        return $interpretasi;
    }
}