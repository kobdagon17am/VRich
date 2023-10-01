<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Customers extends Model
{
    // Name table
    use Notifiable;

    protected $guard = 'customer';

    protected $guarded = [];
    protected $table = 'customers';
    // guarded

}
