<?php

namespace App\Repositories\Interfaces;
use Illuminate\Http\Request;

interface ItemRepositoryInterface{

    public function store(Request $request);
    public function index();
    public function viewAllItems();
}