<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository{
    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function createTag($request){
        $tag = $this->tag->create([
            'photo_id'  => $request['photo_id'],
            'user_id'   => $request['user_id']
        ]);

        return $tag;
    }

    public function deleteTags($photo_id){
        return $this->tag->where('photo_id', $photo_id)->delete();
    }
}