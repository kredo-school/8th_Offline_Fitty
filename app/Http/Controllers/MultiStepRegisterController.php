<?php

namespace App\Http\Controllers;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class MultiStepRegisterController extends Controller
{

    private $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function showStep1()
    {
        return view('auth.register-step1');
    }

    public function processStep1(Request $request)
    {
        $validatedData = $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        dd($validatedData['avatar']);

        if ($request->hasFile('avatar')) {
            $filePath = $request->file('avatar')->store('avatar', 'public');
            $validatedData['avatar'] = $filePath;
        }

        $user = User::create([
            'avatar' => $validatedData['avatar'] ?? 'default_avatar.png',
            'name' => $validatedData['name'] ,
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),        
        ]);

        // 空のプロファイルを作成
        $user->profile()->create([
            'first_name' => '', // 空文字またはデフォルト値
            'last_name' => '',  // 空文字またはデフォルト値
        ]);
        

        Auth::login($user);
        
        $request->session()->put('step1_user_id', $user->id);

        return redirect()->route('register.step2');

    }


    public function showStep2()
    {
        return view('auth.register-step2');
    }

    public function processStep2(Request $request)
    {

        // セッションからユーザーIDを取得
        $userId = $request->session()->get('step1_user_id');
        if (!$userId) {
        // セッションにデータがない場合、ステップ1にリダイレクト
            return redirect()->route('register.step1')->with('error', 'Step 1 is incomplete.');
        }

        $user = User::find($userId);
        // dd($userId);
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string',
            'height' => 'required|numeric|min:120|max:220',
            'activity_level' => 'required|string',
            'health_conditions' => 'nullable|array',
            'dietary_preferences' => 'nullable|array',
            'food_allergies' => 'nullable|string',
            'goals' => 'nullable|string',
        ]);

        // プロファイルを取得または新規作成
        $profile = $user->profile()->firstOrNew([]);
        $profile->user_id = $user->id;
        $profile->first_name = $request->first_name;
        $profile->last_name = $request->last_name;
        $profile->birthday = $request->dob;
        $profile->gender = $request->gender;
        $profile->height = $request->height;
        $profile->activity_level = $this->mapExerciseFrequency($request->activity_level);
        $profile->health_conditions = json_encode($request->health_conditions ?? []);
        $profile->dietary_preferences = json_encode($request->dietary_preferences ?? []);
        $profile->food_allergies = $request->food_allergies ?? null;
        $profile->goals = $request->goals ?? null;

        $profile->save();

        // セッションデータを削除してリダイレクト
        $request->session()->forget('step1_user_id');

        return redirect()->route('user.profile')->with('success', 'Registration completed successfully!');
    }

    // Exercise Frequencyをactivity_levelにマッピングする補助メソッド
    private function mapExerciseFrequency($frequency)
    {
        switch ($frequency) {
            case 'Level_1': return 1;
            case 'Level_2': return 2;
            case 'Level_3': return 3;
            default: return 0;
        }
    }

}
