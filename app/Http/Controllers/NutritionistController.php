<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\DailyLog;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

use App\Services\ChartsService;//レーダーチャート表示の処理を外部に移動 omori



class NutritionistController extends Controller
{
    private $user;
    private $user_profile;
    private $dailylog;
    protected $ChartsService;

    public function __construct(User $user, UserProfile $user_profile, DailyLog $dailylog, ChartsService $ChartsService)
    {
        $this->user = $user;
        $this->user_profile = $user_profile;
        $this->dailylog = $dailylog;
        $this->ChartsService = $ChartsService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $one_week_ago = now()->subWeek();

    // 栄養士に関連するユーザー情報を取得
    $user_profiles = $this->user_profile
        ->where('nutritionist_id', Auth::user()->id)
        ->where(function ($query) use ($one_week_ago) {
            $query->where('advice_sent_date', '<', $one_week_ago)
                ->orWhereNull('advice_sent_date'); // advice_sent_dateがnullの場合も含める
        })
        ->paginate(8); // ← ページネーションを適用

    return view('nutritionists.index', compact('user_profiles'));
}




    function profile($id)
    {

        $user = User::find($id);
        return view('nutritionists.profile', compact('user'));
    }

    function editprofile($id)
    {

        $user = User::find($id);
        return view('nutritionists.editprofile', compact('user'));
    }

    function updateProfile($id, Request $request)
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
            'introduction' => 'required|min:1|max:255',
        ]);

        // データを更新
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            $user->avatar = 'data:image/' . $request->avatar->extension() .
                ';base64,' . base64_encode(file_get_contents($request->avatar));
        }


        // プロファイルの更新
        $profile = $user->nutritionistsProfile;
        $profile->first_name = $request->first_name;
        $profile->last_name = $request->last_name;
        $profile->introduction = $request->introduction;

        $profile->save();


        // ユーザー情報を保存
        $user->save();

        // プロフィールページへリダイレクト
        return redirect()->route('nutri.profile', $user->id);
    }
}
