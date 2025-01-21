<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\DailyLog;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;



class NutritionistController extends Controller
{
    private $user;
    private $user_profile;
    private $dailylog;

    public function __construct(User $user, UserProfile $user_profile, DailyLog $dailylog)
    {
        $this->user = $user;
        $this->user_profile = $user_profile;
        $this->dailylog = $dailylog;

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // 栄養士に関連するユーザー情報を取得
        $user_profiles = $this->user_profile->where('nutritionist_id', Auth::user()->id)->get();

        // 栄養士とその関連ユーザー情報をビューに渡す
        return view('nutritionists.index', compact('user_profiles'));
    }


    function sendAdvice($id)
    {

        $user_profile = $this->user_profile->where('user_id', $id)->first();
        $dailylog = $this->dailylog->where('user_id', $id)->first();

        $radarChartData = $this->showpfcvm($id);

        // 必要に応じて radarChartData のデータを加工
        $satisfactionRates = $radarChartData['satisfactionRates'] ?? [];
        $message = $radarChartData['message'] ?? null;


        return view('nutritionists.sendAdvice', compact('user_profile', 'satisfactionRates', 'message'));
    }

    public function showpfcvm($id)
    {
        $user_prolile = User::find($id);

        if (!$user_prolile) {
            return [
                'satisfactionRates' => [],
                'message' => 'User not found.',
            ];
        }

        $endDate = Carbon::yesterday();
        $startDate = $endDate->copy()->subDays(6);
        $dailyLogs = DailyLog::where('user_id', $id)
            ->whereBetween('input_date', [$startDate, $endDate])
            ->get();

        if ($dailyLogs->isEmpty()) {
            return [
                'satisfactionRates' => [],
                'message' => 'No data available for the last 7 days for this user.',
            ];
        }

        $weight = $dailyLogs->first()->weight;
        $recommendedValues = [
            "Carbohydrates" => $weight * 5 * 7,
            "Fats" => $weight * 1.0 * 7,
            "Proteins" => $weight * 1.2 * 7,
            "Vitamins" => $weight * 2 * 7,
            "Minerals" => $weight * 10 * 7,
        ];

        $actualValues = [];
        foreach ($dailyLogs as $log) {
            $nutritions = json_decode($log->nutritions, true);
            foreach ($nutritions as $key => $value) {
                $numericValue = (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                $actualValues[$key] = ($actualValues[$key] ?? 0) + $numericValue;
            }
        }

        // キー名を統一する処理を追加
        $actualValues = [
            "Proteins" => $actualValues["Protein"] ?? 0,
            "Fats" => $actualValues["Fat"] ?? 0,
            "Carbohydrates" => $actualValues["Carbohydrates"] ?? 0,
            "Vitamins" => $actualValues["Vitamins"] ?? 0,
            "Minerals" => $actualValues["Minerals"] ?? 0,
        ];

        $satisfactionRates = [];
        foreach ($recommendedValues as $key => $recommended) {
            $actual = $actualValues[$key] ?? 0;
            $satisfactionRates[$key] = round(($actual / $recommended) * 100, 1);
        }

        return [
            'satisfactionRates' => $satisfactionRates,
            'message' => null,
            'user_profile' => $user_prolile
        ];
    }







    function profile()
    {
        return view('nutritionists.profile');
    }
    function editprofile()
    {
        return view('nutritionists.editprofile');
    }

    /**
     * Show the form for creating a new resource.
     */

}
