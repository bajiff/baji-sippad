<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        // Tahun Lahir filter
        if ($request->filled('tahun_lahir')) {
            $tahun = $request->input('tahun_lahir');
            if (config('database.default') === 'pgsql') {
                $query->whereRaw('EXTRACT(YEAR FROM tanggal_lahir) = ?', [$tahun]);
            } else {
                $query->whereRaw("strftime('%Y', tanggal_lahir) = ?", [(string)$tahun]);
            }
        }

        // Sorting (A-Z, Z-A, Tertua, Termuda, Rata-rata)
        $sort = $request->input('sort', 'latest');
        if ($sort === 'a_z') {
            $query->orderBy('name', 'asc');
        } elseif ($sort === 'z_a') {
            $query->orderBy('name', 'desc');
        } elseif ($sort === 'tertua') {
            $query->whereNotNull('tanggal_lahir')->orderBy('tanggal_lahir', 'asc');
        } elseif ($sort === 'termuda') {
            $query->whereNotNull('tanggal_lahir')->orderBy('tanggal_lahir', 'desc');
        } elseif ($sort === 'rata_rata') {
            $usersWithBirth = User::whereNotNull('tanggal_lahir')->get();
            $avgAge = $usersWithBirth->avg(fn($u) => $u->umur) ?: 0;
            if ($avgAge > 0) {
                $targetYear = date('Y') - round($avgAge);
                if (config('database.default') === 'pgsql') {
                    $query->whereNotNull('tanggal_lahir')->orderByRaw('ABS(EXTRACT(YEAR FROM tanggal_lahir) - ?)', [$targetYear]);
                } else {
                    $query->whereNotNull('tanggal_lahir')->orderByRaw("ABS(CAST(strftime('%Y', tanggal_lahir) AS INTEGER) - ?)", [$targetYear]);
                }
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        $perPage = $request->input('per_page', 10);
        if ($perPage === 'all') {
            $count = $query->count();
            $perPage = $count > 0 ? $count : 10000;
        } else {
            $perPage = in_array((int)$perPage, [10, 20, 30]) ? (int)$perPage : 10;
        }

        $accounts = $query->paginate($perPage)->withQueryString();

        // Stats Umur
        $allUsersWithBirth = User::whereNotNull('tanggal_lahir')->get();
        $statsUmur = [
            'rata_rata' => $allUsersWithBirth->count() > 0 ? round($allUsersWithBirth->avg(fn($u) => $u->umur), 1) : 0,
            'tertua' => $allUsersWithBirth->count() > 0 ? $allUsersWithBirth->max(fn($u) => $u->umur) : 0,
            'termuda' => $allUsersWithBirth->count() > 0 ? $allUsersWithBirth->min(fn($u) => $u->umur) : 0,
        ];

        return view('admin.accounts.index', compact('accounts', 'statsUmur'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentUser = auth()->user();

        if (!$currentUser->isSuperAdmin() && $request->input('role') === 'admin') {
            return back()->withInput()->withErrors(['role' => 'Admin biasa tidak memiliki hak akses untuk membuat akun dengan role Admin.']);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,user',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'no_hp' => $validated['no_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'is_superadmin' => false,
        ];

        User::create($userData);

        return redirect()->route('admin.accounts.index')->with('success', 'Akun berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $account)
    {
        $currentUser = auth()->user();

        // Prevent non-superadmin from editing a superadmin
        if ($account->isSuperAdmin() && !$currentUser->isSuperAdmin()) {
            return redirect()->route('admin.accounts.index')->with('error', 'Superadmin (admin utama) tidak bisa diubah oleh admin biasa.');
        }

        // Prevent fellow normal admin from editing another admin
        if ($account->role === 'admin' && $account->id !== $currentUser->id && !$currentUser->isSuperAdmin()) {
            return redirect()->route('admin.accounts.index')->with('error', 'Sesama admin biasa tidak dapat mengedit akun admin lainnya.');
        }

        return view('admin.accounts.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $account)
    {
        $currentUser = auth()->user();

        // Prevent non-superadmin from updating a superadmin
        if ($account->isSuperAdmin() && !$currentUser->isSuperAdmin()) {
            return redirect()->route('admin.accounts.index')->with('error', 'Superadmin (admin utama) tidak bisa diubah oleh admin biasa.');
        }

        // Prevent fellow normal admin from updating another admin
        if ($account->role === 'admin' && $account->id !== $currentUser->id && !$currentUser->isSuperAdmin()) {
            return redirect()->route('admin.accounts.index')->with('error', 'Sesama admin biasa tidak dapat mengedit akun admin lainnya.');
        }

        if (!$currentUser->isSuperAdmin() && $request->input('role') === 'admin' && $account->role !== 'admin') {
            return back()->withInput()->withErrors(['role' => 'Admin biasa tidak memiliki hak akses untuk menjadikan akun sebagai Admin.']);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($account->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:admin,user',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $account->name = $validated['name'];
        $account->email = $validated['email'];
        $account->role = $validated['role'];
        $account->no_hp = $validated['no_hp'] ?? null;
        $account->alamat = $validated['alamat'] ?? null;
        $account->tanggal_lahir = $validated['tanggal_lahir'] ?? null;

        if (!empty($validated['password'])) {
            $account->password = Hash::make($validated['password']);
        }

        $account->save();

        return redirect()->route('admin.accounts.index')->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $account)
    {
        $currentUser = auth()->user();

        // Prevent deleting oneself
        if ($account->id === $currentUser->id) {
            return redirect()->route('admin.accounts.index')->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        // Prevent non-superadmin from deleting a superadmin
        if ($account->isSuperAdmin() && !$currentUser->isSuperAdmin()) {
            return redirect()->route('admin.accounts.index')->with('error', 'Superadmin (admin utama) tidak bisa dihapus oleh admin biasa.');
        }

        // Prevent fellow normal admin from deleting another admin
        if ($account->role === 'admin' && !$currentUser->isSuperAdmin()) {
            return redirect()->route('admin.accounts.index')->with('error', 'Sesama admin biasa tidak dapat menghapus akun admin lainnya.');
        }

        $account->delete();

        return redirect()->route('admin.accounts.index')->with('success', 'Akun berhasil dihapus.');
    }
}
