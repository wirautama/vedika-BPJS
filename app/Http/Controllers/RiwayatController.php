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
                                // $button = "<button type='button' class='riwayat btn btn-block btn-primary' id='".$data->no_rawat."' data-bs-toggle='modal' data-bs-target='#exampleModal'><i class='fas fa-folder'></button>";
                                $button = "<select name='status' class='riwayat custom-select' onchange='change()'>
                                             <option data='".$data->no_rawat."' value='0'>PILIH RIWAYAT</option>
                                             <option data='".$data->no_rawat."' value='1'>RAWAT JALAN</option>
                                             <option data='".$data->no_rawat."' value='2'>RAWAT INAP</option>
                                             <option data='".$data->no_rawat."' value='3'>OPERASI</option>
                                             <option data='".$data->no_rawat."' value='4'>LABORATORIUM</option>
                                             <option data='".$data->no_rawat."' value='5'>RADIOLOGI</option>
                                           </select>";
                                    return $button;
                            })
                            ->rawColumns(['file'])
                            ->make(true);
            }
            return view('riwayat px.riwayat',compact('now','user'));
    }


    public function jalan(Request $request){

        $no_rawat = $request->id;

        // $kunjungan = DB::table('simrs_khanza.reg_periksa as a')
        //         ->leftjoin('simrs_khanza.bridging_sep as c','a.no_rawat','=','c.no_rawat')
        //         ->leftjoin('simrs_khanza.pasien as d','a.no_rkm_medis','=','d.no_rkm_medis')
        //         ->where('a.kd_pj','=','BPJ')
        //         ->where('a.no_rawat','=',$no_rawat)
        //         ->select('a.no_rawat as no_rawat', 'a.no_rkm_medis AS no_rkm_medis', 
        //                 'd.nm_pasien AS nm_pasien', 'd.alamat AS alamat',
        //                 'a.tgl_registrasi AS tgl_reg', 'c.nmpolitujuan AS poli', 
        //                 'c.nmdpjplayanan AS dokter', 'c.no_sep AS sep')
        //         ->orderBy('a.no_rawat')
        //         ->first();

        $rawat_jl_dr = DB::table('simrs_khanza.rawat_jl_dr as a')
                ->leftjoin('simrs_khanza.jns_perawatan as b','a.kd_jenis_prw','=','b.kd_jenis_prw')
                ->leftjoin('simrs_khanza.dokter as c','a.kd_dokter','=','c.kd_dokter')
                ->where('a.no_rawat','=',$no_rawat)
                ->select('a.tgl_perawatan as tgl_perawatan', 'a.biaya_rawat as biaya_rawat', 'b.nm_perawatan AS nm_perawatan', 
                        'c.nm_dokter AS nm_dokter')
                ->get()
                ->toArray();

        $rawat_jl_pr = DB::table('simrs_khanza.rawat_jl_pr as a')
                ->leftjoin('simrs_khanza.jns_perawatan as b','a.kd_jenis_prw','=','b.kd_jenis_prw')
                ->leftJoin('simrs_khanza.petugas as c', 'a.nip', '=', 'c.nip')
                ->where('a.no_rawat','=',$no_rawat)
                ->select('a.tgl_perawatan as tgl_perawatan', 'a.biaya_rawat as biaya_rawat', 'b.nm_perawatan AS nm_perawatan', 'c.nama as nm_perawat')
                ->get()
                ->toArray();

        return response()->json(['rawat_jl_dr' => $rawat_jl_dr, 'rawat_jl_pr' => $rawat_jl_pr]);
    }

    public function inap(Request $request){

        $no_rawat = $request->id;

        $rawat_inap_dr = DB::table('simrs_khanza.rawat_inap_dr as a')
                ->leftjoin('simrs_khanza.jns_perawatan as b','a.kd_jenis_prw','=','b.kd_jenis_prw')
                ->leftjoin('simrs_khanza.dokter as c','a.kd_dokter','=','c.kd_dokter')
                ->where('a.no_rawat','=',$no_rawat)
                ->select('a.tgl_perawatan as tgl_perawatan', 'a.biaya_rawat as biaya_rawat', 'b.nm_perawatan AS nm_perawatan', 
                        'c.nm_dokter AS nm_dokter')
                ->get()
                ->toArray();

        $rawat_inap_pr = DB::table('simrs_khanza.rawat_inap_pr as a')
                ->leftjoin('simrs_khanza.jns_perawatan as b','a.kd_jenis_prw','=','b.kd_jenis_prw')
                ->leftJoin('simrs_khanza.petugas as c', 'a.nip', '=', 'c.nip')
                ->where('a.no_rawat','=',$no_rawat)
                ->select('a.tgl_perawatan as tgl_perawatan', 'a.biaya_rawat as biaya_rawat', 'b.nm_perawatan AS nm_perawatan', 'c.nama as nm_perawat')
                ->get()
                ->toArray();

        return response()->json(['rawat_jl_dr' => $rawat_inap_dr, 'rawat_jl_pr' => $rawat_inap_pr]);
    }
}
