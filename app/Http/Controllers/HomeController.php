<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('home');
    }

    public function fetchData() {

        $all_projects = count(DB::select('select * from marketplaces'));

        $data = [
            'all_projects' => $all_projects,
            'active_projects' => $all_projects,
            'active_users' => $all_projects,
            'website_users' => $all_projects,
        ];

        return $data;
    }
}
