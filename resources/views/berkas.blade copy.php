@extends('layout.template')

@section('title','Berkas INACBG')

@section('head')
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('template')}}/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('template')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{asset('template')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('template')}}/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
@endsection

@section('content')
    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body" id="mediumBody">
                      <div>
                          <!-- the result to be displayed apply here -->
                      </div>
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
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Data Pasien</th>
                  <th>Registrasi</th>
                  <th>Kunjungan</th>
                  <th>Berkas</th>
                </tr>
                </thead>
                <tbody>
                  <?php $no=1 ?>
                    @foreach($kunjungan as $val)
                      <tr>
                        <td font-size: 10px;>{{$no++}}</td>
                        <td font-size: 10px;>
                          No.Rawat : {{$val->no_rawat}}<br>
                          No.RM : {{$val->no_rkm_medis}}<br>
                          Nama Pasien : {{$val->nm_pasien}}<br>
                          Alamat Pasien : {{$val->alamat}}
                        </td>
                        <td font-size: 10px;>
                          Tgl. Registrasi : {{$val->tgl_reg}} {{$val->jam_reg}}<br>
                          Poliklinik : {{$val->poli}}<br>
                          Dokter : {{$val->dokter}}<br>
                          Status : <?php echo ($val->status == "1") ? 'Ranap ' : 'Ralan '; ?> ( BPJS KESEHATAN )
                        </td>
                        <td font-size: 10px;>
                          SEP : {{$val->sep}}<br>
                          No. kartu : {{$val->noka}}<br>
                          D.U. : 
                          @foreach($diagnosa as $key)
                            <?php 
                              if($val->no_rawat == $key->no_rawat){
                                echo ("$key->kd_penyakit $key->nm_penyakit");
                              }
                            ?>
                          @endforeach
                        </td>
                        <td font-size: 10px;>
                          @foreach($berkas as $pas)
                            <?php 
                              if($val->no_rawat == $pas->no_rawat){
                                echo ("<a href='http://192.168.1.10/webapps/berkasrawat/$pas->lokasi_file' >$pas->nama</a><br>");
                              }
                            ?>
                          @endforeach
                        </td>
                      </tr>
                    @endforeach
                </tbody>
              </table>
              {{$kunjungan->links()}}
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

<!-- script datatables -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready(function () {
    $('#example1').DataTable({
      "paging": false,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "responsive": true,
    });
    $('#myModal').on('shown.bs.modal', function () {
      $('#myInput').focus()
    })
  });

  function lempar(elem){
  var text = $(elem).attr('value');
  $( ".no_rawat" ).val( text );
  document.getElementById("element").innerHTML = text;
  }
</script>
@endsection