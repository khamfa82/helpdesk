<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExternalAuthController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public static function validator(array $data)
    {

        $options = [

            'http' => [
        
                'method' => 'POST',
        
                'header' => 'User-Agent:IT Asset API'
            ],
        
            'ssl' => [
        
                'verify_peer' => false,
        
                'verify_peer_name' => false,
        
            ]
        
        ];
        
        // dd(bcrypt($data['password']));

        // $url = "https://dms.intranet.live/api/auth/login";
        $url = "http://127.0.0.1:9020/api/auth/login";

        // $check = file_get_contents( $url . '?username=' . $request->get('email') . '&password=' . $request->get('password') . '&application_ref=1', false, stream_context_create($options));

        $url = ($url . '?username=' . $data['user_name'] . '&password=' . $data['password'] . '&application_ref=2');
        // dd(urldecode($url));
        $check = file_get_contents( $url, false, stream_context_create($options));


        // $check = json_decode($check);

        // dd(($check));

        return $check;
        // return Validator::make($data, [
        //     'name'     => 'required|max:255',
        //     'email'    => 'required|email|max:255|unique:users',
        //     'password' => 'required|min:6|confirmed',
        // ]);
    }
}
