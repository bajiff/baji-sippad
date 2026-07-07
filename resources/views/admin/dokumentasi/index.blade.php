@extends('layouts.admin')

@section('title', 'Dokumentasi')
@section('header', 'Dokumentasi Kegiatan')

@section('content')
<div x-data="{ viewMode: 'card' }">
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-[var(--color-ink-muted)]">Total: {{ $pelatihans->total() }} kelas pelatihan</p>
        <div class="flex items-center gap-3">
            <div class="inline-flex bg-[var(--color-surface-2)] p-1 rounded border border-[var(--color-border)]">
                <button @click="viewMode = 'list'" :class="viewMode === 'list' ? 'bg-[var(--color-canvas)] shadow-sm text-[var(--color-ink)]' : 'text-[var(--color-ink-muted)] hover:text-[var(--color-ink)]'" class="px-3 py-1.5 text-xs rounded font-medium transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    List
                </button>
                <button @click="viewMode = 'card'" :class="viewMode === 'card' ? 'bg-[var(--color-canvas)] shadow-sm text-[var(--color-ink)]' : 'text-[var(--color-ink-muted)] hover:text-[var(--color-ink)]'" class="px-3 py-1.5 text-xs rounded font-medium transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Card
                </button>
            </div>
            <a href="{{ route('admin.dokumentasi.create') }}" class="inline-flex items-center px-4 py-2 bg-[var(--color-primary)] text-[var(--color-on-primary)] rounded text-sm font-medium hover:bg-[var(--color-primary-hover)] transition-colors shadow-sm">
                + Upload Dokumentasi
            </a>
        </div>
    </div>

    <!-- Tampilan Card -->
    <div x-show="viewMode === 'card'" class="space-y-6">
        @forelse($pelatihans as $p)
            <div class="card p-6">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-4 gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-[var(--color-ink)]">{{ $p->judul }}</h3>
                        <div class="flex gap-2 mt-2 text-xs">
                            <span class="px-2 py-1 bg-[var(--color-surface-2)] rounded text-[var(--color-ink-muted)]">{{ $p->kategori->nama_kategori ?? 'Kategori' }}</span>
                            <span class="px-2 py-1 rounded font-medium 
                                {{ $p->status === 'publish' ? 'bg-green-100 text-green-700' : ($p->status === 'draft' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700') }}">
                                Status: {{ ucfirst($p->status) }}
                            </span>
                        </div>
                    </div>
                    
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($p->dokumentasi as $d)
                        <div class="bg-[var(--color-surface-1)] rounded overflow-hidden border border-[var(--color-border)] flex flex-col">
                            <div class="aspect-square w-full overflow-hidden bg-[var(--color-canvas)]">
                                <img src="{{ Storage::url($d->foto_kegiatan) }}" alt="Dokumentasi" class="w-full h-full object-cover">
                            </div>
                            <div class="p-2 border-t border-[var(--color-border)] flex items-center justify-between gap-1 bg-[var(--color-surface-2)]">
                                <a href="{{ route('admin.dokumentasi.edit', $d) }}" class="flex-1 text-center px-2 py-1 bg-[var(--color-link)] text-white text-[11px] rounded hover:opacity-90 font-medium transition-opacity">Edit</a>
                                <form method="POST" action="{{ route('admin.dokumentasi.destroy', $d) }}" onsubmit="return confirm('Yakin hapus foto ini?')" class="flex-1 flex">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full px-2 py-1 bg-[var(--color-danger)] text-white text-[11px] rounded hover:opacity-90 font-medium transition-opacity">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                    @if(in_array($p->status, ['publish', 'closed', 'selesai']))
                        @if($p->dokumentasi->count() < 5)
                            <div class="bg-[var(--color-surface-1)] rounded overflow-hidden border-2 border-dashed border-[var(--color-border)] flex flex-col items-center justify-center p-3 text-center min-h-[160px]">
                                <form method="POST" action="{{ route('admin.dokumentasi.store') }}" enctype="multipart/form-data" class="flex flex-col items-center justify-center gap-2 w-full">
                                    @csrf
                                    <input type="hidden" name="pelatihan_id" value="{{ $p->id }}">
                                    <input type="file" name="foto" required accept="image/*" class="w-full text-[10px] border border-[var(--color-border)] rounded px-1 py-1 bg-[var(--color-canvas)]">
                                    <button type="submit" class="w-full px-2 py-1.5 bg-[var(--color-primary)] text-white text-xs rounded hover:bg-[var(--color-primary-hover)] font-medium transition-colors">+ Upload Foto</button>
                                </form>
                            </div>
                        @else
                            <div class="bg-yellow-50 rounded overflow-hidden border border-yellow-200 flex flex-col items-center justify-center p-4 text-center min-h-[160px]">
                                <span class="text-xs font-medium text-yellow-700">Maksimal 5 Foto (Penuh)</span>
                            </div>
                        @endif
                    @else
                        <div class="bg-red-50 rounded overflow-hidden border border-red-200 flex flex-col items-center justify-center p-4 text-center min-h-[160px]">
                            <span class="text-xs font-medium text-red-600">Harus Publish untuk Upload</span>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="card p-8 text-center text-[var(--color-ink-muted)]">Belum ada kelas pelatihan.</div>
        @endforelse
    </div>

    <!-- Tampilan List -->
    <div x-show="viewMode === 'list'" style="display: none;" class="bg-[var(--color-canvas)] rounded-lg border border-[var(--color-border)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[var(--color-surface-2)] text-[var(--color-ink-muted)] text-xs uppercase tracking-wider border-b border-[var(--color-border)]">
                        <th class="p-3 font-semibold">No</th>
                        <th class="p-3 font-semibold">Pelatihan</th>
                        <th class="p-3 font-semibold">Kategori</th>
                        <th class="p-3 font-semibold">Status</th>
                        <th class="p-3 font-semibold">Gambar</th>
                        <th class="p-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--color-border)]">
                    @forelse($pelatihans as $index => $p)
                        <tr class="hover:bg-[var(--color-surface-1)] transition-colors">
                            <td class="p-3 text-sm text-[var(--color-ink)] align-top">{{ $loop->iteration + ($pelatihans->currentPage() - 1) * $pelatihans->perPage() }}</td>
                            <td class="p-3 text-sm font-medium text-[var(--color-ink)] align-top">{{ $p->judul }}</td>
                            <td class="p-3 text-sm text-[var(--color-ink-muted)] align-top">{{ $p->kategori->nama_kategori ?? '-' }}</td>
                            <td class="p-3 align-top">
                                <span class="px-2 py-1 rounded font-medium text-xs whitespace-nowrap
                                    {{ $p->status === 'publish' ? 'bg-green-100 text-green-700' : ($p->status === 'draft' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700') }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="p-3 align-top">
                                <div class="flex flex-wrap gap-2">
                                    @forelse($p->dokumentasi as $d)
                                        <div class="w-14 h-14 rounded overflow-hidden border border-[var(--color-border)] bg-[var(--color-surface-1)]">
                                            <img src="{{ Storage::url($d->foto_kegiatan) }}" class="w-full h-full object-cover">
                                        </div>
                                    @empty
                                        <span class="text-xs text-[var(--color-ink-muted)] italic">Belum ada gambar</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="p-3 align-top text-right">
                                <div class="flex flex-col gap-2 items-end">
                                    @if($p->dokumentasi->isNotEmpty())
                                        <div class="flex flex-col gap-1.5 items-end w-full">
                                            @foreach($p->dokumentasi as $index => $d)
                                                <div class="flex items-center justify-end gap-2">
                                                    @if($p->dokumentasi->count() > 1)
                                                        <span class="text-xs text-[var(--color-ink-muted)] font-mono">#{{ $index + 1 }}</span>
                                                    @endif
                                                    <a href="{{ route('admin.dokumentasi.edit', $d) }}" class="text-[var(--color-link)] hover:underline text-sm">Edit</a>
                                                    <form method="POST" action="{{ route('admin.dokumentasi.destroy', $d) }}" onsubmit="return confirm('Yakin hapus foto ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-[var(--color-danger)] hover:underline text-sm">Hapus</button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="w-full flex justify-end {{ $p->dokumentasi->isNotEmpty() ? 'pt-2 border-t border-[var(--color-border)]' : '' }}">
                                        @if(in_array($p->status, ['publish', 'closed', 'selesai']))
                                            @if($p->dokumentasi->count() >= 5)
                                                <span class="text-[11px] text-yellow-700 bg-yellow-50 px-2 py-0.5 rounded border border-yellow-200 font-medium">Maks 5 Foto (Penuh)</span>
                                            @else
                                                <form method="POST" action="{{ route('admin.dokumentasi.store') }}" enctype="multipart/form-data" class="flex items-center gap-1">
                                                    @csrf
                                                    <input type="hidden" name="pelatihan_id" value="{{ $p->id }}">
                                                    <input type="file" name="foto" required accept="image/*" class="w-[140px] text-[10px] border border-[var(--color-border)] rounded px-1 py-0.5 bg-[var(--color-canvas)]">
                                                    <button type="submit" class="px-2 py-1 bg-[var(--color-primary)] text-white text-[11px] rounded hover:bg-[var(--color-primary-hover)] font-medium whitespace-nowrap">+ Tambah</button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="text-[11px] text-red-500 font-medium">Harus Publish</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-[var(--color-ink-muted)] text-sm">Belum ada data pelatihan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $pelatihans->links() }}</div>
</div>
@endsection
