<?php

namespace App\Http\Controllers\Client\helpdesk;

// controllers
use App\Http\Controllers\Controller;
// models
use App\Model\helpdesk\Settings\System;
// classes
use Config;
use Redirect;
use Auth;

/**
 * OuthouseController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class WelcomepageController extends Controller
{
    public function __construct()
    {
        // $this->middleware('board');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function get(System $note)
    {
        // if (Config::get('database.install') == '%0%') {
        //     return Redirect::route('licence');
        // }
        $notes = $note->get();
        foreach ($notes as $note) {
            $content = $note->content;
        }

        return view('themes.default1.client.guest-user.guest', compact('heading', 'content'));
    }

    public function index()
    {
        $directory = base_path();
        $user = Auth::user();
        if (file_exists($directory.DIRECTORY_SEPARATOR.'.env')) {

            // return view('themes.default1.client.helpdesk.guest-user.index');
            //return redirect(route('dashboard'));

            //ADDED as of Sept 2020
            if(isset($user) && !is_null($user) && ($user->role == 'admin' || $user->role == 'agent')){
              return redirect(route('dashboard'));
            } else {
              return view('themes.default1.client.helpdesk.guest-user.index');
            }
            //ADDED as of Sept 2020
        } else {
            return Redirect::route('licence');
        }


    }
}
