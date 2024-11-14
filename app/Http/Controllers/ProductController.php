<?php

namespace App\Http\Controllers;

use App\Models\settings;
use App\Models\ProductPortfolio;
use Auth;
use Illuminate\Http\Request;
use Hashids;

class ProductController extends Controller
{

    public function dashboard()
    {
        if (Auth::check()) {
            $producPortfolio = ProductPortfolio::orderBy('created_at', 'desc')->get();

            // Calculate video and image counts for each portfolio item
            foreach ($producPortfolio as $portfolio) {
                $portfolio->video_count = 0;
                $portfolio->image_count = 0;

                for ($i = 1; $i <= 5; $i++) {
                    if (!empty($portfolio->{'video_path' . $i})) {
                        $portfolio->video_count++;
                    }
                    $images = json_decode($portfolio->{'image_path' . $i}, true);
                    if (!empty($images) && is_array($images)) {
                        $portfolio->image_count += count($images);
                    }
                }
            }

            $settingsCount = Settings::where('id', 1)->value('count');
            $currentCount = ProductPortfolio::count();

            return view('ProducPortfolio.index', compact('producPortfolio', 'settingsCount', 'currentCount'));
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }



    public function create()
    {
        if (Auth::check()) {
            $setting = settings::first();

            return view('ProducPortfolio.add', compact('setting'));
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }


    public function store(Request $request)
    {
        $settingsCount = Settings::where('id', 1)->value('count');
        $currentCount = ProductPortfolio::count();
        if ($currentCount >= $settingsCount) {
            return redirect()->route('dashboard')->with('error', 'Limit reached. No more records can be saved.');
        }


        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|numeric|digits:10',
            'video' => 'array',
            'images.*.*' => 'nullable|file|mimetypes:video/mp4,video/mpeg,video/quicktime,video/x-matroska,image/jpeg,image/png,image/gif'
            // 'images.*.*' => 'image'
        ]);

        $form = new ProductPortfolio();
        $form->name = $request->name;
        $form->mobile = $request->mobile;

        // Generate a random six-digit ID
        do {
            $randomId = random_int(100000, 999999);
        } while (ProductPortfolio::where('id', $randomId)->exists());

        $form->id = $randomId;

        // Store videos
        foreach ($request->video as $index => $videoPath) {
            $form->{'video_path' . ($index + 1)} = $videoPath;
        }

        // Store images in original quality
        if ($request->has('images') && is_array($request->images)) {
            foreach ($request->images as $index => $images) {
                if (is_array($images)) {
                    $imagePaths = [];
                    foreach ($images as $image) {
                        $originalName = $image->getClientOriginalName();
                        $image->move(public_path('image'), $originalName);
                        $imagePaths[] = 'image/' . $originalName;
                    }
                    $form->{'image_path' . ($index + 1)} = json_encode($imagePaths);
                }
            }
        }


        $form->save();

        return redirect()->route('dashboard')->with('success', 'Form data saved successfully!');
    }


    // Edit method to show the edit form
    public function edit($id)
    {
        if (Auth::check()) {
            $product = ProductPortfolio::findOrFail($id);
            $setting = settings::first();
            return view('ProducPortfolio.edit', compact('product', 'setting'));
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    // Update method to handle the form submission
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|numeric|digits:10',
            'video' => 'nullable|array',
            'images.*.*' => 'nullable|file|mimetypes:video/mp4,video/mpeg,video/quicktime,video/x-matroska,image/jpeg,image/png,image/gif'
            // 'images.*.*' => 'nullable|image'
        ]);

        $form = ProductPortfolio::findOrFail($id);
        $form->name = $request->name;
        $form->mobile = $request->mobile;

        // Update video paths if provided
        if ($request->has('video') && is_array($request->video)) {
            foreach ($request->video as $index => $videoPath) {
                if (!empty($videoPath)) {
                    $form->{'video_path' . ($index + 1)} = $videoPath;
                } else {
                    $form->{'video_path' . ($index + 1)} = null;
                }
            }
        }

        // Update images in original quality if provided
        if ($request->has('images') && is_array($request->images)) {
            foreach ($request->images as $index => $images) {
                if (is_array($images)) {
                    $imagePaths = [];
                    foreach ($images as $image) {
                        if ($image instanceof \Illuminate\Http\UploadedFile) {
                            $originalName = $image->getClientOriginalName();
                            $image->move(public_path('image'), $originalName);
                            $imagePaths[] = 'image/' . $originalName;
                        }
                    }
                    $form->{'image_path' . ($index + 1)} = json_encode(array_merge(
                        json_decode($form->{'image_path' . ($index + 1)}, true) ?? [],
                        $imagePaths
                    ));
                }
            }
        }


        // Handle image removal and deletion from folder
        if ($request->has('remove_images') && is_array($request->remove_images)) {
            foreach ($request->remove_images as $index => $imagePaths) {
                if (is_array($imagePaths)) {
                    $existingImages = json_decode($form->{'image_path' . ($index + 1)}, true) ?? [];
                    $remainingImages = array_diff($existingImages, $imagePaths);

                    // Delete removed images from the folder
                    foreach ($imagePaths as $imagePath) {
                        $filePath = public_path($imagePath);
                        if (file_exists($filePath)) {
                            unlink($filePath); // Delete the image from the 'public/image' folder
                        }
                    }

                    $form->{'image_path' . ($index + 1)} = json_encode($remainingImages);
                }
            }
        }

        $form->save();

        return redirect()->route('dashboard')->with('success', 'Product updated successfully!');
    }





    // Delete method to remove a product
    public function destroy($id)
    {
        if (Auth::check()) {
            $product = ProductPortfolio::findOrFail($id);

            // Loop through the image paths (assuming image_path1, image_path2, ..., up to image_path5)
            for ($i = 1; $i <= 5; $i++) {
                $imageField = 'image_path' . $i;
                $imagePaths = json_decode($product->$imageField, true); // Decode JSON to array

                if (!empty($imagePaths) && is_array($imagePaths)) {
                    foreach ($imagePaths as $imagePath) {
                        $fullPath = public_path($imagePath); // Full path to the image
                        if (file_exists($fullPath)) {
                            unlink($fullPath); // Delete the file if it exists
                        }
                    }
                }
            }

            // Finally, delete the product record
            $product->delete();

            return redirect()->route('dashboard')->with('success', 'Product and associated images deleted successfully!');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function show($encodedId)
    {
        // Decode the encoded ID
        $decoded = Hashids::decode($encodedId);
    
        // Check if the decoding was successful
        if (count($decoded) === 0) {
            abort(404); // If decoding fails, show a 404 error
        }
    
        $id = $decoded[0];
    
        // Find the product or fail
        $product = ProductPortfolio::findOrFail($id);
    
        // Increment the views count
        $product->increment('views');
    
        // Load settings and media as before
        $setting = Settings::first();
        $productMedia = [];
    
        for ($i = 1; $i <= 5; $i++) {
            $media = [
                'video' => $product->{'video_path' . $i},
                'images' => json_decode($product->{'image_path' . $i}, true)
            ];
    
            if (!empty($media['video']) || (!empty($media['images']) && is_array($media['images']))) {
                $productMedia[$i] = $media;
            }
        }
    
        return view('welcome', compact('product', 'setting', 'productMedia'));
    }

    public function listViews()
    {
        $products = ProductPortfolio::all(['id', 'name', 'views']);
        return view('product_views', compact('products'));
    }








    // public function copy($id)
    // {
    //     $originalProduct = ProductPortfolio::findOrFail($id);

    //     return response()->json([
    //         'message' => 'Product copy action initiated',
    //         'productId' => $id,
    //     ]);
    // }




}
