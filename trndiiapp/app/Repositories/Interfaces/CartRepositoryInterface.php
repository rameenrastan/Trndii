<?php

namespace App\Repositories\Interfaces;
use Illuminate\Http\Request;

interface CartRepositoryInterface{

    public function store(Request $request);
    public function destroy($id);
}