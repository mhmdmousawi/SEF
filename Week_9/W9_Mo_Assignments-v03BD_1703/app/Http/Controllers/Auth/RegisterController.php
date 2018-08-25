<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => array(
                'nullable',
                'regex:/^[a-zA-Z\s]+$/u',
                'max:255'
            ),
            'gender' => array(
                'nullable',
                'in:male,female,Male,Female'
            ),
            'phone' => array(
                'nullable',
                'numeric',
                'regex:/^[0-9]{8,16}$/'
            ),
            'email' => array(
                'required',
                'string',
                'email',
                'unique:users',
                'max:255'
            ),
            'username' => array(
                'required',
                'regex:/^[a-zA-Z0-9._]+$/',
                'unique:users',
                'max:255'
            ),
            'password' => array(
                'required',
                'string',
                'min:6',
                'confirmed'
            ),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'gander' => $data['gender'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
