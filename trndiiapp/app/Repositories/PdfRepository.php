<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2017-12-28
 * Time: 8:00 PM
 */

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\PdfRepositoryInterface;
use Log;

class PdfRepository implements PdfRepositoryInterface
{

    public function findAddressByItemId($itemId)
    {

        Log::info("Database query: retrieving all addresses of users commited to item " . $id);
        $addresses = DB::table('users')
            ->join('transactions', 'users.email', '=', 'transactions.email')
            ->join('items', 'items.id', '=', 'transactions.item_fk')
            ->select('users.name','users.addressline1' , 'users.postalcode', 'users.city', 'users.country')
            ->where('items.id', $itemId)
            ->get();
        return $addresses;

    }
}