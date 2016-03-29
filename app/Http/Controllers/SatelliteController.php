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
            'satellite_code' => 'required|max:250|unique:satellite',
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
    public function index($branch_id)
    {
        $result = new Satellite();
        $data = $result->getPaginatedRecords($branch_id);
        
        return view('satellite.index', ['data' => $data, 'branch_id' => $branch_id]);
    }

    /**
     * Handles view for adding a satellite.
     *
     * @param  none
     * @return Satellite
     */
    public function add($branch_id)
    {
        $result = new LookupController();
        $regions = $result->getRegions();
        return view('satellite.add', ['regions' => $regions, 'branch_id' => $branch_id]);
    }

    /**
     * Handles view for editing a satellite.
     *
     * @param  none
     * @return Satellite
     */
    public function edit($branch_id, $id)
    {
        $result = new Satellite();
        $data = $result->where('id', $id)->first();
        $data->date_opened = date('m/d/Y', strtotime($data->date_opened));

        $result = new LookupController();
        $regions = $result->getRegions();

        $result = new LookupController();
        $region = $result->getRegion($data->region);

        return view('satellite.edit', ['regions' => $regions, 'region' => $region, 'data' => $data]);
    }

    /**
     * Add a new satellite.
     *
     * @param  array $data
     * @return Satellite
     */
    protected function postAdd(Request $data)
    {
        $validator = $this->validator($data->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $data, $validator
            );
        }

        $satellite = new Satellite;
        $satellite->branch_id = $data['branch_id'];
        $satellite->satellite_code = $data['satellite_code'];
        $satellite->trade_name = $data['trade_name'];
        $satellite->name = $data['name'];
        $satellite->size = $data['size'];
        $satellite->date_opened = date('Y-m-d h:i:s', strtotime($data['date_opened']));
        $satellite->address = $data['address'];
        $satellite->zip_code = $data['zip_code'];
        $satellite->region = $data['region'];
        $satellite->longitude = $data['longitude'];
        $satellite->latitude = $data['latitude'];
        $satellite->division = $data['division'];
        $satellite->island_group = $data['island_group'];
        $satellite->status = 1;
        $satellite->save();

        return redirect('stores/' . $data['branch_id'] . '/satellite');
    }

    /**
     * Edit an existing satellite.
     *
     * @param  array $data
     * @return Satellite
     */
    protected function postEdit(Request $data)
    {
        $validator = $this->validator($data->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $data, $validator
            );
        }

        $satellite = new Satellite;
        $satellite->satellite_code = $data['satellite_code'];
        $satellite->trade_name = $data['trade_name'];
        $satellite->name = $data['name'];
        $satellite->size = $data['size'];
        $satellite->date_opened = date('Y-m-d h:i:s', strtotime($data['date_opened']));
        $satellite->address = $data['address'];
        $satellite->zip_code = $data['zip_code'];
        $satellite->region = $data['region'];
        $satellite->longitude = $data['longitude'];
        $satellite->latitude = $data['latitude'];
        $satellite->division = $data['division'];
        $satellite->island_group = $data['island_group'];
        $satellite->where('id', $data['id']);
        $satellite->update();

        return redirect('stores');
    }
}
