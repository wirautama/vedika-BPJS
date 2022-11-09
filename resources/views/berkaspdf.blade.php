@extends('layout.template')

@section('title','Berkas INACBG')

@section('content')
    @foreach ($berkas as $bk)
        <h4>
         {{$bk->nama}}
        </h4><br>
    @endforeach

@endsection()