<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WalletTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->seed(\Database\Seeders\AdminSeeder::class);
    }

    public function test_admin_can_see_system_wallet_balance(): void
    {
        $wallet = Wallet::find(1);

        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);

        $response = $this->get(route('admin.dashboard'));
        
        $response->assertSee(['NGN', number_format($wallet->balance, 2)]);
    }
}
