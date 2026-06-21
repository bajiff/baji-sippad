<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\KategoriPelatihan;
use App\Models\Pelatihan;
use App\Models\Pendaftaran;
use App\Models\Kehadiran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KehadiranTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;
    protected $kategori;
    protected $pelatihan;
    protected $pendaftaran;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->user = User::create([
            'name' => 'User Test',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $this->kategori = KategoriPelatihan::create([
            'nama_kategori' => 'Teknologi Informasi',
            'deskripsi' => 'Pelatihan TI',
        ]);

        $this->pelatihan = Pelatihan::create([
            'kategori_id' => $this->kategori->id,
            'judul' => 'Pemrograman Laravel',
            'deskripsi' => 'Belajar Laravel',
            'narasumber' => 'Prof. Dr. Meki',
            'lokasi' => 'Balai Desa',
            'tanggal' => '2026-06-15',
            'jam' => '09:00:00',
            'kuota' => 20,
            'status' => 'publish',
            'presensi_by' => 'admin',
        ]);

        $this->pendaftaran = Pendaftaran::create([
            'user_id' => $this->user->id,
            'pelatihan_id' => $this->pelatihan->id,
            'tanggal_daftar' => '2026-06-14',
            'status' => 'disetujui',
        ]);
    }

    public function test_admin_can_toggle_presensi_mode()
    {
        $this->actingAs($this->admin);

        // Toggle to peserta
        $response = $this->patch(route('admin.kehadiran.toggleMode', $this->pelatihan), [
            'presensi_by' => 'peserta'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Metode presensi berhasil diperbarui.');

        $this->pelatihan->refresh();
        $this->assertEquals('peserta', $this->pelatihan->presensi_by);

        // Toggle back to admin
        $response = $this->patch(route('admin.kehadiran.toggleMode', $this->pelatihan), [
            'presensi_by' => 'admin'
        ]);

        $response->assertRedirect();
        $this->pelatihan->refresh();
        $this->assertEquals('admin', $this->pelatihan->presensi_by);
    }

    public function test_user_can_perform_self_presence_when_mode_is_peserta()
    {
        // Set mode to peserta
        $this->pelatihan->update(['presensi_by' => 'peserta']);

        $this->actingAs($this->user);

        $response = $this->post(route('user.pendaftaran.presensi', $this->pendaftaran));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Presensi kehadiran Anda berhasil dicatat.');

        $this->assertDatabaseHas('kehadiran', [
            'pendaftaran_id' => $this->pendaftaran->id,
            'status_kehadiran' => 'hadir',
        ]);
    }

    public function test_user_cannot_perform_self_presence_when_mode_is_admin()
    {
        // Set mode to admin
        $this->pelatihan->update(['presensi_by' => 'admin']);

        $this->actingAs($this->user);

        $response = $this->post(route('user.pendaftaran.presensi', $this->pendaftaran));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Presensi mandiri dinonaktifkan oleh admin.');

        $this->assertDatabaseMissing('kehadiran', [
            'pendaftaran_id' => $this->pendaftaran->id,
        ]);
    }

    public function test_user_can_perform_self_presence_even_when_initially_marked_as_tidak_hadir()
    {
        $this->pelatihan->update(['presensi_by' => 'peserta']);

        Kehadiran::create([
            'pendaftaran_id' => $this->pendaftaran->id,
            'status_kehadiran' => 'tidak_hadir',
        ]);

        $this->actingAs($this->user);

        $response = $this->post(route('user.pendaftaran.presensi', $this->pendaftaran));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Presensi kehadiran Anda berhasil dicatat.');

        $this->assertDatabaseHas('kehadiran', [
            'pendaftaran_id' => $this->pendaftaran->id,
            'status_kehadiran' => 'hadir',
        ]);
    }
}
