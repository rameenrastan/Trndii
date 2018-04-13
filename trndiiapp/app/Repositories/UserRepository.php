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

    /**
     * Finds a user by their email.
     * @param  $email
     * @return User
     */
    public function findByEmail($email){

        return $this->user->where('email', $email)->first();

    }
    
    public function getEmailSearchResults($request)
    {
        $email = $request->search;
        Log::info(session()->getId() . ' | [Search Query Started] | ' . $email);
        return user::search($email)->paginate(16);
    }

    /**
     * Updates a user's credit card information (Stripe ID in the database)
     * @param  $email, $customerId
     * @return void
     */
    public function updateCreditCard($email, $customerId){

        Log::info(session()->getId() . ' | [Query: Update Card Started] | ' . $this->user->email);

        $currentUser = $this->user->where('email', $email)->first();
        $currentUser->stripe_id = $customerId;
        $currentUser->save();

        Log::info(session()->getId() . ' | [Query: Update Card Finished] | ' . $this->user->email);

    }

    /**
     * Updates a user's information in the database.
     * @param  $request, $id
     * @return void
     */
    public function update($request, $id){

        Log::info(session()->getId() . ' | [Query: Information Update Started] | ' . $this->user->email);

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

        Log::info(session()->getId() . ' | [Query: Information Update Completed] | ' . $this->user->email);

    }

    public function addTokens($tempUser, $nbTokens){

        Log::info('Add tokens to ' . $tempUser->id);
        $tempUser->increment('Tokens',$nbTokens);

    }

    public function removeTokens($tempUser, $nbTokens){

        Log::info('Removing ' . $nbTokens . ' tokens from ' . $tempUser->id);
        $tempUser->decrement('Tokens',$nbTokens);

    }

}