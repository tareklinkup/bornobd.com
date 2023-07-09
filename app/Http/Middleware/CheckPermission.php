<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next)
    {
         $permissions = Permission::with('page')->where('user_id',Auth::user()->id)->get();

        foreach ($permissions as  $value) {
            if($value->page->status == 1){
                if($value->page){
                    if($request->route()->action['as'] == $value->page->name){
                        return $next($request);
                    } 
                }  
            }       
        }
        return redirect()->route('admin.index');
    }
}
