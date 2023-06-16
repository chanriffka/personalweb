<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PortfolioController extends Controller
{
    public function index()
    {
        $data = Portfolio::all();
        return view('portfolios.index', compact('data'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('portfolios.create')->with(['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'image_url' => 'required|max:10000|mimes:jpeg,jpg,png',
            'url' => 'required|string|max:500',
            'category_id' => 'required|exists:categories,id'
        ]);

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
            'category_id' => $data['category_id'],
        ]);

        return redirect()->route('portfolios.index')->with('success_message', 'Success!');
    }

    public function edit(string $id)
    {
        $data = Portfolio::findOrFail($id);
        $categories = Category::all();
        return view('portfolios.edit', compact('data','categories'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $portfolio = Portfolio::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'image_url' => 'max:10000|mimes:jpeg,jpg,png',
            'url' => 'required|string|max:500',
            'category_id' => 'required|exists:categories,id'
        ]);

        if ($file = $request->file('image_url')) {

            // Delete Old File
            $file_path = public_path() . '/file/' . $portfolio['image_file_url'];
            File::delete($file_path);

            // Add New File
            $destinationPath = 'file/';
            $fileInput = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileInput);
            $data['image_url'] = "$fileInput";

            $portfolio->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'image_file_url' => $data['image_url'],
                'url' => $data['url'],
                'category_id' => $data['category_id'],
            ]);
        } else {
            $portfolio->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'url' => $data['url'],
                'category_id' => $data['category_id'],
            ]);
        }

        return redirect()->route('portfolios.index')->with('success_message', 'Success!');
    }

    public function destroy(string $id)
    {
        $portfolio = Portfolio::findOrFail($id);

        // Delete File
        $file_path = public_path() . '/file/' . $portfolio['image_file_url'];
        File::delete($file_path);

        $portfolio->delete();
        return redirect()->route('portfolios.index')->with('success_message', 'Success Delete!');
    }
}
