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
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($request->hasFile('profile_image')) {
            $filePath = $request->file('profile_image')->store('profile_images', 'public');
            $validatedData['avatar'] = $filePath;
        }

        $user = User::create([
            'name' => $validatedData['first_name'] . ' ' . $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'avatar' => $validatedData['avatar'] ?? 'default_avatar.png',
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

        // dd($userId);
        $validatedData = $request->validate([
            'dob' => 'required|date',
            'gender' => 'required|string',
            'height' => 'required|numeric|min:120|max:220',
            'exercise_frequency' => 'required|string',
            'health_conditions' => 'nullable|array',
            'dietary_preferences' => 'nullable|array',
            'food_allergies' => 'nullable|string',
            'goals' => 'nullable|string',
        ]);

        //  // ユーザーを取得
        // $user = User::find($userId);
        // if (!$user) {
        // return redirect()->route('register.step1')->with('error', 'User not found. Please restart registration.');
        // }

        // $userId = $request->session()->get('step1_user_id');

        $user = User::find($userId);

        // dd($user);
        // if ($user) {

            // $user->update([
            //     'birthday' => $validatedData['dob'],
            //     'gender' => $validatedData['gender'],
            //     'height' => $validatedData['height'],
            //     'activity_level' => $this->mapExerciseFrequency($validatedData['exercise_frequency']),
            //     'health_conditions' => json_encode($validatedData['health_conditions'] ?? []),
            //     'dietary_preferences' => json_encode($validatedData['dietary_preferences'] ?? []),
            //     'food_allergies' => $validatedData['food_allergies'] ?? null,
            //     'goals' => $validatedData['goals'] ?? null,
            // ]);
            $user = $this->user->findOrFail(Auth::user()->id);
            $user->birthday = $request->dob;
            $user->gender = $request->gender;
            $user->height = $request->height;
            $user->exercise_frequency = $request->exercise_frequency;
            $user->activity_level = $request->exercise_frequency;
            $user->health_conditions = json_encode($request->health_conditions ?? []);
            $user->dietary_preferences = json_encode($request->dietary_preferences ?? []);
            $user->food_allergies = $request->food_allergies ?? null;
            $user->goals = $request->goals ?? null;

            $user->save();

        // }

        return redirect()->route('home')->with('success', 'Registration completed successfully!');
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
