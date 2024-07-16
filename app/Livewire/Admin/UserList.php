<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Notifications\MakerToCheckerUpdated;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id;

    public function approve($id)
    {
        $this->id = $id;
    }

    public function resetUserAction()
    {
        $this->reset('id');
    }

    public function confirmUserAction()
    {
        $user = User::find($this->id);
        $user->setUserAsChecker();
        $user->save();

        $user->notify(new MakerToCheckerUpdated());

        $this->dispatch('close-user-modal');
    }

    public function getUsers()
    {
        return User::whereNot('role', 'admin')->orderBy('created_at', 'DESC')->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.user-list', ['users' => $this->getUsers()]);
    }
}
