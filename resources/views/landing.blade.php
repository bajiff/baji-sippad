@extends('layouts.app')

@section('title', 'SIPPAD — Platform Pelatihan Anak Desa')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-surface-1 to-canvas pt-24 pb-20 overflow-hidden bg-grid-pattern border-b border-border">
    <!-- Accent Top Bar (Adobe Red) -->
    <div class="absolute top-0 left-0 w-full h-[3px] bg-primary"></div>
    
    <div class="max-w-7xl mx-auto px-4 relative">
        <div class="max-w-3xl mx-auto text-center">
            <!-- Brand Badge -->
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-surface-2 text-xs font-semibold text-ink mb-6 border border-border">
                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                Inisiatif Pemberdayaan Desa Modern
            </div>
            
            <h1 class="text-4xl md:text-6xl font-bold text-ink mb-6 leading-[1.1] tracking-tight">
                Masa Depan Desa Dimulai dari <span class="text-primary relative inline-block">Keterampilan Anda</span>
            </h1>
            
            <p class="text-lg md:text-xl text-ink-muted mb-8 leading-relaxed max-w-2xl mx-auto">
                SIPPAD adalah platform pelatihan terpadu bagi pemuda dan masyarakat desa untuk mengasah keahlian digital, bisnis, pertanian modern, dan pariwisata.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @guest
                    <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3.5 bg-primary !text-white rounded-sm font-semibold hover:bg-primary-hover transition-all duration-200 shadow-md hover:shadow-lg hover:no-underline">
                        Mulai Daftar Pelatihan
                    </a>
                    <a href="#pelatihan" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3.5 border border-border bg-canvas !text-ink rounded-sm font-semibold hover:bg-surface-1 transition-all duration-200 hover:no-underline">
                        Lihat Daftar Kelas
                    </a>
                @else
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3.5 bg-primary !text-white rounded-sm font-semibold hover:bg-primary-hover transition-all duration-200 shadow-md hover:shadow-lg hover:no-underline">
                        Masuk ke Dashboard
                    </a>
                @endguest
            </div>

        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="relative -mt-10 z-10">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Stat 1 -->
            <div class="card p-8 flex items-center gap-6 bg-canvas shadow-card rounded-lg border border-border">
                <div class="w-14 h-14 rounded-sm bg-surface-1 flex items-center justify-center flex-shrink-0 border border-border text-primary">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-ink leading-none mb-1">{{ $stats['total_pelatihan'] }}</h3>
                    <p class="text-sm font-medium text-ink-muted">Pelatihan Tersedia</p>
                </div>
            </div>
            <!-- Stat 2 -->
            <div class="card p-8 flex items-center gap-6 bg-canvas shadow-card rounded-lg border border-border">
                <div class="w-14 h-14 rounded-sm bg-surface-1 flex items-center justify-center flex-shrink-0 border border-border text-link">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-ink leading-none mb-1">{{ $stats['total_peserta'] }}</h3>
                    <p class="text-sm font-medium text-ink-muted">Peserta Terdaftar</p>
                </div>
            </div>
            <!-- Stat 3 -->
            <div class="card p-8 flex items-center gap-6 bg-canvas shadow-card rounded-lg border border-border">
                <div class="w-14 h-14 rounded-sm bg-surface-1 flex items-center justify-center flex-shrink-0 border border-border text-success">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-ink leading-none mb-1">{{ $stats['total_sertifikat'] }}</h3>
                    <p class="text-sm font-medium text-ink-muted">Sertifikat Diterbitkan</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Kategori Pelatihan Section -->
<section class="py-24 bg-canvas">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-xs font-bold text-primary tracking-widest uppercase mb-3">Bidang Keahlian</h2>
            <h3 class="text-3xl md:text-4xl font-bold text-ink">Kategori Pelatihan Unggulan</h3>
            <div class="w-12 h-1 bg-primary mx-auto mt-4"></div>
        </div>
        
        <div class="flex overflow-x-auto gap-6 pb-6 pt-2 px-1 snap-x snap-mandatory scrollbar-thin">
            @forelse($categories as $category)
                @php
                    if (!is_object($category)) {
                        continue;
                    }
                @endphp
                <div class="card p-6 flex flex-col items-center text-center bg-canvas border border-border rounded-lg hover:border-ink flex-shrink-0 w-64 sm:w-72 snap-start">
                    <div class="w-12 h-12 rounded-full bg-surface-1 flex items-center justify-center mb-4 text-ink">
                        @if(Str::contains(Str::lower($category->nama_kategori), ['teknologi', 'ti', 'komputer']))
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        @elseif(Str::contains(Str::lower($category->nama_kategori), ['bisnis', 'wirausaha', 'ekonomi']))
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @elseif(Str::contains(Str::lower($category->nama_kategori), ['tani', 'kebun', 'pertanian']))
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        @elseif(Str::contains(Str::lower($category->nama_kategori), ['wisata', 'pariwisata']))
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        @endif
                    </div>
                    <h4 class="font-bold text-ink text-sm mb-1 line-clamp-1">{{ $category->nama_kategori }}</h4>
                    <p class="text-xs text-ink-muted mb-3 line-clamp-2">{{ $category->deskripsi ?? 'Pelatihan terstruktur di bidang ' . $category->nama_kategori }}</p>
                    <span class="inline-block px-2 py-0.5 rounded-sm bg-surface-2 text-[10px] font-semibold text-ink border border-border">
                        {{ $category->pelatihan_count }} Kelas Aktif
                    </span>
                </div>
            @empty
                <div class="col-span-full text-center text-sm text-ink-muted py-6">
                    Tidak ada kategori pelatihan yang tersedia.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Pelatihan Terbaru Section -->
<section id="pelatihan" class="py-24 bg-surface-1 border-t border-b border-border bg-dot-pattern">
    <div class="max-w-7xl mx-auto px-4">
        <div x-data="{ 
            scroll(direction) { 
                $refs.slider.scrollBy({ left: direction * 360, behavior: 'smooth' }); 
            } 
        }" class="relative">
            <div class="flex flex-col md:flex-row items-start md:items-end justify-between mb-12">
                <div>
                    <h2 class="text-xs font-bold text-primary tracking-widest uppercase mb-3">Jadwal Kelas</h2>
                    <h3 class="text-3xl font-bold text-ink">Pelatihan Terbaru & Unggulan</h3>
                    <div class="w-12 h-1 bg-primary mt-4"></div>
                </div>
                <div class="flex items-center gap-3 mt-6 md:mt-0">
                    <button @click="scroll(-1)" type="button" class="w-10 h-10 rounded-full border border-border bg-canvas text-ink hover:bg-primary hover:!text-white hover:border-primary transition-all duration-200 flex items-center justify-center shadow-sm" aria-label="Geser Kiri">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="scroll(1)" type="button" class="w-10 h-10 rounded-full border border-border bg-canvas text-ink hover:bg-primary hover:!text-white hover:border-primary transition-all duration-200 flex items-center justify-center shadow-sm" aria-label="Geser Kanan">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    @auth
                        <a href="{{ route('user.pelatihan.index') }}" class="ml-2 inline-flex items-center gap-1.5 text-sm font-semibold text-link hover:underline">
                            Lihat Semua Kelas
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endauth
                </div>
            </div>
            
            <div x-ref="slider" class="flex overflow-x-auto gap-8 pb-8 pt-2 px-1 snap-x snap-mandatory scrollbar-thin">
                @forelse($latestTrainings as $pelatihan)
                    @php
                        if (!is_object($pelatihan)) {
                            continue;
                        }
                        $isFull = $pelatihan->isFull();
                        $approved = $pelatihan->approved_count;
                        $quota = $pelatihan->kuota;
                        $percentage = $quota > 0 ? min(($approved / $quota) * 100, 100) : 0;
                    @endphp
                    <div class="card flex flex-col bg-canvas border border-border rounded-lg overflow-hidden shadow-card hover:border-ink flex-shrink-0 w-80 sm:w-96 snap-start">
                        <!-- Top accent line based on category -->
                        <div class="h-1 bg-primary"></div>
                        
                        @if($pelatihan->thumbnail)
                            <img src="{{ Storage::url($pelatihan->thumbnail) }}" alt="{{ $pelatihan->judul }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-surface-1 flex items-center justify-center">
                                <svg class="w-12 h-12 text-border" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                        @endif
                        
                        <div class="p-6 flex-1 flex flex-col">
                            <!-- Category Badge -->
                            <div class="mb-4">
                                <span class="inline-block px-2.5 py-0.5 rounded-sm bg-surface-1 text-xs font-semibold text-ink-muted border border-border">
                                    {{ $pelatihan->kategori->nama_kategori }}
                                </span>
                            </div>
                            
                            <!-- Title -->
                            <h4 class="text-xl font-bold text-ink mb-3 line-clamp-2 leading-snug">
                                {{ $pelatihan->judul }}
                            </h4>
                            
                            <p class="text-sm text-ink-muted mb-6 line-clamp-3 leading-relaxed">
                                {{ $pelatihan->deskripsi }}
                            </p>
                            
                            <!-- Info Grid -->
                            <div class="space-y-2 mb-6 border-t border-surface-2 pt-4 text-xs text-ink">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-ink-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span>Narasumber: <strong class="font-semibold">{{ $pelatihan->narasumber }}</strong></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-ink-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>{{ $pelatihan->tanggal->format('d M Y') }} · {{ \Carbon\Carbon::parse($pelatihan->jam)->format('H:i') }} WIB</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-ink-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span class="line-clamp-1">{{ $pelatihan->lokasi }}</span>
                                </div>
                            </div>
                            
                            <!-- Quota Progress -->
                            <div class="mt-auto">
                                @if($quota > 0)
                                    <div class="flex items-center justify-between text-xs mb-1.5">
                                        <span class="font-medium text-ink-muted">Kuota Pendaftaran</span>
                                        <span class="font-bold text-ink">{{ $approved }} / {{ $quota }} Peserta</span>
                                    </div>
                                    <div class="w-full h-1.5 bg-surface-2 rounded-full overflow-hidden mb-4">
                                        <div class="h-full bg-primary transition-all duration-300" style="width: {{ $percentage }}%"></div>
                                    </div>
                                @else
                                    <div class="mb-4 text-xs font-semibold text-success flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 bg-success rounded-full"></span>
                                        Kuota Terbuka / Tanpa Batas
                                    </div>
                                @endif
                                
                                @if($isFull || $pelatihan->status === 'closed')
                                    <button disabled class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-surface-2 text-ink-muted border border-border text-sm font-semibold rounded-sm cursor-not-allowed">
                                        Sudah Penuh
                                    </button>
                                @else
                                    @guest
                                        <a href="{{ route('login') }}" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-[var(--color-ink)] !text-[var(--color-canvas)] hover:opacity-90 text-sm font-semibold rounded-sm transition-colors duration-200 hover:no-underline">
                                            Login Untuk Mendaftar
                                        </a>
                                    @else
                                        <a href="{{ route('user.pelatihan.show', $pelatihan->id) }}" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-primary !text-white hover:bg-primary-hover text-sm font-semibold rounded-sm transition-colors duration-200 hover:no-underline">
                                            Lihat Detail Kelas
                                        </a>
                                    @endguest
                                @endif

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="w-full card p-12 text-center bg-canvas border border-border rounded-lg shadow-card">
                        <p class="text-ink-muted font-medium">Saat ini tidak ada pelatihan aktif yang terbit.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- Alur Pendaftaran Section (How It Works) -->
<section class="py-24 bg-canvas">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-20">
            <h2 class="text-xs font-bold text-primary tracking-widest uppercase mb-3">Panduan Sistem</h2>
            <h3 class="text-3xl md:text-4xl font-bold text-ink">Alur Pendaftaran Pelatihan</h3>
            <div class="w-12 h-1 bg-primary mx-auto mt-4"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
            <!-- Connection Line (Desktop) -->
            <div class="hidden md:block absolute top-1/4 left-[10%] right-[10%] h-[1px] bg-border z-0"></div>
            
            <!-- Step 1 -->
            <div class="relative z-10 text-center flex flex-col items-center">
                <div class="w-16 h-16 rounded-full bg-canvas border border-primary text-primary flex items-center justify-center font-bold text-xl shadow-md mb-6 hover:scale-105 duration-200">
                    01
                </div>
                <h4 class="font-bold text-ink text-lg mb-2">Buat Akun</h4>
                <p class="text-sm text-ink-muted leading-relaxed max-w-[200px]">Daftarkan diri Anda dengan mengisi data profil lengkap.</p>
            </div>
            <!-- Step 2 -->
            <div class="relative z-10 text-center flex flex-col items-center">
                <div class="w-16 h-16 rounded-full bg-canvas border border-border text-ink-muted flex items-center justify-center font-bold text-xl shadow-sm mb-6 hover:border-primary hover:text-primary hover:scale-105 duration-200">
                    02
                </div>
                <h4 class="font-bold text-ink text-lg mb-2">Pilih Kelas</h4>
                <p class="text-sm text-ink-muted leading-relaxed max-w-[200px]">Pilih pelatihan yang sesuai minat Anda dan ajukan pendaftaran.</p>
            </div>
            <!-- Step 3 -->
            <div class="relative z-10 text-center flex flex-col items-center">
                <div class="w-16 h-16 rounded-full bg-canvas border border-border text-ink-muted flex items-center justify-center font-bold text-xl shadow-sm mb-6 hover:border-primary hover:text-primary hover:scale-105 duration-200">
                    03
                </div>
                <h4 class="font-bold text-ink text-lg mb-2">Verifikasi Admin</h4>
                <p class="text-sm text-ink-muted leading-relaxed max-w-[200px]">Tunggu verifikasi persetujuan keikutsertaan dari admin desa.</p>
            </div>
            <!-- Step 4 -->
            <div class="relative z-10 text-center flex flex-col items-center">
                <div class="w-16 h-16 rounded-full bg-canvas border border-border text-ink-muted flex items-center justify-center font-bold text-xl shadow-sm mb-6 hover:border-primary hover:text-primary hover:scale-105 duration-200">
                    04
                </div>
                <h4 class="font-bold text-ink text-lg mb-2">Unduh Sertifikat</h4>
                <p class="text-sm text-ink-muted leading-relaxed max-w-[200px]">Hadir penuh, ikuti materi, dan unduh sertifikat resmi Anda.</p>
            </div>
        </div>
    </div>
</section>

<!-- Footer Overwrite (Premium 3 Columns) -->
<footer class="bg-[var(--color-surface-1)] text-[var(--color-ink)] pt-16 pb-8 border-t border-[var(--color-border)]">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
            <!-- Column 1 -->
            <div>
                <div class="flex items-center gap-2 text-xl font-bold text-[var(--color-ink)] mb-4">
                    <span class="w-5 h-5 bg-primary inline-flex items-center justify-center text-[10px] text-on-primary font-bold rounded-sm shadow-sm">S</span>
                    <span>SIPPAD</span>
                </div>
                <p class="text-sm text-[var(--color-ink-muted)] leading-relaxed mb-6">
                    Sistem Pendaftaran Pelatihan Anak Desa. Mewujudkan masyarakat desa yang mandiri, kreatif, berdaya saing tinggi, dan cakap teknologi.
                </p>
                <div class="flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                    <span class="text-xs text-[var(--color-ink-muted)] font-medium">Server Status: Operasional</span>
                </div>
            </div>
            <!-- Column 2 -->
            <div>
                <h4 class="text-sm font-bold tracking-wider uppercase text-[var(--color-ink)] mb-4 border-l-2 border-primary pl-2">Navigasi Cepat</h4>
                <ul class="space-y-2 text-sm text-[var(--color-ink-muted)]">
                    <li><a href="{{ route('landing') }}" class="hover:text-[var(--color-link)] hover:underline">Beranda</a></li>
                    <li><a href="#pelatihan" class="hover:text-[var(--color-link)] hover:underline">Daftar Kelas Pelatihan</a></li>
                    @guest
                        <li><a href="{{ route('login') }}" class="hover:text-[var(--color-link)] hover:underline">Masuk Akun</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-[var(--color-link)] hover:underline">Registrasi Baru</a></li>
                    @else
                        <li><a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}" class="hover:text-[var(--color-link)] hover:underline">Dashboard</a></li>
                    @endguest
                </ul>
            </div>
            <!-- Column 3 -->
            <div>
                <h4 class="text-sm font-bold tracking-wider uppercase text-[var(--color-ink)] mb-4 border-l-2 border-primary pl-2">Hubungi Kami</h4>
                <ul class="space-y-3 text-sm text-[var(--color-ink-muted)]">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-[var(--color-ink-muted)] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Kantor Kepala Desa Karangduren, Jl. Pemuda No. 45, Kecamatan Karangduren, Kabupaten Malang, Jawa Timur</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[var(--color-ink-muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>(0341) 7891011</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[var(--color-ink-muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>info@sippad.go.id</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-[var(--color-border)] pt-8 mt-8 text-center text-xs text-[var(--color-ink-muted)] flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; {{ date('Y') }} SIPPAD — Sistem Pendaftaran Pelatihan Anak Desa. Hak Cipta Dilindungi Undang-Undang.</p>
            <p class="text-[var(--color-ink-muted)]">Dikembangkan di bawah Panduan Desain Adobe Spectrum</p>
        </div>
    </div>
</footer>
@endsection
