<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BerkasDigitalPerawatan;
use App\Models\kabupaten;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\DataTables;
use Illuminate\Pagination\Paginator;

class BerkasDigital extends Controller
{

    public function index()
    {
        $kunjungan = DB::table('reg_periksa as a')
                ->leftjoin('bridging_sep as c','a.no_rawat','=','c.no_rawat')
                ->leftjoin('pasien as d','a.no_rkm_medis','=','d.no_rkm_medis')
                ->where('a.kd_pj','=','BPJ')
                ->select('a.no_rawat as no_rawat', 'a.no_rkm_medis AS no_rkm_medis', 
                        'd.nm_pasien AS nm_pasien', 'd.umur AS umur', 'd.jk AS jk', 'd.alamat AS alamat',
                        'a.tgl_registrasi AS tgl_reg', 'a.jam_reg AS jam_reg', 'c.nmpolitujuan AS poli', 
                        'c.nmdpjplayanan AS dokter', 'c.jnspelayanan AS status', 'c.no_sep AS sep', 
                        'c.no_kartu AS noka')
                ->orderBy('a.no_rawat')
                ->paginate(20);

        $diagnosa = DB::table('diagnosa_pasien as a')   
                ->leftJoin('penyakit as b', 'a.kd_penyakit', '=', 'b.kd_penyakit')
                ->where('a.prioritas','=','1')
                ->get();

        $berkas = DB::table('berkas_digital_perawatan as a')
                ->leftJoin('master_berkas_digital as b','a.kode','=','b.kode')
                ->select('a.no_rawat as no_rawat','b.nama as nama','a.lokasi_file as lokasi_file')
                ->get();

        Paginator::useBootstrap();

        return view('berkas', compact('kunjungan','diagnosa','berkas'));
    }


    public function search($id)
    {
        $kunjungan = DB::table('reg_periksa as a')
                    ->leftjoin('bridging_sep as c','a.no_rawat','=','c.no_rawat')
                    ->leftjoin('pasien as d','a.no_rkm_medis','=','d.no_rkm_medis')
                    ->leftJoin('kabupaten as e','d.kd_kab','=','e.nm_kab')
                    ->leftJoin('kecamatan as f','d.kd_kec','=','f.kd_kec')
                    ->leftJoin('kelurahan as g','d.kd_kel','=','g.kd_kel')
                    ->where('a.kd_pj','=','BPJ')
                    ->select('a.no_rawat as no_rawat', 'a.no_rkm_medis AS no_rkm_medis', 
                             'd.nm_pasien AS nm_pasien', 'd.umur AS umur', 'd.jk AS jk', 'd.alamat AS alamat',
                             'e.nm_kab AS kab', 'f.nm_kec AS kec', 'g.nm_kel AS kel', 
                             'a.tgl_registrasi AS tgl_reg', 'a.jam_reg AS jam_reg', 'c.nmpolitujuan AS poli', 
                             'c.nmdpjplayanan AS dokter', 'c.jnspelayanan AS status', 'c.no_sep AS sep', 
                             'c.no_kartu AS noka')
                    ->cursorPaginate(10);
            
        $diagnosa = DB::table('diagnosa_pasien as a')
                    ->leftJoin('penyakit as b', 'a.kd_penyakit', '=', 'b.kd_penyakit')
                    ->where('a.prioritas','=','1')
                    ->get();

        dd($id);

        return view('berkas', compact('kunjungan','diagnosa'));
    }

    public function berkas(){

        $berkas = DB::table('berkas_digital_perawatan as a')
                    ->leftJoin('master_berkas_digital as b','a.kode','=','b.kode')
                    ->select('a.no_rawat as no_rawat','b.nama as nama','a.lokasi_file as lokasi_file')
                    ->get();

        return view('berkaspdf',compact('berkas')); 
    }

    public function titip() {
        $kunjungan = DB::table('reg_periksa as a')
        ->leftjoin('bridging_sep as c','a.no_rawat','=','c.no_rawat')
        ->leftjoin('pasien as d','a.no_rkm_medis','=','d.no_rkm_medis')
        ->where('a.kd_pj','=','BPJ')
        ->select('a.no_rawat as no_rawat', 'a.no_rkm_medis AS no_rkm_medis', 
                'd.nm_pasien AS nm_pasien', 'd.umur AS umur', 'd.jk AS jk', 'd.alamat AS alamat',
                'a.tgl_registrasi AS tgl_reg', 'a.jam_reg AS jam_reg', 'c.nmpolitujuan AS poli', 
                'c.nmdpjplayanan AS dokter', 'c.jnspelayanan AS status', 'c.no_sep AS sep', 
                'c.no_kartu AS noka')
        ->orderBy('a.no_rawat')
        ->paginate(20);

        $diagnosa = DB::table('diagnosa_pasien as a')   
                ->leftJoin('penyakit as b', 'a.kd_penyakit', '=', 'b.kd_penyakit')
                ->where('a.prioritas','=','1')
                ->get();

        $berkas = DB::table('berkas_digital_perawatan as a')
                ->leftJoin('master_berkas_digital as b','a.kode','=','b.kode')
                ->select('a.no_rawat as no_rawat','b.nama as nama','a.lokasi_file as lokasi_file')
                ->get();
    }
}
