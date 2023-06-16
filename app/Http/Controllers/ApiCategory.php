<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiCategory extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'message' => 'Category data',
            'data' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'name' => 'required'
        ]);

        if($validation->fails()) {
            return response()->json([
                'message' => 'Fill the form with valid data',
                'data' => $validation->errors(),
            ],422);
        }

        try {
            $new = Category::create($request->all());

            return response()->json([
                'message' => 'Category created!',
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
        $category = Category::find($id);

        if(!$category) {
            return response()->json([
                'message' => 'Category not found!',
            ],404);
        }

        return response()->json([
            'message' => 'Category found!',
            'data' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        if(!$category) {
            return response()->json([
                'message' => 'Category not found!',
            ],404);
        }

        $validation = Validator::make($request->all(),[
            'name' => 'required'
        ]);

        if($validation->fails()) {
            return response()->json([
                'message' => 'Fill the form with valid data',
                'data' => $validation->errors(),
            ],422);
        }

        try {
            $category->update($request->all());

            return response()->json([
                'message' => 'Category updated!',
                'data' => $category,
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
        $category = Category::find($id);

        if(!$category) {
            return response()->json([
                'message' => 'Category not found!',
            ],404);
        }

        try {
            $category->delete();

            return response()->json([
                'message' => 'Category deleted!',
                'data' => $category,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Internal server error!',
            ]);
        }
    }
}
