<?php

namespace App\Http\Controllers;

use App\BankAccount;
use Faker\Calculator\Iban;
use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allBankaccounts = App\BankAccount::all()->where('users_id', Auth::id())->where('active', '1');

        return view('accounts', ['allBankaccounts' => $allBankaccounts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('addAccount');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['IBAN' => 'iban']);
        $bank = new BankAccount();
        $bank -> users_id = Auth::id();
        $bank -> bank = $request->bank;
        $bank -> iban = $request->IBAN;
        $bank->save();

        return redirect('/accounts')->with('success', 'Bank account is aangemaakt!');
    }

    public function update(Request $request)
    {
        $account = App\BankAccount::where('id', $request->id)->update(['active' => 0]);
        dd($account);
    }
}
