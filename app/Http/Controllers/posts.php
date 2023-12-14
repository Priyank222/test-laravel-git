<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\posts_model;

class posts extends Controller
{
    public function get_posts(Request $request) {
        // dd($this->user);
        // session()->flush();
        $data['posts'] = posts_model::with(['tags','customers'])->get()->toArray();
        return view('posts',$data); 
    }

    function post_form() {
        return view('post_form');
    }

    function add_post_data(Request $request) {
        $request->validate([
            'content' => 'max: 20'
        ]);
        $postArray = $request->all();
        $postArray['customer_id'] = $request->get('user')->id;
        $data_id = posts_model::create($postArray);
        if($request->input('tags')) {
            $data_id->tags()->attach($request->input('tags'));
        }
    }
}
