<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Nutritionist;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class NutritionistController extends Controller
{
    private $user;
    private $nutritionist;

    public function __construct(Nutritionist $nutritionist, User $user)
    {
        $this->nutritionist = $nutritionist;
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 現在の栄養士（ログイン中の栄養士）を取得
        $nutritionist = $this->nutritionist->where('id', 1)->first();

        // 栄養士に関連するユーザー情報を取得
        $users = $this->user->where('nutritionist_id', 3)->get();

        // 栄養士とその関連ユーザー情報をビューに渡す
        return view('nutritionists.index', compact('nutritionist', 'users'));
    }


    function sendAdvice($id)
    {
        $user = $this->user->findOrFail($id);


        return view('nutritionists.sendAdvice', compact('user'));
    }






    function profile($id)
    {
        $user = $this->user->findOrFail($id);
        return view('nutritionists.profile', compact('user'));
    }
    function editProfile($id)
    {
        $user = $this->user->findOrFail($id);
        return view('nutritionists.editProfile', compact('user'));
    }

    public function nutriUpdate(Request $request, $id)
    {
        // 対象ユーザーを取得
        $user = $this->user->findOrFail($id);

        // バリデーションルール
        $request->validate([
            'name' => 'required|min:1|max:255',
            'email' => 'required|email|min:1|max:255|unique:users,email,' . $user->id,
            'avatar' => 'mimes:jpeg,png,jpg|max:2048',
            'first_name' => 'required|min:1|max:255',
            'last_name' => 'required|min:1|max:255',
            'memo' => 'nullable|min:1|max:1080',
            // 性別は"male"または"female"のみ許可

        ]);

        // データを更新
        $user->name = $request->name;
        $user->email = $request->email;
        $user->avatar = $user->avatar ?? 'default_avatar.png';

        if ($request->avatar) {
            $user->avatar = 'data:image/' . $request->avatar->extension() .
                ';base64,' . base64_encode(file_get_contents($request->avatar));
        }



        // プロファイルの更新
        $nutritionistsProfile = $user->nutritionistsProfile;
        $nutritionistsProfile->first_name = $request->first_name;
        $nutritionistsProfile->last_name = $request->last_name;
        $nutritionistsProfile->memo = $request->memo;
        $nutritionistsProfile->save();

        // ユーザー情報を保存
        $user->save();

        // プロフィールページへリダイレクト
        return redirect()->route('nutri.profile', $user->id);
    }

    public function changePassword(Request $request, $id)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // confirmedでnew_passwordとconfirm_passwordを一致させる
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // ユーザーの取得
        $user = $this->user->findOrFail($id);

        // 現在のパスワードが正しいか確認
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
        }

        // 新しいパスワードを保存
        $user->password = Hash::make($request->new_password);
        $user->save();

        // 成功メッセージを設定
        return back()->with('success', 'Password updated successfully.');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(Nutritionist $nutritionist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nutritionist $nutritionist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nutritionist $nutritionist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nutritionist $nutritionist)
    {
        //
    }
}
