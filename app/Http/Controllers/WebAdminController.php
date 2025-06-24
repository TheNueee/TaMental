<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Professional;
use App\Models\License;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class WebAdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // === LICENSES ===
    public function indexLicense()
    {
        $licenses = License::orderBy('created_at', 'desc')->get();
        return view('admin.licenses.index', compact('licenses'));
    }

    public function createLicense()
    {
        return view('admin.licenses.create');
    }

    public function storeLicense(Request $r)
    {
        $r->validate([
            'nama' => 'required|string|max:255',
            'nomor' => 'required|string|max:255|unique:licenses',
            'tanggal_terbit' => 'required|date',
            'tanggal_expired' => 'required|date|after:tanggal_terbit',
            'deskripsi' => 'nullable|string',
        ]);

        License::create($r->all());

        return redirect()->route('admin.licenses.index')->with('success', 'License berhasil ditambahkan.');
    }

    public function editLicense(License $license)
    {
        return view('admin.licenses.edit', compact('license'));
    }

    public function updateLicense(Request $r, License $license)
    {
        $r->validate([
            'nama' => 'required|string|max:255',
            'nomor' => 'required|string|max:255|unique:licenses,nomor,' . $license->id,
            'tanggal_terbit' => 'required|date',
            'tanggal_expired' => 'required|date|after:tanggal_terbit',
            'deskripsi' => 'nullable|string',
        ]);

        $license->update($r->all());

        return redirect()->route('admin.licenses.index')->with('success', 'License berhasil diperbarui.');
    }

    public function destroyLicense(License $license)
    {
        // Check if license is being used by any professional
        if ($license->professionals()->count() > 0) {
            return redirect()->route('admin.licenses.index')->with('error', 'License tidak dapat dihapus karena sedang digunakan oleh professional.');
        }

        $license->delete();
        return redirect()->route('admin.licenses.index')->with('success', 'License berhasil dihapus.');
    }

    // === PROFESSIONALS ===
    public function indexProfessional()
    {
        $professionals = User::where('role', 'professional')
            ->with('professional.licenses')
            ->get();
        return view('admin.professionals.index', compact('professionals'));
    }
    public function createProfessional()
    {
        $licenses = License::orderBy('nama')->get();
        return view('admin.professionals.create', compact('licenses'));
    }
    public function storeProfessional(Request $r)
    {
        $r->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'spesialisasi' => 'nullable|string',
            'pengalaman_tahun' => 'nullable|integer|min:0',
            'str_number' => 'nullable|string',
            'bio' => 'nullable|string',
            'licenses' => 'nullable|array',
            'licenses.*' => 'exists:licenses,id',
            // New license fields
            'new_license_nama' => 'nullable|string|max:255',
            'new_license_nomor' => 'nullable|string|max:255|unique:licenses,nomor',
            'new_license_tanggal_terbit' => 'nullable|date',
            'new_license_tanggal_expired' => 'nullable|date|after:new_license_tanggal_terbit',
            'new_license_deskripsi' => 'nullable|string',
        ]);

        // Validate new license fields if any is provided
        if ($r->new_license_nama || $r->new_license_nomor || $r->new_license_tanggal_terbit || $r->new_license_tanggal_expired) {
            $r->validate([
                'new_license_nama' => 'required|string|max:255',
                'new_license_nomor' => 'required|string|max:255|unique:licenses,nomor',
                'new_license_tanggal_terbit' => 'required|date',
                'new_license_tanggal_expired' => 'required|date|after:new_license_tanggal_terbit',
            ]);
        }

        DB::transaction(function () use ($r) {
            // Create new license if provided
            $newLicenseId = null;
            if ($r->new_license_nama) {
                $newLicense = License::create([
                    'nama' => $r->new_license_nama,
                    'nomor' => $r->new_license_nomor,
                    'tanggal_terbit' => $r->new_license_tanggal_terbit,
                    'tanggal_expired' => $r->new_license_tanggal_expired,
                    'deskripsi' => $r->new_license_deskripsi,
                ]);
                $newLicenseId = $newLicense->id;
            }

            // Create user
            $user = User::create([
                'name' => $r->name,
                'email' => $r->email,
                'role' => 'professional',
                'password' => Hash::make($r->password),
                'email_verified_at' => now(),
            ]);

            // Create professional profile
            $professional = Professional::create([
                'user_id' => $user->id,
                'spesialisasi' => $r->spesialisasi,
                'pengalaman_tahun' => $r->pengalaman_tahun,
                'str_number' => $r->str_number,
                'bio' => $r->bio,
            ]);

            // Attach licenses
            $licensesToAttach = $r->licenses ?? [];
            if ($newLicenseId) {
                $licensesToAttach[] = $newLicenseId;
            }
            if (!empty($licensesToAttach)) {
                $professional->licenses()->attach($licensesToAttach);
            }
        });

        return redirect()->route('admin.professionals.index')->with('success', 'Professional berhasil dibuat.');
    }
    public function editProfessional(User $professional)
    {
        $professional->load('professional.licenses');
        $licenses = License::orderBy('nama')->get();
        return view('admin.professionals.edit', compact('professional', 'licenses'));
    }
    public function updateProfessional(Request $r, User $professional)
    {
        $r->validate([
            'name' => 'required|string',
            'email' => "required|email|unique:users,email,{$professional->id}",
            'password' => 'nullable|string|min:6',
            'spesialisasi' => 'nullable|string',
            'pengalaman_tahun' => 'nullable|integer|min:0',
            'str_number' => 'nullable|string',
            'bio' => 'nullable|string',
            'existing_licenses' => 'nullable|array',
            'existing_licenses.*' => 'exists:licenses,id',
            // New license fields
            'new_license_nama' => 'nullable|string|max:255',
            'new_license_nomor' => 'nullable|string|max:255|unique:licenses,nomor',
            'new_license_tanggal_terbit' => 'nullable|date',
            'new_license_tanggal_expired' => 'nullable|date|after:new_license_tanggal_terbit',
            'new_license_deskripsi' => 'nullable|string',
        ]);

        // Validate new license fields if any is provided
        if ($r->new_license_nama || $r->new_license_nomor || $r->new_license_tanggal_terbit || $r->new_license_tanggal_expired) {
            $r->validate([
                'new_license_nama' => 'required|string|max:255',
                'new_license_nomor' => 'required|string|max:255|unique:licenses,nomor',
                'new_license_tanggal_terbit' => 'required|date',
                'new_license_tanggal_expired' => 'required|date|after:new_license_tanggal_terbit',
            ]);
        }

        DB::transaction(function () use ($r, $professional) {
            // Create new license if provided
            $newLicenseId = null;
            if ($r->new_license_nama) {
                $newLicense = License::create([
                    'nama' => $r->new_license_nama,
                    'nomor' => $r->new_license_nomor,
                    'tanggal_terbit' => $r->new_license_tanggal_terbit,
                    'tanggal_expired' => $r->new_license_tanggal_expired,
                    'deskripsi' => $r->new_license_deskripsi,
                ]);
                $newLicenseId = $newLicense->id;
            }

            // Update user
            $professional->name = $r->name;
            $professional->email = $r->email;
            if ($r->password) {
                $professional->password = Hash::make($r->password);
            }
            $professional->save();

            // Update or create professional profile
            $professionalProfile = $professional->professional ?? new Professional(['user_id' => $professional->id]);
            $professionalProfile->spesialisasi = $r->spesialisasi;
            $professionalProfile->pengalaman_tahun = $r->pengalaman_tahun;
            $professionalProfile->str_number = $r->str_number;
            $professionalProfile->bio = $r->bio;
            $professionalProfile->save();

            // Combine existing licenses with new license
            $licensesToSync = $r->existing_licenses ?? [];
            if ($newLicenseId) {
                $licensesToSync[] = $newLicenseId;
            }

            // Use sync to update licenses (this will keep existing ones from existing_licenses[] and add new one)
            $professionalProfile->licenses()->sync($licensesToSync);
        });

        return redirect()->route('admin.professionals.index')->with('success', 'Professional berhasil diperbarui.');
    }
    public function destroyProfessional(User $professional)
    {
        DB::transaction(function () use ($professional) {
            // Delete professional profile and its license relationships
            if ($professional->professional) {
                $professional->professional->licenses()->detach();
                $professional->professional->delete();
            }
            // Delete user
            $professional->delete();
        });
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