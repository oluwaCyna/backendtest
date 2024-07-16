<?php

namespace Tests\Feature\Checker;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\AdminSeeder::class);
    }

    public function test_checker_can_see_system_wallet_balance(): void
    {
        $wallet = Wallet::find(1);

        $checker = User::factory()->checker()->create();
        $this->actingAs($checker);

        $response = $this->get(route('admin.dashboard'));

        $response->assertSee(['NGN', number_format($wallet->balance, 2)]);
    }
}
