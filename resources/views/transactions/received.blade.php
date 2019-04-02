{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Ontvangen</h1>
@stop

@section('content')
    <table id="table" style="width: 100%;" class="table table-striped">
        <thead>
        <tr>
            <th></th>
            <th>Bedrag</th>
            <th>Verzender</th>
            <th>Beschrijving</th>
            <th>Datum</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($received as $model) {
            echo('<tr>');
            echo('<td><a class="btn btn-primary" href="/transactions/pay/' . $model->request->id . '">Betalen</a></td>');
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
