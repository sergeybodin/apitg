<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class MainController extends Controller
{
    public function index()
    {
//        return response()->json([
//            'status' => 'ok',
//        ]);
        return view('main');
    }
}
