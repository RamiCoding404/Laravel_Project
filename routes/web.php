<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware('auth')->group(function () {

    Route::get('lang/{lang}', function ($lang) {
        if ($lang == 'ar' || $lang == 'en') {
            session()->put('lang', $lang); //baib3at ka session lel change lan 3ashan ya7wal alo8a
            return back();
        } else {
            abort(500);
        }
    })->name('lang');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('companies')->as('companies.')->group(function () {
        Route::get('/', [CompanyController::class, 'index'])->name('index');
        Route::get('/create', [CompanyController::class, 'create'])->name('create');
        Route::post('/store', [CompanyController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CompanyController::class, 'edit'])->name('edit');

        // Route::put('/edit/{id}', [CompanyController::class, 'edit'])->name('edit');
        Route::patch('/update/{id}', [CompanyController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CompanyController::class, 'delete'])->name('delete');
    });
    Route::resource('branches', BranchController::class);
    Route::resource('vendors', VendorController::class)->except('show');
    // Route::resource('branches', BranchController::class)->except('show');
    // Route::resource('branches', BranchController::class)->only('show');
});

require __DIR__ . '/auth.php';