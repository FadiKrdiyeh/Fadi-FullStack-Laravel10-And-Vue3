<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
