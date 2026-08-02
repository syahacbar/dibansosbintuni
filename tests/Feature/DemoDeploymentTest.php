<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DemoDeploymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'Mahasiswa']);
        Role::firstOrCreate(['name' => 'Operator']);
        Role::firstOrCreate(['name' => 'Super Admin']);
    }

    public function test_health_endpoint_returns_ok_unauthenticated(): void
    {
        $response = $this->getJson('/health');

        $response->assertStatus(200);
        $response->assertExactJson(['status' => 'ok']);
    }

    public function test_health_endpoint_works_with_demo_prefix(): void
    {
        config([
            'app.url' => 'https://demo.kasuariweb.net/dibansos-teluk-bintuni/app',
            'demo.enabled' => true,
            'demo.base_path' => '/dibansos-teluk-bintuni/app',
        ]);

        $response = $this->withHeaders([
            'X-Forwarded-Proto' => 'https',
            'X-Forwarded-Host' => 'demo.kasuariweb.net',
            'X-Forwarded-Prefix' => '/dibansos-teluk-bintuni/app',
        ])->getJson('/health');

        $response->assertStatus(200);
        $response->assertExactJson(['status' => 'ok']);
    }

    public function test_application_respects_public_base_path_in_urls_and_redirects(): void
    {
        config([
            'app.url' => 'https://demo.kasuariweb.net/dibansos-teluk-bintuni/app',
            'app.asset_url' => 'https://demo.kasuariweb.net/dibansos-teluk-bintuni/app',
            'demo.enabled' => true,
            'demo.base_path' => '/dibansos-teluk-bintuni/app',
            'session.path' => '/dibansos-teluk-bintuni/app',
        ]);

        // Login page GET
        $loginResponse = $this->withHeaders([
            'REMOTE_ADDR' => '127.0.0.1',
            'X-Forwarded-Proto' => 'https',
            'X-Forwarded-Host' => 'demo.kasuariweb.net',
            'X-Forwarded-Prefix' => '/dibansos-teluk-bintuni/app',
        ])->get('/login');

        $loginResponse->assertStatus(200);

        // Login POST
        $user = User::factory()->create();
        $user->assignRole('Mahasiswa');

        $authResponse = $this->withHeaders([
            'REMOTE_ADDR' => '127.0.0.1',
            'X-Forwarded-Proto' => 'https',
            'X-Forwarded-Host' => 'demo.kasuariweb.net',
            'X-Forwarded-Prefix' => '/dibansos-teluk-bintuni/app',
        ])->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $authResponse->assertRedirect('https://demo.kasuariweb.net/dibansos-teluk-bintuni/app/dashboard');

        // Dashboard GET
        $dashboardResponse = $this->actingAs($user)->withHeaders([
            'REMOTE_ADDR' => '127.0.0.1',
            'X-Forwarded-Proto' => 'https',
            'X-Forwarded-Host' => 'demo.kasuariweb.net',
            'X-Forwarded-Prefix' => '/dibansos-teluk-bintuni/app',
        ])->get('/dashboard');

        $dashboardResponse->assertStatus(200);

        // Mahasiswa representative route GET
        $mahasiswaResponse = $this->actingAs($user)->withHeaders([
            'REMOTE_ADDR' => '127.0.0.1',
            'X-Forwarded-Proto' => 'https',
            'X-Forwarded-Host' => 'demo.kasuariweb.net',
            'X-Forwarded-Prefix' => '/dibansos-teluk-bintuni/app',
        ])->get('/mahasiswa/profil');

        $mahasiswaResponse->assertStatus(200);

        // Operator representative route GET
        $operatorUser = User::factory()->create();
        $operatorUser->assignRole('Operator');

        $operatorResponse = $this->actingAs($operatorUser)->withHeaders([
            'REMOTE_ADDR' => '127.0.0.1',
            'X-Forwarded-Proto' => 'https',
            'X-Forwarded-Host' => 'demo.kasuariweb.net',
            'X-Forwarded-Prefix' => '/dibansos-teluk-bintuni/app',
        ])->get('/operator/dashboard');

        $operatorResponse->assertStatus(200);

        // Logout POST
        $logoutResponse = $this->actingAs($user)->withHeaders([
            'REMOTE_ADDR' => '127.0.0.1',
            'X-Forwarded-Proto' => 'https',
            'X-Forwarded-Host' => 'demo.kasuariweb.net',
            'X-Forwarded-Prefix' => '/dibansos-teluk-bintuni/app',
        ])->post('/logout');

        $this->assertGuest();
        $logoutResponse->assertRedirect('https://demo.kasuariweb.net/dibansos-teluk-bintuni/app/login');
    }

    public function test_application_behaves_normally_when_demo_base_path_is_empty(): void
    {
        config([
            'app.url' => 'http://localhost',
            'demo.enabled' => false,
            'demo.base_path' => '',
            'session.path' => '/',
        ]);

        $response = $this->get('/login');
        $response->assertStatus(200);

        $user = User::factory()->create();
        $user->assignRole('Mahasiswa');

        $loginResponse = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $loginResponse->assertRedirect(route('dashboard'));

        $logoutResponse = $this->actingAs($user)->post('/logout');
        $this->assertGuest();
        $logoutResponse->assertRedirect(route('login'));
    }
}
