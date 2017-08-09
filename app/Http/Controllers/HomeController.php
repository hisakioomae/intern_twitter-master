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

        /** 認証済みユーザ情報の取得 */
        $loginUser = \Auth::user();
        $userInfo = User::find($loginUser['id']);
        return view('home',['user' => $userInfo]);

    }

}
