<?php

namespace App\Http\Controllers\Auth;

use App\EmailConfirmCode;
use App\Helpers\IsLocalhost;
use App\Helpers\Randomizer;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        $email = $data['email'];
        $password = $data['password'];
        $name = $data['name'];

        $code = Randomizer::GetString(50);
        $sent = $this->sendVerificationCodeToEmail($code, $email);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        EmailConfirmCode::create(['code' => $code, 'user_id' => $user->id]);

        return $user;
    }

    public function sendVerificationCodeToEmail($code, $email)
    {
        $isLocalhost = IsLocalhost::Check();

        if ($isLocalhost === true) {
            return true;
        }
        $httpOrigin = 'https://cadwar.karnurmax.kz';
        $message = "https://cadwar.karnurmax.kz/auth/code/$code";

        // $headers = 'MIME-Version: 1.0' . "\r\n";
        // $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

        mail($email, 'Регистрация', $message);
        return true;

    }
}
