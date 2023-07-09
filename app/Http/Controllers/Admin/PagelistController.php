<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PagelistController extends Controller
{

  public function index()
  {
    $pages = Page::all();
    return view('admin.pages.index', compact('pages'));
  }
  public function active(Request $request)
  {
    $page = Page::where('id', $request->id)->first();
    if ($page->status == 1) {
      $page->status = 0;
      $page->save();
    } else {
      $page->status = 1;
      $page->save();
    }
    return back()->with('success', 'Page Updated Successfully');
  }
}
