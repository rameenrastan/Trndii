<?php

namespace App\Http\Controllers;

use App\item;
use App\Supplier;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Repositories\Interfaces\ItemRepositoryInterface as ItemRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface as CategoryRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface as TransactionRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Auth;
use Feature;

class ItemsController extends Controller
{

    protected $itemRepo;
    protected $transactionRepo;
    protected $userRepo;
    protected $logger;
    
    public function __construct(Log $logger, ItemRepositoryInterface $itemRepo, TransactionRepositoryInterface $transactionRepo, UserRepositoryInterface $userRepo)
    {
        $this->itemRepo=$itemRepo;
        $this->transactionRepo = $transactionRepo;
        $this->userRepo = $userRepo;
        $this->logger = new Log;
    }

    /**
     * Displays the item index list to a user.
     *
     * @param  null
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $items=$this->itemRepo->index();
        $this->logger::info("User " . Auth::user()->email . " is viewing the item list");
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

        $categories = Category::pluck('Name')->toArray();

        $categories = array_combine($categories,$categories);

        return view('item.create', compact('supplierNames'), compact('categories'));

        $this->logger::info("User " . Auth::user()->email . "is viewing the item creation page");

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
            'Category' => 'required| string',
            'Start_Date' => 'required| date',
            'End_Date' => 'required| date',
            'Picture_URL' => 'required| string',
            'Shipping_To' => 'required',
            'Supplier' => 'required| string'
        ));

        //Store in database
        $this->itemRepo->store($request);

        //$this->logger::info("User " . $user->email . " created new item ". $request->Name);
        $this->logger::info("Admin created new item " . $request->Name );
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

        $item = $this->itemRepo->find($id);
        $checkCommit = $this->itemRepo->checkCommit($item);

        if (Auth::user())
            $this->logger::info("User " . Auth::user()->email . " is viewing the page for " . $item->Name);
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
        try { 
        $this->itemRepo->update($id);

        return redirect('/viewAllItems')->with('success', 'Item removed!');
        }
        catch(Exception $e) 
        {
            return $e->getMessage();
            $this->logger::error('');
        }
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

    /**
     * Displays all items to an admin.
     * @param  null
     * @return \Illuminate\Http\Response
     */
    public function viewAllItems()
    {
        $items=$this->itemRepo->viewAllItems();
        //$this->logger::info("User " . $user->email . " is viewing all items ");
        $this->logger::info("Admin is viewing all items.");
        return view('item.viewAllItems')->with('items',$items);
    }

    /**
     * Displays all items by category.
     *
     * @param  null
     * @return \Illuminate\Http\Response
     */
    public function getItemsByCategory(CategoryRepositoryInterface $categoriesRepo){

        $items=$this->itemRepo->viewAllItems();
        $categories=$categoriesRepo->getCategories();
        return view('item.viewItemsByCategory')->with('items', $items)->with('categories', $categories);
    }

    /**
     * Gets search results of a user search bar input.
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        try {
        $items = $this->itemRepo->getSearchResults($request);
        $this->logger::info("A user is viewing search results of " . $request->search);
        return view('item.search')->with('items', $items);
        } catch(Exception $e) {
            return $e->getMessage();
            $this->logger::error("Username: " . Auth::user()->email . " Operation Code: " );
        }
    }

}
