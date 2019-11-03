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
        'first_name', 'last_name', 'phone', 'email', 'password', 'image', 
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
     * get mutated phone value 
     * 
     * @return string
     */
    public function getPhoneAttribute($value) 
    {
        return $value? $value : '';
    }

    /**
     * get mutated phone value 
     * 
     * @return string
     */
    public function getImageAttribute($value) 
    {
        return $value? "http://magedmaher-testapi2.s3-eu-west-1.amazonaws.com/users/$value" : '';
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
