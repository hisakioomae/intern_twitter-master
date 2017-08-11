<?php
/**
 * Created by PhpStorm.
 * User: hisaki
 * Date: 2017/08/10
 * Time: 16:49
 */

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Illuminate\Http\Request;


class FollowingController extends Controller
{
    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function following($id)
    {
        // TODO: 自分のユーザID取得
        /** 認証済みユーザ情報の取得 */
        $loginUser = \Auth::user();
        $myID = $loginUser['id'];

        // TODO: 自分のIDからフォロワー情報取得
        $following = DB::table('users')
            ->select('users.description', 'users.display_name', 'users.avatar','users.id')
            ->where('follow.followee_id', '=', $id)
            ->Join('follow', 'users.id', '=', 'follow.follower_id')
            ->get();

        $users = User::find($myID);// エロケントでDB操作

        $user = User::find($id);// エロケントでDB操作

        /**  フォロー数の取得 */
        $following_num = DB::table('users')
            ->select('*')
            ->where('follow.followee_id', '=', $id)
            ->Join('follow', 'users.id', '=', 'follow.follower_id')
            ->count();

        /**  フォロワー数の取得 */
        $follower_num = DB::table('users')
            ->select('*')
            ->where('follow.follower_id', '=', $id)
            ->Join('follow', 'users.id', '=', 'follow.followee_id')
            ->count();

        return view('user.following')->with([
            'following' => $following,
            "users" => $users,
            "user" => $user,
            "following_num" => $following_num,
            "follower_num" => $follower_num
        ]);
    }

}