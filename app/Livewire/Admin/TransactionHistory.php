<?php

namespace App\Livewire\Admin;

use App\Models\Transaction;
use App\Providers\TransactionUpdated;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class TransactionHistory extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $status;

    public $id;

    public $action;

    public function approve($id)
    {
        $this->action = 'approve';
        $this->id = $id;
    }

    public function reject($id)
    {
        $this->action = 'reject';
        $this->id = $id;
    }

    public function resetUserAction()
    {
        $this->reset('action', 'id');
    }

    public function confirmUserAction()
    {
        $transaction = Transaction::find($this->id);
        $this->authorize('update', $transaction);

        if ($this->action === 'approve') {
            $transaction->approve();
            $transaction->save();

            event(new TransactionUpdated('approved', $transaction));
        } else {
            $transaction->reject();
            $transaction->save();

            event(new TransactionUpdated('rejected', $transaction));
        }

        $this->dispatch('close-transaction-modal');
        $this->dispatch('update-total-frontend');
    }

    public function getTransactionHistory()
    {
        return Transaction::with('user')
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
        return view('livewire.admin.transaction-history', ['transactions' => $this->getTransactionHistory()]);
    }
}
