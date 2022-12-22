@extends('layout.template')

@section('title','Berkas Verifikasi Digital Klaim BPJS')

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
  <!-- Datepicker -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
</head>
@endsection

@section('content')
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Berkas Perawatan Digital Rawat Jalan</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
              <div class="modal-body">
                <h5>Data Pasien</h5>
                <div>
                  <p></p>
                  <p id="no_rawat"></p>
                  <p id="sep"></p>
                  <p id="tgl_reg"></p>
                  <p id="poli"></p>
                  <p id="no_rkm_medis"></p>
                  <p id="nm_pasien"></p>
                  <p id="alamat"></p>
                  <p id="status"></p>
                </div>
                <h5>Tindakan Rawat Jalan Dokter</h5>
                  <div class="modal-body">
                    <table id="example1" class="table table-bordered table-striped">
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
                        <?php $no=1 ?>
                            <tr>
                              <td font-size: 10px;>{{$no++}}</td>
                              <td>
                                <p id="tgl_perawatan"></p>
                              </td>
                              <td>
                                <p>coba</p>
                              </td>
                              {{-- <td> {{$rawat_jl_dr->nm_tindakan}} </td>
                              <td> {{$rawat_jl_dr->nm_dokter}} </td>
                              <td> {{$rawat_jl_dr->biaya_rawat}} </td> --}}
                            </tr>
                      </tbody>
                    </table>
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
              <h3 class="card-title">Berkas Digital Rawat Jalan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <h5>Tanggal Registrasi</h5>
              <div class="row input-daterange float-center">
                  <div class="col-md-4">
                      <input type="date" name="from_date" id="from_date" class="form-control" value="{{$now}}" placeholder="Tanggal Awal"/>
                  </div>
                  <div class="col-md-4">
                      <input type="date" name="to_date" id="to_date" class="form-control" value="{{$now}}" placeholder="Tabggal Akhir"/>
                  </div>
                  <div class="col-md-4">
                    <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                    <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
                  </div>
              </div>
              <br>
              <table id="tabel1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                      <th>No</th>
                      <th>Tanggal registrasi</th>
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
<!-- jQuery -->
<script src="{{asset('template')}}/plugins/jquery/jquery.min.js"></script>
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
$(function () {
    var url = window.location;
    // for single sidebar menu
    $('ul.nav-sidebar a').filter(function () {
        return this.href == url;
    }).addClass('active');

    // for sidebar menu and treeview
    $('ul.nav-treeview a').filter(function () {
        return this.href == url;
    }).parentsUntil(".nav-sidebar > .nav-treeview")
        .css({'display': 'block'})
        .addClass('menu-open').prev('a')
        .addClass('active');
});
</script>

<script>
    $(document).ready(function(){
      isi()

      $('.input-daterange').datepicker({
        todayBtn:'linked',
        format:'yyyy-mm-dd',
        autoclose:true
      });        
    })

    function isi(from_date = '', to_date = '') {
        $('#tabel1').DataTable({
            serverside: true,
            responsive: true,
            processing: true,
            ajax: {
                url: "{{route('berkas')}}",
                data:{from_date:from_date, to_date:to_date}
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

    $('#filter').click(function(){
      var from_date = $('#from_date').val();
      var to_date = $('#to_date').val();
      var status = $('#status').val();
      if(from_date != '' &&  to_date != ''){
        $('#tabel1').DataTable().destroy();
        isi(from_date, to_date, status);
      }else{
        alert('Both Date is required');
      }
    });

    $('#refresh').click(function(){
      $('#from_date').val('{{$now}}');
      $('#to_date').val('{{$now}}');
      $('#tabel1').DataTable().destroy();
      isi();
    });

    $(document).on('click','.riwayat',function(){
      let id = $(this).attr('id')
      $.ajax({
        url: "{{route('detail')}}",
        type: 'post',
        data: {
          id: id,
          _token: "{{csrf_token()}}"
        },
        success: function (res) {
          $('#no_rawat').html    ('No Rawat           : ' + res.kunjungan.no_rawat)
          $('#sep').html         ('No SEP             : ' + res.kunjungan.sep)
          $('#tgl_reg').html     ('Tgl Registrasi     : ' + res.kunjungan.tgl_reg)
          $('#poli').html        ('Poliklinik         : ' + res.kunjungan.poli)
          $('#dokter').html      ('Dokter             : ' + res.kunjungan.dokter)
          $('#no_rkm_medis').html('No RM              : ' + res.kunjungan.no_rkm_medis)
          $('#nm_pasien').html   ('Nama Pasien        : ' + res.kunjungan.nm_pasien)
          $('#alamat').html      ('Alamat             : ' + res.kunjungan.alamat)
          
          let elemen = '';

          for(let i=0; i<rawat_jl_dr.length; i++){
              elemen += '<p> '+ res.rawat_jl_dr[i].tgl_perawatan +' </p>'
            }
            $('#tgl_perawatan').html(elemen)
        }
      })
    })
</script>
@endsection