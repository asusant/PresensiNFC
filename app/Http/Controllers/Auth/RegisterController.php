<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Models\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
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
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    // NOTE - Remove Password from validation

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // NOTE delete this line if E-Mail is Done Configured!
            'level' => 'required', 'integer', Rule::in(['7', '8']),
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
        $newUser = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']), // NOTE change this line to  { 'password' => substr(md5(microtime()),rand(0,26),6), }
        ]);

        // NOTE - Send $newUser->password to email
        
        $userLevels = new UserLevel;
        $userLevels->id_user = $newUser->id;
        $userLevels->id_level = $data['level'];
        $userLevels->save();

        return $newUser;
    }


    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        /*$this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());*/

        return redirect(route('login'))->with('message_primary', 'Please Check Your Email for Password!');
    }
}
