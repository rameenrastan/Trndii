<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Auth;
use Log;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Mail\PurchaseConfirmation;
use Illuminate\Support\Facades\Mail;
use App\item; 
use App\Repositories\Interfaces\TransactionRepositoryInterface as TransactionRepositoryInterface;
use App\Repositories\Interfaces\ItemRepositoryInterface as ItemRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepositoryInterface;
use Bart\Ab\Ab;
use App\Repositories\Interfaces\ExperimentsRepositoryInterface;
use App\Domain\PaymentManager;

class TransactionsController extends Controller
{

    protected $transactionRepo;
    protected $itemRepo;
    protected $experimentsRepo;
    protected $userRepo;
    protected $ab;
    protected $paymentManager;

    public function __construct(Ab $ab, TransactionRepositoryInterface $transactionRepo, ItemRepositoryInterface $itemRepo, ExperimentsRepositoryInterface $experimentsRepo,
    UserRepositoryInterface $userRepo, PaymentManager $paymentManager){
    
        $this->transactionRepo = $transactionRepo;
        $this->itemRepo = $itemRepo;
        $this->experimentsRepo = $experimentsRepo;
        $this->userRepo = $userRepo;
        $this->ab = $ab;
        $this->paymentManager = $paymentManager;
        
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->transactionRepo->index();
        $userEmail=Auth::user()->email;

        Log::info(session()->getId() . ' | [Viewing Purchase History] | ' . $userEmail);

        return view('layouts.purchasehistory')
            ->with('items', $items);
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
        try {
        $stripeId = Auth::user()->stripe_id;
        $user = Auth::user();

        Log::info(session()->getId() . ' | [Start Purchase Commitment] | ' . $user->email);

        if($stripeId != ''){

            $this->transactionRepo->insert(Auth::user()->email, $id);    

            app('App\Http\Controllers\ItemsController')->numTransactions($id);    
            
            $item = item::find($id);    
            try {
            Mail::to(Auth::user()->email)->send(new PurchaseConfirmation($item, Auth::user()));
            } catch (Exception $e) {
                Log::info(session()->getId() . ' | [Purchase Confirmation Failed] | ' . $user->email);
                return $e->getMessage();
            }
            if($item->Number_Transactions == $item->Threshold)
            {
                $this->paymentManager->chargeCustomers($item->id);
                $this->itemRepo->setThresholdReached($item->id);
            }

            Log::info(session()->getId() . ' | [Purchase Commitment Success] | ' . $user->email);

            if(Auth::user()->segment== "A"){
                $this->experimentsRepo->incrementExperimentAPurchases();
            }
            else if(Auth::user()->segment== "B"){
                $this->experimentsRepo->incrementExperimentBPurchases();
            };

            return redirect('/')->with('success', 'You have successfully commited to this purchase. You will be notified if the item reaches its threshold. Thanks!');
            
        }
        
        else{

            Log::info(session()->getId() . ' | [Purchase Commitment Failed (No Credit Card)] | ' . $user->email);
            return back()->with('error', 'You do not have a Credit Card registered with this account. Please go to the Edit Account page and register a payment option.');
        }     
        } catch (Exception $e) {
            Log::error(session()->getId() . ' | [Purchase Commitment Failed] | ' . $user->email);
            return $e->getMessage();
        }      
    }

    public function updatePurchaseHistory($email, $itemId){

        DB::table('purchased_items')->insert([

            ['email' => $email, 'item_fk' => $itemId] 

        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($itemId)
    {
        $this->transactionRepo->destroy($itemId);
        $this->itemRepo->numTransactions($itemId);
        $itemName=$this->itemRepo->find($itemId)->Name;

        return redirect('/purchaseHistory')->with('success', 'You have successfully deleted '.$itemName.' from your pending transactions!');
    }

    public function updateTokens(Request $request, $id)
    {
        
        $stripeId = Auth::user()->stripe_id;
        $user = Auth::user();
        $nbTokensSpent = $request->input('Tokens_To_Spend');

        if($stripeId != ''){

            $this->itemRepo->addTotalTokens($nbTokensSpent,$id);
            $this->userRepo->removeTokens($user,$nbTokensSpent);
            $this->transactionRepo->insert(Auth::user()->email, $id);    

            app('App\Http\Controllers\ItemsController')->numTransactions($id);    
            
            $item = item::find($id);    
            Mail::to(Auth::user()->email)->send(new PurchaseConfirmation($item, Auth::user()));

            if($item->Number_Transactions == $item->Threshold)
            {
                app('App\Http\Controllers\PaymentsController')->chargeCustomers($item->id);
                $this->itemRepo->setThresholdReached($item->id);
            }

            Log::info('User ' . $user->email . ' successfully commited to purchasing ' . $item->Name);

            if(Auth::user()->segment== "A"){
                $this->experimentsRepo->incrementExperimentAPurchases();
            }
            else if(Auth::user()->segment== "B"){
                $this->experimentsRepo->incrementExperimentBPurchases();
            };

            return redirect('/')->with('success', 'You have successfully commited to this purchase. You will be notified if the item reaches its threshold. Thanks!');
            
        }
        
        else{

            Log::info('User ' . $user->email . ' attempted to purchase item ' . $id . ' without a registered credit card.');
            return back()->with('error', 'You do not have a Credit Card registered with this account. Please go to the Edit Account page and register a payment option.');

        }           
    }

}
