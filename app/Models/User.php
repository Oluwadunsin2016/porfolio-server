<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'profileImage',
        'firstName',
        'lastName',
        'email',
        'phone_number',
        'self_description',
        'cv_URL',
        'address',
        'password',
        'remember_token',
        'email_verified_at',
        'info_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function work_information(){
    return $this->hasMany('App\Models\WorkInformation');
    }
    public function social_information(){
    return $this->hasMany('App\Models\SocialInformation');
    }
    public function projects(){
    return $this->hasMany('App\Models\Project');
    }
    public function languages(){
    return $this->hasMany('App\Models\Language');
    }
    public function expertise(){
    return $this->hasMany('App\Models\ExpertiseInformation');
    }
}
