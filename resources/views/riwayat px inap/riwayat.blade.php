@extends('layouts.template')

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
        <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Riwayat Perawatan Rawat Inap</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
              <div class="modal-body">
                @include('riwayat px inap.modal')
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
              {{-- Total Pengajuan --}}
              @php
                function rupiah($angka){
                    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
                    return $hasil_rupiah;
                } 
              @endphp

              <h3 class="card-title" id = "total">Pengajuan = {{ rupiah($total) }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <h5>Tanggal KRS</h5>
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
                url: "{{route('riwayat_rn')}}",
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
        isi(from_date, to_date);
      }else{
        alert('Both Date is required');
      }
      $.ajax({
        url: "{{route('total_rn')}}",
        type: 'post',
        data: {
          from_date : from_date,
          to_date : to_date,
          _token: "{{csrf_token()}}"
        },
        success: function (res) {

          let totalIDR = new Intl.NumberFormat('id-ID', {
              style: 'currency',
              currency: 'IDR',
          });

          $('#total').text('Pengajuan = ' + totalIDR.format(res.total));
        }
      })
    });

    $('#refresh').click(function(){
      $('#from_date').val('{{$now}}');
      $('#to_date').val('{{$now}}');
      $('#tabel1').DataTable().destroy();
      isi();
    });

    $(document).on('click','.riwayat',function(){
      $('#data_sep').hide();
      $('#resume').hide();
      $('#rwt_inap').hide();
      $('#kamar').hide();
      $('#obat').hide();

      let totalIDR = new Intl.NumberFormat('id-ID', {
          style: 'currency',
          currency: 'IDR',
      });
      
      let id = $(this).attr('id')
      $.ajax({
        url: "{{route('jalan_rn')}}",
        type: 'post',
        data: {
          id: id,
          _token: "{{csrf_token()}}"
        },
        success: function (res) {

          $('#sep').html         ('No SEP             : ' + res.sep.no_sep)
          $('#tgl_sep').html    ('Tgl. SEP           : ' + res.sep.tglsep)
          $('#no_ka').html     ('No. Kartu     : ' + res.sep.no_kartu)
          $('#no_mr').html     ('No. Kartu     : ' + res.sep.nomr)
          $('#nama_px').html        ('Nama Peserta         : ' + res.sep.nama_pasien)
          $('#tgl_lhr').html      ('Tgl. Lahir             : ' + res.sep.tanggal_lahir)
          $('#no_telp').html('No. Telepon              : ' + res.sep.notelep)
          $('#poli').html('Sub/Poli Spesialis             : ' + res.sep.nmpolitujuan)
          $('#dokter').html   ('Dokter        : ' + res.sep.nmdpdjp)
          $('#perujuk').html      ('Faskes Perujuk             : ' + res.sep.nmppkrujukan)
          $('#diagnosa').html      ('Diagnosa Awal             : ' + res.sep.nmdiagnosaawal)
          $('#catatan').html      ('Catatan             : ' + res.sep.catatan)
          $('#peserta').html      ('Peserta             : ' + res.sep.peserta)
          $('#jenis').html      ('Jns. Rawat             : Rawat Inap')

          let url = "{{ URL::asset('/template/berkas') }}/pages/upload/0195R0401022V000004_resume.pdf";
          $('iframe').attr('src', url)  

          let rawat_inap_dr = res.rawat_inap_dr;
          let rawat_inap_pr = res.rawat_inap_pr;
          let kamar = res.kamar;
          let obat = res.obat;

          let no_dr_in = 1;
          let no_pr_in = 1;
          let no_kamar = 1;
          let no_obat = 1;

          //Tabel rawat inap dokter
            $.each(rawat_inap_dr, function (i, item) {
                $('<tr>').append(
                $('<td>').text(no_dr_in),
                $('<td>').text(item.tgl_perawatan),
                $('<td>').text(item.nm_perawatan),
                $('<td>').text(item.nm_dokter),
                $('<td>').text(totalIDR.format(item.biaya_rawat))
                ).appendTo('#dr_in_table');

                no_dr_in++;
            });
          
          //Tabel rawat inap perawat
            $.each(rawat_inap_pr, function (i, item) {
                $('<tr>').append(
                $('<td>').text(no_pr_in),
                $('<td>').text(item.tgl_perawatan),
                $('<td>').text(item.nm_perawatan),
                $('<td>').text(item.nm_perawat),
                $('<td>').text(totalIDR.format(item.biaya_rawat))
                ).appendTo('#pr_in_table');

                no_pr_in++;
            });

          //Tabel kamar inap
          $.each(kamar, function (i, item) {
              $('<tr>').append(
              $('<td>').text(no_kamar),
              $('<td>').text(item.tgl_masuk + " " + item.jam_masuk),
              $('<td>').text(item.tgl_keluar + " " + item.jam_keluar),
              $('<td>').text(item.lama),
              $('<td>').text(item.kd_kamar + ", " + item.nm_bangsal),
              $('<td>').text(item.stts_pulang),
              $('<td>').text(totalIDR.format(item.ttl_biaya)),
              ).appendTo('#kamar_inap');

              no_kamar++;
          });

          //Tabel obat
          $.each(obat, function (i, item) {
              $('<tr>').append(
              $('<td>').text(no_obat),
              $('<td>').text(item.tgl_perawatan + " " + item.jam),
              $('<td>').text(item.nama_brng),
              $('<td>').text(item.jml + " " + item.satuan),
              $('<td>').text(totalIDR.format(item.total)),
              ).appendTo('#obat_table');

              no_obat++;
          });
        }
      })
    })

    $('#exampleModal').on('hidden.bs.modal', function() {
      $('#dr_in_table tbody').empty();
      $('#pr_in_table tbody').empty();
      $('#kamar_inap tbody').empty();
      $('#obat_table tbody').empty();
    })

    $('#ubah').on('click', function() {
      let dom = $('select').val();
      
      if (dom == 'data_sep'){
        $('#data_sep').show();
        $('#resume').hide();
        $('#rwt_inap').hide();
        $('#kamar').hide();
        $('#obat').hide();
      }
      else if (dom == 'resume') {
        $('#data_sep').hide();
        $('#resume').show();
        $('#rwt_inap').hide();
        $('#kamar').hide();
        $('#obat').hide();
      } 
      else if (dom == 'rwt_jalan') {
        $('#data_sep').hide();
        $('#resume').hide();
        $('#rwt_inap').hide();
        $('#kamar').hide();
        $('#obat').hide();
      } 
      else if (dom == 'rwt_inap') {
        $('#data_sep').hide();
        $('#resume').hide();
        $('#rwt_inap').show();
        $('#kamar').hide();
        $('#obat').hide();
      }
      else if (dom == 'kamar') {
        $('#data_sep').hide();
        $('#resume').hide();
        $('#rwt_inap').hide();
        $('#kamar').show();
        $('#obat').hide();
      }
      else if (dom == 'obat') {
        $('#data_sep').hide();
        $('#resume').hide();
        $('#rwt_inap').hide();
        $('#kamar').hide();
        $('#obat').show();
      }
    })

</script>
@endsection