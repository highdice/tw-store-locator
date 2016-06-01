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
     * Get all branches with pagination.
     * @return json
     */
    public function getPaginatedRecords()
    {
        return Branch::orderBy('id', 'desc')->paginate(10);
    }

    /**
     * Get all branches with pagination on search.
     * @param string $where
     * @return json
     */
    public function getPaginatedRecordsBySearch($where = null)
    {
        return Branch::whereRaw($where)->orderBy('id', 'desc')->paginate(10);
    }

    /**
     * Get all stores
     * @param string $branch_where, string $satellite_where
     * @return json
     */
    public function getStores($branch_where, $satellite_where)
    {
       $satellite = new $this->satellite_table();

       $branch_result = Branch::select('code', 'branch_code as store_code', 'trade_name_prefix', 'trade_name', 'name', 'address', 'region', 'island_group', 'latitude', 'longitude', 'date_opened', 'contact_number', 'image', \DB::raw('"branch" as category'))
                                ->whereRaw($branch_where);

        return $satellite->leftJoin('Branch', 'Satellite.branch_id', '=', 'Branch.id')
                        ->whereRaw($satellite_where)
                        ->union($branch_result)
                        ->get(array('Branch.code', 'Satellite.satellite_code as store_code', 'Satellite.trade_name_prefix', 'Satellite.trade_name', 'Satellite.name', 'Satellite.address', 'Satellite.region', 'Satellite.island_group', 'Satellite.latitude', 'Satellite.longitude', 'Satellite.date_opened', 'Satellite.contact_number', 'Satellite.image', \DB::raw('"satellite" as category')));
    }

    /**
     * Get stores by region
     * @param integer $region_id
     * @return json
     */
    public function getStoresByRegion($region_id)
    {
       $satellite = new $this->satellite_table();

       $branch_result = Branch::select('code', 'branch_code as store_code', 'trade_name_prefix', 'trade_name', 'name', 'address', 'region', 'island_group', 'latitude', 'longitude', 'date_opened', 'contact_number', 'division', 'area', 'image', \DB::raw('1 as category'))
                                ->where('region', '=', $region_id);

       return $satellite->leftJoin('Branch', 'Satellite.branch_id', '=', 'Branch.id')
                        ->where('Satellite.region', '=', $region_id)
                        ->union($branch_result)
                        ->get(array('Branch.code', 'Satellite.satellite_code as store_code', 'Satellite.trade_name_prefix', 'Satellite.trade_name', 'Satellite.name', 'Satellite.address', 'Satellite.region', 'Satellite.island_group', 'Satellite.latitude', 'Satellite.longitude', 'Satellite.date_opened', 'Satellite.contact_number', 'Satellite.division', 'Satellite.area', 'Satellite.image', \DB::raw('2 as category')));
    }

    /**
     * Get stores by island group
     * @param integer $island_group_id
     * @return json
     */
    public function getStoresByIslandgroup($island_group_id)
    {
       $satellite = new $this->satellite_table();

       $branch_result = Branch::select('code', 'branch_code as store_code', 'trade_name_prefix', 'trade_name', 'name', 'address', 'region', 'island_group', 'latitude', 'longitude', 'date_opened', 'contact_number', 'division', 'area', 'image', \DB::raw('1 as category'))
                                ->where('island_group', '=', $island_group_id);

       return $satellite->leftJoin('Branch', 'Satellite.branch_id', '=', 'Branch.id')
                        ->where('Satellite.island_group', '=', $island_group_id)
                        ->union($branch_result)
                        ->get(array('Branch.code', 'Satellite.satellite_code as store_code', 'Satellite.trade_name_prefix', 'Satellite.trade_name', 'Satellite.name', 'Satellite.address', 'Satellite.region', 'Satellite.island_group', 'Satellite.latitude', 'Satellite.longitude', 'Satellite.date_opened', 'Satellite.contact_number', 'Satellite.division', 'Satellite.area', 'Satellite.image', \DB::raw('2 as category')));
    }

    /**
     * Get stores by division
     * @param integer $division_id
     * @return json
     */
    public function getStoresByDivision($division_id)
    {
       $satellite = new $this->satellite_table();

       $branch_result = Branch::select('code', 'branch_code as store_code', 'trade_name_prefix', 'trade_name', 'name', 'address', 'region', 'island_group', 'latitude', 'longitude', 'date_opened', 'contact_number', 'division', 'area', 'image', \DB::raw('1 as category'))
                                ->where('division', '=', $division_id);

       return $satellite->leftJoin('Branch', 'Satellite.branch_id', '=', 'Branch.id')
                        ->where('Satellite.division', '=', $division_id)
                        ->union($branch_result)
                        ->get(array('Branch.code', 'Satellite.satellite_code as store_code', 'Satellite.trade_name_prefix', 'Satellite.trade_name', 'Satellite.name', 'Satellite.address', 'Satellite.region', 'Satellite.island_group', 'Satellite.latitude', 'Satellite.longitude', 'Satellite.date_opened', 'Satellite.contact_number', 'Satellite.division', 'Satellite.area', 'Satellite.image', \DB::raw('2 as category')));
    }

    /**
     * Get stores by area
     * @param integer $area_id
     * @return json
     */
    public function getStoresByArea($area_id)
    {
       $satellite = new $this->satellite_table();

       $branch_result = Branch::select('code', 'branch_code as store_code', 'trade_name_prefix', 'trade_name', 'name', 'address', 'region', 'island_group', 'latitude', 'longitude', 'date_opened', 'contact_number', 'division', 'area', 'image', \DB::raw('1 as category'))
                                ->where('area', '=', $area_id);

       return $satellite->leftJoin('Branch', 'Satellite.branch_id', '=', 'Branch.id')
                        ->where('Satellite.area', '=', $area_id)
                        ->union($branch_result)
                        ->get(array('Branch.code', 'Satellite.satellite_code as store_code', 'Satellite.trade_name_prefix', 'Satellite.trade_name', 'Satellite.name', 'Satellite.address', 'Satellite.region', 'Satellite.island_group', 'Satellite.latitude', 'Satellite.longitude', 'Satellite.date_opened', 'Satellite.contact_number', 'Satellite.division', 'Satellite.area', 'Satellite.image', \DB::raw('2 as category')));
    }

    /**
     * Get all branches
     * @param string $where
     * @return json
     */
    public function getBranches($where)
    {
       return Branch::whereRaw($where)->get(array('code', 'branch_code as store_code', 'trade_name_prefix', 'trade_name', 'name', 'address', 'region', 'island_group', 'latitude', 'longitude', 'date_opened', 'contact_number', 'image', \DB::raw('"branch" as category')));
    }

    /**
     * Get all stores
     * @param integer $branch_id
     * @return json
     */
    public function getBranch($branch_id)
    {
       return Branch::where('id', '=', $branch_id)->get();
    }

    /**
     * Export all branches
     */
    public function exportBranches()
    {
       return Branch::with(array('lookup'=>function($query){
            $query->select('region','trade_name', 'island_group', 'division', 'area');
        }))->get();
    }

    /**
     * Get branches by date opened
     */
    public function getBranchByDateOpened()
    {
       return Branch::groupBy('date_opened')
                        ->orderBy('date_opened', 'asc')
                        ->get(array(\DB::raw('COUNT(*) as count'), \DB::raw('UNIX_TIMESTAMP(DATE_ADD(date_opened, INTERVAL 1 DAY)) as date_opened')));
    }

    /**
     * Get all satellites
     * @param string $where
     * @return json
     */
    public function getSatellites($where)
    {
       $satellite = new $this->satellite_table();

       return $satellite->leftJoin('Branch', 'Satellite.branch_id', '=', 'Branch.id')
                        ->whereRaw($where)
                        ->get(array('Branch.code', 'Satellite.satellite_code as store_code', 'Satellite.trade_name_prefix', 'Satellite.trade_name', 'Satellite.name', 'Satellite.address', 'Satellite.region', 'Satellite.island_group', 'Satellite.latitude', 'Satellite.longitude', 'Satellite.date_opened', 'Satellite.contact_number', 'Satellite.image', \DB::raw('"satellite" as category')));
    }

    /**
     * Get the trade name value from lookup table.
     */
    public function getTradeName()
    {
        return $this->hasOne($this->lookup_table, 'id', 'trade_name');
    }

    /**
     * Get the island group value from lookup table.
     */
    public function getIslandGroup()
    {
        return $this->hasOne($this->lookup_table, 'id', 'island_group');
    }

    /**
     * Get the region value from lookup table.
     */
    public function getRegion()
    {
        return $this->hasOne($this->lookup_table, 'id', 'region');
    }

    /**
     * Get the division value from lookup table.
     */
    public function getDivision()
    {
        return $this->hasOne($this->lookup_table, 'id', 'division');
    }

    /**
     * Get the area value from lookup table.
     */
    public function getArea()
    {
        return $this->hasOne($this->lookup_table, 'id', 'area');
    }

}
