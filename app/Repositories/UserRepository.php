<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository{
    protected $user;

    /**
     * Contructor for UserRespository
     * 
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Storing user data
     * 
     * @param array $request
     * 
     * @return User $user
     */
    public function storeUser($request){
        $user = new $this->user;

        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);

        $user->save();

        return $user->fresh();
    }

    /**
     * Getting user data by email
     * 
     * @param string $email
     * 
     * @return User $user
     */
    public function getUser($email){
        return $this->user->where('email', $email)->first();
    }
}