<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard',['users' => User::paginate(12)]);
    }
}
