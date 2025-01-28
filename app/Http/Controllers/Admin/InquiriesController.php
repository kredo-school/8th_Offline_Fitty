<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry; // 修正: 正しいInquiryモデルをインポート
use Illuminate\Http\Request;

class InquiriesController extends Controller
{
    /**
     * 問い合わせの一覧表示
     */
    public function index(Request $request)
    {
        // 検索条件の取得
        $search = $request->get('search', '');

        // 問い合わせの取得（検索条件がある場合はフィルタリング）
        $inquiries = Inquiry::when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%");
            })
            ->orderBy('submission_date', 'desc') // 提出日でソート
            ->paginate(10);

        // ビューにデータを渡す
        return view('admin.inquiries.index', compact('inquiries', 'search'));
    }

    /**
     * 問い合わせの削除
     */
    public function destroy($id)
    {
        // 該当する問い合わせを削除
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->delete();

        // リダイレクトしてメッセージを表示
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }
}
