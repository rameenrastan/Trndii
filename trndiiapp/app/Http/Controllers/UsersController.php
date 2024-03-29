<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Log;

class UsersController extends Controller
{

    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo){
        $this->userRepo = $userRepo;
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
        Log::info(session()->getId() . ' | [View Account Details] | ' . $user->email);
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
        $user = Auth::user();

        Log::info(session()->getId() . ' | [Update Account Started] | ' . $user->email);

        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required|regex:/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/',
            'addressline1' => 'required',
            'postalcode' => 'required|regex:/[A-Za-z][0-9][A-Za-z] ?[0-9][A-Za-z][0-9]/',
            'city' => 'required',
            'country' => 'required'

        ]);

        $curPassword =$request->input('password');
        $newPassword = $request->input('newpassword');
        $confirmPassword = $request->input("confirmnewpassword");
        $curPasswordLenght = strlen($curPassword);
        $newPasswordLenght = strlen($newPassword);
        $confirmPasswordLenght = strlen($confirmPassword);

        if (Hash::check($curPassword, $user->password) && $confirmPassword == $newPassword && $confirmPassword != "" && $newPassword != "" && $curPasswordLenght > 0) {

            $this->userRepo->update($request, $id);
            Log::info(session()->getId() . ' | [Update Account Successful] | ' . $user->email);
            return redirect('/editDetails')->with('success', 'Account Details Updated!');

        }
        else if(($newPasswordLenght > 0 || $confirmPasswordLenght > 0) && $curPassword == ""){
            Log::info(session()->getId() . ' | [Empty Password Fields] | ' . $user->email);
            return redirect('/editDetails')->with('error', "You must fill in all 3 password fields in order to change your password.");
        }
        else if(($newPassword == "" || $confirmPassword == "") && $curPasswordLenght > 0){
            Log::info(session()->getId() . ' | [Empty Password Fields] | ' . $user->email);
            return redirect('/editDetails')->with('error', "New Password and Confirm Password fields can't be empty.");
        }
        else if(!Hash::check($curPassword, $user->password) && $curPasswordLenght > 0){
            Log::info(session()->getId() . ' | [Wrong Current Password] | ' . $user->email);
            return redirect('/editDetails')->with('error', 'Wrong Current Password Entered.');
        }
        else if($confirmPassword != $newPassword && $curPasswordLenght > 0){
            Log::info(session()->getId() . ' | [Password Not Matching] | ' . $user->email);
            return redirect('/editDetails')->with('error', "New Password and Confirm Password don't match.");
        }
        else{
            Log::info(session()->getId() . ' | [Update Account Successful] | ' . $user->email);
            $this->userRepo->update($request, $id);
            return redirect('/editDetails')->with('success', 'Account Details Updated!');
        }
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
