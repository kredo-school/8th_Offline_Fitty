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
    $inquiries = Inquiry::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('person_in_charge', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('admin.inquiries.index', compact('inquiries', 'search'));
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
