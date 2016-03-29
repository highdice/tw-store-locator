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
}
