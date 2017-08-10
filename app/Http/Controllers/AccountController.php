<?php
/**
 * Created by PhpStorm.
 * User: hisaki
 * Date: 2017/08/10
 * Time: 14:26
 */

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function account()
    {
        /** 認証済みユーザ情報の取得 */
        $loginUser = \Auth::user();
        $users = User::find($loginUser['id']);// エロケントでDB操作

        return view('settings.account', ['users' => $users]);
    }

    public function update(Request $request){

        /** 認証済みユーザ情報の取得 */
        $loginUser = \Auth::user();

        /**  POSTした内容をすべて取得 */
        $postInfo = $request->all();

        // TODO: パスワードが入力されていないときのエラー処理(nullのときリダイレクト)

        /** DBをUPDATE */
        DB::table('users')
            ->where('id', $loginUser['id'])
            ->update([
                'url_name' => $postInfo['url_name'],
                'email' => $postInfo['email'],
                'password' => $postInfo['password']
            ]);

        $users = User::find($loginUser['id']);// エロケントでDB操作



        return view('settings.account', ['users' => $users]);
    }
}