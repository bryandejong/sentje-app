{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ trans('home.overview') }}</h1>
@stop

@section('content')
    <form action="{{url('/accounts/add/finish')}}" method="post">
        {!! csrf_field()!!}
        <div class="form-group">
            <label for="exampleBank1">Bank</label>
            <input name="bank" type="text" class="form-control" id="exampleBank" placeholder="Enter bank">
        </div>
        <div class="form-group">
            <label for="exampleInputIBAN1">IBAN</label>
            <input name="IBAN" type="text" class="form-control" id="exampleIban" placeholder="IBAN">
            <small id="IBANhelp" class="form-text text-muted">We'll never share your IBAN with anyone else.</small>
        </div>
        <input type="submit">
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop