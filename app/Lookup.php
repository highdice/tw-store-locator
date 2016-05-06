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

    /**
     * Get all trade names
     */
    public function getTradeNames()
    {
        return Lookup::where('key', 'trade_name')->orderBy('title', 'asc')->get(array('id', 'title', 'description'));
    }

    public function getSex()
    {
        return Lookup::where('key', 'sex')->get(array('id', 'key', 'title', 'description'));
    }

    /**
     * Get all island groups
     */
    public function getIslandGroups()
    {
        return Lookup::where('key', 'island_group')->orderBy('id', 'asc')->get(array('id', 'title', 'description'));
    }

    /**
     * Get an island group by id
     */
    public function getIslandGroup($id)
    {
        return Lookup::where('id', $id)->orderBy('title', 'asc')->get(array('id', 'title', 'description'));
    }
}
