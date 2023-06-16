<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
class ApiPortfolio extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $portfolios = Portfolio::all();

        return response()->json([
            'message' => 'Portfolio data',
            'data' => $portfolios
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'image_url' => 'required|max:10000|mimes:jpeg,jpg,png',
            'url' => 'required|string|max:500',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->all();

        if($validation->fails()) {
            return response()->json([
                'message' => 'Fill the form with valid data',
                'data' => $validation->errors(),
            ],422);
        }

        $imageUpload = false;

        if ($file = $request->file('image_url')) {
            $destinationPath = 'file/';
            $fileInput = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileInput);

            $data['image_url'] = $fileInput;
            $imageUpload = true;
        }

        if(!$imageUpload) {
            return response()->json([
                'message' => 'Image upload failed!',
            ],422);
        }

        try {
            $new = Portfolio::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'image_file_url' => $data['image_url'],
                'url' => $data['url'],
                'category_id' => $data['category_id'],
            ]);

            return response()->json([
                'message' => 'Portfolio created!',
                'data' => $new,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Internal server error!',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $portfolio = Portfolio::find($id);

        if(!$portfolio) {
            return response()->json([
                'message' => 'Portfolio not found!',
            ],404);
        }

        return response()->json([
            'message' => 'Portfolio found!',
            'data' => $portfolio,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $portfolio = Portfolio::find($id);

        if(!$portfolio) {
            return response()->json([
                'message' => 'Portfolio not found!',
            ],404);
        }

        $validation = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'image_url' => 'required|max:10000|mimes:jpeg,jpg,png',
            'url' => 'required|string|max:500',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->all();

        if($validation->fails()) {
            return response()->json([
                'message' => 'Fill the form with valid data',
                'data' => $validation->errors(),
            ],422);
        }

        if ($file = $request->file('image_url')) {

            // Delete Old File
            $file_path = public_path() . '/file/' . $portfolio['image_file_url'];
            File::delete($file_path);

            // Add New File
            $destinationPath = 'file/';
            $fileInput = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileInput);
            $data['image_url'] = "$fileInput";
        }

        try {
            $portfolio->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'image_file_url' => $data['image_url'],
                'url' => $data['url'],
                'category_id' => $data['category_id'],
            ]);

            return response()->json([
                'message' => 'Portfolio updated!',
                'data' => $portfolio,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Internal server error!',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $portfolio = Portfolio::find($id);

        if(!$portfolio) {
            return response()->json([
                'message' => 'Portfolio not found!',
            ],404);
        }

        try {
            $portfolio->delete();

            return response()->json([
                'message' => 'Portfolio deleted!',
                'data' => $portfolio,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Internal server error!',
            ]);
        }
    }
}
