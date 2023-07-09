<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function index()
    {
        $pages = Page::latest()->get();
        return view('admin.pagelist.index', compact('pages'));
    }
    public function store(Request $request)
    {
        $page = new Page();
        $page->name = $request->name;
        $page->url = $request->url;
        $page->save();
        return back()->with('success', 'Page Created Successfully');
    }
}
