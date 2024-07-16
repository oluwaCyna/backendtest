<?php

namespace Tests\Feature\Checker;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->seed(\Database\Seeders\AdminSeeder::class);
    }

    public function test_checker_can_not_see_create_user_form(): void
    {
        $checker = User::factory()->checker()->create();
        $this->actingAs($checker);

        $response = $this->get(route('admin.dashboard'));

        $response->assertDontSee(['Create Checker', 'Email']);
    }

    public function test_checker_can_see_approve_and_reject_button_on_transaction_history_table(): void
    {
        $maker = User::factory()->maker()->create();
        $this->actingAs($maker);

        $wallet = $this->post(route('wallet.create'), ['id' => $maker->id]);
        $transaction = $this->post(route('transaction.create', [
            'user_id' => $maker->id,
            'type' => 'deposit',
            'amount' => 1000,
            'description' => 'Test transaction',
        ]));

        $checker = User::factory()->checker()->create();
        $this->actingAs($checker);

        $response = $this->get(route('admin.dashboard'));

        $response->assertSee(['Transaction History', 'approve', 'reject', 'Deposit', 'test transaction', '1,000.00']);
    }

    // public function test_checker_can_approve_or_reject_a_transaction(): void
    // {
    //     $maker = User::factory()->maker()->create();
    //     $this->actingAs($maker);

    //     $wallet = $this->post(route('wallet.create'), ['id' => $maker->id]);
    //     $transaction = Transaction::create([
    //         'user_id' => $maker->id,
    //         'type' => 'deposit',
    //         'amount' => 1000,
    //         'description' => 'Test transaction',
    //     ]);

    //     $checker = User::factory()->checker()->create();
    //     $this->actingAs($maker);

    //     $this->assertDatabaseHas('transactions', [
    //         'id' => $transaction->id,
    //         'user_id' => $maker->id,
    //         'type' => $transaction->type,
    //         'amount' => $transaction->amount,
    //         'description' => $transaction->description,
    //         'status' => 'pending',  
    //     ]);

    //     $transaction->update(['status' => 'approved']);
    //     // $transaction->status =  'approved';
    //     // $transaction->save();

    //     $this->assertDatabaseHas('transactions', [
    //         'id' => $transaction->id,
    //         'user_id' => $maker->id,
    //         'type' => $transaction->type,
    //         'amount' => $transaction->amount,
    //         'description' => $transaction->description,
    //         'status' => 'approved',  
    //     ]);
    // }

    // public function test_checker_with_wallet_can_create_transaction_with_pending_status_and_see_it_in_transaction_history(): void
    // {
    //     $checker = User::factory()->checker()->create();
    //     $this->actingAs($checker);

    //     $wallet = $this->post(route('wallet.create'), ['id' => $checker->id]);
    //     $response = $this->post(route('transaction.create', [
    //         'user_id' => $checker->id,
    //         'type' => 'deposit',
    //         'amount' => 1000,
    //         'description' => 'Test transaction',
    //     ]));

    //     $response->assertSessionHasNoErrors();
    //     $this->assertDatabaseHas('transactions', [
    //         'user_id' => $checker->id,
    //         'type' => 'deposit',
    //         'amount' => 1000,
    //         'description' => 'Test transaction',
    //         'status' => 'pending',
    //     ]);

    //     $history = $this->get('/dashboard');
    //     $history->assertSee(['Transaction History', 'Deposit', 'test transaction', '1,000.00', 'Pending']);
    // }

    // public function test_only_checker_can_create_transaction(): void
    // {
    //     $checker = User::factory()->checker()->create();
    //     $this->actingAs($checker);

    //     $wallet = $this->post(route('wallet.create'), ['id' => $checker->id]);
    //     $response = $this->post(route('transaction.create', [
    //         'user_id' => $checker->id,
    //         'type' => 'deposit',
    //         'amount' => 1000,
    //         'description' => 'Test transaction',
    //     ]));

    //     $this->assertDatabaseMissing('transactions', [
    //         'user_id' => $checker->id,
    //         'type' => 'deposit',
    //         'amount' => 1000,
    //         'description' => 'Test transaction',
    //         'status' => 'pending',
    //     ]);
    // }
}
