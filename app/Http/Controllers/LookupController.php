<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Lookup;
use App\Http\Controllers\Controller;
use Response;

class LookupController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function getRegions()
    {
        $result = new Lookup();
        return $result->getRegions();
    }

    public function getRegion($id)
    {
        $result = new Lookup();
        return $result->getRegion($id);
    }

    public function getIslandGroups()
    {
        $result = new Lookup();
        return $result->getIslandGroups();
    }

    public function getIslandGroup($id)
    {
        $result = new Lookup();
        return $result->getIslandGroup($id);
    }

    public function getTradeNames()
    {
        $result = new Lookup();
        return $result->getTradeNames();
    }

    public function getDivisions()
    {
        $result = new Lookup();
        return $result->getDivisions();
    }
}
