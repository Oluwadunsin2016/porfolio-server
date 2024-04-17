<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable=[
    'user_token',
'title',
'category',
'image',
'web_link',
'github_link',
'description',
    ];

     public function user(){
    return $this->hasOne('App\Models\User');
    }
}
