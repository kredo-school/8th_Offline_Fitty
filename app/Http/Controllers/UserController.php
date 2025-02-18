<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Nutritionist;
use App\Models\NutritionistsProfile;
use App\Models\User;
use Carbon\Carbon; // Carbonをインポート
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
        $lastWeight = DailyLog::latest()->where('user_id', Auth::id())->value('weight'); // 最新のweightを取得
        return view('users.inputmeal', compact('lastWeight'));
    }

    public function profile($id)
    {
        $user = $this->user->findOrFail($id);

        //dd($user->profile);
        //user_profileが存在していなければ登録画面にリダイレクト omori
        if (!$user->profile()->exists()) {
            return redirect()->route('register.step2');
        }

        $nutritionists = NutritionistsProfile::all();
        // dd($user->profile);

        $nutritionist_id = $user->profile->nutritionist_id;



        // エラーが出るため一時的にコメント
         $nutritionist_in_charge = User::where('id', $nutritionist_id)->first();
         $allocated = $nutritionist_in_charge->nutritionistsProfile;
         $avatar = $nutritionist_in_charge->avatar;
        // dd($allocated);

// dd($nutritionist_in_charge);

        return view('users.profile', compact('user','nutritionists'
         ,'allocated','avatar'
    ));
    }



    public function editprofile($id)
    {
        $user = $this->user->findOrFail($id);
        return view('users.editprofile', compact('user'));
    }
    public function showhistory($user_id)
    {

        $date = Carbon::today()->toDateString(); // 本日の日付を取得（'YYYY-MM-DD' 形式）

        $user = $this->user->findOrFail($user_id);
        $weightData = $this->showWeight($user_id, $date);

        return view('users.history', compact('user','weightData'));
    }

    public function showWeightData(Request $request, $user_id)
{
    try {
        $date = Carbon::today()->toDateString();
        $type = $request->query('type', 'monthly'); // クエリパラメータで `type` を取得

        $weightData = $this->showWeight($user_id, $date, $type);

        return response()->json([
            'weightData' => $weightData
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Something went wrong',
            'message' => $e->getMessage()
        ], 500);
    }
}

public function showWeight($id, $date, $type = 'daily')
{
    $endDate = Carbon::parse($date)->subDay(); // 前日を取得

    switch ($type) {
        case 'daily': // ✅ 修正: daily は過去7日間
            $startDate = $endDate->copy()->subDays(6); // 過去7日分
            break;
        case 'weekly': // ✅ 修正: weekly は過去4週間分
            $startDate = $endDate->copy()->subDays(29);
            break;
        case 'monthly': // ✅ 修正: monthly は過去12ヶ月分
            $startDate = $endDate->copy()->subDays(364);
            break;
        default:
            $startDate = $endDate->copy()->subDays(6);
    }

    $dailyLogs = DailyLog::where('user_id', $id)
        ->whereBetween('input_date', [$startDate, $endDate])
        ->orderBy('input_date', 'asc')
        ->get();

    $groupedData = $dailyLogs->groupBy(function ($log) use ($type) {
        switch ($type) {
            case 'daily':
                return Carbon::parse($log->input_date)->format('Y-m-d'); // ✅ `Y-m-d` に修正
            case 'weekly':
                return Carbon::parse($log->input_date)->startOfWeek()->format('Y-m-d');
            case 'monthly':
                return Carbon::parse($log->input_date)->format('Y-m'); // ✅ `Y-m` で月単位
            default:
                return Carbon::parse($log->input_date)->format('Y-m-d');
        }
    })->map(fn($logs) => $logs->avg('weight'));

    return [
        'labels' => $groupedData->keys()->toArray(),
        'weights' => $groupedData->values()->toArray(),
        'message' => $dailyLogs->isEmpty() ? 'No data available.' : null,
        'type' => $type
    ];
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
            'new_password' => 'required|min:8|confirmed',
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
        if ($user->save()) {
            return back()->with('success', 'Password updated successfully.');
        } else {
            return back()->withErrors(['new_password' => 'Failed to update password.'])->withInput();
        }
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

        //  Error if there is no profile
        if (!$user->profile) {
            return back()->withErrors(['profile' => 'User profile not found. Please create profile page.']);
    }
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:255',
            'category' => 'required|string|max:255',
            'content'  => 'required|string|min:30',
        ]);

        // Create Inquiry data
        Inquiry::create([
            'user_id'  => $user->id,
            'email'    => $request->email,
            'name'     => $request->name,
            'category' => $request->category,
            'content'  => $request->content,
        ]);

        // Send the thank you email
        // `MailController` の `sendThankYouMail` を呼び出す
            $mailController = new MailController();
            $mailController->sendThankYouMail($user->id, $request->email);


        return redirect()->route('user.sendInquiry.form', $user->id)->with('success', 'Inquiry submit successfully and a confirmation email has been sent!');

    }
}
