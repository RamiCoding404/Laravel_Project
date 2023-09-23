<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) //hna tab3an 3amlen route 3ashan user yashof data lazm yad5l api bta3o
    {
        if ($request->header('api_token') && $user =  User::firstWhere('api_token', $request->header('api_token'))) {
            return Post::where('user_id', $user->id)->get();
        } else {
            return response()->json([
                'status' => 'faild',
                'message' => 'User Token Not Valid'
            ]);
        }
    }
}
