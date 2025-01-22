<?php

namespace App\Http\Controllers;

use App\Models\Advice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;



class AdviceController extends Controller
{
    private $advice;
    private $user_profile;

    public function __construct(Advice $advice, UserProfile $user_profile)
    {
        $this->advice = $advice;
        $this->user_profile = $user_profile;
    }



    /**
     * Store a newly created resource in storage.
     */
    function store(Request $request){
        // dd('test');
        $request->validate([
            'overall'      => 'required',
            'message'     => 'required',
            'user_id'   => 'required|exists:users,id'

        ]);

        $this->advice->nutritionist_id = Auth::user()->id;
        $this->advice->user_id = $request->user_id;
        $this->advice->overall = $request->overall;
        $this->advice->message = $request->message;

        $this->advice->save();

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




    function history($id){
        $user_profile = $this->user_profile->findOrFail($id);
        

        return view('nutritionists.history')->with('user_profile', $user_profile);
    }
    /**
     * Display the specified resource.
     */
    public function show(Advice $advice)
    {
        //
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
}
