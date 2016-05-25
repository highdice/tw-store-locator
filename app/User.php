<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $lookup_table  = 'App\Lookup';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get all satellites with pagination.
     */
    public function getPaginatedRecords()
    {
        return User::orderBy('id', 'desc')->paginate(10);
    }

    /**
     * Get the user level value from lookup table.
     */
    public function getUserLevel()
    {
        return $this->hasOne($this->lookup_table, 'id', 'user_level');
    }
}
