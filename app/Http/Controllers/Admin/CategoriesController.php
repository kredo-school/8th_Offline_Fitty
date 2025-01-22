<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
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
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id' 
        ]);

        // カテゴリを作成
        // Category::create($request->all());
        return redirect()->route('admin.categories.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // 指定したカテゴリを更新
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return redirect()->route('admin.categories.index');
    }

    public function destroy($id)
    {
        // 指定したカテゴリを削除
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories.index');
    }
}
