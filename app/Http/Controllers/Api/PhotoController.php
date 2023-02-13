<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LikeService;
use App\Services\PhotoService;
use App\Services\TagService;
use Exception;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    protected $photoService, $tagService, $likeService;

    public function __construct(PhotoService $photoService, TagService $tagService, LikeService $likeService)
    {
        $this->photoService = $photoService;
        $this->tagService = $tagService;
        $this->likeService = $likeService;
    }

    public function index(){
        try {
            $photos = $this->photoService->getAllPhotos();

            $result = [
                'status'    => true,
                'message'   => 'Get all photos successfully',
                'data'      => $photos,
            ];

            $response_code = 200; 
        } catch (Exception $e) {
            $result = [
                'status'    => false,
                'message'   => 'Get all photos failed',
            ];

            $response_code = 500;
        }

        return response()->json($result, $response_code);
    }

    public function create(Request $request){
        $data = $request->all();

        try {
            $photo = $this->photoService->createPhoto($data);

            if ($request->has('tags')) {
                foreach ($request->tags as $tag) {
                    $tag_data = [
                        'photo_id'  => $photo->id,
                        'user_id'   => $tag
                    ];

                    $this->tagService->tag($tag_data);
                }
            }

            $result = [
                'status'    => true,
                'message'   => 'Photo successfully created',
                'data'      => $photo,
            ];

            $response_code = 200; 
        } catch (Exception $e) {
            $result = [
                'status'    => false,
                'message'   => $e->getMessage(),
            ];

            $response_code = 500;
        }

        return response()->json($result, $response_code);
    }

    public function update(Request $request, $id){
        $data = $request->all();

        try {
            $this->photoService->updatePhotoById($data, $id);
            $photo = $this->photoService->getPhotoById($id);

            $this->tagService->untagAll($photo->id);
            
            if ($request->has('tags')) {
                foreach ($request->tags as $tag) {
                    $tag_data = [
                        'photo_id'  => $photo->id,
                        'user_id'   => $tag
                    ];

                    $this->tagService->tag($tag_data);
                }
            }

            $result = [
                'status'    => true,
                'message'   => 'Photo successfully updated',
                'data'      => $photo,
            ];

            $response_code = 200; 
        } catch (Exception $e) {
            $result = [
                'status'    => false,
                'message'   => $e->getMessage(),
            ];

            $response_code = 500;
        }

        return response()->json($result, $response_code);
    }

    public function show($id){
        try {
            $photo = $this->photoService->getPhotoById($id);

            $result = [
                'status'    => true,
                'message'   => 'Get Photo Successfully',
                'data'      => $photo,
            ];

            $response_code = 200; 
        } catch (Exception $e) {
            $result = [
                'status'    => false,
                'message'   => 'Get Photo Failed',
            ];

            $response_code = 500;
        }

        return response()->json($result, $response_code);
    }

    public function destroy($id){
        try {
            $this->tagService->untagAll($id);
            $this->likeService->removeAllLike($id);
            $this->photoService->deletePhotoById($id);

            $result = [
                'status'    => true,
                'message'   => 'Delete Photo Successfully',
            ];

            $response_code = 200; 
        } catch (Exception $e) {
            $result = [
                'status'    => false,
                'message'   => $e->getMessage(),
            ];

            $response_code = 500;
        }

        return response()->json($result, $response_code);
    }

    public function likePhoto($id){
        try {
            $this->likeService->like($id);

            $result = [
                'status'    => true,
                'message'   => 'Like Photo Successfully',
            ];

            $response_code = 200; 
        } catch (Exception $e) {
            $result = [
                'status'    => false,
                'message'   => $e->getMessage(),
            ];

            $response_code = 500;
        }

        return response()->json($result, $response_code);
    }

    public function unlikePhoto($id){
        try {
            $this->likeService->unlike($id);

            $result = [
                'status'    => true,
                'message'   => 'Unlike Photo Successfully',
            ];

            $response_code = 200; 
        } catch (Exception $e) {
            $result = [
                'status'    => false,
                'message'   => 'Unike Photo Failed',
            ];

            $response_code = 500;
        }

        return response()->json($result, $response_code);
    }


}
