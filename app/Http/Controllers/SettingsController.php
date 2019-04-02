<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SettingsController extends Controller
{
    public function setLanguage(Request $request)
    {
        $user = Auth::user();
        $user->language = $request->lang;
        $user->save();

        return redirect()->action('HomeController@index');
    }
}
