<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $showEditModal = false;
    public $editing = [
        'name' => '',
        'email' => '',
        'status' => ''
    ];

    protected $queryString = ['search' => ['except' =>'']];

    public function edit(User $user)
    {
        $this->editing = ['name' => $user->name,
                          'email' => $user->email,
                          'status' => $user->status
                         ];

        $this->showEditModal = true;

    }

    public function save()
    {
        //validate and save the user
    }
    public function getUsersQueryProperty()
    {
        return User::query()
                ->when($this->search, fn($query, $search) => $query->where('name', 'like', '%'.$search.'%')
                                                            ->orWhere('email', 'like', '%'.$search.'%'));
    }

    public function render()
    {
        return view('livewire.dashboard',['users' => $this->usersQuery->paginate(12)]);
    }
}
