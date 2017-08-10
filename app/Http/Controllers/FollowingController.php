<?php
/**
 * Created by PhpStorm.
 * User: hisaki
 * Date: 2017/08/10
 * Time: 16:49
 */

namespace App\Http\Controllers;

use App\Models\User;
use Request;
use DB;


class FollowingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function following()
    {
        // TODO: 自分のユーザID取得
        /** 認証済みユーザ情報の取得 */
        $loginUser = \Auth::user();
        $myID = $loginUser['id'];

        // TODO: 自分のIDからフォロワー情報取得
        $following = DB::table('users')
            ->select('users.description','users.display_name','users.avatar')
            ->leftJoin('follow','users.id','=','follow.followee_id')
            ->get();

        $users = User::find($myID);// エロケントでDB操作

        return view('user.following')->with([
            'following' => $following,
            "users" => $users
        ]);
    }

}