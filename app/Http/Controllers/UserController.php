<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Nutritionist;
use App\Models\NutritionistsProfile;
use App\Models\User;
use App\Models\Inquiry;


use App\Models\DailyLog;

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

  

    public function showinputmeal()
    {
        $lastWeight = DailyLog::latest()->value('weight'); // 最新のweightを取得
        return view('users.inputmeal', compact('lastWeight'));
    }

    public function profile($id)
    {
        $user = $this->user->findOrFail($id);
        $nutritionists = NutritionistsProfile::all();
        // dd($user->profile);

        $nutritionist_id = $user->profile->nutritionist_id;


        // エラーが出るため一時的にコメント
        // $nutritionist_in_charge = User::where('id', $nutritionist_id)->first();
        // $allocated = $nutritionist_in_charge->nutritionistsProfile;
        // dd($allocated);

// dd($nutritionist_in_charge);

        return view('users.profile', compact('user','nutritionists'
        // ,'allocated'
    ));
    }



    public function editprofile($id)
    {
        $user = $this->user->findOrFail($id);
        return view('users.editprofile', compact('user'));
    }
    public function showhistory($user_id)
    {
        $user = $this->user->findOrFail($user_id);
        return view('users.history', compact('user'));
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
            'avatar' => 'mimes:jpeg,png,jpg|max:2048',
            'birthday' => 'nullable|date|before:today',
            'gender' => 'required|in:male,female,non-binary,prefer_not_to_say,other',
            'height' => 'nullable|numeric|min:120|max:220',
            'activity_level' => 'required|integer|in:1,2,3',
            'health_conditions' => 'nullable|array',
            'dietary_preferences' => 'nullable|array',
            'food_allergies' => 'nullable|string|max:255',
            'goals' => 'nullable|string|max:255',
        ]);

        // データを更新
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            $user->avatar = 'data:image/' . $request->avatar->extension() .
                ';base64,' . base64_encode(file_get_contents($request->avatar));
        }



        // プロファイルの更新
        $profile = $user->profile;
        $profile->first_name = $request->first_name;
        $profile->last_name = $request->last_name;
        $profile->birthday = $request->birthday;
        $profile->gender = $request->gender;
        $profile->height = $request->height;
        $profile->activity_level = $request->activity_level;
        $profile->health_conditions = json_encode($request->health_conditions ?? []); // JSONにエンコード
        $profile->dietary_preferences = json_encode($request->dietary_preferences ?? []); // JSONにエンコード
        $profile->food_allergies = $request->food_allergies;
        $profile->goals = $request->goals;
        $profile->save();


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

    public function showInquiryForm($id)
    {

        $user = $this->user->findOrFail($id);

        return view('users.sendInquiry', compact('user'));

    }

    public function storeInquiry(Request $request ,$id)
    {
        $user = $this->user->findOrFail($id);

        // dd($request->all());


        // プロフィールがない場合はエラー
        if (!$user->profile) {
            return back()->withErrors(['profile' => 'User profile not found. Please create profile page.']);
    }

        $request->validate([
            'category' => 'required|string|max:255',
            'content'  => 'required|string|min:30',
        ]);
// dd('omori');
        // 問い合わせデータの作成
        Inquiry::create([
            'user_id'  => $user->id,
            'email'    => $user->email,
            'name'     => $user->name,
            'category' => $request->category,
            'content'  => $request->content,
        ]);

        return redirect()->route('user.sendInquiry.form', $user->id)->with('success', 'Inquiry sent successfully.');

    }
}
