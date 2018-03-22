<?php

namespace App\Repositories\Interfaces;

interface TransactionRepositoryInterface{

    public function index();
    public function insert($email, $itemId, $chargeId, $tokens);
    public function getAllByItemId($id);
    public function destroy($itemId);

}