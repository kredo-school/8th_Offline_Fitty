<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(10); // ページネーションで10件ずつ表示
        return view('admin.users.index', compact('users'));
    }
    public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
}

}


