<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class UserService{
    protected $userRepository;

    /**
     * Constructor for UserService
     * 
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Storing user data
     * 
     * @param array $request
     * 
     * @return User $user
     */
    public function storeUser($request){
        $validator = Validator::make($request, [
            'name'          => 'required',
            'email'         => 'required|unique:users,email',
            'password'      => 'required' 
        ]);

        if($validator->fails()){
            throw new InvalidArgumentException($validator->errors()->first());
        }

        try {
            return $this->userRepository->storeUser($request);
        } catch (Exception $e) {
            throw new InvalidArgumentException("Registration Failed");
        }

        $result = $this->userRepository->storeUser($request);

        return $result;
    }

    /**
     * Getting user data by email
     * 
     * @param string $email
     * 
     * @return User $user
     */
    public function getUserByEmail($email){
        return $this->userRepository->getUser($email);
    }
}