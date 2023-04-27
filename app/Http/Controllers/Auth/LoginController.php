<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function user_email()
    {
        // return 'user_email';
        return 'user_email';
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $user = User::where('user_email', $request->user_email)->first();
            // activity('login')
            //     ->withProperties(['user_ip' => $ip])
            //     ->log('login');
            // if (Auth::viaRemember()) {
            //     $value = Cookie::get('user_email');
            // }
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        $user = User::where($this->user_email(), $request->user_email)->first();

        if($user){
            return $this->sendFailedLoginPasswordResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function sendFailedLoginPasswordResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'password' => [trans('auth.password')],
        ]);
    }

    public function logout(Request $request)
    {
        $user = User::find(Auth::user()->user_id);

//        $user->update([
//            'email_verified_at' => null
//        ]);

        User::where('user_email', $request->user_email)->first();
        // activity('logout')
        //     ->withProperties(['user_ip' => $ip])
        //     ->log('logout');

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect('/');
    }

    protected function attemptLogin(Request $request)
    {
        $remember_me = false;
        if (isset($request->remember_me)) {
            $remember_me = true;
        }

        return $this->guard()->attempt(
            $this->credentials($request),
            $remember_me
        );
    }

    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->user_email(), 'password');
        $credentials['is_deleted'] = 0;

        return $credentials;
    }

    public function field(Request $request)
    {
        $email = $this->user_email();

        return filter_var($request->get($email), FILTER_VALIDATE_EMAIL) ? $email : 'user_email';
    }

    protected function validateLogin(Request $request)
    {
        $field = $this->field($request);
        $messages = ["{$this->user_email()}.exists" => 'Invalid User Email.'];

        $this->validate($request, [
            $this->user_email() => "required|exists:tbl_user,{$field}",
            'password' => ['required', 'string', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ], $messages);
    }

    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user) {
        if ($user->user_role == 1) {
            return redirect('/modern-dark-menu/dashboard/analytics');
        }else {
            return redirect('/');
        }
    }

//    public function authenticated(Request $request, $user)
//    {
//        $user->generateTwoFactorCode();
//        $user->notify(new TwoFactorCode());
//    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
