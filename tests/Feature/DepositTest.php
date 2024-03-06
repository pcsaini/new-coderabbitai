<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepositTest extends TestCase
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
     * Test visiting the deposit page.
     */
    public function test_visit_deposit_page(): void
    {
        $response = $this->get(route('deposit'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.deposit');
        $response->assertSee('Deposit Money');
    }

    /**
     * Test the validation of deposit post request
     */
    public function test_deposit_validate(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $response = $this->post(route('deposit.post'));

        $response->assertSessionHas('error');
    }

    /**
     * Test depositing money
     */
    public function test_deposit_money(): void
    {
        $amount = 1000;
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $response = $this->post(route('deposit.post'), [
            'amount' => $amount
        ]);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'amount' => $amount,
            'type' => 'credit'
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'balance' => $amount
        ]);

        $response->assertStatus(302);
    }
}
