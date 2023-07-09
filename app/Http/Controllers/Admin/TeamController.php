<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $team = Team::latest()->get();
        return view('admin.team.index', compact('team'));
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
            'name' => 'required|string|max:100',
            'designation' => 'required|string|max:50',
            'image' => 'required|Image|mimes:jpg,png,jpeg,bmp',
            'ip_address' => 'max:15'
        ]);

        $team = new Team();
        $team->name = $request->name;
        $team->designation = $request->designation;
        $team->facebook = $request->facebook;
        $team->twitter = $request->twitter;
        $team->linkedin = $request->linkedin;
        $team->instagram = $request->instagram;
        $team->image = $this->imageUpload($request, 'image', 'uploads/team') ?? '';
        $team->save_by = 1;
        $team->ip_address = $request->ip();
        $team->save();

        if ($team) {
            Session::flash('success', 'Team Member Added Successfully');
            return back();
        } else {
            Session::flash('errors', ' something went wrong');
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
    public function edit(Team $team)
    {
        return view('admin.team.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'designation' => 'required|string|max:50',
            'image' => 'Image|mimes:jpg,png,jpeg,bmp',
            'ip_address' => 'max:15'
        ]);

        $teamImage = '';
        if ($request->hasFile('image')) {
            if (!empty($team->image) && file_exists($team->image)) {
                unlink($team->image);
            }
            $teamImage = $this->imageUpload($request, 'image', 'uploads/team');
        } else {
            $teamImage = $team->image;
        }
        $team->name = $request->name;
        $team->designation = $request->designation;
        $team->facebook = $request->facebook;
        $team->twitter = $request->twitter;
        $team->linkedin = $request->linkedin;
        $team->instagram = $request->instagram;
        $team->updated_by = 1;
        $team->ip_address = $request->ip();
        $team->image = $teamImage;
        $team->save();

        if ($team) {
            Session::flash('success', 'Team Member Updated Successfully');
            return redirect()->route('team.index');
        } else {
            Session::flash('errors', ' something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        if (!empty($team->image) && file_exists($team->image)) {
            unlink($team->image);
        }
        $team->delete();
        if ($team) {
            Session::flash('warning', 'Delete Success');
            return redirect()->back();
        } else {
            Session::flash('errors', 'something went wrong');
            return redirect()->back();
        }
    }
}
