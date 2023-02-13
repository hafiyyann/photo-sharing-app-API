<?php

namespace App\Repositories;

use App\Models\Photo;

class PhotoRepository{
    
    protected $photo;
    
    public function __construct(Photo $photo)
    {
        $this->photo = $photo;    
    }

    public function getPhotos(){
        $photos = $this->photo->get();
        return $photos;
    }

    public function getPhotosWithLikesAndTags(){
        $photos = $this->photo->with('likes.user', 'tags.user')->get();
        return $photos;
    }

    public function getPhoto($id){
        $photo = $this->photo->where('id', $id)->firstOrFail();
        return $photo;
    }

    public function createPhoto($request){
        $photo = $this->photo->create([
            'filename'  => $request['filename'],
            'caption'   => $request['caption'],
            'user_id'   => auth()->user()->id
        ]);

        return $photo;
    }

    public function updatePhoto($request, $id){
        $this->photo->where('id', $id)->update([
            'filename'  => $request['filename'],
            'caption'   => $request['caption'],
            'user_id'   => auth()->user()->id
        ]);
    }

    public function deletePhoto($id){
        return $this->photo->where('id', $id)->delete();
    }
}