<?php

namespace App\Http\Controllers;

use App\Models\User;
use Request;
use DB;

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

        /**  ツイート全件取得 */
        $tweets = DB::table('users')
            ->orderBy('tweets.id','desc')
            ->select('body','display_name')
            ->leftJoin('tweets','users.id','=','user_id')
            ->get();

        return view('home')->with([
            "userInfo" => $userInfo,
            "tweets" => $tweets
        ]);

    }

    public function tweet()
    {
        /**  POSTした内容をすべて取得 */
        $postInfo = Request::all();

        /** 認証済みユーザ情報の取得 */
        $loginUser = \Auth::user();
        $userInfo = User::find($loginUser['id']);// エロケントでDB操作

        /** POSTしたツイートをデータベースに挿入*/
        DB::table('tweets')->insert(
            ['user_id' => $loginUser['id'],
                'body' => $postInfo['body']]
        );

        /**  ツイート全件取得 */
        $tweets = DB::table('users')
            ->orderBy('tweets.id','desc')
            ->select('body','display_name')
            ->leftJoin('tweets','users.id','=','user_id')
            ->get();


        return view('home')->with([
            "userInfo" => $userInfo,
            "tweets" => $tweets
        ]);

    }

}
