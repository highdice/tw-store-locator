<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lookup extends Model
{
    protected $table = 'lookup';

    /**
     * Get all regions
     */
    public function getRegions()
    {
        return Lookup::where('key', 'region')->orderBy('title', 'asc')->get(array('id', 'title', 'description'));
    }

    /**
     * Get a region by id
     */
    public function getRegion($id)
    {
        return Lookup::where('id', $id)->orderBy('title', 'asc')->first(array('id', 'title', 'description'));
    }

    public function getSex()
    {
        return Lookup::where('key', 'sex')->get(array('id', 'key', 'title', 'description'));
    }

    public function getIslandGroup()
    {
        return Lookup::where('key', 'island_group')->get(array('id', 'key', 'title', 'description'));
    }
}
