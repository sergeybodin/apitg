<?php

namespace App\Http\Controllers\Api\Bots\Cinema;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Api;
use ErrorException;

class RequestController extends Controller {
    public function post(Request $request) {
        try {
            $data = $request->all();
            Storage::put('botCinemaRequestPost.txt', print_r($data,1));
        } catch (ErrorException $exception) {
            Storage::put('exceptionRequest.txt', print_r($exception->getTraceAsString(),1));
        }
    }
}
