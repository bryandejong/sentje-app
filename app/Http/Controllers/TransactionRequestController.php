<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Auth;
use App\TransactionRequest;;
use App\UserContact;
use App\User;
use App\BankAccount;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Date;
use Carbon\Carbon;
use Propaganistas\LaravelIntl\Facades\Currency;


class TransactionRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_received()
    {
        $received = App\TransactionUser::all()->where('users_id', Auth::id())->where('paid', null);
        return view('/transactions/received', ['received' => $received]);
    }

    public function index_sent()
    {
        $sent = App\TransactionRequest::all()->where('sender_id', Auth::id());
        foreach($sent as $model){
            $total = App\TransactionUser::all()->where('transaction_requests_id', $model->id)->count();
            $paid = App\TransactionUser::all()->where('transaction_requests_id', $model->id)->where('paid', !null)->count();
            $model->totalSent = $total;
            $model->totalPaid = $paid;
            $model->amount = Currency::format($model->amount, $model->currency);
            $model->sent = Carbon::parse($model->sent)->toShortDateString();
        }
        return view('transactions/sent', ['sent' => $sent]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new()
    {
        $bankaccounts = BankAccount::all()->where('users_id', Auth::id())->where('active', true);
        $contacts = UserContact::all()->where('user_id', Auth::id());

        return view('transactions/new', ['bankaccounts' => $bankaccounts, 'contacts' => $contacts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transaction = new TransactionRequest();
        $transaction->sender_id = Auth::id();
        $transaction->amount = $request->amount;
        $transaction->note = $request->description;
        $transaction->bank_account_id = $request->bankaccount;
        $transaction->created = date("Y-m-d");
        $transaction->sent = "2019-03-30";
        $transaction->image_url = "";
        $transaction->currency = "EUR";
        $transaction->save();

        foreach($request->contact as $contact){
            $transactionUser = new App\TransactionUser();
            $transactionUser->users_id = $contact;
            $transactionUser->transaction_requests_id = $transaction->id;
            $transactionUser->currency = 'EUR';
            $transactionUser->save();
        }

        return redirect("transactions/sent");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TransactionRequest  $transactionRequest
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionRequest $transactionRequest)
    {

    }

    public function pay($id){
        $userRequest = App\TransactionUser::where('users_id', Auth::id())->where('transaction_requests_id', $id)->first();
        $currencies = App\Currency::all();
        return view('transactions/pay', ['userRequest' => $userRequest, 'currencies' => $currencies]);
    }

    public function completePayment(Request $request) {
        $userRequest = App\TransactionUser::where('users_id', Auth::id())
                ->where('transaction_requests_id', $request->transaction_id)
                ->update(['paid' => date("Y-m-d"), 'currency' => $request->currency]);

        return redirect('transactions/received');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TransactionRequest  $transactionRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionRequest $transactionRequest)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TransactionRequest  $transactionRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionRequest $transactionRequest)
    {
    }

    public function destroy(Request $request)
    {

        $transUsers = App\TransactionUser::where('transaction_requests_id', $request->id)->delete();
        $transRequest = App\TransactionRequest::where('id', $request->id)->first()->delete();
        dd($transUsers, $transRequest);
    }
}
