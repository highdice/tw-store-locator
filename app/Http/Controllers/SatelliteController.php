<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;

use App\Satellite;
use App\Http\Controllers\Controller;
use Response;

class SatelliteController extends Controller
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
            'satellite_code' => 'required|max:250|unique:satellite,satellite_code,'.$id,
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
        return view('satellite.locator');
    }

    /**
     * Handles view for the stores menu item.
     * @return view
     */
    public function index($branch_id)
    {
        $result = new Satellite();
        $data = $result->getPaginatedRecords($branch_id);

        return view('satellite.index', ['data' => $data, 'branch_id' => $branch_id]);
    }

    /**
     * Handles view for adding a satellite.
     * @return view
     */
    public function add($branch_id)
    {
        $result = new LookupController();
        $regions = $result->getRegions();
        $trade_names = $result->getTradeNames();
        return view('satellite.add', ['regions' => $regions, 'trade_names' => $trade_names, 'branch_id' => $branch_id]);
    }

    /**
     * Handles view for editing a satellite.
     * @param  integer $branch_id, integer $id
     * @return view
     */
    public function edit($branch_id, $id)
    {
        $result = new Satellite();
        $data = $result->where('id', $id)->first();
        $data->date_opened = date('m/d/Y', strtotime($data->date_opened));

        $result = new LookupController();
        $regions = $result->getRegions();
        $region = $result->getRegion($data->region);
        $trade_names = $result->getTradeNames();

        return view('satellite.edit', ['regions' => $regions, 'trade_names' => $trade_names, 'region' => $region, 'data' => $data]);
    }

    /**
     * Lists all active satellitees.
     * @param  array $data
     * @return array
     */
    public function show(Request $data)
    {
        $where = array();
        $search_where = array();

        $result = new Satellite();

        //check if search data is set
        if(isset($data['search'])) {
            array_push($search_where, "Branch.code LIKE '%" . $data['search'] . "%'");
            array_push($search_where, "Satellite.satellite_code LIKE '%" . $data['search'] . "%'");
            array_push($search_where, "Satellite.name LIKE '%" . $data['search'] . "%'");
            array_push($search_where, "Satellite.trade_name_prefix LIKE '%" . $data['search'] . "%'");
            array_push($search_where, "Satellite.trade_name LIKE '%" . $data['search'] . "%'");
            array_push($search_where, "Satellite.address LIKE '%" . $data['search'] . "%'");

            $search_where = implode(" OR ", $search_where);
            array_push($where, $search_where);
        }
        
        array_push($where, "Satellite.status = 1");
        $where = implode(" AND ", $where);

        return $result->leftJoin('Branch', 'Satellite.branch_id', '=', 'Branch.id')
                      ->whereRaw($where)->get(array('Branch.code', 'Satellite.satellite_code', 'Satellite.trade_name_prefix', 'Satellite.trade_name', 'Satellite.name', 'Satellite.address', 'Satellite.region', 'Satellite.island_group', 'Satellite.latitude', 'Satellite.longitude'));
    }

    /**
     * Handles index searching capability.
     * @return view
     */
    public function search($criteria)
    {
        $result = new Satellite();
        $data = $result->getPaginatedRecords();

        return view('satellite.index', ['data' => $data]);
    }

    /**
     * Add a new satellite.
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

        $satellite = new satellite;
        $satellite->branch_id = $data['branch_id'];
        $satellite->satellite_code = $data['satellite_code'];
        $satellite->trade_name_prefix = strtoupper($data['trade_name_prefix']);
        $satellite->trade_name = $data['trade_name'];
        $satellite->name = $data['name'];
        $satellite->size = $data['size'];
        $satellite->date_opened = date('Y-m-d h:i:s', strtotime($data['date_opened']));
        $satellite->contact_number = $data['contact_number'];
        $satellite->address = $data['address'];
        $satellite->zip_code = $data['zip_code'];
        $satellite->region = $data['region'];
        $satellite->longitude = $data['longitude'];
        $satellite->latitude = $data['latitude'];
        $satellite->area = $data['area'];
        $satellite->division = $data['division'];
        $satellite->island_group = $data['island_group'];
        $satellite->status = 1;

        //image upload
        if(isset($data['image'])) {
            //set up image
            $filename = 's_' . strtotime(date('Y-m-d h:i:s')) . '.' . $data['image']->getClientOriginalExtension();
            $move = $data['image']->move(
                base_path() . '/public/images/', $filename
            );

            $satellite->image = $filename;
        }

        $satellite->save();

        return redirect('stores/' . $data['branch_id'] . '/satellite');
    }

    /**
     * Edit an existing satellite.
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

        $satellite = Satellite::find($data['id']);
        $satellite->satellite_code = $data['satellite_code'];
        $satellite->trade_name_prefix = strtoupper($data['trade_name_prefix']);
        $satellite->trade_name = $data['trade_name'];
        $satellite->name = $data['name'];
        $satellite->size = $data['size'];
        $satellite->date_opened = date('Y-m-d h:i:s', strtotime($data['date_opened']));
        $satellite->contact_number = $data['contact_number'];
        $satellite->address = $data['address'];
        $satellite->zip_code = $data['zip_code'];
        $satellite->region = $data['region'];
        $satellite->longitude = $data['longitude'];
        $satellite->latitude = $data['latitude'];
        $satellite->area = $data['area'];
        $satellite->division = $data['division'];
        $satellite->island_group = $data['island_group'];
        
        //image upload
        if(isset($data['image'])) {
            //delete old image
            $old_filename = Satellite::where('id', $data['id'])->first(['image']);

            //if an image is already set
            if(!empty($old_filename->image)) {
                $old_filename_path = base_path() . '/public/images/' . $old_filename->image;
                unlink($old_filename_path);
            }
            
            //set up new image
            $filename = 's_' . strtotime(date('Y-m-d h:i:s')) . '.' . $data['image']->getClientOriginalExtension(); 
            $move = $data['image']->move(
                    base_path() . '/public/images/', $filename
                );

            $satellite->image = $filename;
        }

        $satellite->save();

        return redirect('stores/' . $data['branch_id'] . '/satellite');
    }

    /**
     * Get satellite by region.
     * @return string $region_id
     */
    public function getStoreByRegion($region_id)
    {
        $data = array();

        $satellite = new Satellite();
        return $satellite->getByRegion($region_id);
    }

    /**
     * Get satellite by region.
     * @return string $region_id
     */
    public function getStoreByIslandGroup($island_group_id)
    {
        $data = array();

        $satellite = new Satellite();
        return $satellite->getByIslandGroup($island_group_id);
    }

    /**
     * Get satellites by opening date.
     */
    public function getSatelliteByDateOpened()
    {
        $values = array();
        $result = array();
        $satellite = new Satellite();
        $data = $satellite->getSatelliteByDateOpened();

        foreach($data as $row) {
            array_push($values, $row->date_opened * 1000);
            array_push($values, $row->count);
            array_push($result, $values);
            $values = array();
        }

        return $result;
    }
}
