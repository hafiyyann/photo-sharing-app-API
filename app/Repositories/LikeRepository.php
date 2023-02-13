<?php

namespace App\Repositories;

use App\Models\Like;

class LikeRepository{
    protected $like;

    public function __construct(Like $like)
    {
        return $this->like = $like;
    }

    public function createLike($photo_id){
        $like = $this->like->create([
            'photo_id'  => $photo_id,
            'user_id'   => auth()->user()->id
        ]);

        return $like;
    }

    public function deleteLike($photo_id){
        return $this->like->where('user_id', auth()->user()->id)->where('photo_id', $photo_id)->delete();
    }

    public function deleteLikes($photo_id){
        return $this->like->where('photo_id', $photo_id)->delete();
    }
}