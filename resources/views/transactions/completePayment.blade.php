{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ trans('transactions.completed_sentje') }}</h1>
@stop

@section('content')
    <div class="panel panel-primary" style="max-width: 50%; margin: 50px auto">
        <div class="panel-title page-header"><h2 class="text-center">{{ $userRequest->request->note }}</h2></div>
        <div class="panel-body">
            <form method="post" action="/transactions/store">
                @csrf
                <div class="input-group" style="margin: auto; max-width: 80%; text-align: center;">
                    <h2 class="well well-lg"><span id="currency-span">{{ $userRequest->request->currency }}</span> <span id="amount-span"></span></h2>
                </div>
                <div style="text-align: center;">
                    <h3>{{ trans("transactions.sent_by") }}</h3>
                    <h4>{{ $userRequest->request->sender->name }}</h4>
                </div>
                <div style="text-align: center;">
                    <h3>{{ trans("transactions.date") }}</h3>
                    <h4>{{ $userRequest->request->sent }}</h4>
                </div>
                <input type="submit" class="btn btn-success center-block"
                       style="font-size: 2rem; padding: 15px; margin-top: 25px;"
                       value="{{ trans('transactions.completed') }}">
            </form>
        </div>
    </div>
    <div class="btn btn-danger"
         style="margin: 15px; position: fixed; bottom: 30px; left: 230px; font-size: 2rem;">
        <a href="{{route('transactions.received')}}" style="color: white; display: block; padding: 10px">
            <i class="fas fa-arrow-left"></i> {{ trans('gen.back') }}
        </a>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

    <script>

        let rates;
        let amount = {{$userRequest->request->amount}};


    </script>

@stop
