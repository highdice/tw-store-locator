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
        return \DB::select(\DB::raw("SELECT lookup.*, 
                                            IFNULL(b_count, 0) + IFNULL(s_count, 0) as store_count 
                                    FROM lookup 
                                    LEFT JOIN (SELECT region, 
                                                      COUNT(*) as b_count 
                                              FROM branch 
                                              GROUP BY region) b 
                                    ON lookup.id = b.region 
                                    LEFT JOIN (SELECT region, 
                                                      COUNT(*) as s_count 
                                              FROM satellite
                                              GROUP BY region) s
                                    ON lookup.id = s.region 
                                    WHERE lookup.key = 'region'
                                    GROUP BY lookup.id")
                          );
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

    /**
     * Get sex
     */
    public function getSex()
    {
        return Lookup::where('key', 'sex')->get(array('id', 'key', 'title', 'description'));
    }

    /**
     * Get all island groups
     */
    public function getIslandGroups()
    {
        return \DB::select(\DB::raw("SELECT lookup.*, 
                                            IFNULL(b_count, 0) + IFNULL(s_count, 0) as store_count 
                                    FROM lookup 
                                    LEFT JOIN (SELECT island_group, 
                                                      COUNT(*) as b_count 
                                              FROM branch 
                                              GROUP BY island_group) b 
                                    ON lookup.id = b.island_group 
                                    LEFT JOIN (SELECT island_group, 
                                                      COUNT(*) as s_count 
                                              FROM satellite
                                              GROUP BY island_group) s
                                    ON lookup.id = s.island_group 
                                    WHERE lookup.key = 'island_group'
                                    GROUP BY lookup.id")
                          );
    }

    /**
     * Get an island group by id
     */
    public function getIslandGroup($id)
    {
        return Lookup::where('id', $id)->orderBy('title', 'asc')->get(array('id', 'title', 'description'));
    }

    /**
     * Get all divisions
     */
    public function getDivisions()
    {
        return \DB::select(\DB::raw("SELECT lookup.*, 
                                            IFNULL(b_count, 0) + IFNULL(s_count, 0) as store_count 
                                    FROM lookup 
                                    LEFT JOIN (SELECT division, 
                                                      COUNT(*) as b_count 
                                              FROM branch 
                                              GROUP BY division) b 
                                    ON lookup.description = b.division 
                                    LEFT JOIN (SELECT division, 
                                                      COUNT(*) as s_count 
                                              FROM satellite
                                              GROUP BY division) s
                                    ON lookup.description = s.division 
                                    WHERE lookup.key = 'division'
                                    GROUP BY lookup.id")
                          );
    }

    /**
     * Get user levels
     */
    public function getUserLevels()
    {
        return Lookup::where('key', 'user_level')->orderBy('id', 'asc')->get(array('id', 'title', 'description'));
    }
}
