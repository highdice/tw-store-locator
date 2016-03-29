<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branch';

	/**
     * Get the satellites for the branch.
     */
    public function satellites()
    {
    	return $this->hasMany('App\Satellite');
    }

    /**
     * Get all branches with pagination.
     */
    public function getPaginatedRecords()
    {
        return Branch::orderBy('id', 'desc')->paginate(10);
    }

    /**
     * Get the satellites for the branch.
     */
    public function getSatellites()
    {
       
    }
}
