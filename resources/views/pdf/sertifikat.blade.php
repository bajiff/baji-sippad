<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Pelatihan - {{ $sertifikat->nomor_sertifikat }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: #fdfcf7; /* Premium cream background */
            font-family: 'Georgia', 'Times New Roman', Times, serif;
            color: #1b1b1b;
        }
        .border-outer {
            position: absolute;
            top: 10mm;
            left: 10mm;
            right: 10mm;
            bottom: 10mm;
            border: 4px double #b89047; /* Elegant Gold Double Border */
            background-color: #ffffff;
        }
        .border-inner {
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border: 1px solid #b89047;
            padding: 10mm 15mm;
            text-align: center;
        }
        .header {
            margin-top: 5px;
        }
        .logo {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 6px;
            color: #b89047;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .title {
            font-size: 34px;
            font-weight: normal;
            letter-spacing: 2px;
            margin: 0 0 5px 0;
            color: #1b1b1b;
        }
        .subtitle {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            letter-spacing: 1.5px;
            color: #6e6e6e;
            text-transform: uppercase;
            margin-bottom: 22px;
        }
        .given-to {
            font-size: 14px;
            font-style: italic;
            color: #6e6e6e;
            margin-bottom: 6px;
        }
        .name {
            font-size: 28px;
            font-weight: bold;
            border-bottom: 2px solid #b89047;
            display: inline-block;
            padding-bottom: 6px;
            margin-bottom: 22px;
            min-width: 380px;
            color: #1b1b1b;
        }
        .reason {
            font-size: 13.5px;
            line-height: 1.75;
            margin-bottom: 20px;
            color: #2b2b2b;
            max-width: 90%;
            margin-left: auto;
            margin-right: auto;
        }
        .training-title {
            font-weight: bold;
            font-style: italic;
            color: #b89047;
        }
        .footer-table {
            width: 100%;
            position: absolute;
            bottom: 8mm;
            left: 0;
            padding: 0 15mm;
        }
        .footer-col {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
        }
        .signature-line {
            width: 200px;
            border-bottom: 1px solid #b89047;
            margin: 0 auto 5px auto;
        }
        .signature-title {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #6e6e6e;
            line-height: 1.4;
        }
    </style>
</head>
<body>
    <div class="border-outer">
        <div class="border-inner">
            <div class="header">
                <div class="logo">S I P P A D</div>
                <div class="title">SERTIFIKAT PENGHARGAAN</div>
                <div class="subtitle">Nomor: {{ $sertifikat->nomor_sertifikat }}</div>
            </div>

            <div class="given-to">Diberikan kepada:</div>
            <div class="name">{{ $kehadiran->pendaftaran->user->name }}</div>

            <div class="reason">
                Atas partisipasi aktif dan keberhasilannya menyelesaikan pelatihan <span class="training-title">"{{ $kehadiran->pendaftaran->pelatihan->judul }}"</span> yang diselenggarakan oleh Sistem Pendaftaran Pelatihan Anak Desa (SIPPAD) pada tanggal {{ $kehadiran->pendaftaran->pelatihan->tanggal->format('d F Y') }} bertempat di {{ $kehadiran->pendaftaran->pelatihan->lokasi }} dengan narasumber {{ $kehadiran->pendaftaran->pelatihan->narasumber }}.
            </div>

            <table class="footer-table">
                <tr>
                    <td class="footer-col">
                        <div style="height: 50px;"></div>
                        <div class="signature-line"></div>
                        <div class="signature-title"><strong style="color: #1b1b1b;">{{ $kehadiran->pendaftaran->pelatihan->narasumber }}</strong></div>
                        <div class="signature-title">Narasumber</div>
                    </td>
                    <td class="footer-col">
                        <div style="height: 20px; font-family: 'Helvetica', sans-serif; font-size: 9.5px; color: #6e6e6e; margin-bottom: 10px;">
                            Desa Karangduren, {{ $sertifikat->tanggal_terbit->format('d F Y') }}
                        </div>
                        <div class="signature-line"></div>
                        <div class="signature-title"><strong style="color: #1b1b1b;">Pemerintah Desa Karangduren</strong></div>
                        <div class="signature-title">Kepala Desa</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
