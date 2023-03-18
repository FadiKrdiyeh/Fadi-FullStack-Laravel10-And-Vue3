<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;

use App\Notifications\BlogAcceptedByAdmin;

class AdminController extends Controller
{
    public function index (Request $request) {
      // return Auth::user();
      // return $request->path();
      // return Auth::user()->type;
      if (Auth::check() && Auth::user()->type == 'admin' && $request->path() == 'admin/login') {
        return redirect('/admin/dashboard');
      }
      if (Auth::check() && Auth::user()->type == 'user') {
        return redirect('/');
      }
      if (!Auth::check() && $request->path() != 'admin/login') {
        return redirect('/login');
      }

      // if (Auth::check() && Auth::user()->type == 'user' && $request->path() != 'login') {
      //   return redirect('/home');
      // }
      // if (!Auth::check() && $request->path() != 'login') {
      //   // return $request->path();
      //   return redirect('/login');
      // }

      return view('app');
    }

    public function login (Request $request) {
      try {
        $request->validate([
          'email' => 'required|email',
          'password' => 'required|min:6'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'type' => 'admin'])) {
          return response()->json([
            'status' => true,
            'message' => 'Logged in successfuly.',
            'data' => Auth::user()
          ], 200);
        }

        return response()->json([
          'status' => false,
          'message' => 'Login failed.',
          'data' => null
        ], 403);
      } catch (\Throwable $th) {
        return response()->json([
          'status' => false,
          'message' => $th->getMessage(),
          'data' => null,
        ], 500);
      }
    }

    public function register (Request $request) {
      try {
        // return $request;
        $request->validate([
          'name' => 'required',
          'email' => 'required|email',
          'password' => 'required|min:6'
        ]);

        $user = User::create([
          'name' => $request->name,
          'email' => $request->email,
          'password' => Hash::make($request->password),
          'type' => 'admin'
        ]);

        return response()->json([
          'status' => true,
          'message' => 'User registered successfuly.',
          'data' => $user
        ], 200);
      } catch (\Throwable $th) {
        return response()->json([
          'status' => false,
          'message' => $th->getMessage(),
          'data' => null,
        ], 500);
      }
    }

    public function logout () {
      try {
        Auth::logout();

        return response()->json([
          'status' => true,
          'message' => 'Logged out',
          'data' => null
        ]);
      } catch (\Throwable $th) {
        return response()->json([
          'status' => false,
          'message' => $th->getMessage(),
          'data' => null,
        ], 500);
      }
    }

    public function blogs () {
      try {
        $blogs = Blog::where('is_accepted', 0)->with(['user' => function ($query) {
          $query->select('id', 'name');
        }, 'categories'])->orderby('created_at', 'desc')->paginate(10);

        if ($blogs) {
          return response()->json([
            'status' => true,
            'message' => 'Blogs fetched successfuly.',
            'data' => $blogs
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => 'Blogs fetched successfuly.',
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

    public function acceptBlog ($id) {
      // DB::beginTransaction();
      try {
        $blog = Blog::find($id);
        if ($blog) {
          // $blog = Blog::where('id', $id)->update(['is_accepted' => 1]);
          // return $blog;
          // return $id;
          // $blog->update(['is_accepted' => 1]);

          // $user = User::where('id', $blog->user_id);

          // Notification::send($user, new BlogAcceptedByAdmin($blog->id));


          // return $blog->user_id;
          $user = User::where('id', $blog->user_id)->get();
          // return $user;
          // $user->notify((new BlogAcceptedByAdmin($blog->id))->afterCommit());
          // $user->notify(new BlogAcceptedByAdmin($blog->id));
          Notification::send($user, new BlogAcceptedByAdmin($blog->id));
          // $user->notify(new InvoicePaid($invoice));

          // DB::commit();
          return response()->json([
            'status' => true,
            'message' => 'Blog accepted successfuly.',
            'data' => $blog
          ], 200);
        } else {
          // DB::rollback();

          return response()->json([
            'status' => false,
            'message' => 'Blog not found.',
            'data' => null
          ], 404);
        }
      } catch (\Throwable $th) {
        // DB::rollback();

        return response()->json([
          'status' => false,
          'message' => $th->getMessage(),
          'data' => null
        ], 500);
      }
    }

    public function deleteBlog ($id) {
      try {
        $blog = Blog::find($id)->first();

        if ($blog) {
          Blog::where('id', $id)->delete();

          return response()->json([
            'status' => true,
            'message' => 'Blog deleted successfuly.',
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

    public function comments()
    {
      try {
        $comments = Comment::with(['user' => function ($query) {
          $query->select('id', 'name');
        }, 'blog'])->orderby('created_at', 'desc')->get();

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

    public function deleteComment ($id) {
      try {
        $comment = Comment::find($id)->first();

        if ($comment) {
          Comment::where('id', $id)->delete();

          return response()->json([
            'status' => true,
            'message' => 'Comment deleted successfuly.',
            'data' => $comment
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => 'Comment not found.',
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

    public function countComments () {
      try {
        $count = Comment::count();
        return response()->json([
          'status' => true,
          'message' => 'Comments counted successfuly!',
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

    public function users ()
    {
      try {
        $users = User::orderby('created_at', 'desc')->get();

        if ($users) {
          return response()->json([
            'status' => true,
            'message' => 'Users fetched successfuly.',
            'data' => $users
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => 'No users yet.',
            'data' => $users
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

    public function deleteUser ($id) {
      try {
        $user = User::find($id)->first();

        if ($user) {
          User::where('id', $id)->delete();

          return response()->json([
            'status' => true,
            'message' => 'User deleted successfuly.',
            'data' => $user
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => 'User not found.',
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

    public function countUsers () {
      try {
        $count = User::count();
        return response()->json([
          'status' => true,
          'message' => 'Users counted successfuly!',
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
