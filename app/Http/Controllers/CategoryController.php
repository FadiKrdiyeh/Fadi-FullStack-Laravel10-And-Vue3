<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
          $categories = Category::orderBy('created_at', 'desc')->get();

          return response()->json([
            'status' => true,
            'message' => 'Data fetched successfuly.',
            'data' => $categories
          ], 200);
        } catch (\Throwable $th) {
          return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
            'data' => null,
          ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
          $request->validate([
            'name' => 'required'
          ]);

          $category = Category::create([
            'name' => $request->name
          ]);

          return response()->json([
            'status' => true,
            'message' => 'Category created successfuly.',
            'data' => $category
          ], 200);
        } catch (\Throwable $th) {
          return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
            'data' => null,
          ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
      try {
          $category = Category::find($request->id);

          if ($category) {
            $request->validate([
              'name' => 'required'
            ]);

            $category->update([
              'name' => $request->name
            ]);

            $category->save();

            return response()->json([
              'status' => true,
              'message' => 'Category updated successfuly.',
              'data' => $category
            ], 200);
          } else {
            return response()->json([
              'status' => false,
              'message' => 'Category not found.',
              'data' => null
            ], 404);
          }
        } catch (\Throwable $th) {
          return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
            'data' => null,
          ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
          $category = Category::find($id);

          if ($category) {
            Category::where('id', $id)->delete();

            return response()->json([
              'status' => true,
              'message' => 'Category deleted successfuly.',
              'data' => null
            ], 200);
          } else {
            return response()->json([
              'status' => false,
              'message' => 'Category not found.',
              'data' => null
            ], 404);
          }
        } catch (\Throwable $th) {
          return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
            'data' => null,
          ], 500);
        }
    }

    public function countCategories () {
      try {
        $count = Category::count();
        return response()->json([
          'status' => true,
          'message' => 'Categories counted successfuly!',
          'data' => $count
        ], 200);
        return $count;
      } catch (\Throwable $th) {
        return response()->json([
          'status' => false,
          'message' => $th->getMessage(),
          'data' => null,
        ], 500);
      }
    }
}
