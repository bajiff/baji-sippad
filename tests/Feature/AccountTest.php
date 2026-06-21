<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;
    protected $normalAdmin;
    protected $normalUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Superadmin
        $this->superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'super@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_superadmin' => true,
        ]);

        // Create Normal Admin
        $this->normalAdmin = User::create([
            'name' => 'Normal Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_superadmin' => false,
        ]);

        // Create Normal User
        $this->normalUser = User::create([
            'name' => 'Normal User',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'is_superadmin' => false,
        ]);
    }

    public function test_normal_admin_can_access_accounts_index()
    {
        $this->actingAs($this->normalAdmin);

        $response = $this->get(route('admin.accounts.index'));

        $response->assertStatus(200);
        $response->assertSee('Normal Admin');
        $response->assertSee('Normal User');
        $response->assertSee('Super Admin');
    }

    public function test_admin_can_use_dynamic_pagination_per_page()
    {
        $this->actingAs($this->normalAdmin);

        // Create 25 additional users (total 25 + 3 = 28)
        User::factory()->count(25)->create(['role' => 'user']);

        // Check default pagination (10)
        $response1 = $this->get(route('admin.accounts.index', ['per_page' => 10]));
        $response1->assertStatus(200);
        $this->assertCount(10, $response1->viewData('accounts'));

        // Check 20 pagination
        $response2 = $this->get(route('admin.accounts.index', ['per_page' => 20]));
        $response2->assertStatus(200);
        $this->assertCount(20, $response2->viewData('accounts'));

        // Check "all" pagination
        $responseAll = $this->get(route('admin.accounts.index', ['per_page' => 'all']));
        $responseAll->assertStatus(200);
        $this->assertCount(28, $responseAll->viewData('accounts'));
    }

    public function test_normal_admin_can_create_user_and_admin_accounts()
    {
        $this->actingAs($this->normalAdmin);

        $response = $this->post(route('admin.accounts.store'), [
            'name' => 'New User Test',
            'email' => 'newuser@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'user',
        ]);

        $response->assertRedirect(route('admin.accounts.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@test.com',
            'role' => 'user',
            'is_superadmin' => false,
        ]);

        // Normal admin attempts to create a superadmin (should fail is_superadmin set to true)
        $response2 = $this->post(route('admin.accounts.store'), [
            'name' => 'New Fake Super',
            'email' => 'fakesuper@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
            'is_superadmin' => '1',
        ]);

        $response2->assertRedirect(route('admin.accounts.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'fakesuper@test.com',
            'role' => 'admin',
            'is_superadmin' => false, // MUST BE FALSE because created by normal admin
        ]);
    }

    public function test_normal_admin_cannot_edit_or_update_superadmin()
    {
        $this->actingAs($this->normalAdmin);

        // Edit request should redirect with error
        $responseEdit = $this->get(route('admin.accounts.edit', $this->superAdmin));
        $responseEdit->assertRedirect(route('admin.accounts.index'));
        $responseEdit->assertSessionHas('error', 'Superadmin (admin utama) tidak bisa diubah oleh admin biasa.');

        // Update request should redirect with error
        $responseUpdate = $this->put(route('admin.accounts.update', $this->superAdmin), [
            'name' => 'Hacked Name',
            'email' => 'super@test.com',
            'role' => 'admin',
        ]);
        $responseUpdate->assertRedirect(route('admin.accounts.index'));
        $responseUpdate->assertSessionHas('error', 'Superadmin (admin utama) tidak bisa diubah oleh admin biasa.');
        $this->assertDatabaseHas('users', [
            'id' => $this->superAdmin->id,
            'name' => 'Super Admin', // Unchanged
        ]);
    }

    public function test_normal_admin_cannot_delete_superadmin()
    {
        $this->actingAs($this->normalAdmin);

        $response = $this->delete(route('admin.accounts.destroy', $this->superAdmin));
        $response->assertRedirect(route('admin.accounts.index'));
        $response->assertSessionHas('error', 'Superadmin (admin utama) tidak bisa dihapus oleh admin biasa.');
        $this->assertDatabaseHas('users', [
            'id' => $this->superAdmin->id,
        ]);
    }

    public function test_superadmin_can_edit_and_update_superadmin()
    {
        $this->actingAs($this->superAdmin);

        $responseEdit = $this->get(route('admin.accounts.edit', $this->superAdmin));
        $responseEdit->assertStatus(200);

        $responseUpdate = $this->put(route('admin.accounts.update', $this->normalAdmin), [
            'name' => 'Updated Admin',
            'email' => 'admin@test.com',
            'role' => 'admin',
            'is_superadmin' => '1', // Superadmin turns normal admin into superadmin
        ]);

        $responseUpdate->assertRedirect(route('admin.accounts.index'));
        $this->assertDatabaseHas('users', [
            'id' => $this->normalAdmin->id,
            'name' => 'Updated Admin',
            'is_superadmin' => true,
        ]);
    }

    public function test_user_cannot_access_accounts_resource()
    {
        $this->actingAs($this->normalUser);

        $response = $this->get(route('admin.accounts.index'));
        $response->assertStatus(403);
    }
}
