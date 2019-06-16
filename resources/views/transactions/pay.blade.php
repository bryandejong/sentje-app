{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ trans('home.confirm') }}</h1>
@stop

@section('content')
    <div class="panel panel-primary" style="max-width: 50%; margin: 50px auto">
        <div class="panel-title page-header"><h2 class="text-center">{{ $userRequest->request->note }}</h2></div>
        <div class="panel-body">
            <form method="post" action="/transactions/completePayment">
                @csrf
                <div class="input-group" style="margin: auto; max-width: 80%; text-align: center;">
                    <h2 class="well well-lg"><span id="amount-span">{{ $userRequest->request->amount }}</span><span id="currency-span">{{ $userRequest->request->currency }}</span></h2>
                </div>
                <div style="text-align: center;">
                    <h3>{{ trans("home.sender") }}</h3>
                    <h4>{{ $userRequest->request->sender->name }}</h4>
                </div>
                <div style="text-align: center;">
                    <h3>{{ trans("home.date") }}</h3>
                    <h4>{{ $userRequest->request->sent }}</h4>
                </div>

                <div class="input-group" style="margin: auto; max-width: 80%; text-align: center;">
                    <h3 for="note">{{ trans("home.note") }}</h3>
                    <input id="note" name="note" placeholder="{{ trans("home.note_example")}}" class="form-control" style="width: 300px;">
                </div>

                <div class="input-group" style="max-width: 350px; margin: 25px auto 30px;">
                    <label class="input-group-addon">{{ trans('home.currency') }}</label>
                    <select id="currency-select" class="form-control" value="EUR" name="currency">
                        <option value="EUR">EUR</option>
                        <option value="USD">USD</option>
                        <option value="GBP">GBP</option>
                    </select>
                </div>
                <input type="hidden" value="{{ $userRequest->transaction_requests_id }}" name="transaction_id">

                <input type="submit" class="btn btn-success center-block"
                       style="font-size: 2rem; padding: 15px; margin-top: 25px;"
                       value="{{ trans('home.pay') }}">
            </form>
        </div>
    </div>
    <div class="btn btn-danger"
         style="margin: 15px; position: fixed; bottom: 30px; left: 230px; font-size: 2rem;">
        <a href="{{route('transactions.received')}}" style="color: white; display: block; padding: 10px">
            <i class="fas fa-arrow-left"></i> {{ trans('home.back') }}
        </a>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop
