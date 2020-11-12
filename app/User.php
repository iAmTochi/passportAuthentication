<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';

    const ADMIN_USER = 'true';
    const REGULAR_USER = 'false';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Mutator to set a name
     *
     * @param $name
     */
    public function setNameAttribute($name){
        $this->attributes['name'] = strtolower($name);
    }

    /**
     * Accessor to get a name
     *
     * @param $name
     * @return string
     */
    public function getNameAttribute($name){
        return ucwords($name);
    }

    /**
     * Mutator to set a email
     *
     * @param $email
     */
    public function setEmailAttribute($email){
        $this->attributes['email'] = strtolower($email);
    }

    /**
     * Accessor to get a email
     *
     * @param $email
     * @return string
     */
    public function getEmailAttribute($email){
        return strtolower($email);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
