<?php

namespace App\Observers;

use App\Models\Invite;
use App\Models\User;
use Illuminate\Support\Str;

class InviteObserver
{
    public function creating(Invite $invite)
    {
        $invite->token = $this->generateToken();
    }

    protected function generateToken()
    {
        $token = Str::random(16);
        if(User::where('token', $token)->first()) {
            return $this->generateToken();
        }
        return $token;
    }
}
