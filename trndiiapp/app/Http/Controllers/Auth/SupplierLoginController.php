<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class SupplierLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:supplier');
    }

    public function showLoginForm()
    {
        return view('auth.supplier-login');
    }

    public function login(Request $request)
    {
        //Validation of data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('supplier')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)){
            
            return redirect()->intended(route('supplier.home'));
        }

        return redirect()->back()->withInput($request->only('email', 'remember'));

    }
}
