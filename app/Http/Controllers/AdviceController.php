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



    function history($id){
        $user = $this->user->findOrFail($id);

        return view('nutritionists.history')->with('user', $user);
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
