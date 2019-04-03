{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ trans('home.overview') }}</h1>
@stop

@section('content')
    <p>{{ trans('home.intro') }}</p>
@stop

@section('css')

    <link rel="stylesheet" href="/css/admin_custom.css">
     
@stop

@section('js')
    <script>
      $(document).ready( function () {
          $('#testTable').DataTable();
      });
    </script>
@stop
