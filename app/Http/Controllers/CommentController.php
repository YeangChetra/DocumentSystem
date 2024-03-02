<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function index(Request $request){
            $current_data = 0;
            return view('comment.index',['current_data'=>$current_data]);
    }
    
}
