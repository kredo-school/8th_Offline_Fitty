<?php

namespace App\Http\Controllers;

use App\Models\Advice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use App\Models\DailyLog;
use App\Models\Category;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use App\Services\ChartsService; //ChartsServiceに処理を記載し共通化 omori




class AdviceController extends Controller
{
    private $advice;
    private $user_profile;
    private $dailylog;
    private $user;
    protected $ChartsService;



    public function __construct(Advice $advice, UserProfile $user_profile, DailyLog $dailylog, User $user, ChartsService $ChartsService)
    {
        $this->advice = $advice;
        $this->user_profile = $user_profile;
        $this->dailylog = $dailylog;
        $this->user = $user; // $userを初期化
        $this->ChartsService = $ChartsService;
    }



    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'overall' => 'required',
            'message' => 'required',
            'user_id' => 'required|exists:users,id'
        ]);

        // 保存するアドバイスのデータを設定
        $this->advice->nutritionist_id = Auth::user()->id;
        $this->advice->user_id = $request->user_id;
        $this->advice->overall = $request->overall;
        $this->advice->message = $request->message;

        // アドバイスを保存
        $this->advice->save();

        // user_profiles テーブルから該当するレコードを取得
        $userProfile = $this->user_profile->where('user_id', $request->user_id)->first();


        // 現在の日付をadvice_dateに保存
        $currentDate = Carbon::now()->toDateString(); // 'Y-m-d'形式で取得

        $userProfile->advice_sent_date = $currentDate;

        $userProfile->save();




        return redirect()->route('nutri.index')->with('success', 'Advice sent successfully!');
    }




    public function updateMemo(Request $request, $id)
    {
        // バリデーション：メモが1000文字以内であることを検証
        $request->validate([
            'memo' => 'nullable|string|max:1000',
        ]);

        try {
            // ユーザーのメモを更新
            $user_profile = $this->user_profile->findOrFail($id);
            $user_profile->nutritionist_memo = $request->memo;
            $user_profile->save();

            // JSON形式のレスポンスを返す
            return response()->json([
                'success' => true,
                'message' => 'Memo updated successfully!',
                'memo' => $user_profile->nutritionist_memo,
            ]);
        } catch (\Exception $e) {


            // エラーレスポンスを返す
            return response()->json([
                'success' => false,
                'message' => 'Failed to update memo. Please try again.',
            ], 500);
        }
    }




    public function history($user_id)
{
    $user_profile = $this->user_profile->where('user_id', $user_id)->first();
    $adviceList = $this->advice->where('user_id', $user_id)
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);  // ページネーションを追加

    return view('nutritionists.history')
        ->with('user_profile', $user_profile)
        ->with('adviceList', $adviceList);
}


    public function showHistory($user_id, Request $request)
    {
        $user_profile = $this->user_profile->where('user_id', $user_id)->first();

        $dailylog = $this->dailylog->where('user_id', $user_id)->first();


        // リクエストの日付でアドバイスを取得
        $adviceDate = $request->input('date');
        $advice = $this->advice->where('user_id', operator: $user_id)
            ->whereDate('created_at', $adviceDate)
            ->first();

        $radarChartData = $this->ChartsService->showpfcvm($user_id, "", $adviceDate); // 指定した日付の前日（2/14）から過去7日間（2/8〜2/14）のデータを取得

        // 必要に応じて radarChartData のデータを加工
        $satisfactionRates = $radarChartData['satisfactionRates'] ?? [];
        $message = $radarChartData['message'] ?? null;
        $categories = ['Carbohydrates', 'Proteins', 'Fats', 'Vitamins', 'Minerals'];
        $categoryData = [];

        foreach ($categories as $category) {
            $categoryData[$category] = $this->ChartsService->showCategory($user_id, $category, "", $adviceDate); // 指定した日付の前日（2/14）から過去7日間（2/8〜2/14）のデータを取得
        }

        return view('nutritionists.showHistory', compact(
            'user_profile',
            'satisfactionRates',
            'categoryData',
            'message',
            'dailylog',
            'advice'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advice $advice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advice $advice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advice $advice)
    {
        //
    }

    public function index($user_id,Request $request)
    {
        $user = User::findOrFail($user_id);

        // 指定されたユーザーIDに関連するアドバイスを取得
        $user = $this->user_profile->where('user_id', $user_id)->first();
        $adviceList = $this->advice->where('user_id', $user_id)->get();

        $query = $this->advice->query();

        $advices = $query->paginate(10);

        $filter = $request->query('filter', 'all'); // デフォルトは 'all'

            if ($filter === 'read') {
                $query->where('is_read', true);
            } elseif ($filter === 'unread') {
                $query->where('is_read', false);
            } elseif ($filter === 'liked') {
                $query->where('is_liked', true);
            } elseif ($filter === 'unliked') {
                $query->where('is_liked', false);
        }


        return view('users.advice_index', compact('user', 'adviceList','advices'));
    }


    public function showAdvice($id, $date)
    {
        $advice = $this->advice
            ->where('id', $id)
            ->firstOrFail();

        $user_profile = $advice->user->where('id', $advice->user_id)->first();
        // dd($user_profile);

        $dailylog = $this->dailylog->where('user_id', $advice->user_id)->first();
        // dd($dailylog);

        // showWeightメソッドを呼び出してグラフ用データを取得
        $weightData = $this->showWeight($advice->user_id, $date);

        $radarChartData = $this->ChartsService->showpfcvm($advice->user_id,"", $date); // 指定した日付の前日（2/14）から過去7日間（2/8〜2/14）のデータを取得

        // 必要に応じて radarChartData のデータを加工
        $satisfactionRates = $radarChartData['satisfactionRates'] ?? [];
        $message = $radarChartData['message'] ?? null;
        $categories = ['Carbohydrates', 'Proteins', 'Fats', 'Vitamins', 'Minerals'];
        $categoryData = [];


        return view('users.advice_show', compact(
            'advice',
            'satisfactionRates',
            'categoryData',
            'message',
            'dailylog',
            'weightData',
            'user_profile',

        ));
    }
    public function showWeight($id, $date)
    {
        $endDate = Carbon::parse($date)->subDay();
        $startDate = $endDate->copy()->subDays(6);

        // データを取得
        $dailyLogs = DailyLog::where('user_id', $id)
            ->whereBetween('input_date', [$startDate, $endDate])
            ->orderBy('input_date', 'asc')
            ->get();

        // グループ化して日ごとの平均を計算
        $groupedData = $dailyLogs->groupBy(function ($log) {
            return Carbon::parse($log->input_date)->format('Y-m-d'); // 日付だけ取得
        })->map(function ($logs) {
            return $logs->avg('weight'); // 体重の平均を計算
        });

        // グラフ用のデータに変換
        $averageDates = $groupedData->keys()->toArray();  // 日付ラベル
        $averageWeights = $groupedData->values()->toArray(); // 平均体重データ

        return [
            'dates' => $averageDates, // 修正: 日ごとのラベル
            'weights' => $averageWeights, // 修正: 平均体重
            'message' => $dailyLogs->isEmpty() ? 'No data available.' : null
        ];
    }


    public function readToggle($id, $adviceId)
    {
        \Log::info("readToggle method called with id: {$id}, adviceId: {$adviceId}");

        $advice = Advice::findOrFail($adviceId);

        $advice->is_read = 1;
        $advice->save();

        \Log::info("Advice read status changed", ['advice_id' => $adviceId, 'new_status' => $advice->is_read]);

        return redirect()->back()->with('success', 'Read status updated');
    }

    public function unread($id, $adviceId)
    {
        \Log::info("unread method called with id: {$id}, adviceId: {$adviceId}");

        $advice = Advice::findOrFail($adviceId);

        $advice->is_read = 0;
        $advice->save();

        \Log::info("Advice read status removed", ['advice_id' => $adviceId]);

        return redirect()->back()->with('success', 'Read status removed');
    }

    public function likeToggle($id, $adviceId)
    {
        \Log::info("likeToggle method called with id: {$id}, adviceId: {$adviceId}");

        $advice = Advice::findOrFail($adviceId);

        $advice->is_liked = 1;
        $advice->save();

        \Log::info("Advice like status changed", ['advice_id' => $adviceId, 'new_status' => $advice->is_liked]);

        return redirect()->back()->with('success', 'Like status updated');
    }

    public function unlike($id, $adviceId)
    {
        \Log::info("unlike method called with id: {$id}, adviceId: {$adviceId}");

        $advice = Advice::findOrFail($adviceId);

        $advice->is_liked = 0;
        $advice->save();

        \Log::info("Advice like status removed", ['advice_id' => $adviceId]);

        return redirect()->back()->with('success', 'Like status removed');
    }

}
