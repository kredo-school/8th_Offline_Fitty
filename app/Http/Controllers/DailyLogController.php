<?php

namespace App\Http\Controllers;

use App\Models\DailyLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Nutritionist;
use App\Models\User;

class DailyLogController extends Controller
{

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
        //
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
