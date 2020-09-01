<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'phone_number' ,'email','date_of_birth','salary'
    ];

}
