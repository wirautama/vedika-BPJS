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
                                ->join('simrs_khanza.bridging_sep as c','a.no_rawat','=','c.no_rawat')
                                ->join('simrs_khanza.pasien as d','a.no_rkm_medis','=','d.no_rkm_medis')
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
                                ->join('simrs_khanza.bridging_sep as c','a.no_rawat','=','c.no_rawat')
                                ->join('simrs_khanza.pasien as d','a.no_rkm_medis','=','d.no_rkm_medis')
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
                        $button = "<button type='button' class='riwayat btn btn-block btn-primary' id='".$data->no_rawat."' data-bs-toggle='modal' data-bs-target='#exampleModal'><i class='fas fa-folder'></button>";
                                return $button;
                        })
                        ->rawColumns(['file'])
                        ->make(true);
        }

        $jumlah_jl_dr = DB::table('simrs_khanza.reg_periksa as a')
                ->join('simrs_khanza.rawat_jl_dr as b','a.no_rawat','=','b.no_rawat')
                ->where('a.tgl_registrasi','=',$now)
                ->sum('b.biaya_rawat');
        $jumlah_jl_pr = DB::table('simrs_khanza.reg_periksa as a')
                ->join('simrs_khanza.rawat_jl_pr as b','a.no_rawat','=','b.no_rawat')
                ->where('a.tgl_registrasi','=',$now)
                ->sum('b.biaya_rawat');
        $jumlah_inap_dr = DB::table('simrs_khanza.reg_periksa as a')
                ->join('simrs_khanza.rawat_inap_dr as b','a.no_rawat','=','b.no_rawat')
                ->where('a.tgl_registrasi','=',$now)
                ->sum('b.biaya_rawat');
        $jumlah_inap_pr = DB::table('simrs_khanza.reg_periksa as a')
                ->join('simrs_khanza.rawat_inap_pr as b','a.no_rawat','=','b.no_rawat')
                ->where('a.tgl_registrasi','=',$now)
                ->sum('b.biaya_rawat');
        $jumlah_kamar = DB::table('simrs_khanza.reg_periksa as a')
                ->join('simrs_khanza.kamar_inap as b','a.no_rawat','=','b.no_rawat')
                ->where('a.tgl_registrasi','=',$now)
                ->sum('b.ttl_biaya');
        $jumlah_obat = DB::table('simrs_khanza.reg_periksa as a')
                ->join('simrs_khanza.detail_pemberian_obat as b','a.no_rawat','=','b.no_rawat')
                ->where('a.tgl_registrasi','=',$now)
                ->sum('b.total');
        
        $total = $jumlah_jl_dr + $jumlah_jl_pr + $jumlah_inap_dr + $jumlah_inap_pr + $jumlah_kamar + $jumlah_obat;

        return view('riwayat px.riwayat',compact('now','user','total'));
    }

    public function total(Request $request)
    {

        $jumlah_jl_dr = DB::table('simrs_khanza.reg_periksa as a')
                ->join('simrs_khanza.rawat_jl_dr as b','a.no_rawat','=','b.no_rawat')
                ->whereBetween('a.tgl_registrasi', array($request->from_date, $request->to_date))
                ->sum('b.biaya_rawat');
        $jumlah_jl_pr = DB::table('simrs_khanza.reg_periksa as a')
                ->join('simrs_khanza.rawat_jl_pr as b','a.no_rawat','=','b.no_rawat')
                ->whereBetween('a.tgl_registrasi', array($request->from_date, $request->to_date))
                ->sum('b.biaya_rawat');
        $jumlah_inap_dr = DB::table('simrs_khanza.reg_periksa as a')
                ->join('simrs_khanza.rawat_inap_dr as b','a.no_rawat','=','b.no_rawat')
                ->whereBetween('a.tgl_registrasi', array($request->from_date, $request->to_date))
                ->sum('b.biaya_rawat');
        $jumlah_inap_pr = DB::table('simrs_khanza.reg_periksa as a')
                ->join('simrs_khanza.rawat_inap_pr as b','a.no_rawat','=','b.no_rawat')
                ->whereBetween('a.tgl_registrasi', array($request->from_date, $request->to_date))
                ->sum('b.biaya_rawat');
        $jumlah_kamar = DB::table('simrs_khanza.reg_periksa as a')
                ->join('simrs_khanza.kamar_inap as b','a.no_rawat','=','b.no_rawat')
                ->whereBetween('a.tgl_registrasi', array($request->from_date, $request->to_date))
                ->sum('b.ttl_biaya');
        $jumlah_obat = DB::table('simrs_khanza.reg_periksa as a')
                ->join('simrs_khanza.detail_pemberian_obat as b','a.no_rawat','=','b.no_rawat')
                ->whereBetween('a.tgl_registrasi', array($request->from_date, $request->to_date))
                ->sum('b.total');

        $total = $jumlah_jl_dr + $jumlah_jl_pr + $jumlah_inap_dr + $jumlah_inap_pr + $jumlah_kamar + $jumlah_obat;

        return response()->json(['total' => $total]);
    }

    public function jalan(Request $request){

        $no_rawat = $request->id;

        $sep = DB::table('simrs_khanza.reg_periksa as a')
                ->join('simrs_khanza.bridging_sep as b','a.no_rawat','=','b.no_rawat')
                ->where('a.no_rawat','=',$no_rawat)
                ->select('b.no_sep as no_sep','b.tglsep as tglsep','b.no_kartu as no_kartu','b.nomr as nomr',
                         'b.nama_pasien as nama_pasien','b.tanggal_lahir as tanggal_lahir',
                         'b.notelep as notelep','b.nmpolitujuan as nmpolitujuan','b.nmdpdjp as nmdpdjp',
                         'b.nmppkrujukan as nmppkrujukan','b.nmdiagnosaawal as nmdiagnosaawal',
                         'b.catatan as catatan','b.peserta as peserta','b.jnspelayanan as jnspelayanan')
                ->orderBy('b.jnspelayanan','DESC')
                ->first();

        $rawat_jl_dr = DB::table('simrs_khanza.rawat_jl_dr as a')
                ->join('simrs_khanza.jns_perawatan as b','a.kd_jenis_prw','=','b.kd_jenis_prw')
                ->join('simrs_khanza.dokter as c','a.kd_dokter','=','c.kd_dokter')
                ->where('a.no_rawat','=',$no_rawat)
                ->select('a.tgl_perawatan as tgl_perawatan', 'a.biaya_rawat as biaya_rawat', 'b.nm_perawatan AS nm_perawatan', 
                        'c.nm_dokter AS nm_dokter')
                ->get()
                ->toArray();

        $rawat_jl_pr = DB::table('simrs_khanza.rawat_jl_pr as a')
                ->join('simrs_khanza.jns_perawatan as b','a.kd_jenis_prw','=','b.kd_jenis_prw')
                ->join('simrs_khanza.petugas as c', 'a.nip', '=', 'c.nip')
                ->where('a.no_rawat','=',$no_rawat)
                ->select('a.tgl_perawatan as tgl_perawatan', 'a.biaya_rawat as biaya_rawat', 'b.nm_perawatan AS nm_perawatan', 'c.nama as nm_perawat')
                ->get()
                ->toArray();

        $rawat_inap_dr = DB::table('simrs_khanza.rawat_inap_dr as a')
                ->join('simrs_khanza.jns_perawatan_inap as b','a.kd_jenis_prw','=','b.kd_jenis_prw')
                ->join('simrs_khanza.dokter as c','a.kd_dokter','=','c.kd_dokter')
                ->where('a.no_rawat','=',$no_rawat)
                ->select('a.tgl_perawatan as tgl_perawatan', 'a.biaya_rawat as biaya_rawat', 'b.nm_perawatan AS nm_perawatan', 
                        'c.nm_dokter AS nm_dokter')
                ->get()
                ->toArray();

        $rawat_inap_pr = DB::table('simrs_khanza.rawat_inap_pr as a')
                ->join('simrs_khanza.jns_perawatan_inap as b','a.kd_jenis_prw','=','b.kd_jenis_prw')
                ->join('simrs_khanza.petugas as c', 'a.nip', '=', 'c.nip')
                ->where('a.no_rawat','=',$no_rawat)
                ->select('a.tgl_perawatan as tgl_perawatan', 'a.biaya_rawat as biaya_rawat', 'b.nm_perawatan AS nm_perawatan', 'c.nama as nm_perawat')
                ->get()
                ->toArray();

        $kamar = DB::table('simrs_khanza.kamar_inap as a')
                ->join('simrs_khanza.kamar as b','a.kd_kamar', '=', 'b.kd_kamar')
                ->join('simrs_khanza.bangsal as c', 'b.kd_bangsal', '=', 'c.kd_bangsal')
                ->where( 'a.no_rawat','=',$no_rawat)
                ->select('a.tgl_masuk as tgl_masuk','a.jam_masuk as jam_masuk','a.tgl_keluar as tgl_keluar',
                         'a.jam_keluar as jam_keluar','a.lama as lama','a.kd_kamar as kd_kamar','c.nm_bangsal as nm_bangsal',
                         'a.ttl_biaya as ttl_biaya','a.stts_pulang as stts_pulang')
                ->get()
                ->toArray();

        $obat = DB::table('simrs_khanza.detail_pemberian_obat as a')
                ->join('simrs_khanza.databarang as b','a.kode_brng','=','b.kode_brng')
                ->join('simrs_khanza.kodesatuan as c','b.kode_sat','=','c.kode_sat')
                ->where( 'a.no_rawat','=',$no_rawat)
                ->select('a.tgl_perawatan as tgl_perawatan', 'a.jam as jam', 'b.nama_brng as nama_brng', 
                         'a.jml as jml', 'a.total as total','c.satuan as satuan')
                ->get()
                ->toArray();

        // $resume = DB::table('simrs_khanza.berkas_digital_perawatan as a')
        //         ->select('a.lokasi_file as lokasi_file')
        //         ->where('a.no_rawat','=',$no_rawat)
        //         ->where('a.kode','=','015')
        //         ->first();

        return response()->json([
                                  'sep' => $sep,
                                  'rawat_jl_dr' => $rawat_jl_dr, 
                                  'rawat_jl_pr' => $rawat_jl_pr, 
                                  'rawat_inap_dr' => $rawat_inap_dr, 
                                  'rawat_inap_pr' => $rawat_inap_pr,
                                  'kamar' => $kamar,
                                  'obat' => $obat,
                                //   'resume' => $resume,
                                ]);
    }
}
