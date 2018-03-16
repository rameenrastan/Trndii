<?php
namespace App\Repositories;
use App\User; 
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Log;

class UserRepository implements UserRepositoryInterface {


    protected $user;
    protected $logger;
    
    public function __construct(User $user, Log $logger){

        $this->user = $user;
        $this->logger = $logger;

    }

    /**
     * Finds a user by their email.
     * @param  $email
     * @return User
     */
    public function findByEmail($email){

        return $this->user->where('email', $email)->first();

    }
    
    /**
     * Updates a user's credit card information (Stripe ID in the database)
     * @param  $email, $customerId
     * @return void
     */
    public function updateCreditCard($email, $customerId){

        $currentUser = $this->user->where('email', $email)->first();
        $currentUser->stripe_id = $customerId;
        $currentUser->save();

    }

    /**
     * Updates a user's information in the database.
     * @param  $request, $id
     * @return void
     */
    public function update($request, $id){

        $this->logger::info(session()->getId() . ' | [Query: Information Update Started] | ' . $this->user->email);

        $newPassword = $request->input('newpassword');
        $currentUser = $this->user->find($id);
        $currentUser->password = Hash::make($newPassword);
        $currentUser->name = $request->input('name');
        $currentUser->country = $request->input('country');
        $currentUser->postalcode = $request->input('postalcode');
        $currentUser->phone = $request->input('phone');
        $currentUser->addressline1 = $request->input("addressline1");
        $currentUser->addressline2 = $request->input("addressline2");
        $currentUser->city = $request->input("city");
        $currentUser->save();

        $this->logger::info(session()->getId() . ' | [Query: Information Update Completed] | ' . $this->user->email);

    }

}