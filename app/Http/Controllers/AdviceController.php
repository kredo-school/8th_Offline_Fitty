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





    function sendAdvice($user_id)
    {
        $user_profile = $this->user_profile->where('user_id', $user_id)->first();

        // 本日の日付を取得
        $date = Carbon::today();

        $user = $this->user_profile->where('user_id', $user_id)->first();


        // 昨日の日付（今日の前日）
        $endDate = $date->copy()->subDay(); // 2/17

        // 1週間前の日付（昨日から過去1週間）
        $startDate = $endDate->copy()->subDays(6); // 2/11

        // 指定した期間のデータを取得
        $dailylogs = $this->dailylog
            ->where('user_id', $user_id)
            ->whereBetween('input_date', [$startDate, $endDate])
            ->orderBy('input_date', 'asc')
            ->get();



         // 栄養カテゴリとサブカテゴリを取得
         $categories = Category::all(); // 例: 全カテゴリ取得
         //dd($categories);
         $sub_categories = SubCategory::all(); // 例: 全サブカテゴリ取得

         $weightData = $this->showWeight($user_id, $date);

        $radarChartData = $this->ChartsService->showpfcvm($user_id); //ChartsServiceに処理を記載し共通化 omori

        $satisfactionRates = $radarChartData['satisfactionRates'] ?? [];
        $message = $radarChartData['message'] ?? null;
        //$categories = ['Carbohydrates', 'Protein', 'Fat', 'Vitamins', 'Minerals'];
        $categoryData = [];

        foreach ($categories as $category) {
            $categoryData[$category->name] = $this->ChartsService->showCategory($user_id, $category->name);
        }

        return view('nutritionists.sendAdvice', compact('user_profile', 'satisfactionRates', 'categoryData', 'message', 'categories','dailylogs','date','user','weightData'));
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

        $date = Carbon::createFromFormat('Y-m-d', $request->input('date'));

        // 昨日の日付（今日の前日）
        $endDate = $date->copy()->subDay(); // 2/17

        // 1週間前の日付（昨日から過去1週間）
        $startDate = $endDate->copy()->subDays(6); // 2/11

        // 指定した期間のデータを取得
        $dailylogs = $this->dailylog
            ->where('user_id', $user_id)
            ->whereBetween('input_date', [$startDate, $endDate])
            ->orderBy('input_date', 'asc')
            ->get();


        // リクエストの日付でアドバイスを取得
        $adviceDate = $request->input('date');
        $advice = $this->advice->where('user_id', operator: $user_id)
            ->whereDate('created_at', $adviceDate)
            ->first();

        $radarChartData = $this->ChartsService->showpfcvm($user_id, "", $adviceDate); // 指定した日付の前日（2/14）から過去7日間（2/8〜2/14）のデータを取得

        // 必要に応じて radarChartData のデータを加工
        $satisfactionRates = $radarChartData['satisfactionRates'] ?? [];
        $message = $radarChartData['message'] ?? null;
        $chart_categories = ['Carbohydrates', 'Protein', 'Fat', 'Vitamins', 'Minerals'];
        // 栄養カテゴリとサブカテゴリを取得
        $categories = Category::all(); // 例: 全カテゴリ取得
        //dd($categories);
        $sub_categories = SubCategory::all(); // 例: 全サブカテゴリ取得
        $categoryData = [];

        foreach ($chart_categories as $category) {
            $categoryData[$category] = $this->ChartsService->showCategory($user_id, $category, "", $adviceDate); // 指定した日付の前日（2/14）から過去7日間（2/8〜2/14）のデータを取得
        }

        return view('nutritionists.showHistory', compact(
            'user_profile',
            'satisfactionRates',
            'categoryData',
            'message',
            'dailylogs',
            'categories',
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

    public function index($user_id, Request $request)
    {
        $user = User::findOrFail($user_id);

        // 指定されたユーザーIDに関連するアドバイスを取得
        $adviceList = $this->advice->where('user_id', $user_id)->get();

        $query = Advice::where('user_id', $user_id);

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

        // ページネーションを適用（`appends()` を使って `filter` を保持）
        $advices = $query->orderBy('created_at', 'desc')->paginate(10)->appends(['filter' => $filter]);

        return view('users.advice_index', compact('user', 'adviceList', 'advices', 'filter'));
    }


    public function showAdvice($advice_id)
    {
        $advice = $this->advice
            ->where('id', $advice_id)
            ->firstOrFail();

        //advice詳細にアクセスしたら既読 omori
        $advice->is_read = 1;
        $advice->save();

        $user = $advice->user_id;
        $date = $advice->created_at;

        $user_profile = $advice->user->where('id', $advice->user_id)->first();
        // dd($user_profile);

        $dailylog = $this->dailylog->where('user_id', $advice->user_id)->first();
        // dd($dailylog);

        // showWeightメソッドを呼び出してグラフ用データを取得
        $weightData = $this->showWeight($advice->user_id, $date);

        $radarChartData = $this->ChartsService->showpfcvm($advice->user_id, "", $date); // 指定した日付の前日（2/14）から過去7日間（2/8〜2/14）のデータを取得

        // 必要に応じて radarChartData のデータを加工
        $satisfactionRates = $radarChartData['satisfactionRates'] ?? [];
        $message = $radarChartData['message'] ?? null;
        $categories = ['Carbohydrates', 'Protein', 'Fat', 'Vitamins', 'Minerals'];
        $categoryData = [];


        return view('users.advice_show', compact(
            'advice',
            'satisfactionRates',
            'categoryData',
            'message',
            'dailylog',
            'weightData',
            'user_profile',
            'user'
        ));
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
