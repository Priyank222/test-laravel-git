<?php

namespace App\Http\Controllers;

use App\Models\Customer_model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\posts_model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $avoid_auth = ['login', 'register', 'check_login'];
    public $user;
    function __construct(Request $request)
    {
        $this->user = $request->get('user');
        // dd($request);
        // $this->set_login_user($request);
    }
    function set_login_user(Request $request) {
        if(!in_array($request->route()->uri(),$this->avoid_auth)) {
            if (session()->has('customer_id')) {
                $this->user = Customer_model::find(session()->get('customer_id'));
            } else {
                Redirect::to('login')->send();
            }
        }
    }
    function upload_image($path,Request $request) {
        $file_name = time().'_'.rand('1000','9999').'.'.$request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs("public/$path",$file_name);
        return "$path/".$file_name;
    }

    function delete_image($path) {
        if(Storage::exists("public/".$path)) {
            Storage::delete("public/".$path);
        }
    }
}
