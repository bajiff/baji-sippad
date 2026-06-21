<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\KategoriPelatihan;
use App\Models\Pelatihan;
use App\Models\Pendaftaran;
use App\Models\Kehadiran;
use App\Models\Sertifikat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SertifikatTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;
    protected $kategori;
    protected $pelatihan;
    protected $pendaftaran;
    protected $kehadiran;

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
            'tanggal' => now()->addDays(5)->toDateString(),
            'jam' => '09:00:00',
            'kuota' => 20,
            'status' => 'publish',
        ]);

        // Create Pendaftaran
        $this->pendaftaran = Pendaftaran::create([
            'user_id' => $this->user->id,
            'pelatihan_id' => $this->pelatihan->id,
            'tanggal_daftar' => now()->toDateString(),
            'status' => 'disetujui',
        ]);

        // Create Kehadiran (User is marked as present)
        $this->kehadiran = Kehadiran::create([
            'pendaftaran_id' => $this->pendaftaran->id,
            'status_kehadiran' => 'hadir',
        ]);
    }

    public function test_admin_can_generate_certificates()
    {
        $this->actingAs($this->admin);

        // Call generate certificate route
        $response = $this->post(route('admin.sertifikat.generate', $this->pelatihan->id));
        $response->assertRedirect(route('admin.sertifikat.index'));
        $response->assertSessionHas('success');

        // Verify certificate is created in DB
        $this->assertDatabaseHas('sertifikat', [
            'kehadiran_id' => $this->kehadiran->id,
        ]);
    }

    public function test_user_can_download_their_certificate_as_pdf()
    {
        // Generate the certificate first
        $sertifikat = Sertifikat::create([
            'kehadiran_id' => $this->kehadiran->id,
            'nomor_sertifikat' => 'SIPPAD-1-0001-2026',
            'tanggal_terbit' => now()->toDateString(),
        ]);

        $this->actingAs($this->user);

        // Call download certificate route
        $response = $this->get(route('user.sertifikat.download', $sertifikat->id));
        
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('Content-Disposition', "attachment; filename=sertifikat-{$sertifikat->nomor_sertifikat}.pdf");
    }

    public function test_user_cannot_download_others_certificate()
    {
        // Generate the certificate first
        $sertifikat = Sertifikat::create([
            'kehadiran_id' => $this->kehadiran->id,
            'nomor_sertifikat' => 'SIPPAD-1-0001-2026',
            'tanggal_terbit' => now()->toDateString(),
        ]);

        // Create another user
        $otherUser = User::create([
            'name' => 'Other User',
            'email' => 'other@test.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $this->actingAs($otherUser);

        // Call download certificate route for other's certificate
        $response = $this->get(route('user.sertifikat.download', $sertifikat->id));
        
        $response->assertStatus(403);
    }

    public function test_user_can_view_their_certificates_page()
    {
        $this->actingAs($this->user);

        // Access certificates page
        $response = $this->get(route('user.sertifikat.index'));

        $response->assertStatus(200);
        $response->assertSee('Sertifikat Saya');
    }

    public function test_admin_can_view_pelatihan_certificate_management()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.sertifikat.pelatihan.show', $this->pelatihan->id));

        $response->assertStatus(200);
        $response->assertSee($this->pelatihan->judul);
        $response->assertSee($this->user->name);
    }

    public function test_admin_can_bulk_generate_certificates()
    {
        $this->actingAs($this->admin);

        // Delete the auto-generated or default certificate to start clean
        Sertifikat::truncate();

        $response = $this->post(route('admin.sertifikat.generate.bulk', $this->pelatihan->id), [
            'pendaftaran_ids' => [$this->pendaftaran->id],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('sertifikat', [
            'kehadiran_id' => $this->kehadiran->id,
        ]);
    }

    public function test_admin_can_bulk_revoke_certificates()
    {
        // First create a certificate manually
        $sertifikat = Sertifikat::create([
            'kehadiran_id' => $this->kehadiran->id,
            'nomor_sertifikat' => 'SIPPAD-1-0001-2026',
            'tanggal_terbit' => now()->toDateString(),
        ]);

        $this->actingAs($this->admin);

        $response = $this->post(route('admin.sertifikat.revoke.bulk', $this->pelatihan->id), [
            'pendaftaran_ids' => [$this->pendaftaran->id],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('sertifikat', [
            'kehadiran_id' => $this->kehadiran->id,
        ]);
    }

    public function test_admin_can_download_certificate_pdf()
    {
        $sertifikat = Sertifikat::create([
            'kehadiran_id' => $this->kehadiran->id,
            'nomor_sertifikat' => 'SIPPAD-1-0001-2026',
            'tanggal_terbit' => now()->toDateString(),
        ]);

        $this->actingAs($this->admin);

        $response = $this->get(route('admin.sertifikat.download', $sertifikat->id));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }
}
