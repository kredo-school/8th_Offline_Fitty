<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;


class UsersController extends Controller
{

    private $user;
    private $user_profile;

    public function __construct(UserProfile $user_profile, User $user)
    {
        $this->user_profile = $user_profile;
        $this->user = $user;
    }

    /*
     * ユーザー一覧の表示（検索機能付き）
     */
    public function index(Request $request)
    {
        // 検索クエリを取得
        $search = $request->input('search');

        // ユーザープロファイルを検索
        $query = $this->user_profile->query(); // user_profile にアクセスする

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%'); // 必要に応じて検索フィールドを追加
        }

        // ページネーションで10件ずつ表示
        $user_profiles = $query->paginate(10);

        return view('admin.users.index', compact('user_profiles', 'search'));
    }

    /**
     * ユーザーの削除
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function allocateNutritionist($user_id, Request $request)
    {
        $user = $this->user->findOrFail($user_id);

        $request->validate([
            'nutritionist_id' => 'required',
        ]);

        $profile = $user->profile;
        $profile->nutritionist_id = $request->nutritionist_id;
        $profile->save();

        return redirect()->route('user.profile', $user->id);
    }
}
