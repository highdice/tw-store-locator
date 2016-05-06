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
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming post request.
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $id = null)
    {
        return Validator::make($data, [
            'code' => 'required|max:250|unique:branch,code,'.$id,
            'branch_code' => 'required|max:250|unique:branch,branch_code,'.$id,
            'trade_name_prefix' => 'required|max:100',
            'trade_name' => 'required|integer',
            'name' => 'required|max:250',
            'size' => 'required',
            'date_opened' => 'required|date',
            'address' => 'required',
            'zip_code' => 'integer',
            'region' => 'required',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'area' => 'required|max:250',
            'division' => 'required|integer|between:1,4',
            'island_group' => 'required',
            'image_path' => 'mimes:png,jpeg,jpg'
        ]);
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */

    /**
     * Handles view for the locator menu item.
     * @return view
     */    
    public function locator()
    {
        return view('branch.locator');
    }

    /**
     * Handles view for the stores menu item.
     * @return view
     */
    public function index()
    {
        $result = new Branch();
        $data = $result->getPaginatedRecords();

        return view('branch.index', ['data' => $data]);
    }

    /**
     * Handles view for adding a branch.
     * @return view
     */
    public function add()
    {
        $result = new LookupController();
        $regions = $result->getRegions();
        $trade_names = $result->getTradeNames();
        return view('branch.add', ['regions' => $regions, 'trade_names' => $trade_names]);
    }

    /**
     * Handles view for editing a branch.
     * @param  integer $id
     * @return view
     */
    public function edit($id)
    {
        $result = new Branch();
        $data = $result->where('id', $id)->first();
        $data->date_opened = date('m/d/Y', strtotime($data->date_opened));

        $result = new LookupController();
        $regions = $result->getRegions();
        $trade_names = $result->getTradeNames();     

        return view('branch.edit', ['regions' => $regions, 'trade_names' => $trade_names, 'data' => $data]);
    }

    /**
     * Lists all active branches.
     * @param  array $data
     * @return array
     */
    public function show(Request $data)
    {
        $where = array();
        $search_where = array();

        $result = new Branch();

        //check if search data is set
        if(isset($data['search'])) {
            array_push($search_where, "code LIKE '%" . $data['search'] . "%'");
            array_push($search_where, "branch_code LIKE '%" . $data['search'] . "%'");
            array_push($search_where, "name LIKE '%" . $data['search'] . "%'");
            array_push($search_where, "trade_name_prefix LIKE '%" . $data['search'] . "%'");
            array_push($search_where, "trade_name LIKE '%" . $data['search'] . "%'");
            array_push($search_where, "address LIKE '%" . $data['search'] . "%'");

            $search_where = implode(" OR ", $search_where);
            array_push($where, $search_where);
        }
        
        array_push($where, "status = 1");
        $where = implode(" AND ", $where);

        return $result->whereRaw($where)->get(array('code', 'branch_code', 'trade_name_prefix', 'trade_name', 'name', 'address', 'region', 'island_group', 'latitude', 'longitude'));
    }

    /**
     * Handles index searching capability.
     * @return view
     */
    public function search($criteria)
    {
        $result = new Branch();
        $data = $result->getPaginatedRecords();

        return view('branch.index', ['data' => $data]);
    }

    /**
     * Add a new branch.
     * @param  array $data
     * @return redirect
     * @throws exception
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
        $branch->trade_name_prefix = strtoupper($data['trade_name_prefix']);
        $branch->trade_name = $data['trade_name'];
        $branch->name = $data['name'];
        $branch->size = $data['size'];
        $branch->date_opened = date('Y-m-d h:i:s', strtotime($data['date_opened']));
        $branch->contact_number = $data['contact_number'];
        $branch->address = $data['address'];
        $branch->zip_code = $data['zip_code'];
        $branch->region = $data['region'];
        $branch->longitude = $data['longitude'];
        $branch->latitude = $data['latitude'];
        $branch->area = $data['area'];
        $branch->division = $data['division'];
        $branch->island_group = $data['island_group'];
        $branch->status = 1;

        //image upload
        if(isset($data['image'])) {
            //set up image
            $filename = 'b_' . strtotime(date('Y-m-d h:i:s')) . '.' . $data['image']->getClientOriginalExtension();
            $move = $data['image']->move(
                base_path() . '/public/images/', $filename
            );

            $branch->image = $filename;
        }

        $branch->save();

        return redirect('stores');
    }

    /**
     * Edit an existing branch.
     * @param  array $data
     * @return redirect
     * @throws exception
     */
    protected function postEdit(Request $data)
    {
        $validator = $this->validator($data->all(), $data['id']);

        if ($validator->fails()) {
            $this->throwValidationException(
                $data, $validator
            );
        }

        $branch = Branch::find($data['id']);
        $branch->code = $data['code'];
        $branch->branch_code = $data['branch_code'];
        $branch->trade_name_prefix = strtoupper($data['trade_name_prefix']);
        $branch->trade_name = $data['trade_name'];
        $branch->name = $data['name'];
        $branch->size = $data['size'];
        $branch->date_opened = date('Y-m-d h:i:s', strtotime($data['date_opened']));
        $branch->contact_number = $data['contact_number'];
        $branch->address = $data['address'];
        $branch->zip_code = $data['zip_code'];
        $branch->region = $data['region'];
        $branch->longitude = $data['longitude'];
        $branch->latitude = $data['latitude'];
        $branch->area = $data['area'];
        $branch->division = $data['division'];
        $branch->island_group = $data['island_group'];
        
        //image upload
        if(isset($data['image'])) {
            //delete old image
            $old_filename = Branch::where('id', $data['id'])->first(['image']);
            $old_filename_path = base_path() . '/public/images/' . $old_filename->image;
            unlink($old_filename_path);

            //set up new image
            $filename = 'b_' . strtotime(date('Y-m-d h:i:s')) . '.' . $data['image']->getClientOriginalExtension();
            $move = $data['image']->move(
                base_path() . '/public/images/', $filename
            );

            $branch->image = $filename;
        }

        $branch->save();

        return redirect('stores');
    }

    /**
     * Get branch by region.
     * @return string $region_id
     */
    public function getStoreByRegion($region_id)
    {
        $data = array();

        $branch = new Branch();
        return $branch->getByRegion($region_id);
    }

    /**
     * Get branch by region.
     * @return string $region_id
     */
    public function getStoreByIslandGroup($island_group_id)
    {
        $data = array();

        $branch = new Branch();
        return $branch->getByIslandGroup($island_group_id);
    }
}
