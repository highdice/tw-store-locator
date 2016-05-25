<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;

use App\User;
use App\Http\Controllers\Controller;
use Response;

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
            'email' => 'required|max:255|email|unique:users,email,'.$id,
            'password' => 'sometimes|required|confirmed|max:16|min:6',
            'password_confirmation' => 'sometimes|required',
            'name' => 'max:255|min:3',
            'user_level' => 'sometimes|required'
        ]);
    }

    /**
     * Handles view for the users menu item.
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
    }

    /**
     * Add a new user.
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
        $user->password = $data['password'];
        $user->name = $data['name'];
        $user->user_level = $data['user_level'];
        $user->status = 1;
        $user->save();

        return redirect('users');
    }

    /**
     * Edit an existing user.
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

        return redirect('users');
    }

    /**
     * Edit profile.
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

        return redirect('users/' . $data['id'] . '/profile');
    }
}
