<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Professional;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AuthApiController extends Controller
{
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role
                    ],
                    'token' => $token
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Default role is client
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'client'
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ],
                'token' => $token
            ]
        ], 201);
    }

    public function createProfessional(Request $request)
    {
        // Check if user is admin
        if (!Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admins can create professional accounts.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'spesialisasi' => 'required|string|max:255',
            'pengalaman_tahun' => 'required|integer|min:0',
            'str_number' => 'nullable|string',
            'bio' => 'nullable|string',
            'licenses' => 'nullable|array',
            'licenses.*.nama' => 'required|string',
            'licenses.*.nomor' => 'nullable|string',
            'licenses.*.tanggal_terbit' => 'nullable|date',
            'licenses.*.tanggal_expired' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'professional',
                'email_verified_at' => now()
            ]);

            $professional = Professional::create([
                'user_id' => $user->id,
                'spesialisasi' => $request->spesialisasi,
                'pengalaman_tahun' => $request->pengalaman_tahun,
                'str_number' => $request->str_number,
                'bio' => $request->bio,
            ]);

            // Handle licenses if provided
            if ($request->has('licenses') && is_array($request->licenses)) {
                foreach ($request->licenses as $licenseData) {
                    $license = License::create([
                        'nama' => $licenseData['nama'],
                        'nomor' => $licenseData['nomor'] ?? null,
                        'tanggal_terbit' => $licenseData['tanggal_terbit'] ?? null,
                        'tanggal_expired' => $licenseData['tanggal_expired'] ?? null,
                    ]);
                    
                    $professional->licenses()->attach($license->id);
                }
            }

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Professional account created successfully',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role
                    ],
                    'professional' => [
                        'id' => $professional->id,
                        'spesialisasi' => $professional->spesialisasi,
                        'pengalaman_tahun' => $professional->pengalaman_tahun,
                        'str_number' => $professional->str_number,
                        'bio' => $professional->bio,
                        'licenses' => $professional->licenses
                    ]
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create professional account',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getProfessionals(Request $request)
    {
        // Check if user is admin
        if (!Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admins can view professional accounts list.'
            ], 403);
        }

        $perPage = $request->get('per_page', 10);
        $professionals = User::where('role', 'professional')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Professional accounts retrieved successfully',
            'data' => $professionals,
            'pagination' => [
                'current_page' => $professionals->currentPage(),
                'last_page' => $professionals->lastPage(),
                'per_page' => $professionals->perPage(),
                'total' => $professionals->total(),
                'from' => $professionals->firstItem(),
                'to' => $professionals->lastItem()
            ]
        ]);
    }

    public function getProfessionalDetail($id)
    {
        // Check if user is admin
        if (!Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admins can view professional account details.'
            ], 403);
        }

        $professional = User::where('id', $id)
            ->where('role', 'professional')
            ->with('professional.licenses')
            ->first();

        if (!$professional) {
            return response()->json([
                'success' => false,
                'message' => 'Professional account not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Professional account details retrieved successfully',
            'data' => [
                'id' => $professional->id,
                'name' => $professional->name,
                'email' => $professional->email,
                'created_at' => $professional->created_at->format('Y-m-d H:i:s'),
                'email_verified_at' => $professional->email_verified_at ? 
                    $professional->email_verified_at->format('Y-m-d H:i:s') : null,
                'professional' => $professional->professional ? [
                    'spesialisasi' => $professional->professional->spesialisasi,
                    'pengalaman_tahun' => $professional->professional->pengalaman_tahun,
                    'str_number' => $professional->professional->str_number,
                    'bio' => $professional->professional->bio,
                    'licenses' => $professional->professional->licenses
                ] : null
            ]
        ]);
    }

    public function updateProfessional(Request $request, $id)
    {
        // Check if user is admin
        if (!Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admins can update professional accounts.'
            ], 403);
        }

        $user = User::where('id', $id)
            ->where('role', 'professional')
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Professional account not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6',
            'spesialisasi' => 'required|string|max:255',
            'pengalaman_tahun' => 'required|integer|min:0',
            'str_number' => 'nullable|string',
            'bio' => 'nullable|string',
            'licenses' => 'nullable|array',
            'licenses.*.id' => 'nullable|exists:licenses,id',
            'licenses.*.nama' => 'required|string',
            'licenses.*.nomor' => 'nullable|string',
            'licenses.*.tanggal_terbit' => 'nullable|date',
            'licenses.*.tanggal_expired' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $user->name = $request->name;
            $user->email = $request->email;
            
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            
            $user->save();

            // Update or create professional info
            $professional = $user->professional;
            if (!$professional) {
                $professional = new Professional();
                $professional->user_id = $user->id;
            }
            
            $professional->spesialisasi = $request->spesialisasi;
            $professional->pengalaman_tahun = $request->pengalaman_tahun;
            $professional->str_number = $request->str_number;
            $professional->bio = $request->bio;
            $professional->save();

            // Handle licenses
            if ($request->has('licenses') && is_array($request->licenses)) {
                // Get current license IDs to determine which ones to detach
                $existingLicenseIds = $professional->licenses->pluck('id')->toArray();
                $newLicenseIds = [];
                
                foreach ($request->licenses as $licenseData) {
                    // Update existing license or create new one
                    if (isset($licenseData['id'])) {
                        $license = License::find($licenseData['id']);
                        if ($license) {
                            $license->update([
                                'nama' => $licenseData['nama'],
                                'nomor' => $licenseData['nomor'] ?? null,
                                'tanggal_terbit' => $licenseData['tanggal_terbit'] ?? null,
                                'tanggal_expired' => $licenseData['tanggal_expired'] ?? null,
                            ]);
                            $newLicenseIds[] = $license->id;
                        }
                    } else {
                        // Create new license
                        $license = License::create([
                            'nama' => $licenseData['nama'],
                            'nomor' => $licenseData['nomor'] ?? null,
                            'tanggal_terbit' => $licenseData['tanggal_terbit'] ?? null,
                            'tanggal_expired' => $licenseData['tanggal_expired'] ?? null,
                        ]);
                        $newLicenseIds[] = $license->id;
                    }
                }
                
                // Sync the professional's licenses
                $professional->licenses()->sync($newLicenseIds);
            } else {
                // If no licenses provided, detach all
                $professional->licenses()->detach();
            }

            DB::commit();
            
            // Reload professional with licenses
            $professional->load('licenses');

            return response()->json([
                'success' => true,
                'message' => 'Professional account updated successfully',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role
                    ],
                    'professional' => [
                        'spesialisasi' => $professional->spesialisasi,
                        'pengalaman_tahun' => $professional->pengalaman_tahun,
                        'str_number' => $professional->str_number,
                        'bio' => $professional->bio,
                        'licenses' => $professional->licenses
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update professional account',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteProfessional($id)
    {
        // Check if user is admin
        if (!Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admins can delete professional accounts.'
            ], 403);
        }

        $professional = User::where('id', $id)
            ->where('role', 'professional')
            ->first();

        if (!$professional) {
            return response()->json([
                'success' => false,
                'message' => 'Professional account not found'
            ], 404);
        }

        $professional->delete();

        return response()->json([
            'success' => true,
            'message' => 'Professional account deleted successfully'
        ]);
    }

    public function getUser()
    {
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ]
            ]
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'current_password' => 'nullable|string|required_with:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check current password if changing password
        if ($request->filled('password') && !Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect',
                'errors' => ['current_password' => ['The current password is incorrect']]
            ], 422);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ]
            ]
        ]);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Get the professional's profile
     */
    public function getProfessionalProfile()
    {
        $user = Auth::user();
        
        if (!$user->isProfessional()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only professional accounts can access this endpoint.'
            ], 403);
        }

        // Load professional with licenses
        $user->load('professional.licenses');

        return response()->json([
            'success' => true,
            'message' => 'Professional profile retrieved successfully',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ],
                'professional' => $user->professional ? [
                    'id' => $user->professional->id,
                    'spesialisasi' => $user->professional->spesialisasi,
                    'pengalaman_tahun' => $user->professional->pengalaman_tahun,
                    'str_number' => $user->professional->str_number,
                    'bio' => $user->professional->bio,
                    'licenses' => $user->professional->licenses->map(function ($license) {
                        return [
                            'id' => $license->id,
                            'nama' => $license->nama,
                            'nomor' => $license->nomor,
                            'tanggal_terbit' => $license->tanggal_terbit ? $license->tanggal_terbit->format('Y-m-d') : null,
                            'tanggal_expired' => $license->tanggal_expired ? $license->tanggal_expired->format('Y-m-d') : null,
                        ];
                    })
                ] : null
            ]
        ]);
    }

    /**
     * Update the professional's profile
     */
    public function updateProfessionalProfile(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isProfessional()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only professional accounts can access this endpoint.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'current_password' => 'nullable|string|required_with:password',
            'password' => 'nullable|string|min:6|confirmed',
            'spesialisasi' => 'required|string|max:255',
            'pengalaman_tahun' => 'required|integer|min:0',
            'str_number' => 'nullable|string',
            'bio' => 'nullable|string',
            'licenses' => 'nullable|array',
            'licenses.*.id' => 'nullable|exists:licenses,id',
            'licenses.*.nama' => 'required|string',
            'licenses.*.nomor' => 'nullable|string',
            'licenses.*.tanggal_terbit' => 'nullable|date',
            'licenses.*.tanggal_expired' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check current password if changing password
        if ($request->filled('password') && !Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect',
                'errors' => ['current_password' => ['The current password is incorrect']]
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Update user info
            $user->name = $request->name;
            $user->email = $request->email;
            
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            
            $user->save();

            // Update or create professional info
            $professional = $user->professional;
            if (!$professional) {
                $professional = new Professional();
                $professional->user_id = $user->id;
            }
            
            $professional->spesialisasi = $request->spesialisasi;
            $professional->pengalaman_tahun = $request->pengalaman_tahun;
            $professional->str_number = $request->str_number;
            $professional->bio = $request->bio;
            $professional->save();

            // Handle licenses
            if ($request->has('licenses') && is_array($request->licenses)) {
                // Get current license IDs to determine which ones to detach
                $existingLicenseIds = $professional->licenses->pluck('id')->toArray();
                $newLicenseIds = [];
                
                foreach ($request->licenses as $licenseData) {
                    // Update existing license or create new one
                    if (isset($licenseData['id'])) {
                        $license = License::find($licenseData['id']);
                        if ($license) {
                            $license->update([
                                'nama' => $licenseData['nama'],
                                'nomor' => $licenseData['nomor'] ?? null,
                                'tanggal_terbit' => $licenseData['tanggal_terbit'] ?? null,
                                'tanggal_expired' => $licenseData['tanggal_expired'] ?? null,
                            ]);
                            $newLicenseIds[] = $license->id;
                        }
                    } else {
                        // Create new license
                        $license = License::create([
                            'nama' => $licenseData['nama'],
                            'nomor' => $licenseData['nomor'] ?? null,
                            'tanggal_terbit' => $licenseData['tanggal_terbit'] ?? null,
                            'tanggal_expired' => $licenseData['tanggal_expired'] ?? null,
                        ]);
                        $newLicenseIds[] = $license->id;
                    }
                }
                
                // Sync the professional's licenses
                $professional->licenses()->sync($newLicenseIds);
            } else {
                // If no licenses provided, detach all
                $professional->licenses()->detach();
            }

            DB::commit();

            // Reload professional with licenses
            $user->load('professional.licenses');

            return response()->json([
                'success' => true,
                'message' => 'Professional profile updated successfully',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role
                    ],
                    'professional' => [
                        'id' => $professional->id,
                        'spesialisasi' => $professional->spesialisasi,
                        'pengalaman_tahun' => $professional->pengalaman_tahun,
                        'str_number' => $professional->str_number,
                        'bio' => $professional->bio,
                        'licenses' => $professional->licenses->map(function ($license) {
                            return [
                                'id' => $license->id,
                                'nama' => $license->nama,
                                'nomor' => $license->nomor,
                                'tanggal_terbit' => $license->tanggal_terbit ? $license->tanggal_terbit->format('Y-m-d') : null,
                                'tanggal_expired' => $license->tanggal_expired ? $license->tanggal_expired->format('Y-m-d') : null,
                            ];
                        })
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update professional profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get licenses for a professional
     */
    public function getProfessionalLicenses($id)
    {
        // Check if user is admin
        if (!Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admins can view professional licenses.'
            ], 403);
        }

        $user = User::where('id', $id)
            ->where('role', 'professional')
            ->first();

        if (!$user || !$user->professional) {
            return response()->json([
                'success' => false,
                'message' => 'Professional account not found'
            ], 404);
        }

        $licenses = $user->professional->licenses;

        return response()->json([
            'success' => true,
            'message' => 'Professional licenses retrieved successfully',
            'data' => [
                'professional_id' => $user->professional->id,
                'licenses' => $licenses->map(function ($license) {
                    return [
                        'id' => $license->id,
                        'nama' => $license->nama,
                        'nomor' => $license->nomor,
                        'tanggal_terbit' => $license->tanggal_terbit ? $license->tanggal_terbit->format('Y-m-d') : null,
                        'tanggal_expired' => $license->tanggal_expired ? $license->tanggal_expired->format('Y-m-d') : null,
                    ];
                })
            ]
        ]);
    }
}