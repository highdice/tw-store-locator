<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;

use App\User;
use App\Http\Controllers\Controller;
use Response;
use Hash;
use Redirect;
use Excel;

class UserController extends Controller
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
    protected function validator(array $data, $id = null)
    {
        return Validator::make($data, [
            'email' => 'sometimes|required|max:255|email|unique:users,email,'.$id,
            'old_password' => 'sometimes|required',
            'password' => 'sometimes|required|confirmed|max:16|min:6',
            'password_confirmation' => 'sometimes|required',
            'name' => 'max:255|min:3',
            'user_level' => 'sometimes|required'
        ]);
    }

    /**
     * Handles view for the users index page.
     *
     * @param  none
     * @return User
     */
    public function index()
    {
        $result = new User();
        $data = $result->getPaginatedRecords();
        
        return view('user.index', ['data' => $data]);
    }

    /**
     * Handles view for the users search page.
     *
     * @param  none
     * @return User
     */
    public function search(Request $data)
    {  
        $search = array();
        $where = array();

        //check if search data is set
        if(isset($data['search'])) {
            //user search
            array_push($search, "id LIKE '%" . $data['search'] . "%'");
            array_push($search, "email LIKE '%" . $data['search'] . "%'");
            array_push($search, "name LIKE '%" . $data['search'] . "%'");

            $search = implode(" OR ", $search);
            array_push($where, $search);
        }
        
        array_push($where, "status = 1");
        $where = implode(" AND ", $where);

        $result = new User();
        $data = $result->getPaginatedRecordsBySearch($where);
        
        return view('user.index', ['data' => $data]);
    }

    /**
     * Handles view for adding a user.
     *
     * @param  none
     * @return User
     */
    public function add()
    {
        $result = new LookupController();
        $user_levels = $result->getUserLevels();

        return view('user.add', ['user_levels' => $user_levels]);
    }

    /**
     * Handles view for editing a user.
     *
     * @param  none
     * @return User
     */
    public function edit($id)
    {
        $result = new User();
        $data = $result->where('id', $id)->first();

        $result = new LookupController();
        $user_levels = $result->getUserLevels();

        return view('user.edit', ['user_levels' => $user_levels, 'data' => $data]);
    }

    /**
     * Handles view for user profile.
     *
     * @param  none
     * @return User
     */
    public function profile($id)
    {
        $result = new User();
        $data = $result->where('id', $id)->first();

        $result = new LookupController();
        $user_levels = $result->getUserLevels();

        return view('user.profile', ['user_levels' => $user_levels, 'data' => $data]);
    }

    /**
     * Handles view for editing a user.
     *
     * @param  none
     * @return User
     */
    public function changePassword($id)
    {
        $result = new User();
        $data = $result->where('id', $id)->first();

        return view('user.change_password', ['data' => $data]);
    }

    /**
     * Handles excel export of all users.
     */
    public function export() {
        $filename = 'users_' . date('Ymd-his') . '_export';
        
        Excel::create($filename, function ($excel) {

            $excel->sheet('Users', function ($sheet) {

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

                $sheet->row(2, array('List of all the users'));

                $users = User::where('id', '!=', 1)->get()->toArray();

                if((count($users) > 0)) {
                    //setting column names
                    $sheet->appendRow(array_keys($users[0])); // column names

                    //getting last row number
                    $sheet->row($sheet->getHighestRow(), function ($row) {
                        $row->setFontFamily('Verdana');
                        $row->setFontSize(10);
                        $row->setBackground('#2674ce');
                        $row->setFontColor('#ffffff');
                    });

                    //putting data as next rows
                    foreach ($users as $user) {
                        $sheet->appendRow($user);
                    }
                }
                else {
                    $sheet->row(3, array('No records available'));
                }
            });

        })->export('xls');
    }

    /**
     * Add a new user on post.
     *
     * @param  array $data
     * @return User
     */
    protected function postAdd(Request $data)
    {
        $validator = $this->validator($data->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $data, $validator
            );
        }

        $password = 't0m$w0rld' . strtotime(date('Y-m-d h:i:s'));

        $user = new User;
        $user->email = $data['email'];
        $user->password = Hash::make($password);
        $user->default_password = $password;
        $user->default_password_changed = 0;
        $user->name = $data['name'];
        $user->user_level = $data['user_level'];
        $user->status = 1;
        $user->save();

        return redirect('users');
    }

    /**
     * Edit an existing user on post.
     *
     * @param  array $data
     * @return User
     */
    protected function postEdit(Request $data)
    {
        $validator = $this->validator($data->all(), $data['id']);

        if ($validator->fails()) {
            $this->throwValidationException(
                $data, $validator
            );
        }

        $user = User::find($data['id']);
        $user->email = $data['email'];
        $user->name = $data['name'];
        $user->user_level = $data['user_level'];
        $user->where('id', $data['id']);
        $user->update();

        return Redirect::back()->with('success_message', 'Success! User details have been updated.');
    }

    /**
     * Update user status.
     *
     * @param  integer $id, integer $status
     * @return User
     */
    protected function postStatus($id, $status)
    {
        $message = '';

        $user = User::find($id);
        $user->status = $status;
        $user->where('id', $id);
        $user->update();

        if($status == 0) {
            $message = 'Success! User with ID ' . $id .' has been deactivated.';
        }
        else {
            $message = 'Success! User with ID ' . $id .' has been activated.';
        }

        return Redirect::back()->with('success_message', $message);
    }

    /**
     * Reset user password.
     *
     * @param  integer $id
     * @return User
     */
    protected function postReset($id)
    {
        $user = User::find($id);

        $password = 't0m$w0rld' . $id . strtotime(date('Y-m-d h:i:s'));

        $user->password = Hash::make($password);
        $user->default_password = $password;
        $user->default_password_changed = 0;
        $user->where('id', $id);
        $user->update();

        return Redirect::back()->with('success_message', 'Success! Password for user with ID ' . $id .' has been reset. The new password is ' . $password . '.');
    }

    /**
     * Edit profile on post.
     *
     * @param  array $data
     * @return User
     */
    protected function postProfile(Request $data)
    {
        $validator = $this->validator($data->all(), $data['id']);

        if ($validator->fails()) {
            $this->throwValidationException(
                $data, $validator
            );
        }

        $user = User::find($data['id']);
        $user->email = $data['email'];
        $user->name = $data['name'];
        $user->where('id', $data['id']);
        $user->update();

        return Redirect::back()->with('success_message', 'Success! Your profile has been updated.');
    }

    /**
     * Change password on post.
     *
     * @param  array $data
     * @return User
     */
    protected function postChangePassword(Request $data)
    {
        $validator = $this->validator($data->all(), $data['id']);

        if ($validator->fails()) {
            $this->throwValidationException(
                $data, $validator
            );
        }

        $user = User::find($data['id']);

        //check if old password is correct
        if(isset($data['old_password'])) {
            $old_password = $user['password'];

            if (!Hash::check($data['old_password'], $old_password)) {
                return Redirect::back()->with('error_message', 'Failed! Old password is incorrect.');
            }
        }

        $user->password = Hash::make($data['password']);
        $user->default_password = '';
        $user->default_password_changed = 1;
        $user->where('id', $data['id']);
        $user->update();

        return Redirect::back()->with('success_message', 'Success! Your password has been updated.');
    }

    /**
     * Count users.
     * @return integer
     */
    protected function count()
    {
        $count = User::count();
        return $count;
    }
}
