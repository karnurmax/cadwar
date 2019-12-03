<?php

namespace App\Http\Controllers;

use App\EmailConfirmCode;
use App\Helpers\IsLocalhost;
use App\Helpers\Randomizer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->all();
        list($validated, $email, $password, $validateErrors) = $this->validateData($data);

        if ($validated === false) {
            return $this->makeError($validateErrors);
        }
        $user = User::where('email', $email)->first();
        if (isset($user)) {
            return $this->makeError("email уже существует");
        }
        $user = new User;
        $user->email = $email;
        $user->password = Hash::make($password);
        // $user->save();

        $code = Randomizer::GetString(500);
        $sent = $this->sendVerificationCodeToEmail($code, $email);
        return $sent;
        if ($sent !== true) {
            return $this->makeError('Произошла ошибка на стороне сервера. Не удалось отправить код на почту', 500);
        }
        $created = EmailConfirmCode::create(['code' => $code, 'user_id' => $user->id]);
        if ($created === false) {
            return $this->makeError('Произошла ошибка на стороне сервера. Не удалось создать запись в базе', 500);
        }
        return response("OK", 200);
    }

    public function code(Request $request, $code)
    {
        return $code;
    }

    public function login(Request $request)
    {

    }

    public function reset(Request $request)
    {

    }
    private function validateData($data)
    {
        $validated = true;
        $email = $data['email'];
        $password = $data['password'];
        $confirm = $data['confirm'];
        $validateErrors = [];
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $validated = false;
            $validateErrors[] = "email не прошел валидацию";
        }
        if (strlen($password) < 6) {
            $validated = false;
            $validateErrors[] = "пароль слишком короткий";
        }
        if ($password !== $confirm) {
            $validated = false;
            $validateErrors[] = "подтверждение пароля не совпадает";
        }
        return array($validated, $email, $password, $validateErrors);
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
        return repsonse(201);

    }
}
