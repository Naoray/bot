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
        'messenger_id',
        'username',
        'first_name',
        'last_name',
        'street',
        'zip',
        'city',
        'name',
        'email',
        'password',
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
     * Get user by messenger id.
     * 
     * @param  [type] $query       [description]
     * @param  [type] $messengerId [description]
     * @return [type]              [description]
     */
    public function scopeMessenger($query, $messengerId)
    {
        return $query->whereMessengerId($messengerId);
    }

    /**
     * Anticipate user account by name & username.
     * 
     * @param  [type] $query   [description]
     * @param  [type] $botUser [description]
     * @return [type]          [description]
     */
    public function scopeAnticipateUser($query, $botUser)
    {
        return $query->orWhere([
                    ['first_name', $botUser->getFirstName()],
                    ['last_name', $botUser->getLastName()],
                    ['username', $botUser->getUsername()]
                ]);
    }
}
