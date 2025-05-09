<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TagController extends Controller
{
    public function tag(){
        $tags = Tag::paginate(10);
        return view('admin.tag.index',[
            'tags'=>$tags,
        ]);
    }
    public function tag_store(Request $request){
        $request->validate([
            'tag_name' => 'required|unique:tags'
        ]);
        Tag::insert([
            'tag_name' => $request->tag_name,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('tag_add', "This Tag add Successfully!");
    }
}
