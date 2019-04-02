{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ trans('Contacten') }}</h1>
@stop

@section('content')
    <a href="/contacts/add" type="button" class="btn btn-default">+</a>
    <table style="width: 100%;" class="table  table-hover">
        <tr>
            <th>Contact</th>
            <th>Email</th>
            <th></th>
        </tr>

        @foreach($allContacts as $contact )
        <tr id="contact-{{$contact->contact_id }}">
            <td> {{ $contact->contact->name }}</td>
            <td> {{ $contact->contact->email}}</td>
            <td><a onclick="removeContact({{ $contact->contact_id }})" class="btn btn-danger">Delete</a></td>
        </tr>
        @endforeach
    </table>
@stop

@section('css')
@stop

@section('js')
    <script>
        function removeContact(id) {
            $('#contact-' + id).remove();
            $.ajax({
                method: 'DELETE', // Type of response and matches what we said in the route
                url: '/contacts/delete', // This is the url we gave in the route
                data: {
                    'id': id,
                    '_token': "{{csrf_token()}}"
                }, // a JSON object to send back
                success: function (response) { // What to do if we succeed

                },
                error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        }
    </script>
@stop
