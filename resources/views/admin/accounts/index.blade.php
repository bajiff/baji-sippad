@extends('layouts.admin')

@section('title', 'Manajemen Akun')
@section('header', 'Manajemen Akun')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <p class="text-sm text-[var(--color-ink-muted)]">Total: {{ $accounts->total() }} akun terdaftar</p>
    </div>
    <div>
        <a href="{{ route('admin.accounts.create') }}" class="inline-flex items-center px-4 py-2 bg-[var(--color-primary)] text-[var(--color-on-primary)] rounded text-sm font-medium hover:bg-[var(--color-primary-hover)] transition-colors">
            + Tambah Akun Baru
        </a>
    </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="card p-4 border-l-4 border-l-[var(--color-link)]">
        <p class="text-xs text-[var(--color-ink-muted)]">Rata-rata Umur</p>
        <p class="text-xl font-bold text-[var(--color-ink)] mt-1">{{ $statsUmur['rata_rata'] }} <span class="text-xs font-normal">Tahun</span></p>
    </div>
    <div class="card p-4 border-l-4 border-l-[var(--color-primary)]">
        <p class="text-xs text-[var(--color-ink-muted)]">Umur Tertua</p>
        <p class="text-xl font-bold text-[var(--color-primary)] mt-1">{{ $statsUmur['tertua'] }} <span class="text-xs font-normal">Tahun</span></p>
    </div>
    <div class="card p-4 border-l-4 border-l-[var(--color-success)]">
        <p class="text-xs text-[var(--color-ink-muted)]">Umur Termuda</p>
        <p class="text-xl font-bold text-[var(--color-success)] mt-1">{{ $statsUmur['termuda'] }} <span class="text-xs font-normal">Tahun</span></p>
    </div>
    <div class="card p-4 border-l-4 border-l-[var(--color-warning)]">
        <p class="text-xs text-[var(--color-ink-muted)]">Total Akun</p>
        <p class="text-xl font-bold text-[var(--color-ink)] mt-1">{{ $accounts->total() }} <span class="text-xs font-normal">Akun</span></p>
    </div>
</div>

<div class="card p-6 mb-6">
    <form method="GET" action="{{ route('admin.accounts.index') }}" class="flex flex-wrap items-end gap-4">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-[var(--color-ink)] mb-1">Cari Akun</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, email, atau no HP..." 
                   class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
        </div>
        <div>
            <label class="block text-sm font-medium text-[var(--color-ink)] mb-1">Role</label>
            <select name="role" class="px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User (Peserta)</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-[var(--color-ink)] mb-1">Urutkan / Filter</label>
            <select name="sort" class="px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                <option value="a_z" {{ request('sort') == 'a_z' ? 'selected' : '' }}>Nama: A - Z</option>
                <option value="z_a" {{ request('sort') == 'z_a' ? 'selected' : '' }}>Nama: Z - A</option>
                <option value="tertua" {{ request('sort') == 'tertua' ? 'selected' : '' }}>Umur: Tertua</option>
                <option value="termuda" {{ request('sort') == 'termuda' ? 'selected' : '' }}>Umur: Termuda</option>
                <option value="rata_rata" {{ request('sort') == 'rata_rata' ? 'selected' : '' }}>Mendekati Rata-rata</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-[var(--color-ink)] mb-1">Tahun Lahir</label>
            <input type="number" name="tahun_lahir" value="{{ request('tahun_lahir') }}" placeholder="Contoh: 1998"
                   class="w-28 px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
        </div>
        <div>
            <label class="block text-sm font-medium text-[var(--color-ink)] mb-1">Tampilkan</label>
            <select name="per_page" class="px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10 data</option>
                <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20 data</option>
                <option value="30" {{ request('per_page') == '30' ? 'selected' : '' }}>30 data</option>
                <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Semua data</option>
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-[var(--color-surface-2)] text-[var(--color-ink)] rounded text-sm font-medium hover:bg-[var(--color-border)]">Filter</button>
        @if(request()->anyFilled(['search', 'role', 'tahun_lahir']) || (request('per_page') && request('per_page') !== '10') || (request('sort') && request('sort') !== 'latest'))
            <a href="{{ route('admin.accounts.index') }}" class="px-4 py-2 border border-[var(--color-border)] rounded text-sm text-[var(--color-ink)] hover:bg-[var(--color-surface-1)]">Reset</a>
        @endif
    </form>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-[var(--color-surface-1)]">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)] w-12">#</th>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Nama</th>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Email</th>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">No. HP</th>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Role</th>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Tgl Lahir / Umur</th>
                    <th class="text-right px-4 py-3 font-medium text-[var(--color-ink-muted)]">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[var(--color-border)]">
                @forelse($accounts as $account)
                    <tr class="{{ $account->id === auth()->id() ? 'bg-[var(--color-surface-1)]/40' : '' }}">
                        <td class="px-4 py-3 text-[var(--color-ink-muted)]">{{ $accounts->firstItem() + $loop->index }}</td>
                        <td class="px-4 py-3 font-medium">
                            <div class="flex items-center gap-2">
                                <span>{{ $account->name }}</span>
                                @if($account->id === auth()->id())
                                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-[var(--color-link)]/10 text-[var(--color-link)] font-semibold">Anda</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-[var(--color-ink-muted)]">{{ $account->email }}</td>
                        <td class="px-4 py-3">{{ $account->no_hp ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                @if($account->role === 'admin')
                                    <x-badge variant="success">Admin</x-badge>
                                @else
                                    <x-badge variant="info">User</x-badge>
                                @endif

                                @if($account->isSuperAdmin())
                                    <x-badge variant="danger">Superadmin</x-badge>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-[var(--color-ink-muted)]">
                            @if($account->tanggal_lahir)
                                {{ $account->tanggal_lahir->format('d/m/Y') }} ({{ $account->umur }} tahun)
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                @if($account->isSuperAdmin())
                                    @if(auth()->user()->isSuperAdmin())
                                        <a href="{{ route('admin.accounts.edit', $account) }}" class="text-[var(--color-link)] hover:underline text-sm font-medium">Edit</a>
                                        @if($account->id !== auth()->id())
                                            <form id="delete-form-{{ $account->id }}" method="POST" action="{{ route('admin.accounts.destroy', $account) }}" style="display: none;">
                                                @csrf @method('DELETE')
                                            </form>
                                            <button type="button" onclick="if(confirm('Yakin hapus akun Superadmin ini?')) { document.getElementById('delete-form-{{ $account->id }}').submit(); }" class="text-[var(--color-danger)] hover:underline text-sm font-medium">Hapus</button>
                                        @endif
                                    @else
                                        <span class="text-[var(--color-ink-muted)] text-xs italic" title="Admin biasa tidak memiliki hak akses untuk mengedit Superadmin">Terkunci</span>
                                    @endif
                                @else
                                    @if($account->role === 'admin' && $account->id !== auth()->id() && !auth()->user()->isSuperAdmin())
                                        <span class="text-[var(--color-ink-muted)] text-xs italic" title="Sesama admin biasa tidak dapat mengedit admin lainnya">Terkunci</span>
                                    @else
                                        <a href="{{ route('admin.accounts.edit', $account) }}" class="text-[var(--color-link)] hover:underline text-sm font-medium">Edit</a>
                                        @if($account->id !== auth()->id())
                                            <form id="delete-form-{{ $account->id }}" method="POST" action="{{ route('admin.accounts.destroy', $account) }}" style="display: none;">
                                                @csrf @method('DELETE')
                                            </form>
                                            <button type="button" onclick="if(confirm('Yakin hapus akun ini?')) { document.getElementById('delete-form-{{ $account->id }}').submit(); }" class="text-[var(--color-danger)] hover:underline text-sm font-medium">Hapus</button>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-[var(--color-ink-muted)]">Tidak ada akun yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $accounts->links() }}</div>
@endsection
