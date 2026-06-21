<?php

namespace Tests\Feature;

use App\Models\KategoriPelatihan;
use App\Models\Pelatihan;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PelatihanQueryOptimizationTest extends TestCase
{
    use RefreshDatabase;

    protected $kategori;
    protected $pelatihan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->kategori = KategoriPelatihan::create([
            'nama_kategori' => 'Teknologi Informasi',
            'deskripsi' => 'Pelatihan bidang TI',
        ]);

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

        $user1 = User::create([
            'name' => 'User Test 1',
            'email' => 'user1@test.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $user2 = User::create([
            'name' => 'User Test 2',
            'email' => 'user2@test.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        Pendaftaran::create([
            'user_id' => $user1->id,
            'pelatihan_id' => $this->pelatihan->id,
            'tanggal_daftar' => now()->toDateString(),
            'status' => 'disetujui',
        ]);
        
        Pendaftaran::create([
            'user_id' => $user2->id,
            'pelatihan_id' => $this->pelatihan->id,
            'tanggal_daftar' => now()->toDateString(),
            'status' => 'pending',
        ]);
    }

    public function test_query_count_is_zero_when_using_with_count()
    {
        // Load withCount
        $pelatihan = Pelatihan::withCount([
            'pendaftaran as approved_pendaftaran_count' => function ($query) {
                $query->where('status', 'disetujui');
            },
            'pendaftaran as pending_pendaftaran_count' => function ($query) {
                $query->where('status', 'pending');
            }
        ])->find($this->pelatihan->id);

        DB::flushQueryLog();
        DB::enableQueryLog();

        // Access the properties
        $approved = $pelatihan->approved_count;
        $pending = $pelatihan->pending_count;
        $isFull = $pelatihan->isFull();

        $this->assertEquals(1, $approved);
        $this->assertEquals(1, $pending);
        $this->assertFalse($isFull);

        // Verify no extra query was executed
        $queries = DB::getQueryLog();
        $this->assertCount(0, $queries);
    }

    public function test_query_count_is_zero_when_relation_loaded()
    {
        // Load with relation
        $pelatihan = Pelatihan::with('pendaftaran')->find($this->pelatihan->id);

        DB::flushQueryLog();
        DB::enableQueryLog();

        // Access the properties
        $approved = $pelatihan->approved_count;
        $pending = $pelatihan->pending_count;
        $isFull = $pelatihan->isFull();

        $this->assertEquals(1, $approved);
        $this->assertEquals(1, $pending);
        $this->assertFalse($isFull);

        // Verify no extra query was executed
        $queries = DB::getQueryLog();
        $this->assertCount(0, $queries);
    }

    public function test_query_count_is_present_when_nothing_eager_loaded()
    {
        // Find fresh model
        $pelatihan = Pelatihan::find($this->pelatihan->id);

        DB::flushQueryLog();
        DB::enableQueryLog();

        // Access properties
        $approved = $pelatihan->approved_count;
        $pending = $pelatihan->pending_count;
        $isFull = $pelatihan->isFull();

        $this->assertEquals(1, $approved);
        $this->assertEquals(1, $pending);
        $this->assertFalse($isFull);

        // Verify queries were executed (3 queries: approved, pending, isFull)
        $queries = DB::getQueryLog();
        $this->assertCount(3, $queries);
    }
}
