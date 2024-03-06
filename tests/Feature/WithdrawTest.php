<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WithdrawTest extends TestCase
{
    use RefreshDatabase;

    public User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create()->first();
        $this->actingAs($this->user);
    }

    /**
     * Test visiting the withdraw page.
     */
    public function test_visit_withdraw_page(): void
    {
        $response = $this->get(route('withdraw'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.withdraw');
        $response->assertSee('Withdraw Money');
    }

    /**
     * Test the validation of withdrawal request
     */
    public function test_withdraw_validate(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $response = $this->post(route('withdraw.post'));

        $response->assertSessionHas('error');
    }

    /**
     * Test the functionality of withdrawing money.
     */
    public function test_withdraw_money(): void
    {
        // Set the amount to be withdrawn
        $amount = 1000;

        // Bypass CSRF token verification for the request
        $this->withoutMiddleware(VerifyCsrfToken::class);

        // Send a POST request to the withdraw route with the specified amount
        $response = $this->post(route('withdraw.post'), [
            'amount' => $amount
        ]);

        // Assert that the transaction is recorded in the database
        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'amount' => $amount,
            'type' => 'debit'
        ]);

        // Assert that the user's balance is updated in the database
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'balance' => -$amount
        ]);

        // Assert that the response status is a redirect
        $response->assertStatus(302);
    }
}
