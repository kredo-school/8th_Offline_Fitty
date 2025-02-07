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
        $one_week_ago = now()->subWeek();

        // 栄養士に関連するユーザー情報を取得（advice_sent_dateが一週間前よりも前のデータを取得）
        $user_profiles = $this->user_profile
            ->where('nutritionist_id', Auth::user()->id)
            ->where(function ($query) use ($one_week_ago) {
                $query->where('advice_sent_date', '<', $one_week_ago)
                    ->orWhereNull('advice_sent_date'); // advice_sent_dateがnullの場合も含める
            })
            ->get();
        return view('nutritionists.index', compact('user_profiles'));
    }



    function sendAdvice($user_id)
    {
        $user_profile = $this->user_profile->where('user_id', $user_id)->first();
        $dailylog = $this->dailylog->where('user_id', $user_id)->first();
        $radarChartData = $this->showpfcvm($user_id);

        $satisfactionRates = $radarChartData['satisfactionRates'] ?? [];
        $message = $radarChartData['message'] ?? null;
        $categories = ['Carbohydrates', 'Proteins', 'Fats', 'Vitamins', 'Minerals'];
        $categoryData = [];

        foreach ($categories as $category) {
            $categoryData[$category] = $this->showCategory($user_id, $category);
        }

        return view('nutritionists.sendAdvice', compact('user_profile', 'satisfactionRates', 'categoryData', 'message', 'categories'));
    }

    public function showpfcvm($user_id)
    {
        $user_profile = $this->user_profile->where('user_id', $user_id)->first();

        if (!$user_profile) {
            return [
                'satisfactionRates' => [],
                'message' => 'User not found.',
            ];
        }

        $endDate = Carbon::yesterday();
        $startDate = $endDate->copy()->subDays(6);
        $dailyLogs = DailyLog::where('user_id', $user_id)
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
            $satisfactionRates[$key] = $recommended > 0 ? round(($actual / $recommended) * 100, 1) : 0;
        }

        return [
            'satisfactionRates' => $satisfactionRates,
            'message' => null,
            'user_profile' => $user_profile,
        ];
    }

    public function showCategory($user_id, $category)
    {
        // ユーザー情報を取得
        $user_profile = $this->user_profile->where('user_id', $user_id)->first();

        if (!$user_profile) {
            return [
                'subCategoryRates' => [],
                'message' => 'User not found.',
            ];
        }

        // 1週間分のデータを取得
        $endDate = Carbon::yesterday();
        $startDate = $endDate->copy()->subDays(6);

        $dailyLogs = DailyLog::where('user_id', $user_id)
            ->whereBetween('input_date', [$startDate, $endDate])
            ->get();

        if ($dailyLogs->isEmpty()) {
            return [
                'subCategoryRates' => [],
                'message' => 'No data available for the last 7 days for this user.',
            ];
        }

        $weight = (float) $dailyLogs->first()->weight ?? 70; // デフォルト体重もfloatに


        // 指定されたカテゴリーのサブカテゴリを取得
        $categoryModel = Category::with('subcategory')->where('name', $category)->first();

        if (!$categoryModel) {
            return [
                'subCategoryRates' => [],
                'message' => 'Category not found.',
            ];
        }

        $subcategories = $categoryModel->subcategory;

        $subCategoryTotals = [];
        $subCategoryRecommended = [];

        foreach ($dailyLogs as $log) {
            // JSONデータを正規化
            $nutritions = json_decode($log->nutritions, true);
            // dd($nutritions);
            $normalizedNutritions = $this->normalizeToMg($nutritions);
            // dd($normalizedNutritions);

            if (!isset($normalizedNutritions['Subcategories'])) {
                continue;
            }

            $subCategoryRecommended = []; // 初期化


            // JSON内のSubcategoriesキーに基づいてデータを処理
            foreach ($subcategories as $subcategory) {
                $subCategoryName = $subcategory->name;

                // 実際の値がJSONに存在するか確認
                if (!isset($normalizedNutritions['Subcategories'][$subCategoryName])) {
                    continue;
                }

                $numericValue = $normalizedNutritions['Subcategories'][$subCategoryName];

                // 実績値を加算
                $subCategoryTotals[$subCategoryName] = ($subCategoryTotals[$subCategoryName] ?? 0) + $numericValue;

                // 推奨値を取得
                $requirement = (float) $this->getSubcategoryRequirementFromDB($subCategoryName);

                // 推奨値を単純に設定 (繰り返し加算しない)
                $subCategoryRecommended[$subCategoryName] = $requirement * $weight * 7;
            }

        }

        // サブカテゴリーごとの充足率を計算
        $subCategoryRates = [];
        foreach ($subCategoryRecommended as $subCategoryName => $recommended) {
            $actual = $subCategoryTotals[$subCategoryName] ?? 0;
            $subCategoryRates[$subCategoryName] = $recommended > 0 ? round(($actual / $recommended) * 100, 1) : 0;
        }
        // dd([
        //     'Subcategory' => $subCategoryName,
        //     'Requirement per Day (mg/kg)' => $requirement,
        //     'Weight (kg)' => $weight,
        //     'Weekly Requirement (mg)' => $requirement * $weight * 7,
        //     'subCategoryRecommended' => $subCategoryRecommended, // 現在の全体状況
        // ]);

        // dd([
        //     'Subcategory' => $subCategoryName,
        //     'Actual Value (mg)' => $actual, // 実績値
        //     'Recommended Value (mg)' => $recommended, // 推奨値
        //     'Satisfaction Rate (%)' => $subCategoryRates[$subCategoryName] // 充足率
        // ]);

        return [
            'subCategoryRates' => $subCategoryRates,
            'message' => empty($subCategoryRates) ? 'No subcategories found for this category.' : null,
        ];
    }



    private function getSubcategoryRequirementFromDB($subCategoryName)
    {
        // サブカテゴリーの`requirement`を取得し、float型に変換
        $requirement = (float) SubCategory::where('name', $subCategoryName)->value('requirement');

        return $requirement;
    }


    private function normalizeToMg($nutritions)
    {
        $normalized = [];

        foreach ($nutritions as $key => $value) {
            // Subcategoriesの処理を分ける
            if ($key === 'Subcategories' && is_array($value)) {
                $normalized['Subcategories'] = $this->normalizeToMg($value);
                continue;
            }

            // 数値部分を取得
            $numericValue = (float) filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

            // 単位を取得（g, µg, mg）
            $unit = strtolower(preg_replace('/[0-9\.\s]+/', '', $value)); // 数値部分を取り除く

            // 単位に応じた変換
            switch ($unit) {
                case 'g': // グラムをmgに変換
                    $normalized[$key] = $numericValue * 1000;
                    break;
                case 'µg': // マイクログラムをmgに変換
                    $normalized[$key] = $numericValue / 1000;
                    break;
                case 'mg': // mgはそのまま
                default:
                    $normalized[$key] = $numericValue;
                    break;
            }



        }

        return $normalized;
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
