{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{trans('home.sent')}}</h1>
@stop

@section('content')
    <div style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{route('transactions.new')}}">
        <i class="fas fa-plus"></i>
            {{ trans('home.newSentje') }}
        </a>
    </div>
    <table style="width: 100%;" class="table table-striped" id="table">
    <thead>
      <tr>
            <th>{{trans('home.amountPaid')}}</th>
            <th>{{trans('home.amount')}}</th>
            <th>{{trans('home.description')}}</th>
            <th>{{trans('home.date')}}</th>
            <th></th>
      </tr>
      </thead>
      <tbody>
              @foreach($sent as $model )
                <tr id="request-{{$model->id}}">
                    <td>{{$model->totalPaid}} / {{ $model->totalSent}}</td>
                    <td>{{ $model->amount }}</td>
                    <td>{{ $model->note }}</td>
                    <td>{{ $model->sent }}</td>
                    <td>@if($model->canClose()) <a class="btn btn-warning" data-id="{{$model->id}}" onclick="removeRequest({{$model->id}})">{{trans('home.cancel')}}</a> @endif </td>
                </tr>
              @endforeach
        </tbody>
    </table>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> 
        $(document).ready(() => {
            $("#table").DataTable();
        });
        function removeRequest(id){
            $('#request-' + id).remove();
            $.ajax({
                method: 'POST', // Type of response and matches what we said in the route
                url: '/transactions/destroy', // This is the url we gave in the route
                data: {
                    'id' : id,
                    '_token': "{{csrf_token()}}"}, // a JSON object to send back
                success: function(response){ // What to do if we succeed
                },
                error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        }
    </script>
@stop
