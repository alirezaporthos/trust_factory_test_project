<?php

namespace App\Http\Livewire;

use App\Models\Invite;
use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $showEditModal = false;
    public $showInviteModal = false;
    public $showSuccessfullEdit = false;
    public $showArchivedOnly = false;
    public $showActiveOnly = false;
    public $inviteeEmail;
    public $editingStatus;
    public User $editingUser;

    protected $queryString = ['search' => ['except' =>'']];

    public function rules()
    {
        return ['editingUser.name' => 'required',
                'editingUser.email' => 'required|email|unique:users,email,'.$this->editingUser->id,
                'editingStatus' => 'required|in:'.implode(',' ,User::STATUSES)
        ];
    }

    public function mount()
    {
        $this->editingUser = User::make();
    }

    public function updatedEditingUserEmail()
    {
        $this->validate(['editingUser.email' => 'required|email|unique:users,email,'.$this->editingUser->id]);
    }

    public function updatedShowArchivedOnly()
    {
        if($this->showArchivedOnly)
            $this->showActiveOnly = false;
    }
    public function updatedShowActiveOnly()
    {
        if($this->showActiveOnly)
            $this->showArchivedOnly = false;
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

    public function invite()
    {
        $data = $this->validateOnly('inviteeEmail',['inviteeEmail' => 'required|email|unique:invites,email|unique:users,email']);

        if(Invite::create(['email' => $data['inviteeEmail']]))
            session()->flash('invite.message', 'Post successfully updated.');

        $this->reset('showInviteModal', 'inviteeEmail');
        $this->showSuccessfullEdit = true;
    }
    public function getUsersQueryProperty()
    {
        return User::query()
                ->when($this->search, fn($query, $search) => $query->where('name', 'like', '%'.$search.'%')
                                                                ->orWhere('email', 'like', '%'.$search.'%')
                    )->when($this->showArchivedOnly, fn($query) => $query->whereNotNull('archived_at'))
                    ->when($this->showActiveOnly, fn($query) => $query->whereNull('archived_at')
                );
    }

    public function render()
    {
        return view('livewire.dashboard',['users' => $this->usersQuery->paginate(12)]);
    }
}
