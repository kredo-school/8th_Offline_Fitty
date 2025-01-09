<?php

namespace App\Http\Controllers;

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
        $user = $this->user->where('id', 1)->first();

        return view('users.profile',compact('user'));
    }

    public function editprofile($id)
    {
        $user = $this->user->findOrFail($id);
        return view('users.editprofile',compact('user'));
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

    public function profileupdate(Request $request, $id)
    {
              // 対象ユーザーを取得
              $user = $this->user->findOrFail($id);

              // バリデーションルール
              $request->validate([
                  'name' => 'required|min:1|max:255',
                  'email' => 'required|email|min:1|max:255|unique:users,email,' . $user->id,
                  'avatar' => 'nullable|mimes:png,jpg,jpeg,gif|max:1048', // アバターは任意で更新可能
                  'gender' => 'required|in:male,female', // 性別は"male"または"female"のみ許可
                  'birthday' => 'nullable|date|before:today', // 誕生日は過去の日付で任意
                  'height' => 'nullable|numeric|min:50|max:300', // 身長は50〜300cmの範囲
                  'activity_level' => 'required|integer|in:1,2,3', // アクティビティレベルは1, 2, 3のいずれか
              ]);

              // データを更新
              $user->name = $request->name;
              $user->email = $request->email;
              $user->gender = $request->gender;
              $user->birthday = $request->birthday;
              $user->height = $request->height;
              $user->activity_level = $request->activity_level;

              // アバターの更新
              if ($request->hasFile('avatar')) {
                  $user->avatar = 'data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
              }

              // 保存
              $user->save();

              // プロフィールページへリダイレクト
              return redirect()->route('user.profile', $user->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 対象ユーザーを取得
        $user = $this->user->findOrFail($id);

        // バリデーションルール
        $request->validate([
            'name' => 'required|min:1|max:255',
            'email' => 'required|email|min:1|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|mimes:png,jpg,jpeg,gif|max:1048', // アバターは任意で更新可能
            'gender' => 'required|in:male,female', // 性別は"male"または"female"のみ許可
            'birthday' => 'nullable|date|before:today', // 誕生日は過去の日付で任意
            'height' => 'nullable|numeric|min:50|max:300', // 身長は50〜300cmの範囲
            'activity_level' => 'required|integer|in:1,2,3', // アクティビティレベルは1, 2, 3のいずれか
        ]);

        // データを更新
        $user->name = $request->name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->birthday = $request->birthday;
        $user->height = $request->height;
        $user->activity_level = $request->activity_level;

        // アバターの更新
        if ($request->hasFile('avatar')) {
            $user->avatar = 'data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
        }

        // 保存
        $user->save();

        // プロフィールページへリダイレクト
        return redirect()->route('user.profile', $user->id);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
