<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;

class UserAuthController extends Controller
{
    public function register(Request $request) //hna ban3ml register an 7ad ya5osh 3la api
    {
        $request->validate([ //tab3an lazm validate lel register
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);
        try {
            $user = User::create([ //ban3ml create fe gadwl user aly da5l be api random
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), //hash password baib2a 8areb kda
                'api_token' => Str::random(64), //random api
            ]);
            return response()->json([ //hna law nag7at al3amlia baitl3 massage an user da5l fel postman
                'status' => 'User Register',
                'user' => $user
            ]);
        } catch (Exception $e) {
            return response()->json([ //hna law fashlt
                'status' => 'falid',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function login(Request $request) //nafs kalam lel login bas bao5osh b2a 3ashan nazhar lel data
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:6'
        ]);
        if ($user = User::firstWhere('email', $request->email)) {
            if (Hash::check($request->password, $user->password)) {
                $user->update(['api_token' => Str::random(64)]); //hna ban8ier api 3ashan zaiada aman
                return response()->json([
                    'status' => 'loged',
                    'user_token' =>  $user->api_token
                ]);
            }
        }
        return response()->json([
            'status' => 'falid',
            'message' => 'email or password not valid'
        ], 500);
    }
}
