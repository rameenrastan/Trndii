<?php

namespace App\Repositories\Interfaces;

interface TransactionRepositoryInterface{

    public function index();
    public function insert($email, $itemId);
    public function getAllByItemId($id);

}