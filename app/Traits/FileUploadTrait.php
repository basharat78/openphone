<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Unique;

use File;

trait FileUploadTrait
{

    /**
     * Upload an image file.
     *
     * @param Request $request The HTTP request object.
     * @param string $InputName The name of the input field containing the file.
     * @param string|null $oldpath The path to the old file to be deleted (if any).
     * @param string $path The directory where the file should be uploaded.
     * @return string|null The path to the uploaded file or the old path if no new file was uploaded.
     */


    public function UploadImage(Request $request, string $InputName, ?string $oldpath = null, string $path = 'uploads') : ?string // ?string means the return type is either a string or null
    {
        if($request->hasFile($InputName)) { // check if the file is uploaded
            $image = $request->{$InputName}; // get the file
            $ext = $image->getClientOriginalExtension(); // get the file extension png, jpg, jpeg
            $imageName = 'media_'.uniqid().'.'.$ext; // create a new name for the file to be uploaded e.g media_123456.png
            $image->move(public_path($path), $imageName); // move the file to the specified path
         // the upper code will be responsible for uploading the file to the server

         //Delete previous image
         $excludedFolder = '/default'; // exclude the default folder from deletion
         if($oldpath != null && File::exists(public_path($oldpath)) && strpos($oldpath, $excludedFolder) !== false){ // check if the old file exists in the server and  if the old file is not in the excluded folder 
                File::delete(public_path($oldpath)); // delete the old file
               
            }
            
              return $path . '/' . $imageName; // return the path to the uploaded file
         
        }
        return null; // return null if no file was uploaded
    }

    function uploadMultipleImage(Request $request, string $inputName, string $path = '/uploads') : ?array
    {
        if($request->hasFile($inputName)){

            $images = $request->{$inputName};

            $paths = [];

            foreach($images as $image){

                $ext = $image->getClientOriginalExtension();
                $imageName = 'media_' . uniqid(). '.' . $ext;

                $image->move(public_path($path), $imageName);
                $paths[] = $path . '/' . $imageName;
            }

            return $paths;
        }

        return null;
    }


    function deleteFile($path) : void {
        // Delete previous image from storage
        $exculudedFolder = '/default';

        if($path && File::exists(public_path($path)) && strpos($path, $exculudedFolder) !== 0){
            File::delete(public_path($path));
        }
}
}

    