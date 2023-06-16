<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPortfolioRequest;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Portfolio::all();
        return response($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddPortfolioRequest $request)
    {
        $data = $request->all();
        if ($file = $request->file('image_url')) {
            $destinationPath = 'file/';
            $fileInput = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileInput);
            $data['image_url'] = $fileInput;
        }

        Portfolio::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'image_file_url' => $data['image_url'],
            'url' => $data['url'],
            'category' => $data['category'],
        ]);

        return response('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        // $data = Portfolio::all();
        // return response($data);
    }
}
