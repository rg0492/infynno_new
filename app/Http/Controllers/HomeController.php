<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $status = Status::all();
        return view('home',compact('status'));
    }
}
