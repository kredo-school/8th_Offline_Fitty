<?php

namespace App\Http\Controllers;

use App\Models\Advice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;



class AdviceController extends Controller
{
    private $advice;
    private $user;

    public function __construct(Advice $advice, User $user)
    {
        $this->advice = $advice;
        $this->user = $user;
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
        $this->advice->user_id = $request->user_id;;

        $this->advice->overall = $request->overall;
        $this->advice->message = $request->message;


        $this->advice->save();

        return redirect()->route('nutri.index')->with('success', 'Advice sent successfully!');


    }


public function updateMemo(Request $request, $id)
    {
        // メモが空でないかを検証
        $request->validate([
            'memo' => 'max:1000',
        ]);

        // ユーザーのメモを更新
        $user = $this->user->findOrFail($id);
        $user->nutritionist_memo = $request->memo;
        $user->save();

        return redirect()->back()->with('success', 'Memo updated successfully!');
    }



    function history($id){
        $user = $this->user->findOrFail($id);

        return view('nutritionists.history')->with('user', $user);
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

    public function index($id)
    {
        // 指定されたユーザーIDに関連するアドバイスを取得
        $user = $this->user->findOrFail($id);
        $adviceList = $this->advice->where('user_id', $id)->get();

        return view('users.advice_index', compact('user', 'adviceList'));
    }

    public function show($id, $adviceId)
    {
        // 指定されたアドバイスを取得
        $user = $this->user->findOrFail($id);
        $advice = $this->advice->where('id', $adviceId)->where('user_id', $id)->firstOrFail();

        return view('users.advice.show', compact('user', 'advice'));
    }

}
