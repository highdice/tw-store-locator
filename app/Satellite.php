<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Satellite extends Model
{
    protected $table = 'satellite';
    protected $lookup_table  = 'App\Lookup';

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
     * Get all satellites with pagination.
     */
    public function getPaginatedRecords($branch_id)
    {
        return Satellite::where('branch_id', $branch_id)->orderBy('id', 'desc')->paginate(10);
    }

    /**
     * Get satellites by region
     */
    public function getByRegion($region_id)
    {
       return Satellite::where('region', '=', $region_id)->get();
    }

    /**
     * Get satellites by island group
     */
    public function getByIslandgroup($island_group_id)
    {
       return Satellite::where('island_group', '=', $island_group_id)->get();
    }

    /**
     * Get satellites by date opened
     * @return json
     */
    public function getSatelliteByDateOpened()
    {
       return Satellite::groupBy('date_opened')
                        ->orderBy('date_opened', 'asc')
                        ->get(array(\DB::raw('COUNT(*) as count'), \DB::raw('UNIX_TIMESTAMP(DATE_ADD(date_opened, INTERVAL 1 DAY)) as date_opened')));
    }
}
