<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;


Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');
Route::get('users', [UsersController::class, 'list'])->name('users');
Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
Route::get('users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete');
Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
Route::post('users/save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');



Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/multable', function (Request $request) {
    $j = $request->number??5;
    $msg = $request->msg;
    return view('multable', compact("j", "msg"));
});

Route::get('/even', function () {
    return view('even');
});

Route::get('/prime', function () {
    return view('prime');
});

Route::get('/test', function () {
    return view('test');
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

use App\Http\Controllers\Web\StudentController;

// Ensure Laravel properly registers the route
Route::get('/students/add', function () {
    return "Route is working!";
});

// Now re-register it properly
Route::get('/students/add', [StudentController::class, 'add'])->name('students.add');

// Keep your 'view' route
Route::get('/student', [StudentController::class, 'view'])->name('student');

// Your 'save' route remains the same
Route::post('/students/save', [StudentController::class, 'save'])->name('student_save');
