<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;
    //use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    

    public function login(Request $request)
    {
        dd('here');
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }     

        try {
            $loginAttempt = true;
        } catch (Exception $e) {
                return redirect()->back()
                        ->withInput()
                        ->with('user-error', '<br/>Error Occured: ');
        }

        if ($loginAttempt->fail == 0 || $request->email == 'admin') {
            // Active Directory Login Verification Success.
            if($request->email != 'admin'){
                $user = \App\User::where('user_name', $request->email)->first();
                if ($user === null) {
                    // user doesn't exist
                    return redirect()->back()
                            ->withInput()
                            ->with('user-error', 'User Exists on the Remotely But Does Not For This System. <br />Please Contact System Administrator.');
                }
                elseif ($user->isNotActive()) {
                    // User is not active
                    return redirect()->back()
                        ->withInput()
                        ->with('user-error', 'Your User Account Exists on the Remotely But Has Been Disabled/De-activated For This System. <br />Please Contact System Administrator.');
                }
                else{
                    $user->password = Hash::make($request->password);
                    // $user->ad_verified = 1;
                    $user->save();
                }
            }

            // Authenticating The User Locally Vs. The Respective Data in the Database
            if(\Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1])) {

                // return redirect()->intended('dashboard');
            }  else {
                $this->incrementLoginAttempts($request);
                // Local System User has been deactivated.

                return redirect()->back()
                        ->withInput()
                        ->with('user-error', 'This User Account is not Active on this System.');
            }
        } else {
            // Active Directory Username or password is incorrect.
            return redirect()->back()
                        ->withInput()
                        ->with('user-error', 'Invalid Username/Password Provided. <br />Remote Verification Has Failed.');
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }
}
