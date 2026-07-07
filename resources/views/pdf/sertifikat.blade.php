<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Penghargaan - {{ $sertifikat->nomor_sertifikat }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background-color: #181818; /* Dark Luxury Background representing the outer dark frame */
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #111111;
        }
        .page-container {
            position: absolute;
            top: 8mm;
            left: 8mm;
            width: 281mm;
            height: 194mm;
            background-color: #ffffff; /* White center canvas */
            border: 3px solid #c59b27; /* Gold border accent */
            overflow: visible;
            box-sizing: border-box;
        }
        /* Geometric & Wavy Corner Accents matching the template */
        .corner-tl {
            position: absolute;
            top: 0;
            left: 0;
            width: 85px;
            height: 85px;
            background: #181818;
            border-bottom-right-radius: 60px;
            border-right: 3px solid #c59b27;
            border-bottom: 3px solid #c59b27;
            z-index: 1;
        }
        .corner-tr {
            position: absolute;
            top: 0;
            right: 0;
            width: 85px;
            height: 85px;
            background: #181818;
            border-bottom-left-radius: 60px;
            border-left: 3px solid #c59b27;
            border-bottom: 3px solid #c59b27;
            z-index: 1;
        }
        .corner-bl {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 85px;
            height: 85px;
            background: #181818;
            border-top-right-radius: 60px;
            border-right: 3px solid #c59b27;
            border-top: 3px solid #c59b27;
            z-index: 1;
        }
        .corner-br {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 85px;
            height: 85px;
            background: #181818;
            border-top-left-radius: 60px;
            border-left: 3px solid #c59b27;
            border-top: 3px solid #c59b27;
            z-index: 1;
        }
        /* Gold connecting accent lines */
        .gold-line-top {
            position: absolute;
            top: 15px;
            left: 100px;
            right: 100px;
            height: 2px;
            background-color: #c59b27;
        }
        .gold-line-bottom {
            position: absolute;
            bottom: 15px;
            left: 100px;
            right: 100px;
            height: 2px;
            background-color: #c59b27;
        }
        /* Circular Emblem Badge Logo in top left */
        .badge-logo {
            position: absolute;
            top: 28px;
            left: 105px;
            width: 76px;
            height: 76px;
            border-radius: 50%;
            border: 2px solid #c92a2a;
            background: #ffffff;
            text-align: center;
            padding: 8px 4px;
            box-sizing: border-box;
            z-index: 5;
        }
        .badge-text-top {
            font-size: 5.5px;
            font-weight: bold;
            color: #c92a2a;
            letter-spacing: 0.3px;
            line-height: 1.1;
            margin-bottom: 4px;
            text-transform: uppercase;
        }
        .badge-title {
            font-size: 11px;
            font-weight: bold;
            color: #ffffff;
            background: #181818;
            padding: 2px 5px;
            border-radius: 3px;
            margin: 2px auto;
            display: inline-block;
            letter-spacing: 1px;
        }
        .badge-est {
            font-size: 6px;
            color: #c59b27;
            font-weight: bold;
            margin-top: 4px;
            letter-spacing: 0.5px;
        }
        /* Main Typography Structure */
        .content-area {
            position: relative;
            z-index: 10;
            text-align: center;
            padding-top: 30px;
            padding-bottom: 30px;
        }
        .title-main {
            font-size: 42px;
            font-weight: 900;
            letter-spacing: 8px;
            color: #111111;
            margin: 0;
            text-transform: uppercase;
        }
        .title-sub {
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 6px;
            color: #333333;
            margin: 2px 0 0 0;
            text-transform: uppercase;
        }
        .cert-number {
            font-size: 10px;
            color: #666666;
            letter-spacing: 1px;
            margin-top: 6px;
            margin-bottom: 18px;
            text-transform: uppercase;
        }
        .given-to {
            font-size: 14px;
            color: #333333;
            margin-bottom: 8px;
        }
        .recipient-name {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-style: italic;
            font-weight: bold;
            font-size: 36px;
            color: #b8860b; /* Golden mustard color matching template */
            display: inline-block;
            padding-bottom: 4px;
            border-bottom: 2px solid #c59b27;
            min-width: 450px;
            margin-bottom: 12px;
        }
        .as-role-label {
            font-size: 13px;
            color: #555555;
            margin-bottom: 4px;
        }
        .role-title {
            font-size: 24px;
            font-weight: bold;
            color: #111111;
            margin-bottom: 16px;
        }
        .reason-text {
            font-size: 13px;
            line-height: 1.6;
            color: #333333;
            max-width: 78%;
            margin: 0 auto;
            text-align: center;
        }
        .training-highlight {
            font-weight: bold;
            color: #111111;
        }
        /* Footer Signatures matching template style */
        .footer-table {
            position: absolute;
            bottom: 25px;
            left: 0;
            width: 100%;
            padding: 0 80px;
            box-sizing: border-box;
            z-index: 10;
        }
        .footer-col {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
        }
        .sig-name {
            font-size: 14px;
            font-weight: bold;
            color: #111111;
            margin-bottom: 3px;
        }
        .sig-title {
            font-size: 11px;
            color: #555555;
        }
    </style>
</head>
<body>
    <div class="page-container">
        <!-- Geometric Corner Accents -->
        <div class="corner-tl"></div>
        <div class="corner-tr"></div>
        <div class="corner-bl"></div>
        <div class="corner-br"></div>
        
        <!-- Gold Connecting Accent Lines -->
        <div class="gold-line-top"></div>
        <div class="gold-line-bottom"></div>

        <!-- Circular Emblem Badge Logo -->

        <!-- Main Content Area -->
        <div class="content-area">
            <h1 class="title-main">SERTIFIKAT</h1>
            <div class="title-sub">PENGHARGAAN</div>
            <div class="cert-number">Nomor: {{ $sertifikat->nomor_sertifikat }}</div>

            <div class="given-to">Dengan bangga dipersembahkan kepada:</div>
            
            <div class="recipient-name">{{ $kehadiran->pendaftaran->user->name }}</div>
            
            <div class="as-role-label">sebagai</div>
            <div class="role-title">Peserta</div>

            <div class="reason-text">
                Atas partisipasi aktif dan keberhasilannya menyelesaikan pelatihan <span class="training-highlight">"{{ $kehadiran->pendaftaran->pelatihan->judul }}"</span> yang diselenggarakan oleh Sistem Pendaftaran Pelatihan Anak Desa (SIPPAD) pada tanggal {{ $kehadiran->pendaftaran->pelatihan->tanggal->format('d F Y') }} bertempat di {{ $kehadiran->pendaftaran->pelatihan->lokasi }} dengan narasumber<span class="training-highlight"> "{{ $kehadiran->pendaftaran->pelatihan->narasumber }}"</span>
            </div>

            <!-- Ketua Pelaksana Section -->
            <div style="margin-top: 25px; text-align: center;">
                <div style="font-size: 13px; color: #555555; margin: 50px 0px;">Ketua Pelaksana</div>
                <div style="font-size: 15px; font-weight: bold; color: #111111;">
                    <span style="border-bottom: 1px solid #111111; display: inline-block; padding-bottom: 1px;">{{ $kehadiran->pendaftaran->pelatihan->ketua_pelaksana ?? 'Ahmad Fauzi, S.T.' }}</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
