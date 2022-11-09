@extends('layout.template')

@section('title','Berkas INACBG')

@section('head')
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('template')}}/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('template')}}/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- CSS DataTable -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
  <!-- Bootsrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</head>
@endsection

@section('content')
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
                  <p></p>
                  <p id="no_rawat"></p>
                  <p id="no_rkm_medis"></p>
                  <p id="nm_pasien"></p>
                  <p id="alamat"></p>
                </div>
                <h5>Registrasi</h5>
                <div>
                  <p></p>
                  <p id="tgl_reg"></p>
                  <p id="poli"></p>
                  <p id="dokter"></p>
                  <p id="status"></p>
                </div>
                <h5>Kunjungan</h5>
                <div>
                  <p></p>
                  <p id="sep"></p>
                  <p id="noka"></p>
                  <p id="diagnosa"></p>
                </div>
                <h5>Berkas Perawatan Digital</h5>
                <div id=div1>
                  <p id="berkas"></p>
                </div>
              </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>                      
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Berkas Verifikasi Digital Klaim BPJS</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form method="POST">
                  {{ csrf_field() }}
                  <div class="mb-3">
                      <label>First Date:</label>
                      <input type="date" class="form-control" id="fdate" name="fdate">
                  </div>
                  <div class="mb-3">
                      <label>Second Date:</label>
                      <input type="date" class="form-control" id="sdate" name="sdate">
                  </div>
                  <input type="submit" value="Submit" class="btn btn-primary" id="filter">
              </form>
              <br>
              <table id="tabel1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                      <th>No</th>
                      <th>Tgl registrasi</th>
                      <th>No Rawat</th>
                      <th>No RM</th>
                      <th>Nama Pasien</th>
                      <th>SEP</th>
                      <th>No. Kartu</th>
                      <th>File</th>
                  </tr>
                </thead>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
@endsection
@section('script')
<!-- Bootstrap 4 -->
<script src="{{asset('template')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('template')}}/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('template')}}/dist/js/demo.js"></script>
<!-- page script -->

<!-- script datatables dan JQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

<script>
    $(document).ready(function(){
        isi()
    })

    function isi() {
        $('#tabel1').DataTable({
            serverside: true,
            responsive: true,
            ajax: {
                url: "{{route('berkas')}}"
            },
            columns: [
                {
                    "data" :null, "sortable": true,
                    render: function (data, type, row, meta){
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                {data: 'tgl_reg', name:'tgl_reg'},
                {data: 'no_rawat', name:'no_rawat'},
                {data: 'no_rkm_medis', name:'no_rkm_medis'},
                {data: 'nm_pasien', name:'nm_pasien'},
                {data: 'sep', name:'sep'},
                {data: 'noka', name:'noka'},
                {data: 'file', name:'file'}
            ]
        })
    }

    $(document).on('click','.file',function(){
      let id = $(this).attr('id')
      $.ajax({
        url: "{{route('files')}}",
        type: 'post',
        data: {
          id: id,
          _token: "{{csrf_token()}}"
        },
        success: function (res) {
          if(res.kunjungan.status = 1){
            $status = 'Ranap';
          }else{
            $status = 'Ralan';
          }

          $('#no_rawat').html    ('No Rawat        : ' + res.kunjungan.no_rawat)
          $('#no_rkm_medis').html('No RM           : ' + res.kunjungan.no_rkm_medis)
          $('#nm_pasien').html   ('Nama Pasien     : ' + res.kunjungan.nm_pasien)
          $('#alamat').html      ('Alamat          : ' + res.kunjungan.alamat)

          $('#tgl_reg').html     ('Tgl Registrasi     : ' + res.kunjungan.tgl_reg)
          $('#poli').html        ('Poliklinik         : ' + res.kunjungan.poli)
          $('#dokter').html      ('Dokter             : ' + res.kunjungan.dokter)
          $('#status').html      ('Status             : ' + $status)

          $('#sep').html         ('No SEP             : ' + res.kunjungan.sep)
          $('#noka').html        ('No BPJS            : ' + res.kunjungan.noka)
          $('#diagnosa').html    ('Diagnosa Utama     : ' + res.diagnosa.kd_penyakit + ' ' + res.diagnosa.nm_penyakit)
          
          
          let berkas = res.berkas;
          let elemen = '';

          if(Array.isArray(berkas) && berkas.length){
            for(let i=0; i<berkas.length; i++){
              elemen += '<a href="http://192.168.1.10/webapps/berkasrawat/'+res.berkas[i].lokasi_file+'">'+res.berkas[i].nama+'</a><br>'
            }
            $('#berkas').html(elemen)
          }
          else{
            $('#berkas').html('TIDAK ADA BERKAS')
          }
        }
      })
    })
</script>
@endsection