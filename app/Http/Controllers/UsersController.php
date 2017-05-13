<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UsersController extends Controller
{
    private function isValidUserData($email, $password) {
        $userData = [ 'email' => $email, 'password' => $password ];
        $rules    = [ 'email' => 'required|email', 'password' => 'required|alphaNum|min:8' ];

        $validator = Validator::make($userData, $rules);

        if ($validator->fails()) {
            return false;
        }

        return true;
    }

    private function getUserIfExists($email, $password) {
        $user = User::where('email', '=', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }

        return false;
    }

    private function isDuplicateUser($username, $email) {
        $username_found = User::where('username', '=', $username)->first();
        $email_found    = User::where('email', '=', $email)->first();

        if ($username_found || $email_found) {
            return true;
        }

        return false;
    }

    private function authUser() {
        $email    = Input::get('email');
        $password = Input::get('password');

        if (!$this->isValidUserData($email, $password)) {
            return false;
        }

        $user = $this->getUserIfExists($email, $password);
        if ($user) {
            return $user;
        }

        return false;
    }

    public function getAllUsers() {
        $users = User::all();
        return json_encode($users);
    }

    public function getUserById($id) {
        $user = User::where('id', '=', $id)->first();
        return json_encode($user);
    }

    public function getUserByUsername($username) {
        $user = UserRepository::getUserByUserName($username);
        return json_encode($user);
    }

    public function getUserRankings(Request $request) {
        $users = UserRepository::getUserRankings($request);
        return json_encode($users);
    }

    public function loginUser() {
        $response = $this->authUser();
        return json_encode($response);
    }

    public function registerUser() {
        $image    = Input::get('image');
        $username = Input::get('username');
        $email    = Input::get('email');
        $password = Input::get('password');

        $img = Image::make($image)->resize(300, 200);
        $img_path = '/img/' . $username . '.jpg';
        $img->save(public_path() . $img_path, 60);

        $response = array(
            'success' => '',
            'status'  => '',
            'error'   => ''
        );

        if (!$this->isValidUserData($email, $password)) {
            $response['success']  = '0';
            $response['status']   = '';
            $response['error']    = 'The server encountered an error while trying to process your request.';
            return json_encode($response);
        }

        if ($this->isDuplicateUser($username, $email)) {
            $response['success']  = '0';
            $response['status']   = '';
            $response['error']    = 'Sorry! A user with that information already exists in our system.';
            return json_encode($response);
        }

        $user = new User;
        $user->image = $img_path;
        $user->username = $username;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        return json_encode($user);
    }
}
