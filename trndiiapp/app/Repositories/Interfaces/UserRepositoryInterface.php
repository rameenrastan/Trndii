<?php
namespace App\Repositories\Interfaces;
 

interface UserRepositoryInterface {
	
    public function findByEmail($email);

    public function updateCreditCard($user, $customerId);
	
}