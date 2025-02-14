<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiriesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $category = $request->get('category', '');
        $status = $request->get('status', '');

        $inquiries = Inquiry::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhere('person_in_charge', 'like', "%{$search}%");
                });
            })
            ->when($category, function ($query, $category) {
                $query->where('category', $category);
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends([
                'search' => $search,
                'category' => $category,
                'status' => $status
            ]);

        $categories = Inquiry::select('category')->distinct()->pluck('category');
        $statuses = Inquiry::select('status')->distinct()->pluck('status');

        return view('admin.inquiries.index', compact('inquiries', 'search', 'category', 'status', 'categories', 'statuses'));
    }






    public function show($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function update(Request $request, $id)
    {
        Inquiry::where('id', $id)->update([
            'status' => $request->status,
            'memo' => $request->memo,
            'person_in_charge' => $request->person_in_charge, // 🔹 ここを追加
        ]);

        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry updated successfully.');
    }

    public function destroy($id)
    {
        Inquiry::destroy($id);
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }
}
