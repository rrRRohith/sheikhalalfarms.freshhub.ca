<?php

namespace App\Http\Traits;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


trait UploadPictureTrait{
 
 public function __uploadPicture($name,$path='') {

     
        if(!empty(request()->input($name)) && strlen(request()->input($name)) > 6) {

            $picture = request()->input($name);

            if(preg_match('/data:image/', $picture)) {
                list($type, $picture) = explode(';', $picture);
                list($i, $picture) = explode(',', $picture);
                $picture = base64_decode($picture);
                $image_name = Str::random(30) . '.png';
                Storage::put($path . $image_name, $picture);
                return  $image_name;
            }

            return false;
        }
        return false;
    }
}
?>