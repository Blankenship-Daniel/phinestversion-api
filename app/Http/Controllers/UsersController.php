<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    private function isValidUserData($email, $password) {
        $userData = [ 'email' => $email, 'password' => $password ];
        $rules = [ 'email' => 'required|email', 'password' => 'required|alphaNum|min:8' ];

        $validator = Validator::make($userData, $rules);

        if ($validator->fails()) {
            return false;
        }

        return true;
    }

    private function getUserIfExists($email, $password) {
        $hashedPass = Hash::make($password);
        $user = User::where('email', '=', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            return $user;
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
        $email    = Input::get('email');
        $password = Input::get('password');

        if (!$this->isValidUserData($email, $password)) {
            return json_encode(false);
        }

        $user = $this->getUserIfExists($email, $password);
        if ($user) {
            return json_encode(false);
        }

        // TODO: finish functionality to save user
        // $user = new User;
        // $user->image = '';
        // $user->username = '';
        // $user->email = $email;
        // $user->password = Hash::make($password);
        // $user->save();

        // return $user;
        return json_encode(false);
    }
}
