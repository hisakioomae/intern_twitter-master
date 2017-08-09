<?php

namespace App\Http\Controllers;

use App\Models\User;

class HomeController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $user = User::find(1);
        //dd($user);
        return view('home',['user' => $user]);

    }

}
