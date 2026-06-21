@extends('layouts.admin')

@section('title', 'Dokumentasi')
@section('header', 'Dokumentasi Kegiatan')

@section('content')
<div x-data="{ viewMode: 'card' }">
    <div class="flex justify-end mb-4">
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
                    
                    @if(in_array($p->status, ['publish', 'closed', 'selesai']))
                        <form method="POST" action="{{ route('admin.dokumentasi.store') }}" enctype="multipart/form-data" class="flex items-center gap-2">
                            @csrf
                            <input type="hidden" name="pelatihan_id" value="{{ $p->id }}">
                            <input type="file" name="foto" required accept="image/*" class="text-sm border border-[var(--color-border)] rounded px-2 py-1 max-w-[200px]">
                            <button type="submit" class="px-3 py-1.5 bg-[var(--color-primary)] text-white text-sm rounded hover:bg-[var(--color-primary-hover)] whitespace-nowrap">Upload Foto</button>
                        </form>
                    @else
                        <div class="px-3 py-1.5 bg-red-50 border border-red-200 text-red-600 rounded text-xs font-medium">
                            Harus di-publish terlebih dahulu untuk menambah foto
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @forelse($p->dokumentasi as $d)
                        <div class="relative group aspect-square bg-[var(--color-surface-1)] rounded overflow-hidden border border-[var(--color-border)]">
                            <img src="{{ Storage::url($d->foto_kegiatan) }}" alt="Dokumentasi" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <form method="POST" action="{{ route('admin.dokumentasi.destroy', $d) }}" onsubmit="return confirm('Yakin hapus foto ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600 font-medium">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-6 text-center text-sm text-[var(--color-ink-muted)] border-2 border-dashed border-[var(--color-border)] rounded">
                            Belum ada foto dokumentasi.
                        </div>
                    @endforelse
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
                        <th class="p-3 font-semibold text-center">Aksi (Upload / Hapus)</th>
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
                                        <div class="relative group w-14 h-14 rounded overflow-hidden border border-[var(--color-border)]">
                                            <img src="{{ Storage::url($d->foto_kegiatan) }}" class="w-full h-full object-cover">
                                            <form method="POST" action="{{ route('admin.dokumentasi.destroy', $d) }}" onsubmit="return confirm('Yakin hapus foto ini?')" class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-white hover:text-red-400" title="Hapus Foto">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    @empty
                                        <span class="text-xs text-[var(--color-ink-muted)] italic">Belum ada gambar</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="p-3 align-top text-center">
                                @if(in_array($p->status, ['publish', 'closed', 'selesai']))
                                    <form method="POST" action="{{ route('admin.dokumentasi.store') }}" enctype="multipart/form-data" class="flex flex-col items-center gap-1">
                                        @csrf
                                        <input type="hidden" name="pelatihan_id" value="{{ $p->id }}">
                                        <input type="file" name="foto" required accept="image/*" class="w-full max-w-[150px] text-[10px] border border-[var(--color-border)] rounded px-1 py-1 bg-[var(--color-canvas)]">
                                        <button type="submit" class="w-full max-w-[150px] px-2 py-1.5 bg-[var(--color-primary)] text-white text-[11px] rounded hover:bg-[var(--color-primary-hover)] font-medium">Upload Foto Baru</button>
                                    </form>
                                @else
                                    <span class="text-[11px] text-red-500 font-medium">Harus Publish</span>
                                @endif
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
