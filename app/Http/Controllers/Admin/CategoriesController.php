<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;

class CategoriesController extends Controller
{
    private $category;
    private $subcategory;

    public function __construct(Category $category, SubCategory $subcategory)
    {
        $this->category = $category;
        $this->subcategory = $subcategory;
    }

    public function index()
    {
        // データを取得 (子カテゴリも含む)
        $categories = $this->category->get();
        return view('admin.categories.index')->with('categories', $categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|max:50|unique:categories,name',
            'category_id' => 'required|exists:categories,id', 
    ]);

        $this->subcategory->name = $request->name;
        $this->subcategory->category_id = $request->category_id; 
        $this->subcategory->save();

        return redirect()->back();
    }


    public function update(Request $request, $Subcategory_id)
{
    // リクエストのバリデーション
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    // サブカテゴリーを取得
    $category = SubCategory::findOrFail($Subcategory_id);

    // 一括更新
    $category->update($validatedData);

    return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
}

    

    public function destroy($Subcategory_id)
    {
        // 指定したカテゴリを削除
        $category = SubCategory::findOrFail($Subcategory_id);
        $category->delete();
        return redirect()->route('admin.categories.index');
    }
}
