{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ trans('transactions.new_sentje') }}</h1>
@stop

@section('content')
    <form method="post" action="/transactions/store">
        @csrf
        <div style="max-width: 40%; float: left; margin-right: 10%;">
            <div class="form-group">
                <label for="description">{{ trans('transactions.description') }}</label>
                <input type="text" placeholder="{{ trans('transactions.description_example') }}" class="form-control"
                       id="description" name="description" required>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('transactions.amount') }}</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" placeholder="{{ trans('transactions.amount_example') }}" class="form-control"
                           id="description" name="amount" step="0.01" required>
                </div>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('transactions.expiry_date') }}</label>
                <input type="date" placeholder="{{trans('transactions.expiry_date_exmp')}}" class="form-control"
                       id="description" name="date" required>
            </div>
            <div class="form-group">
                <label for="bankaccount">{{ trans('gen.bank_account') }}</label>
                <select name="bankaccount" value="{{ $bankaccounts->first() }}" class="form-control">
                    @foreach($bankaccounts as $account)
                        <option value="{{ $account->id }}">
                            {{ $account->bank }} | {{ $account->iban }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div style="float: left; width: 45%; top: -25px; position: relative;">
            <table id="contacts-table" class="table table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th>Naam</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($contacts as $model) {
                    $id = $model->contact->id;
                    $name = $model->contact->name;
                    echo("<tr style='cursor: pointer;' id='user#{{$id}}'>");
                    echo("<td><a class='btn btn-primary add-button' data-id='$id' data-name='$name'>
                            <i class='fas fa-plus'></i> </a></td>");
                    echo('<td>' . $name . '</td>');
                    echo('</tr>');
                }
                ?>
                </tbody>
            </table>
        </div>
        <div style="clear: both;"></div>

        <!--  List of added contacts  -->
        <label>Ontvangers</label>
        <div id="addedContacts">

        </div>

        <input type="submit" class="btn btn-success" value="{{ trans('transactions.submit') }}"
               style="position: fixed; bottom: 30px; right: 30px; margin: 15px; padding: 15px; font-size: 2rem;">
    </form>
    <div class="btn btn-danger"
         style="margin: 15px; position: fixed; bottom: 30px; left: 230px; padding: 15px; font-size: 2rem;">
        <a href="{{route('transactions.sent')}}" style="color: white;">
            <i class="fas fa-arrow-left"></i> {{ trans('gen.back') }}
        </a>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script type="text/javascript">

        var addedContactIds = [];

        $(document).ready(function() {
            $('#contacts-table').DataTable({
                "pageLength": 5,
                "lengthChange": false
            });

            $('.add-button').click(function(){
               addContact($(this).data('id'), $(this).data('name'))
            })
        });

        function addContact(id, name) {
            for(i = 0; i < addedContactIds.length; i++){
                if(addedContactIds[i] === id) {
                    return;
                }
            }
            addedContactIds.push(id);
            console.log(addedContactIds);
            $('#addedContacts').append(
                "<div id='contact-" + id + "'>" +
                    "<input type='hidden' value='" + id + "' name='contact[]'>" +
                    "<label>" +
                    "<a class='btn btn-danger remove-button' style='margin-right: 15px' onclick='removeContact(" + id +")'>" +
                    "<i class='fas fa-times'></i></a>" + name +
                    "</label>" +
                "</div>"
            );
        }

        function removeContact(id) {
            console.log(id);
            for(i = 0; i < addedContactIds.length; i++){
                if(addedContactIds[i] === id) {
                    addedContactIds.splice(i, 1);
                    $('#contact-' + id).remove();
                    return;
                }
            }
        }
    </script>
@stop
