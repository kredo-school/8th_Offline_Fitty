<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nutritionist;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
        //
    }

    public function showdailylog()
    {
        return view('users.dailylog');
    }

    public function showinputmeal()
    {
        return view('users.inputmeal');
    }

    public function profile()
    {
        $user = $this->user->where('id', 1)->first();

        return view('users.profile',compact('user'));
    }
    public function editprofile()
    {
        return view('users.editprofile');
    }
    public function showhistory()
    {
        return view('users.history');
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
