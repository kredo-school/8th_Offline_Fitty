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
        $categories = $this->category->with('subcategory')->get();  // 子カテゴリも一括取得
        return view('admin.categories.index')->with('categories', $categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|max:50|unique:sub_categories,name',
            'category_id' => 'required|exists:categories,id',
            'requirement' => 'required|numeric|min:0',  // requirementのバリデーションを追加
        ]);

        // 新しいサブカテゴリを保存
        $this->subcategory->name = $request->name;
        $this->subcategory->category_id = $request->category_id;
        $this->subcategory->requirement = $request->requirement;  // requirementを保存
        $this->subcategory->save();

        return redirect()->back()->with('success', 'Subcategory added successfully!');
    }

    public function update(Request $request, $subcategory_id)
{
    // バリデーション
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'requirement' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
    ]);

    // サブカテゴリーの取得と更新
    $subcategory = SubCategory::findOrFail($subcategory_id);

    // 必要なプロパティを更新
    $subcategory->update([
        'name' => $validatedData['name'],
        'requirement' => $validatedData['requirement'],
        'category_id' => $validatedData['category_id'],  // メインカテゴリーを更新
    ]);

    // 編集後のメインカテゴリーへリダイレクト
    return redirect()->route('admin.categories.index', ['highlighted_category' => $validatedData['category_id']])
                     ->with('success', 'Subcategory updated successfully!');
}




    public function destroy($Subcategory_id)
    {
        // 指定したサブカテゴリを削除
        $subcategory = SubCategory::findOrFail($Subcategory_id);
        $subcategory->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Subcategory deleted successfully!');
    }
}
