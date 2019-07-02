<?php

namespace BajakLautMalaka\PmiAdmin\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return response()->success(['test'=>'ok']);
    }
}
