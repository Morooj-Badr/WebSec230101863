<?php

use Illuminate\Support\Facades\Route;


    Route::get('/', function () {
    return view('welcome'); 
    });

    Route::get('/multable', function () {
    return view('multable'); 
    });
    
    Route::get('/even', function () {
    return view('even'); 
    });

    Route::get('/prime', function () {
    return view('prime'); 
    });

    Route::get('/minitest', function () {
        $bill=[
            ['item' => 'Milk' , 'quantity' => 2 , 'price' => 20],
            ['item' => 'Bread' , 'quantity' => 6 , 'price' => 10],
            ['item' => 'Eggs' , 'quantity' => 8 , 'price' => 40],
            ['item' => 'Juice' , 'quantity' => 5 , 'price' => 50],
        ];
        return view('minitest' , ['bill' => $bill]);
    });

    use App\Http\Controllers\Web\ProductsController;
    Route::get('products', [ProductsController::class,'list'])->name('products_list');
    Route::get('products/edit/{product?}', [ProductsController::class,'edit'])->name('products_edit');
    Route::post('products/save/{product?}', [ProductsController::class,'save'])->name('products_save');
    Route::get('products/delete/{product}', [ProductsController::class,'delete'])->name('products_delete');

    use App\Http\Controllers\Web\UsersController;
    Route::get('register', [UsersController::class, 'register'])->name('register');
    Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
    Route::get('login', [UsersController::class, 'login'])->name('login');
    Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
    Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');


    Route::get('/forgot-password', [UsersController::class, 'forgotPassword'])->name('users.forgotPassword');
    Route::post('/forgot-password', [UsersController::class, 'resetPassword'])->name('users.resetPassword');
    


    use App\Http\Controllers\Web\CrudController; 
    Route::resource('crud', CrudController::class);
    Route::delete('crud/{user}', [CrudController::class, 'destroy'])->name('crud.destroy');
    
    
    use App\Http\Controllers\Web\ProfileController;

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    