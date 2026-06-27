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

        $perPage = $request->input('per_page', 10);
        if ($perPage === 'all') {
            $count = $query->count();
            $perPage = $count > 0 ? $count : 10000;
        } else {
            $perPage = in_array((int)$perPage, [10, 20, 30]) ? (int)$perPage : 10;
        }

        $accounts = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin.accounts.index', compact('accounts'));
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

        $account->delete();

        return redirect()->route('admin.accounts.index')->with('success', 'Akun berhasil dihapus.');
    }
}
