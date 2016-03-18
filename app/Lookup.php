<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lookup extends Model
{
    protected $table = 'lookup';

    /**
     * Get all branches with pagination.
     */
    public function getRegions()
    {
        return Lookup::where('key', 'region')->orderBy('title', 'asc')->get(array('id', 'key', 'title', 'description'));
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
