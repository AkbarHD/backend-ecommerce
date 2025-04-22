<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// intervention image
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TemImageController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }

        $tempImage = new TempImage();
        $tempImage->name = "Save dummy image";
        $tempImage->save();

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/temp'), $imageName);

        $tempImage->name = $imageName;
        $tempImage->save();

        $manager = new ImageManager(Driver::class);
        $img = $manager->read(public_path('uploads/temp/' . $imageName)); // 800 x 600
        $img->coverDown(400, 450);
        $img->save(public_path('uploads/temp/thumb/' . $imageName)); // 800 x 600

        return response()->json([
            'status' => 200,
            'message' => 'Image uploaded successfully',
            'data' => $tempImage
        ], 200);
    }
}
