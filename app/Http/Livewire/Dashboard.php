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

    public function edit()
    {
        $this->showEditModal = true;
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
