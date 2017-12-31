<?php
namespace App\Repositories;
use App\User; 
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Log;

class UserRepository implements UserRepositoryInterface {

    protected $user;
    
    public function __construct(User $user){

        $this->user = $user;

    }

    public function findByEmail($email){

        Log::info('Database query: retrieving user ' . $email);
        return $this->user->where('email', $email)->first();

    }
	
    public function updateCreditCard($email, $customerId){

        Log::info('Database query: updating credit card information of user ' . $email);
        $currentUser = $this->user->where('email', $email)->first();
        $currentUser->stripe_id = $customerId;
        $currentUser->save();

    }

    public function update($request, $id){

        Log::info('Database query: updating account information of user ' . $id);
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

    }

}