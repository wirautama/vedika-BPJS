<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
            $user = auth()->user();

            $now=Carbon::now()->toDateString();

            if(request()->ajax()){
                    if(!empty($request->from_date)){
                            $data = DB::table('simrs_khanza.reg_periksa as a')
                                    ->leftjoin('simrs_khanza.bridging_sep as c','a.no_rawat','=','c.no_rawat')
                                    ->leftjoin('simrs_khanza.pasien as d','a.no_rkm_medis','=','d.no_rkm_medis')
                                    ->where('a.kd_pj','=','BPJ')
                                    ->where('c.jnspelayanan','=','2')
                                    ->whereBetween('a.tgl_registrasi', array($request->from_date, $request->to_date))
                                    ->select('a.no_rawat as no_rawat', 'a.no_rkm_medis AS no_rkm_medis','c.no_kartu AS noka',
                                            'd.nm_pasien AS nm_pasien','a.tgl_registrasi AS tgl_reg','c.no_sep AS sep'
                                            )
                                    ->orderBy('a.no_rawat')
                                    ->get();
                    }
                    else{
                            $data = DB::table('simrs_khanza.reg_periksa as a')
                                    ->leftjoin('simrs_khanza.bridging_sep as c','a.no_rawat','=','c.no_rawat')
                                    ->leftjoin('simrs_khanza.pasien as d','a.no_rkm_medis','=','d.no_rkm_medis')
                                    ->where('a.kd_pj','=','BPJ')
                                    ->where('c.jnspelayanan','=','2')
                                    ->where('a.tgl_registrasi','=',$now)
                                    ->select('a.no_rawat as no_rawat', 'a.no_rkm_medis AS no_rkm_medis','c.no_kartu AS noka',
                                            'd.nm_pasien AS nm_pasien','a.tgl_registrasi AS tgl_reg','c.no_sep AS sep'
                                            )
                                    ->orderBy('a.no_rawat')
                                    ->get();
                    }
                    return datatables()
                            ->of($data)
                            ->addColumn('file', function($data){
                                    $button = "<button type='button' class='riwayat btn btn-block btn-primary' id='".$data->no_rawat."'><i class='fas fa-folder'></button>";
                                    return $button;
                            })
                            ->rawColumns(['file'])
                            ->make(true);
            }
            return view('riwayat',compact('now','user'));
    }


    public function detail(Request $request){

            $no_rawat = $request->id;
            $kunjungan = DB::table('simrs_khanza.reg_periksa as a')
                    ->leftjoin('simrs_khanza.bridging_sep as c','a.no_rawat','=','c.no_rawat')
                    ->leftjoin('simrs_khanza.pasien as d','a.no_rkm_medis','=','d.no_rkm_medis')
                    ->where('a.kd_pj','=','BPJ')
                    ->where('a.no_rawat','=',$no_rawat)
                    ->select('a.no_rawat as no_rawat', 'a.no_rkm_medis AS no_rkm_medis', 
                            'd.nm_pasien AS nm_pasien', 'd.umur AS umur', 'd.jk AS jk', 'd.alamat AS alamat',
                            'a.tgl_registrasi AS tgl_reg', 'a.jam_reg AS jam_reg', 'c.nmpolitujuan AS poli', 
                            'c.nmdpjplayanan AS dokter', 'c.jnspelayanan AS status', 'c.no_sep AS sep', 
                            'c.no_kartu AS noka')
                    ->orderBy('a.no_rawat')
                    ->first();

            $rawat_jl_dr = DB::table('simrs_khanza.rawat_jl_dr as a')
                    ->leftjoin('simrs_khanza.jns_perawatan as b','a.no_rawat','=','b.no_rawat')
                    ->leftjoin('simrs_khanza.dokter as c','b.kd_dokter','=','c.kd_dokter')
                    ->where('a.no_rawat','=',$no_rawat)
                    ->select('a.tgl_perawatan as tgl_perawatan', 'a.biaya_rawat as biaya_rawat', 'b.nm_perawatan AS nm_perawatan', 
                            'c.nm_dokter AS nm_dokter')
                    ->get()
                    ->toArray();

            return response()->json(['kunjungan' => $kunjungan, 'rawat_jl_dr' => $rawat_jl_dr]);
    }
}
