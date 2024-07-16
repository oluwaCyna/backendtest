<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Admin\UserList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UserListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        Livewire::test(UserList::class)
            ->assertStatus(200);
    }
}
