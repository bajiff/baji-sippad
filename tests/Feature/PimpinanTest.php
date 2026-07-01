<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PimpinanTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_pimpinan_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.pimpinan.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.pimpinan.index');
    }

    public function test_admin_can_update_pimpinan_data(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->patch(route('admin.pimpinan.update'), [
            'nama_desa' => 'Desa Suranenggala Kidul',
            'nama_kepala_desa' => 'Dr. Baji Ajalah, M.Kom.',
        ]);

        $response->assertRedirect(route('admin.pimpinan.index'));
        $this->assertDatabaseHas('pimpinans', [
            'nama_desa' => 'Desa Suranenggala Kidul',
            'nama_kepala_desa' => ' Dr. Baji Ajalah, M.Kom.',
        ]);
    }
}
