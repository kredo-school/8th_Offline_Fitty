<?php

namespace App\Http\Controllers;

use App\Models\Nutritionist;
use Illuminate\Http\Request;

class NutritionistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function index(){
        
        return view('nutritionists.index');
    }


    function sendAdvice(){
        return view('nutritionists.sendAdvice');
    }


    function history(){
        return view('nutritionists.history');
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
