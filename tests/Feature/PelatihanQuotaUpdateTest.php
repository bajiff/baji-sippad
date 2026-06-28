<?php

namespace Tests\Feature;

use App\Models\KategoriPelatihan;
use App\Models\Pelatihan;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PelatihanQuotaUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_pelatihan_status_reopens_to_publish_when_quota_is_added()
    {
        Storage::fake('public');

        $admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $kategori = KategoriPelatihan::create([
            'nama_kategori' => 'Bisnis Digital',
            'deskripsi' => 'Pelatihan bisnis',
        ]);

        $pelatihan = Pelatihan::create([
            'kategori_id' => $kategori->id,
            'judul' => 'Digital Marketing',
            'deskripsi' => 'Belajar digital marketing',
            'narasumber' => 'Prof. Dr. Meki',
            'lokasi' => 'Aula Desa',
            'tanggal' => now()->addDays(10)->toDateString(),
            'jam' => '08:00:00',
            'kuota' => 1,
            'status' => 'closed',
        ]);

        $user = User::create([
            'name' => 'User Test',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        Pendaftaran::create([
            'user_id' => $user->id,
            'pelatihan_id' => $pelatihan->id,
            'tanggal_daftar' => now()->toDateString(),
            'status' => 'disetujui',
        ]);

        $this->assertTrue($pelatihan->isFull());
        $this->assertEquals('closed', $pelatihan->status);

        $response = $this->actingAs($admin)->put(route('admin.pelatihan.update', $pelatihan), [
            'kategori_id' => $kategori->id,
            'judul' => 'Digital Marketing',
            'deskripsi' => 'Belajar digital marketing',
            'narasumber' => 'Prof. Dr. Meki',
            'lokasi' => 'Aula Desa',
            'tanggal' => now()->addDays(10)->toDateString(),
            'jam' => '08:00:00',
            'kuota' => 5,
            'persyaratan' => '',
            'sertifikat_enabled' => 0,
        ]);

        $response->assertRedirect(route('admin.pelatihan.index'));
        $response->assertSessionHas('success');

        $pelatihan->refresh();
        $this->assertFalse($pelatihan->isFull());
        $this->assertEquals('publish', $pelatihan->status);
    }
}
