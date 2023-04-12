<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;
    // Name table
    protected $table = 'admin';
    // guarded
    protected $guarded = [];

    protected $guard = 'admin';
}
