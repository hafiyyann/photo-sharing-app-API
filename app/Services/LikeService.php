<?php

namespace App\Services;

use App\Repositories\LikeRepository;

class LikeService{
    
    protected $likeRepository;

    public function __construct(LikeRepository $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }

    public function like($photo_id){
        return $this->likeRepository->createLike($photo_id);
    }

    public function unlike($photo_id){
        return $this->likeRepository->deleteLike($photo_id);
    }

    public function removeAllLike($photo_id){
        return $this->likeRepository->deleteLikes($photo_id);
    }
}