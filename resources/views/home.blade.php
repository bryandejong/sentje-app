{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ trans('home.overview') }}</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
    <table style="width:100" class="table table-striped" id="testTable">
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th> 
        <th>Age</th>
      </tr>
  </thead>
  <tbody>
    <tr>
      <td>Jill</td>
      <td>Smith</td> 
      <td>50</td>
    </tr>
    <tr>
      <td>Eve</td>
      <td>Jackson</td> 
      <td>94</td>
    </tr>
  </tbody>
</table>
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