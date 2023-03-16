<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
          $blogs = Blog::where('is_accepted', 1)->with(['user' => function ($query) {
            $query->select('id', 'name');
          }, 'categories'])->withCount('comments')->orderby('created_at', 'desc')->paginate(10);

          if ($blogs) {
            return response()->json([
              'status' => true,
              'message' => 'Blogs fetched successfuly.',
              'data' => $blogs
            ], 200);
          } else {
            return response()->json([
              'status' => false,
              'message' => 'No blogs yet.',
              'data' => $blogs
            ], 404);
          }
        } catch (\Throwable $th) {
          return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
            'data' => null
          ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {
          $request->validate([
            'title' => 'required',
            'content' => 'required',
            'categories' => 'required'
          ]);

          $blogCategories = [];

          $blog = Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->title,
            'user_id' => Auth::id(),
          ]);

          // Add categories...
          foreach ($request->categories as $category) {
            array_push($blogCategories, ['blog_id' => $blog->id, 'category_id' => $category]);
          }

          BlogCategories::insert($blogCategories);

          DB::commit();

          return response()->json([
            'status' => true,
            'message' => 'Blog created successfuly.',
            'data' => $blog->with('categories')
          ], 200);
        } catch (\Throwable $th) {
          //throw $th;
          DB::rollback();
          return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
            'data' => null
          ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        try {
          $blog = Blog::where('slug', $slug)->with(['categories', 'user' => function ($query) {
            $query->select('id', 'name');
          }])->withCount('comments')->get();

          if ($blog) {
            return response()->json([
              'status' => true,
              'message' => 'Blog fetched successfuly.',
              'data' => $blog
            ], 200);
          } else {
            return response()->json([
              'status' => false,
              'message' => 'Blog not found.',
              'data' => null
            ], 404);
          }
        } catch (\Throwable $th) {
          return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
            'data' => null
          ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
      try {
        $blog = Blog::where('id', $id)->with(['categories', 'user'])->first();
        if ($blog) {
          return response()->json([
            'status' => true,
            'message' => 'Blog fethed successfuly.',
            'data' => $blog
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => 'Blog not found.',
            'data' => null
          ], 404);
        }
      } catch (\Throwable $th) {
        return response()->json([
          'status' => false,
          'message' => $th->getMessage(),
          'data' => null
        ], 500);
      }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
          $request->validate([
            'id' => 'required',
            'title' => 'required',
            'content' => 'required',
            'categories_id' => 'required'
          ]);

          $blogCategories = [];

          $blog = Blog::findorfail($request->id);
          $blog->title = $request->title;
          $blog->content = $request->content;
          $blog->slug = $request->title;
          $blog->save();
          // return $blog;
          // Blog::where('id', $request->id)->update([
          //   'title' => $request->title,
          //   'content' => $request->content,
          //   'slug' => $request->title,
          // ]);

          // Add categories...
          foreach ($request->categories_id as $category) {
            array_push($blogCategories, ['blog_id' => $request->id, 'category_id' => $category]);
          }
          // return $blogCategories;

          BlogCategories::where('blog_id', $request->id)->delete();
          BlogCategories::insert($blogCategories);

          DB::commit();

          return response()->json([
            'status' => true,
            'message' => 'Blog updated successfuly.',
            'data' => null
          ], );
        } catch (\Throwable $th) {
          //throw $th;
          DB::rollback();
          return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
            'data' => null
          ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }

    public function countBlogs () {
      try {
        $count = Blog::count();
        return response()->json([
          'status' => true,
          'message' => 'Blogs counted successfuly!',
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
