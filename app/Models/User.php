<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false; // karena kita tidak pakai timestamps()

    protected $fillable = ['name', 'email', 'gender', 'user_id'];

}
