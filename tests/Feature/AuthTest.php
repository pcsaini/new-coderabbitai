<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_visit_register_page(): void
    {
        $response = $this->get(route('auth.register'));

        $response->assertSee('Create new account');
        $response->assertViewIs('pages.auth.register');
        $response->assertStatus(200);
    }

    public function test_register(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $user = User::factory(1)->make()->first();

        $response = $this->post(route('auth.register.post'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password'
        ]);

        $this->assertDatabaseHas('users', ['email' => $user->email]);
        $response->assertRedirectToRoute('home');
    }

    public function test_register_validate(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $response = $this->post(route('auth.register.post'));

        $response->assertSessionHas('error');
    }

    public function test_visit_login_page(): void
    {
        $response = $this->get(route('auth.login'));

        $response->assertSee('Login to your account');
        $response->assertViewIs('pages.auth.login');
        $response->assertStatus(200);
    }

    public function test_login(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $user = User::factory(1)->create()->first();

        $response = $this->post(route('auth.login.post'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertRedirectToRoute('home');
    }

    public function test_login_validate(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $response = $this->post(route('auth.login.post'));

        $response->assertSessionHas('error');
    }
}
