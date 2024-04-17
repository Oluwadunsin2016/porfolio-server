<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkInformation extends Model
{
    use HasFactory;
    protected $fillable=['user_token','profession','professional'];

         public function user(){
    return $this->hasOne('App\Models\User');
    }
}
