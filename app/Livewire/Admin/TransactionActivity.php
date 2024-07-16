<?php

namespace App\Livewire\Admin;

use App\Models\TransactionActivity as ModelsTransactionActivity;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class TransactionActivity extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[On('update-total-frontend')]
    public function getTransactionActivity()
    {
        return ModelsTransactionActivity::orderBy('created_at', 'DESC')->paginate(5);
    }
    public function render()
    {
        return view('livewire.admin.transaction-activity', ['transactionActivity' => $this->getTransactionActivity()]);
    }
}
