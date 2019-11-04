<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Favorite;

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
     * get all favorites
     * 
     * @return relationship
     */
    public function favorites() 
    {
        return $this->hasMany(Favorite::class);
    }

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
    public function getImageUrlAttribute($value) 
    {
        return $this->image ? config('filesystems.disks.s3.url') . "/users/$this->image" : null;
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
