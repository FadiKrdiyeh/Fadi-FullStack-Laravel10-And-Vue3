<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Http\Request;

class AccountController extends Controller
{
  public function index (Request $request) {
    // return Auth::user();
    // return $request->path();

    if (Auth::check() && Auth::user()->type == 'user' && $request->path() != 'login') {
      return view('app');
    }
    if (!Auth::check() && $request->path() != 'login') {
      // return $request->path();
      return redirect('/login');
    }
    return view('app');
  }

  public function login (Request $request) {
    try {
      $request->validate([
        'email' => 'required|email',
        'password' => 'required'
      ]);

      if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'type' => 'user'])) {
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
      $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6'
      ]);

      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'type' => 'user'
      ]);

      if ($user) {
        Auth::login($user);

        return response()->json([
          'status' => true,
          'message' => 'Registration succeed.',
          'data' => $user
        ]);
      }

      return response()->json([
        'status' => false,
        'message' => 'Registration failed.',
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
}
