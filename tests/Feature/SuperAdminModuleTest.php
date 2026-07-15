<?php

namespace Tests\Feature;

use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SuperAdminModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_manage_users(): void
    {
        $admin = User::factory()->create();
        $role = Role::create(['name' => 'Operator']);

        $this->actingAs($admin)
            ->get(route('super-admin.users.index'))
            ->assertOk()
            ->assertSee('User');

        $this->actingAs($admin)
            ->post(route('super-admin.users.store'), [
                'name' => 'Operator Baru',
                'email' => 'operatorbaru@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
                'roles' => [$role->name],
            ])
            ->assertRedirect(route('super-admin.users.index'));

        $user = User::where('email', 'operatorbaru@example.com')->firstOrFail();
        $this->assertTrue($user->hasRole('Operator'));

        $this->actingAs($admin)
            ->put(route('super-admin.users.update', $user), [
                'name' => 'Operator Update',
                'email' => 'operatorupdate@example.com',
                'password' => '',
                'password_confirmation' => '',
                'roles' => [$role->name],
            ])
            ->assertRedirect(route('super-admin.users.index'));

        $this->assertDatabaseHas('users', ['email' => 'operatorupdate@example.com']);

        $this->actingAs($admin)
            ->delete(route('super-admin.users.destroy', $user->fresh()))
            ->assertRedirect(route('super-admin.users.index'));

        $this->assertDatabaseMissing('users', ['email' => 'operatorupdate@example.com']);
    }

    public function test_super_admin_can_manage_roles(): void
    {
        $admin = User::factory()->create();
        $permission = Permission::create(['name' => 'manage reports']);

        $this->actingAs($admin)
            ->post(route('super-admin.roles.store'), [
                'name' => 'Reviewer',
                'guard_name' => 'web',
                'permissions' => [$permission->name],
            ])
            ->assertRedirect(route('super-admin.roles.index'));

        $role = Role::where('name', 'Reviewer')->firstOrFail();
        $this->assertTrue($role->hasPermissionTo('manage reports'));

        $this->actingAs($admin)
            ->put(route('super-admin.roles.update', $role), [
                'name' => 'Reviewer Senior',
                'guard_name' => 'web',
                'permissions' => [$permission->name],
            ])
            ->assertRedirect(route('super-admin.roles.index'));

        $this->assertDatabaseHas('roles', ['name' => 'Reviewer Senior']);

        $this->actingAs($admin)
            ->delete(route('super-admin.roles.destroy', $role->fresh()))
            ->assertRedirect(route('super-admin.roles.index'));

        $this->assertDatabaseMissing('roles', ['name' => 'Reviewer Senior']);
    }

    public function test_super_admin_can_manage_permissions(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->post(route('super-admin.permissions.store'), [
                'name' => 'manage exports',
                'guard_name' => 'web',
            ])
            ->assertRedirect(route('super-admin.permissions.index'));

        $permission = Permission::where('name', 'manage exports')->firstOrFail();

        $this->actingAs($admin)
            ->put(route('super-admin.permissions.update', $permission), [
                'name' => 'manage imports',
                'guard_name' => 'web',
            ])
            ->assertRedirect(route('super-admin.permissions.index'));

        $this->assertDatabaseHas('permissions', ['name' => 'manage imports']);

        $this->actingAs($admin)
            ->delete(route('super-admin.permissions.destroy', $permission->fresh()))
            ->assertRedirect(route('super-admin.permissions.index'));

        $this->assertDatabaseMissing('permissions', ['name' => 'manage imports']);
    }

    public function test_super_admin_can_update_system_settings(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->get(route('super-admin.settings.edit'))
            ->assertOk()
            ->assertSee('Pengaturan Sistem');

        $this->actingAs($admin)
            ->put(route('super-admin.settings.update'), [
                'active_year' => 2026,
                'logo' => UploadedFile::fake()->image('logo.png', 100, 100),
            ])
            ->assertRedirect(route('super-admin.settings.edit'));

        $this->assertDatabaseHas('system_settings', [
            'key' => 'active_year',
            'value' => '2026',
        ]);

        $logoPath = SystemSetting::where('key', 'logo_path')->value('value');
        $this->assertNotNull($logoPath);
        Storage::disk('public')->assertExists($logoPath);
    }
}
