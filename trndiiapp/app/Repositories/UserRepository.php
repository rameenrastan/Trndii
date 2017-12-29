<?php
namespace App\Repositories;
use App\User; 
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {


    protected $user;
    
    public function __construct(User $user){

        $this->user = $user;

    }

    public function findByEmail($email){

        return $this->user->where('email', $email)->first();

    }
	
    public function updateCreditCard($email, $customerId){
        $currentUser = $this->user->where('email', $email)->first();
        $currentUser->stripe_id = $customerId;
        $currentUser->save();

    }

}