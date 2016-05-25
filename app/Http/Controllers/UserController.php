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

        $user = new User;
        $user->email = $data['email'];
        $user->password = Hash::make('t0m$w0rld');
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
        $user->where('id', $data['id']);
        $user->update();

        return Redirect::back()->with('success_message', 'Success! Your password has been updated.');
    }
}
