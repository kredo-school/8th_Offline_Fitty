<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{

    public function index()
    {
        return view('admin.categories.index');
    }
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'parent_id' => 'nullable|exists:categories,id'
    //     ]);

    //     Category::create($request->all());
    //     return redirect()->route('admin.categories.index');
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //     ]);

    //     $category = Category::findOrFail($id);
    //     $category->update($request->all());
    //     return redirect()->route('admin.categories.index');
    // }

    // public function destroy($id)
    // {
    //     $category = Category::findOrFail($id);
    //     $category->delete();
    //     return redirect()->route('admin.categories.index');
    // }



