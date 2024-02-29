<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatementTest extends TestCase
{
    use RefreshDatabase;

    public int $amount;

    protected function setUp(): void
    {
        parent::setUp();

        $this->balance = 10000;
        $this->amount = 1000;

        $this->user = User::factory(1)->create()->first();

        $this->actingAs($this->user);
    }

    /**
     * Test visiting the statement page.
     */
    public function test_visit_statement_page(): void
    {
        $response = $this->get(route('statement'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.statement');
        $response->assertSee('Statement of amount');
        $response->assertViewHas('transactions', $this->user->transactions()->paginate(5));
    }
}
