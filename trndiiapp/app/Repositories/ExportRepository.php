<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2017-12-28
 * Time: 8:00 PM
 */

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ExportRepositoryInterface;

class ExportRepository implements ExportRepositoryInterface
{

    /**
     * Retrieves all addresses of users commited to an item from the database.
     * @param  int $itemId
     * @return $addresses
     */
    public function findAddressByItemId($itemId)
    {
        $addresses = DB::table('users')
            ->join('transactions', 'users.email', '=', 'transactions.email')
            ->join('items', 'items.id', '=', 'transactions.item_fk')
            ->select('users.name','users.addressline1' , 'users.postalcode', 'users.city', 'users.country', 'users.email')
            ->where('items.id', $itemId)
            ->get();
        return $addresses;

    }
}