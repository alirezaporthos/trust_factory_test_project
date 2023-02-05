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
    public $editingStatus;
    public User $editingUser;

    protected $queryString = ['search' => ['except' =>'']];

    public function rules()
    {
        return ['editingUser.name' => 'required',
                'editingUser.email' => 'required|unique:users,email_address,'.$this->editingUser->id,
                'editingStatus' => 'required|in:'.implode(',' ,User::STATUSES)
        ];
    }
    public function mount()
    {
        $this->editingUser = User::make();
    }

    public function edit(User $user)
    {

        if ($this->editingUser->isNot($user)) $this->editingUser = $user;

        $this->editingStatus = $user->archived_at ? 'archived' : 'active';
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        if($this->editingUser->archived_at && $this->editingStatus === 'active' )
            $this->editingUser->archived_at = null ;
        elseif(is_null($this->editingUser->archived_at) && $this->editingStatus === 'archived' )
            $this->editingUser->archived_at = now() ;

        $this->editingUser->save();
        $this->showEditModal = false;

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
