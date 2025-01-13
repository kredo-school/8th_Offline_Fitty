<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Nutritionist;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
        //
    }

    public function showdailylog()
    {
        return view('users.dailylog');
    }

    public function showinputmeal()
    {
        return view('users.inputmeal');
    }

    public function profile()
    {
        $user = Auth::user();

        return view('users.profile', compact('user'));
    }

    public function editprofile($id)
    {
        $user = $this->user->findOrFail($id);
        return view('users.editprofile', compact('user'));
    }
    public function showhistory()
    {
        return view('users.history');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function userUpdate(Request $request, $id)
    {
        // 対象ユーザーを取得
        $user = $this->user->findOrFail($id);

        // バリデーションルール
        $request->validate([
            'name' => 'required|min:1|max:255',
            'email' => 'required|email|min:1|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|mimes:png,jpg,jpeg,gif|max:2048', // アバターは任意で更新可能
            'gender' => 'required|in:male,female', // 性別は"male"または"female"のみ許可
            'birthday' => 'nullable|date|before:today', // 誕生日は過去の日付で任意
            'height' => 'nullable|numeric|min:50|max:300', // 身長は50〜300cmの範囲
            'activity_level' => 'required|integer|in:1,2,3', // アクティビティレベルは1, 2, 3のいずれか
        ]);

        // データを更新
        $user->name = $request->name;
        $user->email = $request->email;

        // プロファイルの更新
        $profile = $user->profile;
        $profile->gender = $request->gender;
        $profile->birthday = $request->birthday;
        $profile->height = $request->height;
        $profile->activity_level = $request->activity_level;
        $profile->save();

        // アバターの更新
        if ($request->hasFile('avatar')) {
            $user->avatar = 'data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
        }

        // ユーザー情報を保存
        $user->save();

        // プロフィールページへリダイレクト
        return redirect()->route('user.profile', $user->id);
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
