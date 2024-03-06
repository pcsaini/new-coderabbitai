<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransferTest extends TestCase
{
    use RefreshDatabase;

    public User $user;
    public User $anotherUser;
    public int $balance;
    public int $amount;

    protected function setUp(): void
    {
        parent::setUp();

        $this->balance = 10000;
        $this->amount = 1000;

        $this->user = User::factory(1)->create([
            'balance' => $this->balance
        ])->first();
        $this->anotherUser = User::factory(1)->create()->first();

        $this->actingAs($this->user);
    }

    /**
     * Test visiting the transfer page.
     */
    public function test_visit_transfer_page(): void
    {
        $response = $this->get(route('transfer'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.transfer');
        $response->assertSee('Transfer Money');
    }

    /**
     * Test transfer validation
     */
    public function test_transfer_validate(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $response = $this->post(route('transfer.post'));

        $response->assertSessionHas('error');
    }

    /**
     * Test transferring money from one user to another.
     */
    public function test_transfer_money(): void
    {
        // Disable CSRF token verification
        $this->withoutMiddleware(VerifyCsrfToken::class);

        // Send a POST request to the transfer route with amount and recipient email
        $response = $this->post(route('transfer.post'), [
            'amount' => $this->amount,
            'email' => $this->anotherUser->email
        ]);

        // Check if a debit transaction is recorded in the database
        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'amount' => $this->amount,
            'type' => 'debit'
        ]);

        // Check if a credit transaction is recorded in the database for the recipient
        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->anotherUser->id,
            'amount' => $this->amount,
            'type' => 'credit'
        ]);

        // Check if the sender's balance is updated correctly after the transfer
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'balance' => $this->balance - $this->amount
        ]);

        // Check if the recipient's balance is updated correctly after the transfer
        $this->assertDatabaseHas('users', [
            'id' => $this->anotherUser->id,
            'balance' => $this->amount
        ]);

        // Assert that the response status is a redirect (302)
        $response->assertStatus(302);
    }
}
