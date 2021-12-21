<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $jmluser = DB::table('users')->where('level', 0)
            ->count();

        // return response()->json($jmluser);
        // dd($jmluser);
        return view('welcome', compact('jmluser'));
    }

    public function coba()
    {
    }
}
