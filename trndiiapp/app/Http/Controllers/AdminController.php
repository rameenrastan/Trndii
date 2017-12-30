<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Supplier;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.admin-home');
    }

    public function createSupplier(){
        return view('supplier.create');
    }

    public function storeSupplier(Request $request){

        /*
        $table->increments('id');
        $table->string('name');
        $table->string('phone')->default("Enter a phone number");
        $table->string('addressline1')->default("Enter an address line");
        $table->string('addressline2')->nullable();
        $table->string('postalcode')->default("Enter a postal code");
        $table->string("city")->default("Enter a city");
        $table->string('country')->default("Enter a country");
        $table->string('email')->unique();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
        */

        //Validate data
        $this->validate($request, array(

            'Name'=>'required|max:255',
            'Phone'=>'required',
            'addressline1'=>'required',
            'addressline2'=>'required',
            'postalcode' => 'required',
            'city' => 'required|string',
            'country' => 'required| string',
            'email' => 'required| email',
            'password' => 'required',

        ));

        //Store in database
        $supplier= new Supplier();

        $supplier->Name=$request->Name;
        $supplier->Phone=$request->Phone;
        $supplier->Addressline1=$request->Addressline1;
        $supplier->Addressline2=$request->Adressline2;
        $supplier->postalcode=$request->postalcode;
        $supplier->city=$request->city;
        $supplier->country=$request->country;
        $supplier->email=$request->email;
        $supplier->password=$request->password;

        $supplier->save();

        //Redirect
        return redirect('/admin')->with('success', 'Supplier successfully created.');

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
     * @param  \App\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(admin $admin)
    {
        //
    }
}
