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
use Symfony\Component\HttpFoundation\Response;

class TransactionRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexReceived()
    {
        $received = App\TransactionUser::all()->where('users_id', Auth::id())->where('paid', null);
        foreach($received as $model){
            $model->request->amount = Currency::format($model->request->amount, $model->request->currency);
            $model->request->sent = Carbon::parse($model->request->sent)->toShortDateString();
        }
        return view('/transactions/received', ['received' => $received]);
    }

    public function indexSent()
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
        $bank = BankAccount::all()->where('users_id', Auth::id())->where('active', true);

        if($bank->first() == null){
          return redirect('/accounts')->with('danger', 'Je hebt nog geen bank account...');
        }

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
        $transaction->sent = date("Y-m-d");
        $transaction->image_url = "";
        $transaction->currency = "EUR";
        $transaction->save();

        foreach($request->contact as $contact){
            $transactionUser = new App\TransactionUser();
            $transactionUser->users_id = $contact;
            $transactionUser->transaction_requests_id = $transaction->id;
            $transactionUser->currency = 'EUR';
            $transactionUser->mollie_id = "";
            $transactionUser->save();
        }

        return redirect("transactions/sent")->with('success', 'Verzoek is gestuurd!');
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
        $userRequest->request->sent = Carbon::parse($userRequest->request->sent)->toShortDateString();
        return view('transactions/pay', ['userRequest' => $userRequest, 'currencies' => $currencies]);
    }

    public function completePayment(Request $request) {
                
        $currency = $request->currency;

        $userRequest = App\TransactionUser::where('users_id', Auth::id())
                ->where('transaction_requests_id', $request->transaction_id)->first();

        $amount = App\Currency::convertTo($userRequest->request->amount, $currency);

        $amount = number_format((float)$amount, 2, '.', '');

        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey("test_uaUHPuuRsJW6Gmz9K5Ee99rDrBdbak");
        $payment = $mollie->payments->create([
            "amount" => [
                "currency" => $currency,
                "value" => "$amount"
            ],
            "description" => "My first API payment",
            "redirectUrl" => "http://localhost.sentje/",
            "webhookUrl"  => "http://comitto.serveo.net/transactions/update",
        ]);
        //ssh -R comitto.serveo.net:80:127.0.0.2:80 serveo.net for webhook to work
        
        App\TransactionUser::where('users_id', Auth::id())
                ->where('transaction_requests_id', $request->transaction_id)
                ->update(['paid' => date("Y-m-d"), 'currency' => $request->currency, 'paymentNote' => $request->note, 'mollie_id' => $payment->id]);

        return redirect($payment->getCheckoutUrl());
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
    public function update(Request $request)
    {
        App\TransactionUser::where('mollie_id', $request->id)
                ->update(['paid' => date("Y-m-d")]);
        error_log($request);
    }

    public function destroy(Request $request)
    {

        $transUsers = App\TransactionUser::where('transaction_requests_id', $request->id);
        foreach($transUsers as $model) {
            if($model->paid != null) {
                return response()->json(['message' => 'Transaction with existing payments cannot be cancelled'], 403);
            }
        }
        $transUsers->delete();
        $transRequest = App\TransactionRequest::where('id', $request->id)->first()->delete();
        dd($transUsers, $transRequest);
    }
}
