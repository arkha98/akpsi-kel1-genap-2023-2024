<?php

namespace App\Helpers;

use App\Repos\UserRepository;
use App\Repos\UserRoleMappingRepository;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class FileHelper
{

    public static function uploadProjectDigest(Request $request, $contentParent) {
        try {
            $image = $request->file('project_digest');
            $label = $request->input('content_image_label', '');
            $desc = $request->input('content_image_desc', '');
            $nameUploadImage = $image->getClientOriginalName();
            $imageExtension = $image->extension();
            $newName = $contentParent['content_group'] . '_' . Str::uuid() . '.' . $imageExtension;
            $size = '-';
            $sizeType = 'kb';

            $path = $request->file('project_digest')->storeAs('public/competitive_grants', $newName);

            $result = [
                'content_id' => $contentParent['id'],
                'media_upload_name' => $nameUploadImage,
                'media_server_name' => $newName,
                'media_label' =>$label,
                'media_desc' => $desc,
                'media_type' => $imageExtension,
                'size_value' => $size,
                'size_type' => $sizeType,
            ];

            return $result;

        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    #region image processing

    public static function uploadSingleImageContentStatic(Request $request, $contentStatic) {
        try {
            $image = $request->file('content_image');
            $label = $request->input('content_image_label', '');
            $desc = $request->input('content_image_desc', '');
            $nameUploadImage = $image->getClientOriginalName();
            $imageExtension = $image->extension();

            $newName = $contentStatic->content_code . '_' . Str::uuid() . '.' . 'webp';
            $size = '-';
            $sizeType = 'kb';

            $webp_image = Image::make($request->file('content_image'))->encode('webp', 90);
            $path = $webp_image->storeAs('public/content_statics', $newName);

            $result = [
                'content_id' => $contentStatic->id,
                'media_upload_name' => $nameUploadImage,
                'media_server_name' => $newName,
                'media_label' =>$label,
                'media_desc' => $desc,
                'media_type' => $imageExtension,
                'size_value' => $size,
                'size_type' => $sizeType,
            ];

            return $result;

        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    public static function uploadMultiImageContentStatic(Request $request, $contentStatic) {
        $result = [];
        try {
            $i = 0;
            foreach ($request->file('content_images') as $file) {

                $image = $file;
                $label = '';
                if($request->content_image_labels){
                    if($request->content_image_labels[$i]){
                        $label = $request->content_image_labels[$i];
                    }
                }
                $desc = '';
                if($request->content_image_descs){
                    if($request->content_image_descs[$i]){
                        $desc = $request->content_image_descs[$i];
                    }
                }
                $nameUploadImage = $file->getClientOriginalName();
                $imageExtension = $file->extension();
                $newName = $contentStatic->content_code . '_' . Str::uuid() . '.' . 'webp';
                $size = '-';
                $sizeType = 'kb';

                $webp_image = Image::make($file)->encode('webp', 90);
                $path = $webp_image->storeAs('public/content_statics', $newName);

                $temp = [
                    'content_id' => $contentStatic->id,
                    'media_upload_name' => $nameUploadImage,
                    'media_server_name' => $newName,
                    'media_label' =>$label,
                    'media_desc' => $desc,
                    'media_type' => $imageExtension,
                    'size_value' => $size,
                    'size_type' => $sizeType,
                ];

                array_push($result, $temp);
                $i++;
            }

            return $result;
        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    public static function uploadSingleImageContentDynamic(Request $request, $contentParent) {
        try {
            $image = $request->file('content_image');
            $label = $request->input('content_image_label', '');
            $desc = $request->input('content_image_desc', '');
            $nameUploadImage = $image->getClientOriginalName();
            $imageExtension = $image->extension();
            $newName = $contentParent['content_group'] . '_' . Str::uuid() . '.' . $imageExtension;
            $size = '-';
            $sizeType = 'kb';

            $path = $request->file('content_image')->storeAs('public/content_dynamics', $newName);

            $result = [
                'content_id' => $contentParent['id'],
                'media_upload_name' => $nameUploadImage,
                'media_server_name' => $newName,
                'media_label' =>$label,
                'media_desc' => $desc,
                'media_type' => $imageExtension,
                'size_value' => $size,
                'size_type' => $sizeType,
            ];

            return $result;

        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    public static function uploadMultiImageContentDynamic(Request $request, $contentParent) {
        $result = [];
        try {
            $i = 0;
            foreach ($request->file('content_images') as $file) {

                $image = $file;
                $label = '';
                if($request->content_image_labels){
                    if($request->content_image_labels[$i]){
                        $label = $request->content_image_labels[$i];
                    }
                }
                $desc = '';
                if($request->content_image_descs){
                    if($request->content_image_descs[$i]){
                        $desc = $request->content_image_descs[$i];
                    }
                }
                $nameUploadImage = $file->getClientOriginalName();
                $imageExtension = $file->extension();
                $newName = $contentParent['content_group'] . '_' . Str::uuid() . '.' . $imageExtension;
                $size = '-';
                $sizeType = 'kb';

                $path = $image->storeAs('public/content_dynamics', $newName);

                $temp = [
                    'content_id' => $contentParent['id'],
                    'media_upload_name' => $nameUploadImage,
                    'media_server_name' => $newName,
                    'media_label' =>$label,
                    'media_desc' => $desc,
                    'media_type' => $imageExtension,
                    'size_value' => $size,
                    'size_type' => $sizeType,
                ];

                array_push($result, $temp);
                $i++;
            }

            return $result;
        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    public static function uploadSingleImageThumbnail(Request $request, $contenParent) {
        try {
            $image = $request->file('content_thumbnail') ?? $request->file('content_image');
            $label = $request->input('content_thumbnail_label', '') ?? $request->input('content_image_label', '');
            $desc = $request->input('content_thumbnail_desc', '') ?? $request->input('content_image_desc', '');
            $nameUploadImage = $image->getClientOriginalName();
            $imageExtension = $image->extension();
            $newName = $contenParent['content_group'] . '_' . Str::uuid() . '.' . $imageExtension;
            $size = '-';
            $sizeType = 'kb';

            $path = $image->storeAs('public/global_thumbnails', $newName);

            $result = [
                'content_id' => $contenParent['id'],
                'media_upload_name' => $nameUploadImage,
                'media_server_name' => $newName,
                'media_label' =>$label,
                'media_desc' => $desc,
                'media_type' => $imageExtension,
                'size_value' => $size,
                'size_type' => $sizeType,
            ];

            return $result;

        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    public static function uploadSingleFile(Request $request, $contenParent) {
        try {
            $image = $request->file('content_file');
            $label = $request->input('content_file_label', '');
            $desc = $request->input('content_file_desc', '');
            $nameUploadImage = $image->getClientOriginalName();
            $imageExtension = $image->extension();
            $newName = $contenParent['content_group'] . '_' . Str::uuid() . '.' . $imageExtension;
            $size = '-';
            $sizeType = 'kb';

            $path = $request->file('content_file')->storeAs('public/global_files', $newName);

            $result = [
                'content_id' => $contenParent['id'],
                'media_upload_name' => $nameUploadImage,
                'media_server_name' => $newName,
                'media_label' =>$label,
                'media_desc' => $desc,
                'media_type' => $imageExtension,
                'size_value' => $size,
                'size_type' => $sizeType,
            ];

            return $result;

        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    public static function uploadProfilePicture(Request $request){
        try {
            $image = $request->file('profile_picture');
            $imageExtension = $image->extension();
            $newName = 'profile_' . Str::uuid() . '.' . $imageExtension;
            $size = '-';
            $sizeType = 'kb';

            $path = $request->file('profile_picture')->storeAs('public/profile_pictures', $newName);

            $result = [
                'media_server_name' => $newName
            ];

            return $result;

        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

    public static function uploadProfilePicturePejabat(Request $request){
        try {
            $image = $request->file('profile_picture');
            $imageExtension = $image->extension();
            $newName = 'profile_' . Str::uuid() . '.' . $imageExtension;
            $size = '-';
            $sizeType = 'kb';

            $path = $request->file('profile_picture')->storeAs('public/profile_picture_pejabat', $newName);

            $result = [
                'media_server_name' => $newName
            ];

            return $result;

        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }


    #endregion image processing

    public static function mappingLinkFile(Request $request, $contenParent) {
        try {
            $link = $request->input('content_link');
            $label = $request->input('content_file_label', '');
            $desc = $request->input('content_file_desc', '');
            $nameUploadImage = $link;
            $imageExtension = 'link';
            $newName = $link;
            $size = '-';
            $sizeType = 'kb';

            $result = [
                'content_id' => $contenParent['id'],
                'media_upload_name' => $nameUploadImage,
                'media_server_name' => $newName,
                'media_label' =>$label,
                'media_desc' => $desc,
                'media_type' => $imageExtension,
                'size_value' => $size,
                'size_type' => $sizeType,
            ];

            return $result;

        } catch (\Throwable $th) {
            return CustomHelper::returnResultErrorThrowException($th);
        }
    }

}
