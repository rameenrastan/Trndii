<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Supplier;
use Illuminate\Http\Request;
use Log;
use Auth;
use App\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class AdminController extends Controller
{

    protected $userRepo;
    protected $logger;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepo, Log $logger)
    {
        $this->middleware('auth:admin');
        $this->userRepo = $userRepo;
        $this->logger = $logger;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->logger::info("User " . Auth::user()->email . " is viewing the admin home page.");
        return view('admin.admin-home');
    }

    public function createSupplier(){
        return view('supplier.create');
    }

    public function banUserForm(){

        $userEmails = User::pluck('email')->toArray();

        $userEmails=array_combine($userEmails,$userEmails);


        //return view('item.create', compact('supplierNames'), compact('categories'));

        return view('admin.banUserForm', compact('userEmails'));
    }
    public function banUser(Request $request){

        //Validate data
        $this->validate($request, array(

            'Comment' => 'required| string'
        ));

        $ban_type=$request->Ban_Type;
        $email=$request->Email;
        $suspension_time=$request->Suspension_Time;
        $comment=$request->Comment;

        $user=$this->userRepo->findByEmail($email);



        if($ban_type=="Ban"){
            $this->logger::info('Ban user' . $email);
            $user->ban(['comment' => 'Enjoy your ban!',]);
            return redirect('/admin')->with('success','You banned '. $email);
        }
        else if($ban_type=="Unban"){
            $this->logger::info('Unban user' . $email);
            $user->unban();

            return redirect('/admin')->with('success','You unbanned '. $email);
        }

        else if($ban_type=="Suspension"){
            $this->logger::info('Ban user' . $email. ' for '.$suspension_time.' days');
            $user->ban([
                'comment' => 'You\'re banned for '.$suspension_time.' days',
                'expired_at' => '+'.$suspension_time.' days',
            ]);
            return redirect('/admin')->with('success','You banned '. $email.  ' for '.$suspension_time.' days');
        }

    }

    public function storeSupplier(Request $request){

        //Validate data
        $this->validate($request, array(

            'name'=>'required|max:255',
            'phone'=>'required|min:10 | max:10',
            'addressline1'=>'required',
            'postalcode' => 'required',
            'city' => 'required|string',
            'country' => 'required| string',
            'email' => 'required| email',
            'password' => 'required',

        ));

        $request->password = bcrypt($request->password);
        
        //Store in database
        $supplier= new Supplier;

        $supplier->name=$request->name;
        $supplier->phone=$request->phone;
        $supplier->addressline1=$request->addressline1;
        $supplier->addressline2=$request->adressline2;
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
