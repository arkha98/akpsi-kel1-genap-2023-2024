<?php

namespace App\Http\Controllers\Etc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EtcController extends Controller
{
    public function __construct()
    {
    }

    public function view500Response500() {
        return response()->view('view-etc.errors',[],500);
    }

    public function view404Response404() {
        return response()->view('view-etc.404',[],404);
    }

    public function view404Response200() {
        return response()->view('view-etc.404',[],200);
    }

    public function view404Response401() {
        return response()->view('view-etc.404',[],401);
    }

    public function view404Response403() {
        return response()->view('view-etc.404',[],403);
    }

    public function json404() {
        return response()->json('404', 404);
    }

    public function json404Response200() {
        return response()->json('404', 200);
    }

    public function json404Response401() {
        return response()->json('404', 401);
    }

    public function json404Response403() {
        return response()->json('404', 403);
    }

}
