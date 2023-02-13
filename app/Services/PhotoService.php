<?php

namespace App\Services;

use App\Repositories\PhotoRepository;
use Exception;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class PhotoService{
    protected $photoRepository;

    public function __construct(PhotoRepository $photoRepository)
    {
        $this->photoRepository = $photoRepository;
    }

    public function getAllPhotos(){
        return $this->photoRepository->getPhotosWithLikesAndTags();
    }

    public function getPhotoById($id){
        return $this->photoRepository->getPhoto($id);
    }

    public function createPhoto($request){
        $validator = Validator::make($request, [
            'filename'  => 'required|string',
            'caption'   => 'string|max:4000',
        ]);

        if($validator->fails()){
            throw new InvalidArgumentException($validator->errors()->first());
        }

        try {
            return $this->photoRepository->createPhoto($request);
        } catch (Exception $e) {
            throw new InvalidArgumentException("Unable to create photo");
        }
    }

    public function updatePhotoById($request, $id){
        $validator = Validator::make($request, [
            'filename'  => 'required|string',
            'caption'   => 'string|max:4000',
        ]);

        if($validator->fails()){
            throw new InvalidArgumentException($validator->errors()->first());
        }

        try {
            return $this->photoRepository->updatePhoto($request, $id);
        } catch (Exception $e) {
            throw new InvalidArgumentException("Unable to create photo");
        }
    }

    public function deletePhotoById($id){
        return $this->photoRepository->deletePhoto($id);
    }
    
}