<?php

namespace App\Http\Controllers;

use App\Models\DailyLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Nutritionist;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Category;
use App\Models\SubCategory;

use Illuminate\Support\Facades\Auth;

use App\Services\ChartsService; //ChartsServiceに処理を記載し共通化 omori




class DailyLogController extends Controller
{
    private $user;
    private $user_profile;
    private $dailylog;
    protected $ChartsService;

    public function __construct(User $user, UserProfile $user_profile ,dailylog $dailylog, ChartsService $ChartsService)
    {
        $this->user = $user;
        $this->dailylog = $dailylog;
        $this->ChartsService = $ChartsService;
        $this->user_profile = $user_profile;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'input_date' => 'required|date',
            'meal_type' => 'required|string',
            'meal_content' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0', // 体重は任意
            'comment' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 現在の認証ユーザーのIDを取得して設定
        $this->dailylog->user_id = Auth::id();

        // データを設定
        $this->dailylog->input_date = $request->input('input_date');
        $this->dailylog->meal_type = $request->input('meal_type');
        $this->dailylog->meal_content = $request->input('meal_content');
        $this->dailylog->weight = $request->input('weight');
        $this->dailylog->comment = $request->input('comment');

        $this->dailylog->nutritions = $request->input('nutritions');

        if($request->image){
            $this->dailylog->image = 'data:image/' . $request->image->extension() .
            ';base64,' . base64_encode(file_get_contents($request->image));
        }

        // データベースに保存
        $this->dailylog->save();

        // リダイレクト
        return redirect()->route('user.dailylog', [Auth::id(), $request->input('input_date')]);
    }

    /**
     * Display the specified resource.
     */

     public function showdailylog($user_id, $date)
     {
         $user = $this->user->findOrFail($user_id);

         $user_profile = $this->user_profile->where('user_id', $user_id)->first();

         // 指定された日付の履歴を取得（単一レコードを取得）
         $dailylogs = Dailylog::where('user_id', $user_id)
             ->whereDate('input_date', $date)
             ->get(); // get() ではなく firstOrFail() に変更し、単一のデータを取得

         // 栄養カテゴリとサブカテゴリを取得
         $categories = Category::all(); // 例: 全カテゴリ取得
         $sub_categories = SubCategory::all(); // 例: 全サブカテゴリ取得
         //dd($dailylogs);

         $radarChartData = $this->ChartsService->showpfcvm($user_id, $date, $date);

         $satisfactionRates = $radarChartData['satisfactionRates'] ?? [];

         //dd($satisfactionRates);
         $message = $radarChartData['message'] ?? null;

         return view('users.dailylog', compact('user', 'dailylogs', 'date', 'categories', 'sub_categories','satisfactionRates','user_profile'));
     }

     public function getEvents($id)
{
    $dailyLogs = DailyLog::where('user_id', $id)->get(['meal_type', 'meal_content', 'input_date']);

    $mealShortNames = [
        'Breakfast' => 'B',
        'Lunch' => 'L',
        'Dinner' => 'D',
        'Other' => 'O'
    ];

    $mealColors = [
        'Breakfast' => '#FFA07A', // Light Salmon 🟥
        'Lunch' => '#98FB98', // Pale Green 🟩
        'Dinner' => '#87CEFA', // Light Sky Blue 🟦
        'Other' => '#FFD700' // Gold 🟨
    ];

    $events = $dailyLogs->map(function ($log) use ($mealColors) {
        $shortTitle = $mealShortNames[$log->meal_type] ?? 'O'; // デフォルトで 'O' にする
        return [
            'title' => $log->meal_type . ': ' . $log->meal_content, // ここを統一
            'start' => $log->input_date,
            'backgroundColor' => $mealColors[$log->meal_type] ?? '#808080',
            'borderColor' => $mealColors[$log->meal_type] ?? '#808080',
            'textColor' => '#fff',
            'mealOrder' => array_search($shortTitle, ['B', 'L', 'D', 'O']) // ソート用
        ];
    });

    $sortedEvents = $events->sortBy('mealOrder')->values();

    return response()->json($sortedEvents);
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyLog $dailyLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailyLog $dailyLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyLog $dailyLog)
    {
        //
    }
}
