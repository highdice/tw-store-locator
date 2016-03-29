<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Satellite extends Model
{
    protected $table = 'satellite';

    /**
     * Get all satellites with pagination.
     */
    public function getPaginatedRecords($branch_id)
    {
        return Satellite::where('branch_id', $branch_id)->orderBy('id', 'desc')->paginate(10);
    }
}
