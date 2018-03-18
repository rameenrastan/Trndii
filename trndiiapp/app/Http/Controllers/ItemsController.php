<?php

namespace App\Http\Controllers;

use App\item;
use App\Supplier;
use App\Category;
use Dompdf\Exception;
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
    
    public function __construct(ItemRepositoryInterface $itemRepo, TransactionRepositoryInterface $transactionRepo, UserRepositoryInterface $userRepo)
    {
        $this->itemRepo=$itemRepo;
        $this->transactionRepo = $transactionRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * Displays the item index list to a user.
     *
     * @param  null
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $items=$this->itemRepo->index();
        Log::info(session()->getId() . ' | [Viewing Item List] | ' . Auth::user()->email);
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

        Log::info(session()->getId() . ' | [Create Item Page] | ' . 'Admin');

        return view('item.create', compact('supplierNames'), compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Log::info(session()->getId() . ' | [Create Item Started] | ' . 'Admin');

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

        Log::info(session()->getId() . ' | [Create Item Completed] | ' . 'Admin');
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
        try {
        $item = $this->itemRepo->find($id);
        $checkCommit = $this->itemRepo->checkCommit($item);

        if (Auth::user())
            Log::info(session()->getId() . ' | [Viewing Item Page] | ' . Auth::user()->email);
        return view('item.show')->withitem($item)
            ->with('checkCommit', $checkCommit);
        } catch (Exception $e) {
            Log::error(session()->getId() . ' | [Viewing Item Page Failed] | ' . Auth::user()->email);
        }
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
        Log::info(session()->getId() . ' | [Item Removed] | ' . 'Admin');
        return redirect('/viewAllItems')->with('success', 'Item removed!');
        }
        catch(Exception $e) 
        {
            return $e->getMessage();
            Log::error(session()->getId() . ' | [Item Removed Failed] | ' . 'Admin');
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
        Log::info(session()->getId() . ' | [Admin View Items] | ' . 'Admin');
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
        Log::info(session()->getId() . ' | [Item Search Started]');
        $items = $this->itemRepo->getSearchResults($request);
        Log::info(session()->getId() . ' | [Item Search Finished]');
        return view('item.search')->with('items', $items);
        } catch(Exception $e) {
            return $e->getMessage();
            Log::info(session()->getId() . ' | [Item Search Failed]');
        }
    }

    //Get purchase confirmation page
    public function getConfirm($id)
    {
        $item = $this->itemRepo->find($id);
        $checkCommit = $this->itemRepo->checkCommit($item);

        if (Auth::user())
            Log::info("User " . Auth::user()->email . " is viewing the purchase confirmation page after buying " . $item->Name);
        return view('item.confirm')->withitem($item)
            ->with('checkCommit', $checkCommit);

    }

    public function getItemThread($itemId)
    {

        try {
            $item=$this->itemRepo->find($itemId);
            if($item==null){
                Log::info("Unable to retrieve item from database, needed to display its comment thread");
                throw new Exception('Item not found on databae.');
            }else {
                Log::info("Retrieving item to than display the comment thread assosiated to it.");
                return view('item.viewItemCommentThread')->with('item', $item)->with('user', Auth::user());
            }
        } catch (Exception $e) {

            return view('item.viewItemCommentThread')->with('item', $item)->with('user', Auth::user());
        }



    }


}
