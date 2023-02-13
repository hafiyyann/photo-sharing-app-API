<?php

namespace App\Services;

use App\Repositories\TagRepository;
use Exception;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class TagService{
    
    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function tag($request){
        $validator = Validator::make($request, [
            'photo_id'  => 'required|numeric',
            'user_id'   => 'required|numeric'
        ]);

        if($validator->fails()){
            throw new InvalidArgumentException($validator->errors()->first());
        }

        try {
            return $this->tagRepository->createTag($request);
        } catch (Exception $e) {
            throw new InvalidArgumentException("Unable to add tag");
        }
    }

    public function untagAll($photo_id){
        try {
            return $this->tagRepository->deleteTags($photo_id);
        } catch (Exception $e) {
            throw new InvalidArgumentException("Unable to remove tag");
        }
    }
}