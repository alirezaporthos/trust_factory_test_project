<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{


    public $name = '';
    public $email = '';
    public $password = '';
    public $passwordConfirmation = '';
    public $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|same:passwordConfirmation',
        ];

    public function updatedPassword()
    {
        $this->validate(['password'=>'required|min:6']);
    }
    public function updatedEmail()
    {
        $this->validate(['email' => 'required|email|unique:users']);
    }
    public function updatedName()
    {
        $this->validate(['name' => 'required']);
    }


    public function register()
    {
        $data = $this->validate();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        auth()->login($user);

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.guest');
    }
}
