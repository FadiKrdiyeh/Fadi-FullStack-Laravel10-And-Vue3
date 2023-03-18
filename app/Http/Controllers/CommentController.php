<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
      try {
        $comments = Comment::where('blog_id', $id)->with(['user' => function ($query) {
          $query->select('id', 'name');
        }])->orderby('created_at', 'desc')->paginate(5);

        if ($comments) {
          return response()->json([
            'status' => true,
            'message' => 'Comments fetched successfuly.',
            'data' => $comments
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => 'No comments yet.',
            'data' => $comments
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      try {
        $request->validate([
          'content' => 'required',
          'blog_id' => 'required',
          'user_id' => 'required'
        ]);

        // return $request;


        $comment = Comment::create([
          'content' => $request->content,
          'blog_id' => $request->blog_id,
          'user_id' => $request->user_id,
        ]);

        return response()->json([
          'status' => true,
          'message' => 'Comment added successfuly.',
          'data' => $comment->load('user')
        ], 200);
      } catch (\Throwable $th) {
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
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
      //
    }
}
