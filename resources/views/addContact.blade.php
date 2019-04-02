{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ trans('home.overview') }}</h1>
@stop

@section('content')
    <form action="{{url('/contacts/add/finish')}}" method="post">
        {!! csrf_field()!!}
        <div class="form-group">
            <label for="exampleEmail1">Email</label>
            <input name="email" type="text" class="form-control" id="exampleEmail" placeholder="Enter email">
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