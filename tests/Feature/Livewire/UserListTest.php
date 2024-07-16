<?php

namespace Tests\Feature\Livewire;

use App\Livewire\UserList;
use Livewire\Livewire;
use Tests\TestCase;

class UserListTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(UserList::class)
            ->assertStatus(200);
    }
}
