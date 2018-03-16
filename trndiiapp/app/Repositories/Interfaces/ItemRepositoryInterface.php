<?php

namespace App\Repositories\Interfaces;
use Illuminate\Http\Request;

interface ItemRepositoryInterface{

    public function store(Request $request);
    public function index();
    public function viewAllItems();
    public function update($id);
    public function numTransactions($id);
    public function find($id);
    public function checkCommit($item);
    public function setThresholdReached($id);
    public function setExpired($id);
    public function getExpiredItems();
    public function getSupplierItems();
    public function addCommentToItem(Request $request,$itemId);
    public function getCommentsForItem($itemId);


}