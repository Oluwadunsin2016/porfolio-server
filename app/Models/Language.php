<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected $fillable=['user_token','name','url'];

         public function user(){
    return $this->hasOne('App\Models\User');
    }
}
