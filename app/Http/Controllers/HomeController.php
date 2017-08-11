<?php

namespace App\Http\Controllers;

use App\Models\User;
use Request;
use DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {

        /** 認証済みユーザ情報の取得 */
        $loginUser = \Auth::user();
        $userInfo = User::find($loginUser['id']);// エロケントでDB操作

        /**  ツイート全件取得 */ //TODO: フォローしている人だけ
        $tweets = DB::table('users')
            ->orderBy('tweets.id','desc')
            ->where('follow.followee_id', '=', $loginUser['id'])
            ->orWhere('users.id','=', $loginUser['id'])
            ->select('body','display_name','tweets.created_at','users.avatar')
            ->Join('tweets','users.id','=','user_id')
            ->LeftJoin('follow', 'users.id', '=', 'follow.follower_id')
            ->get();

        //dd($tweets);

        /**  フォロー数の取得 */
        $following_num = DB::table('users')
            ->select('*')
            ->where('follow.followee_id', '=', $loginUser['id'])
            ->Join('follow', 'users.id', '=', 'follow.follower_id')
            ->count();

        /**  フォロワー数の取得 */
        $follower_num = DB::table('users')
            ->select('*')
            ->where('follow.follower_id', '=', $loginUser['id'])
            ->Join('follow', 'users.id', '=', 'follow.followee_id')
            ->count();


        return view('home')->with([
            "users" => $userInfo,
            "tweets" => $tweets,
            "following_num" => $following_num,
            "follower_num" => $follower_num
        ]);

    }

    /**
     * ツイートを反映する
     */
    public function tweet()
    {
        /**  POSTした内容をすべて取得 */
        $postInfo = Request::all();
        /** PHPのコマンドで現在時刻を取得 */
        $nowTime = Carbon::now('Asia/Tokyo');

        /** 認証済みユーザ情報の取得 */
        $loginUser = \Auth::user();
        $userInfo = User::find($loginUser['id']);// エロケントでDB操作

        /** POSTしたツイートをデータベースに挿入*/
        DB::table('tweets')->insert(
            ['user_id' => $loginUser['id'],
                'body' => $postInfo['body'],
                'created_at' => $nowTime]
        );

        /**  ツイート全件取得 */ //TODO: フォローしている人だけ
        $tweets = DB::table('users')
            ->orderBy('tweets.id','desc')
            ->where('follow.followee_id', '=', $loginUser['id'])
            ->orWhere('tweets.user_id','=', $loginUser['id'])
            ->select('body','display_name','tweets.created_at','users.avatar')
            ->LeftJoin('tweets','users.id','=','user_id')
            ->LeftJoin('follow', 'users.id', '=', 'follow.follower_id')
            ->get();

        /**  フォロー数の取得 */
        $following_num = DB::table('users')
            ->select('*')
            ->where('follow.followee_id', '=', $loginUser['id'])
            ->Join('follow', 'users.id', '=', 'follow.follower_id')
            ->count();

        /**  フォロワー数の取得 */
        $follower_num = DB::table('users')
            ->select('*')
            ->where('follow.follower_id', '=', $loginUser['id'])
            ->Join('follow', 'users.id', '=', 'follow.followee_id')
            ->count();

        return view('home')->with([
            "users" => $userInfo,
            "tweets" => $tweets,
            "following_num" => $following_num,
            "follower_num" => $follower_num
        ]);

    }


}
