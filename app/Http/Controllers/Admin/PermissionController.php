<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        return view('admin.permission.index', compact('users'));
    }
    public function permission($id)
    {
        $permission = '';
        $user = User::where('id', $id)->first();
        $orders = Page::where('group_id', 1)->get();
        $products = Page::where('group_id', 2)->get();
        $contents = Page::where('group_id', 3)->get();
        $settings = Page::where('group_id', 4)->get();
        $customers = Page::where('group_id', 5)->get();
        $others = Page::where('group_id', 6)->get();
        $permissions = Permission::where('user_id',$id)->get()->pluck('page_id')->toArray();
        return view('admin.permission.edit', compact('orders', 'products', 'contents', 'settings', 'customers', 'others', 'user','permissions'));
    }



    public function store(Request $request, $id)
    {
        try {
            $count = count($request->page_id);
        Permission::where('user_id', $id)->delete();
        for ($i = 0; $i < $count; $i++) {
            $permission = new Permission();
            $permission->user_id = $id;
            $permission->page_id = $request->page_id[$i];
            $permission->status = 1;
            $permission->save();
        }

        return back()->with('success', 'Permission Created Successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Minimub one permission given');
        }
       
    }
}
