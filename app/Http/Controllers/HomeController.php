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

        /**  ツイート全件取得 */ //TODO: 冗長な処理(関数化)
        $tweets = DB::table('users')
            ->orderBy('tweets.id','desc')
            ->select('body','display_name','tweets.created_at','users.avatar')
            ->leftJoin('tweets','users.id','=','user_id')
            ->get();

        return view('home')->with([
            "users" => $userInfo,
            "tweets" => $tweets
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
        $nowTime = Carbon::now();

        /** 認証済みユーザ情報の取得 */
        $loginUser = \Auth::user();
        $userInfo = User::find($loginUser['id']);// エロケントでDB操作

        /** POSTしたツイートをデータベースに挿入*/
        DB::table('tweets')->insert(
            ['user_id' => $loginUser['id'],
                'body' => $postInfo['body'],
                'created_at' => $nowTime]
        );

        /**  ツイート全件取得 */
        $tweets = DB::table('users')
            ->orderBy('tweets.id','desc')
            ->select('body','display_name','tweets.created_at','users.avatar')
            ->leftJoin('tweets','users.id','=','user_id')
            ->get();


        return view('home')->with([
            "users" => $userInfo,
            "tweets" => $tweets
        ]);

    }


}
