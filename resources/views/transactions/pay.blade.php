{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ trans('transactions.new_sentje') }}</h1>
@stop

@section('content')
    <div class="panel panel-primary" style="max-width: 50%; margin: 50px auto">
        <div class="panel-title page-header"><h2 class="text-center">{{ $userRequest->request->note }}</h2></div>
        <div class="panel-body">
            <form method="post" action="/transactions/completePayment">
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

                <div class="input-group" style="max-width: 350px; margin: 25px auto 30px;">
                    <label class="input-group-addon">{{ trans('transactions.currency') }}</label>
                    <select id="currency-select" class="form-control" value="EUR" name="currency">
                        <option value="EUR">EUR</option>
                        <option value="USD">USD</option>
                        <option value="GBP">GBP</option>
                    </select>
                </div>
                <input type="hidden" value="{{ $userRequest->transaction_requests_id }}" name="transaction_id">

                <input type="submit" class="btn btn-success center-block"
                       style="font-size: 2rem; padding: 15px; margin-top: 25px;"
                       value="{{ trans('transactions.pay') }}">
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

        $(document).ready(() => {
            $('#amount-span').text(amount);

            $.ajax({
                url: "https://www.freeforexapi.com/api/live?pairs="
                    @for($i = 1; $i < $currencies->count(); $i++)
                    + "EUR{{$currencies[$i]->currency}}"
                        @if($i < $currencies->count() - 1)
                        + ","
                        @endif
                    @endfor
                        +"",
                // Work with the response
                success: function (response) {
                    rates = response.rates;
                    console.log(rates);
                }
            });

            $('#currency-select').change(function () {
                const pair = "EUR" + $('#currency-select').val();
                const rate = pair == "EUREUR" ? 1 : rates[pair].rate;
                $('#amount-span').text(amount * rate);
                $('#currency-span').text($('#currency-select').val());
            })
        });
    </script>

@stop
