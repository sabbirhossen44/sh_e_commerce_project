<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = Faq::all();
        return view('admin.faq.index',[
            'faqs' => $faqs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faq.store');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);
        Faq::insert([
            'question' => $request->question,
            'answer' => $request->answer,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('success', 'Faq Added Successful!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        // $faq = Faq::find($faq);
        // return $faq_id;
        return view('admin.faq.edit',[
            'faq' => $faq,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);
        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'updated_at' => Carbon::now(),

        ]);
        return back()->with('success', 'Faq Updated Successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return back()->with('success', 'FAQ Delete Successfully!');
    }
}
