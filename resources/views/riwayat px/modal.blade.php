<div class="card">
    <div class="card-body">
        <div class="col-md-8 float-left">
          <select name='status' class='riwayat custom-select'>
            <option value='0'>PILIH RIWAYAT</option>
            <option value='data_sep'>DATA SEP</option>
            <option value='resume'>RESUME MEDIS</option>
            <option value='rwt_jalan'>RAWAT JALAN</option>
            <option value='4'>LABORATORIUM</option>
            <option value='5'>RADIOLOGI</option>
            <option value='obat'>OBAT</option>
          </select>
        </div>
        <div class="col-md-4 float-right ">
          <button type='button' id='ubah' class='btn btn-block btn-primary'>Pilih</button>
        </div>
    </div>
  </div>
  <div id=data_sep>
    <h5>Data SEP</h5>
    <div>
      <p></p>
      <p id="sep"></p>
      <p id="tgl_sep"></p>
      <p id="no_ka"></p>
      <p id="no_mr"></p>
      <p id="nama_px"></p>
      <p id="tgl_lhr"></p>
      <p id="no_telp"></p>
      <p id="dokter"></p>
      <p id="perujuk"></p>
      <p id="diagnosa"></p>
      <p id="catatan"></p>
      <p id="peserta"></p>
      <p id="jenis"></p>
    </div>
  </div>
  <div id=resume>
    <h5>Resume Medis</h5>
    <div>
        <iframe src='' align="top" height="620" width="100%" frameborder="0" scrolling="auto"></iframe>
    </div>
  </div>
  <br>
  <div id = rwt_jalan>
    <h5>Tindakan Rawat Jalan Dokter</h5>
    <div class="modal-body">
      <table id="dr_jl_table" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>No.</th>
          <th>Tanggal</th>
          <th>Nama Tindakan/Perawatan</th>
          <th>Dokter</th>
          <th>Biaya</th>
        </tr>
        </thead>
        <tbody>
          <tr>
          </tr>
        </tbody>
      </table>
    </div>
    <h5>Tindakan Rawat Jalan Perawat</h5>
    <div class="modal-body">
      <table id="pr_jl_table" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>No.</th>
          <th>Tanggal</th>
          <th>Nama Tindakan/Perawatan</th>
          <th>Dokter</th>
          <th>Biaya</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
  <div id='obat'>
    <h5>Pemberian Obat/BHP/Alkes</h5>
    <div class="modal-body">
        <table id="obat_table" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>Nama Obat/BHP/Alkes</th>
            <th>Jumlah</th>
            <th>Biaya</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
  </div>