<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\NutritionistsProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NutritionistsController extends Controller
{
    private $nutritionist_profile;
   

    public function __construct(NutritionistsProfile $nutritionist_profile)
    {
        $this->nutritionist_profile = $nutritionist_profile;
    }

    /*
     * 栄養士一覧の表示（検索機能付き）
     */
    public function index(Request $request)
    {
        // 検索クエリを取得
        $search = $request->input('search');
    
        // 栄養士データを検索
        $query = $this->nutritionist_profile->query();
    
        if ($search) {
            $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
        }
    
        // ページネーションでデータを取得
        $nutritionists_profiles = $query->paginate(10);
    
        // ビューにデータを渡す
        return view('admin.nutritionists.index', compact('nutritionists_profiles', 'search'));
    }
    

    /**
     * 栄養士の削除
     */
    public function destroy($id)
    {
        $nutritionist_profile = NutritionistsProfile::findOrFail($id);
        $nutritionist_profile->delete();

        return redirect()->route('admin.nutritionists.index')->with('success', 'Nutritionist profile deleted successfully.');
    }

    /**
     * 新しい栄養士を作成するためのページ表示
     */
    public function create()
    {
        return view('admin.nutritionists.profile.register');
    }

    public function store(Request $request)
{
    // バリデーション
    $validated = $request->validate([
        'username' => 'required|string|max:255',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:8',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
    ]);

    // ユーザーの作成
    $user = User::create([
        'name' => $validated['username'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    // プロファイルの作成
    $profileData = [
        'user_id' => $user->id,
        'first_name' => $validated['first_name'],
        'last_name' => $validated['last_name'],
        'introduction' => $request->introduction,
    ];

    if ($request->hasFile('profile_image')) {
        $profileData['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
    }

    NutritionistsProfile::create($profileData);

    return redirect()->route('admin.nutritionists.index')->with('success', 'Nutritionist added successfully.');
}


}






// <!-- 

// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use App\Models\Nutritionist; // モデル Nutritionist
// use App\Models\NutritionistsProfile; // モデル NutritionistProfile
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class NutritionistsController extends Controller
// {
//     private $nutritionist_profile;
//     private $nutritionist;

//     public function __construct(NutritionistsProfile $nutritionist_profile, Nutritionist $nutritionist)
//     {
//         $this->nutritionist_profile = $nutritionist_profile;
//         $this->nutritionist = $nutritionist;
//     }
    


    // public function index()
    // {
    //     // Nutritionist 一覧を取得
    //     $nutritionists = Nutritionists::paginate(10); // 1ページあたり10件
    //     return view('admin.nutritionists.index', compact('nutritionists'));
    // }

    // public function create()
    // {
    //     // 現在のログインユーザーを取得
    //     $user = Auth::user();

    //     // 登録ページを表示
    //     return view('admin.nutritionists.profile.register', compact('user'));
    // }

