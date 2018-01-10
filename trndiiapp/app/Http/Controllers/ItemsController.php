<?php

namespace App\Http\Controllers;

use App\item;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Repositories\Interfaces\ItemRepositoryInterface as ItemRepositoryInterface;
use Log;
use Auth;

class ItemsController extends Controller
{

    protected $itemRepo;

    public function __construct(ItemRepositoryInterface $itemRepo)
    {
        $this->itemRepo=$itemRepo;
    }

    public function index(){

        $items=$this->itemRepo->index();
        Log::info("User " . Auth::user()->email . " is viewing the item list");
        return view('item.index')->with('items',$items);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $supplierNames = Supplier::pluck('name')->toArray();

        $supplierNames=array_combine($supplierNames,$supplierNames);

        return view('item.create', compact('supplierNames'));

        Log::info("User " . Auth::user()->email . "is viewing the item creation page");

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Validate data
        $this->validate($request, array(

            'Name'=>'required|max:255',
            'Price'=>'required',
            'Bulk_Price'=>'required',
            'Tokens_Given'=>'required',
            'Threshold' => 'required| integer',
            'Short_Description' => 'required',
            'Long_Description' => 'required| string',
            'Start_Date' => 'required| date',
            'End_Date' => 'required| date',
            'Picture_URL' => 'required| string',
            'Shipping_To' => 'required',
            'Supplier' => 'required| string'
        ));

        //Store in database
        $this->itemRepo->store($request);

        //Redirect
        Log::info("User " . Auth::user()->email . " created new item " . $request->Name );
        return redirect('/admin')->with('success', 'Item successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\i
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $item=$this->itemRepo->find($id);

        $checkCommit = $this->itemRepo->checkCommit($item);
        Log::info("User " . Auth::user()->email . " is viewing the page for " . $item->Name);
        return view('item.show')->withitem($item)
                                ->with('checkCommit', $checkCommit);
    }

    
    /**
     * Displays the current number of users who are commmited to an item.
     *
     * @param  $id
     * @return $numTransactions
     */
    public function numTransactions($id)
    {

        $this->itemRepo->numTransactions($id);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->itemRepo->update($id);

        return redirect('/viewAllItems')->with('success', 'Item removed!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function viewAllItems()
    {
        $items=$this->itemRepo->viewAllItems();
        Log::info("User " . Auth::user()->email . " is viewing all items.");
        return view('item.viewAllItems')->with('items',$items);
    }

    public function getItemsByCategory(){

        return view('item.viewItemsByCategory');
    }
}
