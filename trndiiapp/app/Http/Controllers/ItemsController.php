<?php

namespace App\Http\Controllers;

use App\item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Repositories\Interfaces\ItemRepositoryInterface as ItemRepositoryInterface;

class ItemsController extends Controller
{

    protected $itemRepo;

    public function __construct(ItemRepositoryInterface $itemRepo)
    {
        $this->itemRepo=$itemRepo;
    }

    public function index(){

        $items=$this->itemRepo->index();
        return view('item.index')->with('items',$items);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('item.create');
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
            'Shipping_To' => 'required'
        ));

        //Store in database
        $this->itemRepo->store($request);

        //Redirect
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
        return view('item.viewAllItems')->with('items',$items);
    }
}
