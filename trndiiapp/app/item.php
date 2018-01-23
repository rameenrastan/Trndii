<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    use Searchable;

    protected $fillable = [
        'id', 'Name', 'Price','Bulk_Price','Threshold', 'Tokens_Given', 'Short_Description', 'Long_Description','Category','Status','Number_Transactions','Start_Date','End_Date','Picture_URL', 'Shipping_To','Supplier','created_at','updated_at'
    ];

    public function searchableAs()
    {
        return 'Name';
    }
}
