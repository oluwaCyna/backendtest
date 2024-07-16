<?php

namespace App\Livewire\User;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class TransactionHistory extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $status;

    public function getTransactionHistory()
    {
        return Transaction::where('user_id', auth()->user()->id)
            ->when($this->status, function ($query) {
                switch ($this->status) {
                    case 'approved':
                        $query->approved();
                        break;
                    case 'pending':
                        $query->pending();
                        break;
                    case 'rejected':
                        $query->rejected();
                        break;
                    default:
                        break;
                }
            })->orderBy('created_at', 'DESC')->paginate(10);
    }

    public function render()
    {
        return view('livewire.user.transaction-history', ['transactions' => $this->getTransactionHistory()]);
    }
}
