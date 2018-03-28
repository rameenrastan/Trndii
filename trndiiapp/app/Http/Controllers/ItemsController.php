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
use App\Repositories\Interfaces\ReviewRepositoryInterface as ReviewRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Auth;
use Feature;
use Illuminate\Support\Facades\Mail;
use App\Mail\ItemExpired;
use App\Comment;

class ItemsController extends Controller
{

    protected $itemRepo;
    protected $transactionRepo;
    protected $userRepo;
    protected $reviewRepo;
    
    public function __construct(ItemRepositoryInterface $itemRepo, TransactionRepositoryInterface $transactionRepo, UserRepositoryInterface $userRepo, ReviewRepositoryInterface $reviewRepo)
    {
        $this->itemRepo=$itemRepo;
        $this->transactionRepo = $transactionRepo;
        $this->userRepo = $userRepo;
        $this->reviewRepo = $reviewRepo;

        $this->middleware('auth:admin', ['only'=>['viewAllItems' , 'create']]);
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
            'Actual_Price'=>'required',
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

        $itemReviews = $this->reviewRepo->getItemReviews($id);
        $comments = $this->itemRepo->getCommentsForItem($id);

        if (Auth::user())
            Log::info(session()->getId() . ' | [Viewing Item Page] | ' . Auth::user()->email);
        return view('item.show')->withitem($item)
            ->with('itemReviews', $itemReviews)
            ->with('checkCommit', $checkCommit)->with('itemComments', $comments);
        } catch (Exception $e) {
            Log::error(session()->getId() . ' | [Viewing Item Page Failed] | ' . Auth::user()->email);
        }
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
        Log::info(session()->getId() . ' | [View Item Confirmation Started]' . $id);

        $item = $this->itemRepo->find($id);
        $checkCommit = $this->itemRepo->checkCommit($item);

        if (Auth::user())
            Log::info(session()->getId() . ' | [View Item Confirmation Finished]' . Auth::user()->email);
        return view('item.confirm')->withitem($item)
            ->with('checkCommit', $checkCommit);

    }

    public function getItemThread($itemId)
    {
        try {
            $item=$this->itemRepo->find($itemId);
            $comments = $this->itemRepo->getCommentsForItem($itemId);
            if($item==null){
                throw new Exception('Item not found on databae.');
            }else {
                return view('item.viewItemCommentThread')->with('item', $item)->with('user', Auth::user())->with('itemComments', $comments);
            }
        } catch (Exception $e) {
            Log::error(session()->getId() . ' | [Item Thread Failed]' . $itemId);
        }
    }


    public function addComment(Request $request, $itemId, $page)
    {
        $this->validate($request, array(
            'comment'   =>  'required|min:5|max:2000'
        ));

        $this->itemRepo->addCommentToItem($request,$itemId);

        if($page == "itemCommentThreadOnly") {
            return redirect()->route('ItemController', [$itemId]);
        }

        if($page == "itemShow") {
            return redirect()->route('showItem', [$itemId]);
        }


    }


}
