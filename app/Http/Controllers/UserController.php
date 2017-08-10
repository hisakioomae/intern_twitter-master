<?php
/**
 * Created by PhpStorm.
 * User: hisaki
 * Date: 2017/08/10
 * Time: 11:08
 */

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * ユーザ情報を表示する
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile()
    {
        /** 認証済みユーザ情報の取得 */
        $loginUser = \Auth::user();
        $users = User::find($loginUser['id']);// エロケントでDB操作

        return view('settings.profile', ['users' => $users]);
    }


    /**
     * @param Request $request POST情報
     * ユーザ情報を更新して表示する
     */
    public function update(Request $request)
    {
        /**  POSTした内容をすべて取得 */
        $postInfo = $request->all();

        /** 認証済みユーザ情報の取得 */
        $loginUser = \Auth::user();

        // TODO: フォームに何もないときのエラー処理
        //if ($request->has('avatar')) {
        $image = $request->file('avatar');// アップロード画像を取得
        $name = md5(sha1(uniqid(mt_rand(), true))) . '.' . $image->getClientOriginalExtension();// ファイル名生成
        $upload = $image->move('images', $name);// 画像アップロード
        $filePath = 'images\\' . $name;
        //}

        DB::table('users')
            ->where('id', $loginUser['id'])
            ->update([
                'display_name' => $postInfo['display_name'],
                'avatar' => $filePath,
                'description' => $postInfo['description']
            ]);

        $users = User::find($loginUser['id']);// エロケントでDB操作

        return view('settings.profile', ['users' => $users]);

    }
}