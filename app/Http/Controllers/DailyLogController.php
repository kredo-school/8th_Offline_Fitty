<?php

namespace App\Http\Controllers;

use App\Models\DailyLog;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class DailyLogController extends Controller
{

    private $dailylog;

    public function __construct(dailylog $dailylog)
    {
        $this->dailylog = $dailylog;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // バリデーション
        $request->validate([
            'input_date' => 'required|date',
            'meal_type' => 'required|string',
            'meal_content' => 'nullable|string',
            'comment' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 現在の認証ユーザーのIDを取得して設定
        $this->dailylog->user_id = Auth::id();

        // データを設定
        $this->dailylog->input_date = $request->input('input_date');
        $this->dailylog->meal_type = $request->input('meal_type');
        $this->dailylog->meal_content = $request->input('meal_content');
        $this->dailylog->comment = $request->input('comment');

        if($request->image){
            $this->dailylog->image = 'data:image/' . $request->image->extension() .
            ';base64,' . base64_encode(file_get_contents($request->image));
        }

        // データベースに保存
        $this->dailylog->save();

        // リダイレクト
        return redirect()->route('user.profile',Auth::id());
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyLog $dailyLog)
    {
        //
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
