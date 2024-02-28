<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class HomeTest extends TestCase
{
    public User $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create()->first();
    }

    /**
     * A basic feature test example.
     */
    public function test_the_base_url_redirect_to_home(): void
    {
        $response = $this->get('/');

        $response->assertRedirectToRoute('home');
    }

    /**
     * A basic feature test example.
     */
    public function test_the_home_page_redirect_to_login_if_not_logged_in(): void
    {
        $response = $this->get('/home');

        $response->assertRedirectToRoute('auth.login');
    }

    public function test_the_home_page(): void
    {
        $response = $this->actingAs($this->user)->get('/home');

        $response->assertStatus(200);
        $response->assertViewIs('pages.home');
        $response->assertSee('Welcome, ' . $this->user->name);
        $response->assertSee($this->user->email);
    }
}
