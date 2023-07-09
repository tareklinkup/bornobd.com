<?php

namespace App\Http\Controllers\Admin;

use App\Models\VideoGallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Support\Facades\Session;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $video = VideoGallery::latest()->get();
        return view('admin.video.index', compact('video'));
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
        $request->validate([
            'title' => 'required|string|max:120',
            'youtube_link' => 'required|string',
            'ip_address' => 'max:15'
        ]);

        $video = new VideoGallery();
        $video->title = $request->title;
        $video->youtube_link = $request->youtube_link;
        $video->save_by = 1;
        $video->ip_address = $request->ip();
        $video->save();
        if ($video) {
            Session::flash('success', 'video added Successfully');
            return back();
        } else {
            Session::flash('errors', 'Opps! Something went wrong');
            return back();
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
    public function edit(VideoGallery $video)
    {
        return view('admin.video.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VideoGallery $video)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'youtube_link' => 'required|string|max:100',
            'ip_address' => 'max:15'
        ]);
        $video->title = $request->title;
        $video->youtube_link = $request->youtube_link;
        $video->ip_address = $request->ip();
        $video->update_by = 1;
        $video->save();
        if ($video) {
            Session::flash('success', 'video updated Successfully');
            return redirect()->route('video.index');
        } else {
            Session::flash('errors', 'Opps! Something went wrong');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VideoGallery $video)
    {
        $video->delete();
        if ($video) {
            Session::flash('info', 'delete  Successfully');
            return back();
        } else {
            Session::flash('errors', 'Opps! Something went wrong');
            return back();
        }
    }
}
