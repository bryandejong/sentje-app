{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ trans('home.bankaccounts') }}</h1>
@stop

@section('content')
    <a href="/accounts/add" type="button" class="btn btn-default">+</a>
    <table style="width: 100%;" class="table  table-hover">
        <tr>
            <th>Bank</th>
            <th>IBAN</th>
            <th></th>
        </tr>

    @foreach($allBankaccounts as $bank )
        <tr id="account-{{$bank->id}}">
        <td>{{ $bank->bank }} </td>
        <td>{{ $bank->iban }} </td>
        <td><a onclick="hideAccount({{$bank->id}})" class="btn btn-danger" data-id="{{ $bank->id }}">{{trans('home.delete')}}</a></td>
        </tr>
    @endforeach
    </table>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
    function hideAccount(id){
        $('#account-' + id).remove();
        $.ajax({
            method: 'POST', // Type of response and matches what we said in the route
            url: '/accounts/update', // This is the url we gave in the route
            data: {
                    'id' : id,
                    '_token': "{{csrf_token()}}"}, // a JSON object to send back
            success: function(response){ // What to do if we succeed
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    }
    </script>
@stop
