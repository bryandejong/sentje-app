<?php

namespace App\Http\Controllers;

use App;
use App\UserContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index(){
        $allContacts = App\UserContact::all()->where('user_id', Auth::id());
        return view('contacts', ['allContacts' => $allContacts]);
    }

    public function create(){

        return view('addContact');
    }

    public function store(Request $request){
        $this->validate($request,["email"=>'email']);
        $account = App\User::where('email', $request->email)->first();
        $allContacts = App\UserContact::all()->where('user_id', Auth::id());

                if($account->id == null){
                    return redirect('/contacts');
                }
                foreach ($allContacts as $contact){
                    if($contact->contact_id == $account->id){
                        return redirect('/contacts');
                    }
                }

                $contact = new UserContact;
                $contact -> user_id = Auth::id();
                $contact -> contact_id = $account->id;

                $contact -> save();
                return redirect('/contacts');

    }

    public function delete(Request $request){
        $contact = App\UserContact::where('user_id', Auth::id())->where('contact_id', $request->id)->delete();
        dd($contact);
    }
}
