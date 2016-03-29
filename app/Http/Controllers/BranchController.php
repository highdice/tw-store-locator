<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;

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
     * Get a validator for an incoming post request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'code' => 'required|max:250|unique:branch',
            'branch_code' => 'required|max:250|unique:branch',
            'trade_name' => 'required||max:250',
            'name' => 'required|max:250',
            'size' => 'required',
            'date_opened' => 'required|date',
            'address' => 'required',
            'zip_code' => 'integer',
            'region' => 'required',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'division' => 'required|integer|between:1,4',
            'island_group' => 'required'
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Handles view for the locator menu item.
     *
     * @param  none
     * @return Branch
     */    
    public function locator()
    {
        return view('branch.locator');
    }

    /**
     * Handles view for the stores menu item.
     *
     * @param  none
     * @return Branch
     */
    public function index()
    {
        $result = new Branch();
        $data = $result->getPaginatedRecords();
        
        return view('branch.index', ['data' => $data]);
    }

    /**
     * Handles view for adding a branch.
     *
     * @param  none
     * @return Branch
     */
    public function add()
    {
        $result = new LookupController();
        $regions = $result->getRegions();
        return view('branch.add', ['regions' => $regions]);
    }

    /**
     * Handles view for editing a branch.
     *
     * @param  none
     * @return Branch
     */
    public function edit($id)
    {
        $result = new Branch();
        $data = $result->where('id', $id)->first();
        $data->date_opened = date('m/d/Y', strtotime($data->date_opened));

        $result = new LookupController();
        $regions = $result->getRegions();

        $result = new LookupController();
        $region = $result->getRegion($data->region);

        return view('branch.edit', ['regions' => $regions, 'region' => $region, 'data' => $data]);
    }

    /**
     * Lists all active branches.
     *
     * @param  array $data
     * @return Branch
     */
    public function show(Request $data)
    {
        if(empty($data)) {
            $result = new Branch();
            return $result->where('status', '1')->get(array('name', 'address', 'region', 'island_group', 'latitude', 'longitude'));
        }
        else {
            return 1;
        }
    }

    /**
     * Add a new branch.
     *
     * @param  array $data
     * @return Branch
     */
    protected function postAdd(Request $data)
    {
        $validator = $this->validator($data->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $data, $validator
            );
        }

        $branch = new Branch;
        $branch->code = $data['code'];
        $branch->branch_code = $data['branch_code'];
        $branch->trade_name = $data['trade_name'];
        $branch->name = $data['name'];
        $branch->size = $data['size'];
        $branch->date_opened = date('Y-m-d h:i:s', strtotime($data['date_opened']));
        $branch->address = $data['address'];
        $branch->zip_code = $data['zip_code'];
        $branch->region = $data['region'];
        $branch->longitude = $data['longitude'];
        $branch->latitude = $data['latitude'];
        $branch->division = $data['division'];
        $branch->island_group = $data['island_group'];
        $branch->status = 1;
        $branch->save();

        return redirect('stores');
    }

    /**
     * Edit an existing branch.
     *
     * @param  array $data
     * @return Branch
     */
    protected function postEdit(Request $data)
    {
        $validator = $this->validator($data->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $data, $validator
            );
        }

        $branch = new Branch;
        $branch->code = $data['code'];
        $branch->branch_code = $data['branch_code'];
        $branch->trade_name = $data['trade_name'];
        $branch->name = $data['name'];
        $branch->size = $data['size'];
        $branch->date_opened = date('Y-m-d h:i:s', strtotime($data['date_opened']));
        $branch->address = $data['address'];
        $branch->zip_code = $data['zip_code'];
        $branch->region = $data['region'];
        $branch->longitude = $data['longitude'];
        $branch->latitude = $data['latitude'];
        $branch->division = $data['division'];
        $branch->island_group = $data['island_group'];
        $branch->where('id', $data['id']);
        $branch->update();

        return redirect('stores');
    }

    /**
     * Get branch count per island group.
     *
     * @param  none
     * @return Branch
     */
    public function getIslandGroupsCount()
    {
        $data = array();

        $luzon = new Branch();
        array_push($data, $luzon->where('island_group', 1)->count());

        $visayas = new Branch();
        array_push($data, $visayas->where('island_group', 2)->count());

        $mindanao = new Branch();
        array_push($data, $mindanao->where('island_group', 3)->count());

        return json_encode($data);
    }
}
