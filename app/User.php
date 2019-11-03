<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'first_name', 'last_name', 'phone', 'email', 'password',
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
     * get full name 
     * 
     * @return string
     */
    public function getNameAttribute() 
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * check if user is admin
     * 
     * @return boolean
     */
    public function isAdmin() 
    {
        return $this->admin;
    }
}
