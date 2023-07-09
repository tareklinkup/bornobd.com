<?php

namespace App\Http\Controllers\Admin;

use App\Models\Answar;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AnswarController extends Controller
{
    public function index(){
        $question = Question::latest()->get();
        return view('admin.answar.index',compact('question'));
    }
    public function reply($id){
        $question = Question::where('id',$id)->first();
        return view('admin.answar.reply',compact('question'));
    }
    public function answarStore(Request $request){
        $request->validate([
            'answar' => 'required'
        ]);

        $answar = new Answar();
        $answar->product_id   = $request->product_id;
        $answar->question_id  = $request->question_id;
        $answar->user_id      = Auth::user()->id;
        $answar->answar       = $request->answar;
        $answar->save();
        return redirect()->route('answar')->with('success','answar reply successfully');
    }
}
