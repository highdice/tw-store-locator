<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Branch;
use App\Http\Controllers\Controller;
use Response;

class BranchController extends Controller
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

    public function locator()
    {
        return view('branch.locator');
    }

    public function index()
    {
        $result = new Branch();
        $data = $result->getPaginatedRecords();
        return view('branch.index', ['data' => $data]);
    }

    public function add()
    {
        $result = new LookupController();
        $regions = $result->getRegions();
        return view('branch.add', ['regions' => $regions]);
    }

    public function show()
    {
        $result = new Branch();
        return $result->get(array('name', 'address', 'region', 'latitude', 'longitude'));
    }
}
