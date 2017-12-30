<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PreregisteredUser;
use Illuminate\Validation\Rule;
use Log;

class PreregisteredUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('preregistration');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|unique:preregistered_users'
        ]);

        $preregisteredUser = new PreregisteredUser;
        $preregisteredUser->firstName = $request->input('firstName');
        $preregisteredUser->lastName = $request->input('lastName');
        $preregisteredUser->email = $request->input('email');
        $preregisteredUser->save();
        
        Log::info($preregisteredUser->email . " has preregistered an account.");
        return redirect('/preregistration')->with('success', 'Thank you for your interest! You will be notified via email when the website goes live.');
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
    public function edit($id)
    {
        //
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
        //
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
