<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;

use App\Satellite;
use App\Http\Controllers\Controller;
use Response;
use Redirect;
use Excel;

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
            'area' => 'required|integer',
            'division' => 'required|integer',
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
     * Handles view for the satellites page.
     * @return view
     */
    public function index($branch_id)
    {
        $result = new Satellite();
        $data = $result->getPaginatedRecords($branch_id);

        return view('satellite.index', ['data' => $data, 'branch_id' => $branch_id]);
    }

    /**
     * Handles view for the satellites search page.
     * @return view
     */
    public function search($branch_id, Request $data)
    {
        $search = array();
        $where = array();

        //check if search data is set
        if(isset($data['search'])) {
            //satellite search
            array_push($search, "satellite_code LIKE '%" . $data['search'] . "%'");
            array_push($search, "trade_name_prefix LIKE '%" . $data['search'] . "%'");
            array_push($search, "trade_name LIKE '%" . $data['search'] . "%'");
            array_push($search, "name LIKE '%" . $data['search'] . "%'");
            array_push($search, "division LIKE '%" . $data['search'] . "%'");
            array_push($search, "area LIKE '%" . $data['search'] . "%'");

            $search = implode(" OR ", $search);
            array_push($where, $search);
        }
        
        array_push($where, "status = 1");
        array_push($where, "branch_id = " . $branch_id);
        $where = implode(" AND ", $where);

        $result = new Satellite();
        $data = $result->getPaginatedRecordsBySearch($where);

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
        $divisions = $result->getDivisions();
        $areas = $result->getAreas();

        return view('satellite.add', ['regions' => $regions, 'trade_names' => $trade_names, 'divisions' => $divisions, 'areas' => $areas, 'branch_id' => $branch_id]);
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
        $divisions = $result->getDivisions();
        $areas = $result->getAreas();

        return view('satellite.edit', ['regions' => $regions, 'trade_names' => $trade_names, 'region' => $region, 'divisions' => $divisions, 'areas' => $areas, 'data' => $data]);
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
     * Handles excel export of satellites.
     */
    public function export($branch_id) {
        $filename = 'satellites_' . $branch_id . '_' . date('Ymd-his') . '_export';
        
        Excel::create($filename, function ($excel) use($branch_id) {

            $excel->sheet('Satellites', function ($sheet) use($branch_id) {

                //first row styling and writing content
                $sheet->mergeCells('A1:W1');
                $sheet->row(1, function ($row) {
                    $row->setFontFamily('Verdana');
                    $row->setFontSize(14);
                });

                $sheet->row(1, array("Tom's World Philippines"));

                //second row styling and writing content
                $sheet->row(2, function ($row) {

                    //call cell manipulation methods
                    $row->setFontFamily('Verdana');
                    $row->setFontSize(10);

                });

                $sheet->row(2, array('List of all the satellites for Branch ID #' . $branch_id));

                $satellites = Satellite::where('branch_id', '=', $branch_id)->get()->toArray();

                if((count($satellites) > 0)) {
                    //setting column names
                    $sheet->appendRow(array_keys($satellites[0])); // column names

                    //getting last row number
                    $sheet->row($sheet->getHighestRow(), function ($row) {
                        $row->setFontFamily('Verdana');
                        $row->setFontSize(10);
                        $row->setBackground('#2674ce');
                        $row->setFontColor('#ffffff');
                    });

                    //putting data as next rows
                    foreach ($satellites as $satellite) {
                        $sheet->appendRow($satellite);
                    }
                }
                else {
                    $sheet->row(3, array('No records available'));
                }
            });

        })->export('xls');
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

        return Redirect::back()->with('success_message', 'Success! Satellite details have been updated.');
    }

     /**
     * Update satellite status.
     *
     * @param  integer $id, integer $status
     * @return Satellite
     */
    protected function postStatus($branch_id, $id, $status)
    {
        $message = '';

        $user = Satellite::find($id);
        $user->status = $status;
        $user->where('id', $id);
        $user->update();

        if($status == 0) {
            $message = 'Success! Satellite with ID ' . $id .' has been deactivated.';
        }
        else {
            $message = 'Success! Satellite with ID ' . $id .' has been activated.';
        }

        return Redirect::back()->with('success_message', $message);
    }

    /**
     * Count satellites.
     * @return integer
     */
    protected function count()
    {
        $count = Satellite::count();
        return $count;
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
