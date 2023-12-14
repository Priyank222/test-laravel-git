<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Post_api_con extends Controller
{
    function create_post(Request $request)
    {
        // $validate = Validator::make($request->all(),[
        //     'email' => ['email', 'required'],
        // ]);
        $validate = $request->validate([
            'email' => ['email', 'required'],
        ]);
        dd($validate);
        return $request->all();
    }
}
