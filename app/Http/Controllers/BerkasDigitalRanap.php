<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\DataTables;
use Illuminate\Support\Carbon;

class BerkasDigitalRanap extends Controller
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
                                        ->leftJoin('simrs_khanza.kamar_inap as b','a.no_rawat','=','b.no_rawat')
                                        ->leftjoin('simrs_khanza.bridging_sep as c','a.no_rawat','=','c.no_rawat')
                                        ->leftjoin('simrs_khanza.pasien as d','a.no_rkm_medis','=','d.no_rkm_medis')
                                        ->where('a.kd_pj','=','BPJ')
                                        ->where('c.jnspelayanan','=','1')
                                        ->whereBetween('b.tgl_keluar', array($request->from_date, $request->to_date))
                                        ->select('a.no_rawat as no_rawat', 'a.no_rkm_medis AS no_rkm_medis','c.no_kartu AS noka',
                                                'd.nm_pasien AS nm_pasien','b.tgl_keluar AS tgl_reg','c.no_sep AS sep'
                                                )
                                        ->orderBy('a.no_rawat')
                                        ->get();
                        }
                        else{
                                $data = DB::table('simrs_khanza.reg_periksa as a')
                                        ->leftJoin('simrs_khanza.kamar_inap as b','a.no_rawat','=','b.no_rawat')
                                        ->leftjoin('simrs_khanza.bridging_sep as c','a.no_rawat','=','c.no_rawat')
                                        ->leftjoin('simrs_khanza.pasien as d','a.no_rkm_medis','=','d.no_rkm_medis')
                                        ->where('a.kd_pj','=','BPJ')
                                        ->where('c.jnspelayanan','=','1')
                                        ->where('b.tgl_keluar','=',$now)
                                        ->select('a.no_rawat as no_rawat', 'a.no_rkm_medis AS no_rkm_medis','c.no_kartu AS noka',
                                                'd.nm_pasien AS nm_pasien','b.tgl_keluar AS tgl_reg','c.no_sep AS sep'
                                                )
                                        ->orderBy('a.no_rawat')
                                        ->get();
                        }
                        return datatables()
                                ->of($data)
                                ->addColumn('file', function($data){
                                        $button = "<button type='button' class='file btn btn-block btn-primary' id='".$data->no_rawat."' data-bs-toggle='modal' data-bs-target='#exampleModal'><i class='fas fa-folder'></button>";
                                        return $button;
                                })
                                ->rawColumns(['file'])
                                ->make(true);
                }
                return view('berkas_ranap',compact('now','user'));
        }


        public function file(Request $request){

                $no_rawat = $request->id;
                $kunjungan = DB::table('simrs_khanza.reg_periksa as a')
                        ->leftjoin('simrs_khanza.bridging_sep as c','a.no_rawat','=','c.no_rawat')
                        ->leftjoin('simrs_khanza.pasien as d','a.no_rkm_medis','=','d.no_rkm_medis')
                        ->where('a.kd_pj','=','BPJ')
                        ->where('a.no_rawat','=',$no_rawat)
                        ->select('a.no_rawat as no_rawat', 'a.no_rkm_medis AS no_rkm_medis', 
                                'd.nm_pasien AS nm_pasien', 'd.umur AS umur', 'd.jk AS jk', 'd.alamat AS alamat',
                                'a.tgl_registrasi AS tgl_reg', 'a.jam_reg AS jam_reg', 'c.klsrwt AS poli', 
                                'c.nmdpdjp AS dokter', 'c.jnspelayanan AS status', 'c.no_sep AS sep', 
                                'c.no_kartu AS noka')
                        ->orderBy('a.no_rawat')
                        ->first();

                $diagnosa = DB::table('simrs_khanza.diagnosa_pasien as a')   
                        ->leftJoin('simrs_khanza.penyakit as b', 'a.kd_penyakit', '=', 'b.kd_penyakit')
                        ->where('a.prioritas','=','1')
                        ->where('a.no_rawat','=',$no_rawat)
                        ->first();

                $berkas = DB::table('simrs_khanza.berkas_digital_perawatan as a')
                        ->leftJoin('simrs_khanza.master_berkas_digital as b','a.kode','=','b.kode')
                        ->select('a.no_rawat as no_rawat','b.nama as nama','a.lokasi_file as lokasi_file')
                        ->where('a.no_rawat','=',$no_rawat)
                        ->get()
                        ->toArray();

                return response()->json(['kunjungan' => $kunjungan, 'berkas' => $berkas, 'diagnosa' => $diagnosa]);
        }

}

