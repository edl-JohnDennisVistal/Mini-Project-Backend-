<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function hello(Request $request)
    {
        return 'hello world';
    }
    public function privatehello(Request $request)
    {
        return 'this private message for authenticated users';
    }
}
