{{-- resources/views/admin/dashboard.blade.php --}}
<?php
use Propaganistas\LaravelIntl\Facades\Currency;
?>
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{trans('home.received')}}</h1>
@stop

@section('content')
    <table id="table" style="width: 100%;" class="table table-striped">
        <thead>
        <tr>
            <th></th>
            <th>{{trans('home.amount')}}</th>
            <th>{{trans('home.sender')}}</th>
            <th>{{trans('home.description')}}</th>
            <th>{{trans('home.date')}}</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($received as $model) {
            echo('<tr>');
            echo('<td><a class="btn btn-primary" href="/transactions/pay/' . $model->request->id . '">' . trans("home.pay") . '</a></td>');
            echo('<td>' . $model->request->amount . '</td>');
            echo('<td>' . $model->request->sender->name . '</td>');
            echo('<td>' . $model->request->note . '</td>');
            echo('<td>' . $model->request->sent . '</td>');
            echo('</tr>');
        }
        ?>
        </tbody>
    </table>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script type="text/javascript">$(document).ready(() => {
            $('#contacts-table').DataTable();
        });</script>
@stop
