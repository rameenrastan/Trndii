<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UsersController extends Controller
{

    protected $user;

    public function _construct(UserRepositoryInterface $user){

        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();
        return view('layouts.editAccount')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required|regex:/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/',
            'addressline1' => 'required',
            'postalcode' => 'required|regex:/[A-Za-z][0-9][A-Za-z] ?[0-9][A-Za-z][0-9]/',
            'city' => 'required',
            'country' => 'required'

        ]);

        $user = Auth::user();

        $curPassword =$request->input('password');
        $newPassword = $request->input('newpassword');
        $confirmPassword = $request->input("confirmnewpassword");
        $curPasswordLenght = strlen($curPassword);
        $newPasswordLenght = strlen($newPassword);
        $confirmPasswordLenght = strlen($confirmPassword);

        if (Hash::check($curPassword, $user->password) && $confirmPassword == $newPassword && $confirmPassword != "" && $newPassword != "" && $curPasswordLenght > 0) {


            $user->password = Hash::make($newPassword);
            $user->name = $request->input('name');
            $user->country = $request->input('country');
            $user->postalcode = $request->input('postalcode');
            $user->phone = $request->input('phone');
            $user->addressline1 = $request->input("addressline1");
            $user->addressline2 = $request->input("addressline2");
            $user->city = $request->input("city");
            $user->save();
            return redirect('/editDetails')->with('success', 'Account Details Updated!');

        }
        else if(($newPasswordLenght > 0 || $confirmPasswordLenght > 0) && $curPassword == ""){
            return redirect('/editDetails')->with('error', "You must fill in all 3 password fields in order to change your password.");
        }
        else if(($newPassword == "" || $confirmPassword == "") && $curPasswordLenght > 0){
            return redirect('/editDetails')->with('error', "New Password and Confirm Password fields can't be empty.");
        }
        else if(!Hash::check($curPassword, $user->password) && $curPasswordLenght > 0){
            return redirect('/editDetails')->with('error', 'Wrong Current Password Entered.');
        }
        else if($confirmPassword != $newPassword && $curPasswordLenght > 0){
            return redirect('/editDetails')->with('error', "New Password and Confirm Password don't match.");
        }
        else{
            $user->name = $request->input('name');
            $user->country = $request->input('country');
            $user->postalcode = $request->input('postalcode');
            $user->phone = $request->input('phone');
            $user->addressline1 = $request->input("addressline1");
            $user->addressline2 = $request->input("addressline2");
            $user->city = $request->input("city");
            $user->save();
            return redirect('/editDetails')->with('success', 'Account Details Updated!');
        }
    }



    ///// User Acount functions

    public function editAccountView()
    {
        return view('layouts.editAccount');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
