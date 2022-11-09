<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Berkas Perawatan Digital</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">
            <h5>Data Pasien</h5>
            <div>
                <p>No Rawat : {{$kunjungan->no_rawat}}</p>
                <p>No RM : {{$kunjungan->no_rkm_medis}}</p>
                <p>Nama Pasien : {{$kunjungan->nm_pasien}}</p>
                <p>Alamat Pasien : {{$kunjungan->alamat}}</p>
            </div>
            <h5>Registrasi</h5>
            <div>
                <p>Tgl Registrasi : {{$kunjungan->tgl_reg}}</p>
                <p>Poliklinik : {{$kunjungan->poli}}</p>
                <p>Dokter : {{$kunjungan->dokter}}</p>
                <p>Status : {{$kunjungan->status}}</p>
            </div>
            <h5>Kunjungan</h5>
            <div>
                <p>No SEP : {{$kunjungan->sep}}</p>
                <p>No Kartu : {{$kunjungan->noka}}</p>
                <p>D.U. : {{$diagnosa->kd_penyakit}} {{$diagnosa->nm_penyakit}}</p>
            </div>
            <h5>Berkas Perawatan Digital</h5>
            <div>
                @foreach ($berkas as $val)
                <a href="http://192.168.1.10/webapps/berkasrawat/{{$berkas->lokasi_file}}">{{$berkas->nama}}</a>
                @endforeach
            </div>
            </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div> 