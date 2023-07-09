<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blog = Blog::all();
        return view('admin.blog.index', compact('blog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'       => 'required', 'max:100','unique:blogs',
            'image'       => 'required|max:1024||Image|mimes:jpg,png,jpeg,bmp',
            'date'        => 'required',
            'description' => 'required',
            'ip_address'  => 'max:15'
        ]);
        $slug = Str::slug($request->title . '-');

        $blog               = new Blog();
        $blog->title        = $request->title;
        $blog->slug         = $slug;
        $blog->description  = $request->description;
        $blog->date         = $request->date;
        $blog->image        = $this->imageUpload($request, 'image', 'uploads/blog');
        $blog->save_by      = Auth::user()->id;
        $blog->ip_address   = $request->ip();
        $blog->save();

        if ($blog) {
            return back()->with('success', 'News and Event added successfully');
        } else {
            return back()->with('error', 'News And Event added Faild');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::where('id', $id)->first();
        return view('admin.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'title'       => 'required', 'max:100',
            'image'       => 'max:1024||Image|mimes:jpg,png,jpeg,bmp',
            'date'        => 'required',
            'description' => 'required',
            'ip_address'  => 'max:15'
        ]);
        $blog = Blog::find($id);

        $Image = '';
        if ($request->hasFile('image')) {
            if (!empty($blog->image) && file_exists($blog->image)) {
                unlink($blog->image);
            }
            $Image = $this->imageUpload($request, 'image', 'uploads/blog');
        } else {
            $Image = $blog->image;
        }

        $blog->title        = $request->title;
        $blog->description  = $request->description;
        $blog->date         = $request->date;
        $blog->image        = $Image;
        $blog->updated_by   = Auth::user()->id;
        $blog->ip_address   = $request->ip();
        $blog->save();
        if ($blog) {
            return redirect()->route('blog.index')->with('success', 'Blog updated successfully');
        } else {
            return redirect()->bacK()->with('error', 'Fail updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::where('id', $id)->first();
        if ($blog->image) {
            @unlink($blog->image);
        }
        $blog->delete();
        return redirect()->route('blog.index')->with('success', 'Blog Deleted Successfully');
    }
}
