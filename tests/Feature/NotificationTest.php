<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\KategoriPelatihan;
use App\Models\Pelatihan;
use App\Models\Pendaftaran;
use App\Notifications\PendaftaranStatusNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationTest extends TestCase
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
            'status' => 'pending',
        ]);
    }

    public function test_admin_approving_registration_sends_notification()
    {
        $this->actingAs($this->admin);

        // Approve registration
        $response = $this->patch(route('admin.pendaftaran.setujui', $this->pendaftaran->id));
        $response->assertRedirect();

        // Verify status updated
        $this->assertEquals('disetujui', $this->pendaftaran->fresh()->status);

        // Verify notification was sent to user
        $this->assertCount(1, $this->user->notifications);
        $notification = $this->user->notifications->first();
        $this->assertEquals(PendaftaranStatusNotification::class, $notification->type);
        $this->assertEquals('disetujui', $notification->data['status']);
        $this->assertStringContainsString('disetujui oleh Admin', $notification->data['message']);
    }

    public function test_admin_rejecting_registration_sends_notification()
    {
        $this->actingAs($this->admin);

        // Reject registration
        $response = $this->patch(route('admin.pendaftaran.tolak', $this->pendaftaran->id));
        $response->assertRedirect();

        // Verify status updated
        $this->assertEquals('ditolak', $this->pendaftaran->fresh()->status);

        // Verify notification was sent to user
        $this->assertCount(1, $this->user->notifications);
        $notification = $this->user->notifications->first();
        $this->assertEquals(PendaftaranStatusNotification::class, $notification->type);
        $this->assertEquals('ditolak', $notification->data['status']);
        $this->assertStringContainsString('ditolak oleh Admin', $notification->data['message']);
    }

    public function test_user_can_mark_single_notification_as_read()
    {
        $this->actingAs($this->admin);
        $this->patch(route('admin.pendaftaran.setujui', $this->pendaftaran->id));

        $notification = $this->user->fresh()->notifications->first();
        $this->assertNull($notification->read_at);

        $this->actingAs($this->user);

        // Call read route
        $response = $this->post(route('notifications.read', $notification->id));
        
        // Assert redirect to the URL specified in notification
        $response->assertRedirect($notification->data['url']);

        // Verify marked as read
        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_user_can_mark_all_notifications_as_read()
    {
        $this->actingAs($this->admin);
        
        // Approve pendaftaran
        $this->patch(route('admin.pendaftaran.setujui', $this->pendaftaran->id));

        $this->actingAs($this->user);
        $this->assertCount(1, $this->user->unreadNotifications);

        // Call read-all route
        $response = $this->post(route('notifications.readAll'));
        $response->assertRedirect();

        // Verify marked as read
        $this->assertCount(0, $this->user->fresh()->unreadNotifications);
    }
}
