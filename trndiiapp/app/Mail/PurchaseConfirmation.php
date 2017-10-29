<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\item; 
use App\User;
use Auth;

class PurchaseConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $item, $user;

    /**
     * Create a new message instance.
     * @param $item, $user
     * @return void
     */
    public function __construct(item $item, User $user)
    {
        $this->User = $user;
        $this->item = $item;   
    }

    /**
     * Build Purchase Confirmation message
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@trndii.com')->view('mail.orderconfirmation')
                                                ->with([
                                                       'itemName' => $this->item->Name,
                                                       'itemPrice' => $this->item->Price,
                                                       'itemBulkPrice' => $this->item->Bulk_Price,
                                                       'threshold' => $this->item->Threshold,
                                                       'shortDescription' => $this->item->Short_Description,
                                                       'userName' => $this->User->name
                                                ]);
    }
}
