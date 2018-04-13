<?php
namespace App\Repositories\Interfaces;
 

interface UserRepositoryInterface {
	
    public function findByEmail($email);
    public function updateCreditCard($user, $customerId);
    public function update($request, $id);
    public function addTokens($tempUser, $nbTokens);
    public function removeTokens($tempUser, $nbTokens);
    public function getEmailSearchResults($request);

}