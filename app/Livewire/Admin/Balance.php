<?php

namespace App\Livewire\Admin;

use App\Models\Wallet;
use Livewire\Attributes\On;
use Livewire\Component;

class Balance extends Component
{
    #[On('update-total-frontend')]
    public function getTotalBalance()
    {
        return Wallet::find(1)->formatted_balance;
    }

    public function render()
    {
        return view('livewire.admin.balance', ['total_balance' => $this->getTotalBalance()]);
    }
}
