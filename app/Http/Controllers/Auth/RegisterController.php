<?php

namespace App\Http\Controllers\Auth;
use App\Accesscode;
use App\UserType;
use App\LeadTo;
use App\User;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\Rule;

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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if($data['userType_id'] == 1){
            return Validator::make($data, [
                'userType_id' =>['required', 'integer'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }elseif($data['userType_id'] == 2){
            return Validator::make($data, [
                'userType_id' =>['required', 'integer'],
                'school_id' =>['required'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }elseif($data['userType_id'] == 3){
            return Validator::make($data, [
                'userType_id' =>['required', 'integer'],
                'school_id' =>['required'],
                'section_id' =>['required'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }elseif($data['userType_id'] == 4){
            return Validator::make($data, [
                'userType_id' =>['required', 'integer'],
                'school_id' =>['required', 'exists:users'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if($data['userType_id'] == 1){
            return User::create([
                'profilePic_location' => 'default-account-image.png',
                'userType_id' => $data['userType_id'],
                'school_id' => null,
                'child_id' => null,
                'section_id' => null,
                'usable' => $data['usable'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        }elseif($data['userType_id'] == 2){
            return User::create([
                'profilePic_location' => 'default-account-image.png',
                'userType_id' => $data['userType_id'],
                'school_id' => $data['school_id'],
                'child_id' => null,
                'section_id' => null,
                'usable' => $data['usable'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        }elseif($data['userType_id'] == 3){
            return User::create([
                'profilePic_location' => 'default-account-image.png',
                'userType_id' => $data['userType_id'],
                'school_id' => $data['school_id'],
                'child_id' => null,
                'section_id' => $data['section_id'],
                'usable' => $data['usable'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        }elseif($data['userType_id'] == 4){

            $child_id = DB::table('users')
                        ->select('users.id')
                        ->where('users.school_id', '=', $data['school_id'])
                        ->first();
            
            return User::create([
                'profilePic_location' => 'default-account-image.png',
                'userType_id' => $data['userType_id'],
                'school_id' => null,
                'child_id' => $child_id->id,
                'section_id' => null,
                'usable' => $data['usable'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        }
    }
}
