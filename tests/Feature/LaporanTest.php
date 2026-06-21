<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\KategoriPelatihan;
use App\Models\Pelatihan;
use App\Models\Pendaftaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;
    protected $kategori;
    protected $pelatihan;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Admin
        $this->admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create User
        $this->user = User::create([
            'name' => 'User Test',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Create Kategori
        $this->kategori = KategoriPelatihan::create([
            'nama_kategori' => 'Teknologi Informasi',
            'deskripsi' => 'Pelatihan bidang TI',
        ]);

        // Create Pelatihan
        $this->pelatihan = Pelatihan::create([
            'kategori_id' => $this->kategori->id,
            'judul' => 'Pemrograman Laravel Pemula',
            'deskripsi' => 'Belajar dasar Laravel',
            'narasumber' => 'Prof. Dr. Meki',
            'lokasi' => 'Balai Desa',
            'tanggal' => '2026-06-15',
            'jam' => '09:00:00',
            'kuota' => 20,
            'status' => 'publish',
        ]);
    }

    public function test_admin_can_access_laporan_index_page()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.laporan.index'));

        $response->assertStatus(200);
        $response->assertSee('Laporan & Statistik');
        $response->assertSee('Pemrograman Laravel Pemula');
    }

    public function test_admin_can_export_laporan_as_csv()
    {
        $this->actingAs($this->admin);

        // Call export CSV
        $response = $this->get(route('admin.laporan.export', 'csv'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $response->assertHeader('Content-Disposition', 'attachment; filename="laporan-pelatihan.csv"');

        // Capture streamed content
        ob_start();
        $response->sendContent();
        $content = ob_get_clean();

        $this->assertStringContainsString('Pelatihan,Kategori,Tanggal,"Total Pendaftar",Disetujui,Ditolak,Hadir', $content);
        $this->assertStringContainsString('Pemrograman Laravel Pemula', $content);
    }

    public function test_admin_can_export_laporan_as_pdf()
    {
        $this->actingAs($this->admin);

        // Call export PDF
        $response = $this->get(route('admin.laporan.export', 'pdf'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('Content-Disposition', 'attachment; filename=laporan-pelatihan.pdf');
    }

    public function test_admin_can_export_laporan_as_xlsx()
    {
        \Maatwebsite\Excel\Facades\Excel::fake();

        $this->actingAs($this->admin);

        // Call export Excel (xlsx)
        $response = $this->get(route('admin.laporan.export', 'xlsx'));

        $response->assertStatus(200);
        \Maatwebsite\Excel\Facades\Excel::assertDownloaded('laporan-pelatihan.xlsx');
    }

    public function test_admin_can_export_laporan_with_filters()
    {
        $this->actingAs($this->admin);

        // Call export PDF with filters that match
        $responseMatched = $this->get(route('admin.laporan.export', [
            'format' => 'pdf',
            'tahun' => '2026',
            'bulan' => '06',
        ]));
        $responseMatched->assertStatus(200);

        // Call export PDF with filters that don't match (e.g. year 2025)
        $responseUnmatched = $this->get(route('admin.laporan.export', [
            'format' => 'pdf',
            'tahun' => '2025',
        ]));
        $responseUnmatched->assertStatus(200);
    }

    public function test_admin_cannot_export_invalid_format()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.laporan.export', 'txt'));

        $response->assertRedirect(route('admin.laporan.index'));
        $response->assertSessionHas('error', 'Format export belum tersedia.');
    }
}
