<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $user = auth()->user();
        $sep = DB::table('bridging_sep')->count();
        $kunjungan = DB::table('reg_periksa')->count();
        $pasien = DB::table('pasien')->count();
        $berkas = DB::table('berkas_digital_perawatan')->distinct('no_rawat')->count();


        return view('layouts.dashboard',compact('sep','kunjungan','pasien','berkas','user'));
    }
}
