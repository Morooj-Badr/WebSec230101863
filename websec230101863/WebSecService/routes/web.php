<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\OrdersController;
use App\Http\Controllers\Web\PurchasesController;
use App\Http\Controllers\Web\EmployeesController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\StudentController;
use App\Http\Controllers\Web\QuestionController;
use App\Http\Controllers\Web\ExamController;


Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');


Route::middleware(['auth'])->group(function () {
    Route::get('users', [UsersController::class, 'list'])->name('users');
    Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
    Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
    Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
    Route::get('users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete');
    Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
    Route::post('users/save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');
});


Route::middleware(['auth'])->group(function () {
    Route::get('products', [ProductsController::class, 'list'])->name('products_list');
    Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
    Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
    Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/multable', function (Request $request) {
    $j = $request->number ?? 5;
    $msg = $request->msg;
    return view('multable', compact("j", "msg"));
});

Route::get('/even', fn() => view('even'));
Route::get('/prime', fn() => view('prime'));
Route::get('/test', fn() => view('test'));


Route::get('/minitest', function () {
    $bill = [
        ['item' => 'Milk', 'quantity' => 2, 'price' => 20],
        ['item' => 'Bread', 'quantity' => 6, 'price' => 10],
        ['item' => 'Eggs', 'quantity' => 8, 'price' => 40],
        ['item' => 'Juice', 'quantity' => 5, 'price' => 50],
    ];
    return view('minitest', ['bill' => $bill]);
});


Route::get('/transcript', function () {
    $courses = [
        ['name' => 'Web Security', 'grade' => 'A'],
        ['name' => 'Digital Forensics', 'grade' => 'B+'],
        ['name' => 'Network Security', 'grade' => 'A-'],
        ['name' => 'Linux Programming', 'grade' => 'B']
    ];
    return view('transcript', compact('courses'));
})->name('transcript');

Route::get('/calculator', fn() => view('calculator'))->name('calculator');

Route::get('/students/add', [StudentController::class, 'add'])->name('students.add');
Route::get('/student', [StudentController::class, 'view'])->name('student');
Route::post('/students/save', [StudentController::class, 'save'])->name('student_save');


Route::resource('questions', QuestionController::class);
Route::get('exam', [ExamController::class, 'start'])->name('exam.start');
Route::post('exam/submit', [ExamController::class, 'submit'])->name('exam.submit');


Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrdersController::class, 'list'])->name('orders_list');
    Route::post('/purchase/{product}', [OrdersController::class, 'purchase'])->name('orders.purchase');
    
    Route::post('/buy-product/{id}', [PurchasesController::class, 'buy'])->name('purchases.buy');
});




Route::post('/purchase/{id}', [PurchasesController::class, 'buy'])->name('purchases.buy');
use App\Http\Controllers\CustomerController;

Route::post('/customers/{customer}/update-credit', [CustomerController::class, 'updateCredit'])
    ->name('customers.updateCredit')
    ->middleware('auth'); // Ensure authentication
    Route::get('/customers', [CustomerController::class, 'index'])
    ->name('customers.index')
    ->middleware('auth'); // Ensure authentication
