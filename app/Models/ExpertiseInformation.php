<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertiseInformation extends Model
{
    use HasFactory;
    protected $fillable=['user_token','year_of_experience','number_of_clients','number_of_projects'];
    
       public function user(){
    return $this->hasOne('App\Models\User');
    }
}
