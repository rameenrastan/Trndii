<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Repositories\Interfaces\ReviewRepositoryInterface as ReviewRepositoryInterface;

class ReviewController extends Controller
{
    protected $reviewRepo;

    public function __construct(ReviewRepositoryInterface $reviewRepo) { 

        $this->reviewRepo = $reviewRepo;
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
        $this->validate($request, array(

            'Rating'=>'required',
            'Comment'=>'required'
        ));

        $reviewExists = $this->reviewRepo->checkIfReviewExists($request);

        if(!$reviewExists)
        {
            $this->reviewRepo->storeReview($request);
            return redirect('/purchaseHistory')->with('success', 'Thank you for your feedback!');
        }
        else
        {
            return redirect('/purchaseHistory')->with('error', 'You have already reviewed this item!');
        }
    }

    public function storeLikeDislike(Request $request)
    {
        if($request->has('LikeSubmit')){
            $likeSaved = $this->reviewRepo->storeReviewLike($request);
            if($likeSaved){
                return redirect('/item')->with('success', 'Review liked!');
            }
            else{
                return redirect('/item')->with('error', 'Review already liked!');
            }
        }

        if($request->has('DislikeSubmit')){
            $dislikeSaved = $this->reviewRepo->storeReviewDislike($request);
            if($dislikeSaved){
                return redirect('/item')->with('success', 'Review disliked!');
            }
            else{
                return redirect('/item')->with('error', 'Review already disliked!');
            }
        }
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
