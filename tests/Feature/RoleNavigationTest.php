<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_only_sees_student_navigation(): void
    {
        $user = $this->userWithRole('Mahasiswa');

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Mahasiswa')
            ->assertSee('Profil')
            ->assertSee('Upload Dokumen')
            ->assertDontSee('Operator')
            ->assertDontSee('Super Admin')
            ->assertDontSee('Master Data');
    }

    public function test_operator_dashboard_redirects_and_only_sees_operator_navigation(): void
    {
        $user = $this->userWithRole('Operator');

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertRedirect(route('operator.dashboard'));

        $this->actingAs($user)
            ->get(route('operator.dashboard'))
            ->assertOk()
            ->assertSee('Operator')
            ->assertSee('Daftar Pengajuan')
            ->assertDontSee('Super Admin')
            ->assertDontSee('Master Data')
            ->assertDontSee('Upload Dokumen');
    }

    public function test_super_admin_dashboard_redirects_and_only_sees_admin_navigation(): void
    {
        $user = $this->userWithRole('Super Admin');

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertRedirect(route('monitoring.dashboard'));

        $this->actingAs($user)
            ->get(route('monitoring.dashboard'))
            ->assertOk()
            ->assertSee('Super Admin')
            ->assertSee('Master Data')
            ->assertSee('Dashboard Monitoring')
            ->assertSee('Laporan')
            ->assertDontSee('Upload Dokumen')
            ->assertDontSee('Daftar Pengajuan');
    }

    private function userWithRole(string $roleName): User
    {
        $role = Role::firstOrCreate(['name' => $roleName]);
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }
}
