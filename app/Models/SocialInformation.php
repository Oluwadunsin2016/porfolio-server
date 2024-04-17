<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialInformation extends Model
{
    use HasFactory;
    protected $fillable=[
    'user_token',
    'whatsapp',
    'facebook',
    'instagram',
    'twitter',
    'linkedin',
    'telegram',
    ];

         public function user(){
    return $this->hasOne('App\Models\User');
    }
}
