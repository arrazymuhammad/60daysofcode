<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
class ImageUploadController extends Controller
{

	public function createPost()
	{
		return view('create_post');
	}

    public function upload(Request $req)
    {
    	if ($req->hasFile('image')) {
            $image = $req->file('image');
            $image_name = time().".".$image->extension();
            $destination = "assets/img/post";
            
            $filepath = $req->file('image')->storeAs($destination, $image_name);

            $img = Image::make($filepath);
            $img->resize(1000,1000,  function($constraint){
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($destination."/".$image_name, 60);

            return $filepath;
        }
    }

    public function delete(Request $req)
    {
    	$image_path = str_replace(url(), "", $req->image_path);
    	$filepath = public_path($image_path);

        if(file_exists($filepath)){
            unlink($filepath);
        }
    }
}
