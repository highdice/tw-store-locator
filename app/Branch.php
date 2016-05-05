<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branch';
    protected $satellite_table  = 'App\Satellite';
    protected $lookup_table  = 'App\Lookup';

	/**
     * Get the satellites for the branch.
     */
    public function satellites()
    {
    	return $this->hasMany($this->satellite_table);
    }

    /**
     * Get the trade name value from lookup table.
     */
    public function getTradeName()
    {
        return $this->hasOne($this->lookup_table, 'id', 'trade_name');
    }

    /**
     * Get the region value from lookup table.
     */
    public function getRegion()
    {
        return $this->hasOne($this->lookup_table, 'id', 'region');
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

    /**
     * Get branches by region
     */
    public function getByRegion($region_id)
    {
       return Branch::where('region', '=', $region_id)->get();
    }
}
