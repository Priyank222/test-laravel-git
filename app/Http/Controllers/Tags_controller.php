<?php

namespace App\Http\Controllers;

use App\Models\tags_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tags_controller extends Controller
{
    function tags_search(Request $request) {
        $data = tags_model::select([DB::raw('name as text'), 'id'])->get();

        return $data;
    }
}
