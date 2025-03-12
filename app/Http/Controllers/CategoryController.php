<?php

namespace App\Http\Controllers;

use App\Models\categories;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::all();

        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        categories::create(["name"=> $request->name]);

        return response()->json(['message' => "Category added successfully!"], 201);
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
        $request->validate([
            "name" => "required",
        ]);
    
        $category = Categories::find($id);
    
        if ($category) {
            $category->update(["name" => $request->name]);
    
            return response()->json(['message' => 'Category updated successfully!']);
        }
    
        return response()->json(['message' => 'Category not found!'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Categories::destroy($id);
    }

}
