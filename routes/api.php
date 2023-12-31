<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CompanyController;
use App\Http\Controllers\api\UserAuthController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('companies', CompanyController::class);

Route::post('user/auth/login', [UserAuthController::class, 'login']); //dah route lel login
Route::post('user/auth/register', [UserAuthController::class, 'register']); //dah route lel register
Route::get('user/posts', [PostController::class, 'index']); //data route 3ashan ya5osh 3la data