<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\AuthController;
use App\Models\Flower;

Route::get('/', function () {
    $flowers = Flower::latest()->get();
    return view('welcome', compact('flowers'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);


Route::prefix('admin')->group(function () {

    // Named login routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');

    // Protected routes
    Route::middleware('admin')->group(function () {

        // Route::get('/dashboard', function () {
        //     return view('admin.dashboard');
        // })->name('admin.dashboard');

        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
        Route::get('/flowers', [AdminController::class, 'flowers'])->name('admin.flowers');
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
        Route::post('/pos-items/store', [AdminController::class, 'store'])->name('pos-items.store');
        Route::post('/checkout', [AdminController::class, 'storeOrder'])->name('checkout.store');
        Route::patch('/admin/orders/{order}/complete', [AdminController::class, 'complete'])->name('admin.orders.complete');

        Route::patch('/admin/orders/{order}/cancel', [AdminController::class, 'cancel'])->name('admin.orders.cancel');
        Route::get('/pos-items/edit', [AdminController::class, 'editPosItems'])->name('pos-items.edit');
        Route::put('/pos-items/{id}', [AdminController::class, 'updatePosItems'])->name('pos-items.update');

        Route::get('/orders/completed', [AdminController::class, 'completedOrders'])->name('admin.completed');
        Route::get('/orders/cancelled', [AdminController::class, 'cancelledOrders'])->name('admin.cancelled');



        Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::post('/profile/email', [AdminController::class, 'updateEmail'])->name('admin.profile.email');
        Route::post('/profile/password', [AdminController::class, 'updatePassword'])->name('admin.profile.password');


        Route::get('/admin/reports/pdf', [AdminController::class, 'downloadPdf'])->name('admin.reports.pdf');
        Route::post('/flowers', [AdminController::class, 'storeFlower'])->name('admin.flowers.store');

        Route::delete('/pos-items/{id}', [AdminController::class, 'destroy'])->name('pos-items.destroy');
        Route::put('/flowers/{id}', [AdminController::class, 'updateFlower'])->name('admin.flowers.update');

        Route::delete('/flowers/{id}', [AdminController::class, 'destroyFlower'])->name('admin.flowers.destroy');





    });


});





require __DIR__.'/auth.php';
