<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'first_name', 'last_name', 'street', 'zip', 'city', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * [scopeMessenger description]
     * @param  [type] $query   [description]
     * @param  [type] $botUser [description]
     * @return [type]          [description]
     */
    public function scopeMessenger($query, $botUser)
    {
        return $query->whereMessengerId($botUser->getId())
                ->orWhere('first_name', $botUser->getFirstName())
                ->orWhere('last_name', $botUser->getLastName())
                ->orWhere('username', $botUser->getUsername());
    }
}
