<?php

namespace App\Http\Controllers;

use App\Models\Nutritionist;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class NutritionistController extends Controller
{
    private $user;
    private $nutritionist;

    public function __construct(Nutritionist $nutritionist, User $user)
    {
        $this->nutritionist = $nutritionist;
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 現在の栄養士（ログイン中の栄養士）を取得
        $nutritionist = $this->nutritionist->where('id', 1)->first();

        // 栄養士に関連するユーザー情報を取得
        //$user = $this->user->where('nutritionist_id', $nutritionist->id);
        $users = $this->user->where('nutritionist_id', 3)->get();

        // 栄養士とその関連ユーザー情報をビューに渡す
        return view('nutritionists.index', compact('nutritionist', 'users'));
    }


    function sendAdvice(){
        return view('nutritionists.sendAdvice');
    }


    function history(){
        return view('nutritionists.history');
    }

    function profile(){
        return view('nutritionists.profile');
    }
    function editprofile(){
        return view('nutritionists.editprofile');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Nutritionist $nutritionist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nutritionist $nutritionist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nutritionist $nutritionist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nutritionist $nutritionist)
    {
        //
    }
}
