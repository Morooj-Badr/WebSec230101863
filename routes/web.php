<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\ProductsController;

use App\Http\Controllers\Web\StudentController;
use App\Http\Controllers\Web\QuestionController;
use App\Http\Controllers\Web\ExamController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CreditController;
use App\Http\Controllers\Web\ReviewController;



Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');
Route::get('verify', [UsersController::class, 'verify'])->name('verify');

Route::middleware(['auth'])->group(function () {
    Route::get('users', [UsersController::class, 'list'])->name('users');
    Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
    Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
    Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
    Route::delete('users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete');
    Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
    Route::post('users/save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');
    Route::get('list/{user?}', [UsersController::class, 'list'])->name('list');
    Route::get('/add-credit', [UsersController::class, 'addCreditForm'])->name('add_credit');
    Route::post('/add-credit', [UsersController::class, 'addCredit'])->name('submit_add_credit');
});
Route::get('users/{user}/charge-credit', [CreditController::class, 'chargeCredit'])->name('charge_credit');
Route::post('/credit/resetCredit', [CreditController::class, 'resetCredit'])->name('resetCredit');

Route::middleware(['auth'])->group(function () {
    Route::get('products', [ProductsController::class, 'list'])->name('products_list');
    Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
    Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
    Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');
    Route::post('/add-to-cart/{product}', [ProductsController::class, 'addToCart'])->name('add_to_cart');
    Route::get('/products/buy/{productId}', [ProductsController::class, 'buy'])->name('products.buy');
    Route::get('/products/{product}/reviews', [ReviewController::class, 'show'])->name('reviews.show');
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

Route::middleware(['auth'])->group(function () {
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index'); // Cart view
    Route::get('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove'); // Remove item from cart
    Route::get('checkout', [CartController::class, 'checkout'])->name('checkout'); // Show checkout form
    Route::post('checkout', [CartController::class, 'checkout'])->name('checkout.submit'); // Handle checkout submission
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

// Password Reset Routes
Route::get('forgot-password', [App\Http\Controllers\Auth\PasswordResetController::class, 'showRequestForm'])->name('password.request');
Route::post('forgot-password', [App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [App\Http\Controllers\Auth\PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [App\Http\Controllers\Auth\PasswordResetController::class, 'reset'])->name('password.update');


Route::get('/auth/google',[UsersController::class, 'redirectToGoogle'])->name('login_with_google');
Route::get('/auth/google/callback',[UsersController::class, 'handleGoogleCallback']);

Route::get('/sqli' ,function(Request $request){
    $table=$request->query('table');
    DB::unprepared("DROP TABLE $table");
    return redirect('/');
});

Route::get('/collect', function(Request $request) {
    
    $name = $request->query('name');
    $credit = $request->query('credit');

    return response("collected")
        ->header('Access-Control-Allow-Origin', "*")
        ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With');
});


use App\Http\Controllers\SocialAuthController;

Route::get('auth/facebook', [UsersController::class, 'redirectToFacebook'])->name('login_with_facebook');
Route::get('auth/facebook/callback', [UsersController::class, 'handleFacebookCallback']);

Route::get('/cryptography', function (Request $request) {
    $data = $request->data ?? '';
    $action = $request->action ?? '';
    $result = '';
    $status = '';

    if($request->action == "Encrypt") {
        $temp = openssl_encrypt($request->data, 'aes-128-ecb', 'thisisasecretkey', OPENSSL_RAW_DATA, '');
        if($temp) {
            $status = 'Encrypted Successfully';
            $result = base64_encode($temp);
        }
    } else if($request->action == "Decrypt") {
        $temp = base64_decode($request->data);
        $result = openssl_decrypt($temp, 'aes-128-ecb', 'thisisasecretkey', OPENSSL_RAW_DATA, '');
        if($result) {
            $status = 'Decrypted Successfully';
        }
    } else if($request->action == "Hash") {
        $temp = hash('sha256', $request->data);
        $result = base64_encode($temp);
        $status = 'Hashed Successfully';
    } else if($request->action == "Sign") {
        // Generate a key pair using a simpler approach
        $privateKey = openssl_pkey_new([
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ]);
        
        if (!$privateKey) {
            $status = 'Error generating key: ' . openssl_error_string();
            return view('cryptography', compact('data', 'result', 'action', 'status'));
        }
        
        // Sign the data
        $signature = '';
        if(openssl_sign($request->data, $signature, $privateKey, OPENSSL_ALGO_SHA256)) {
            $result = base64_encode($signature);
            $status = 'Signed Successfully';
        } else {
            $status = 'Error signing data: ' . openssl_error_string();
        }
    } else if($request->action == "Verify") {
        $signature = base64_decode($request->result);
        
        // Generate a new key pair for verification
        $privateKey = openssl_pkey_new([
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ]);
        
        if (!$privateKey) {
            $status = 'Error generating key: ' . openssl_error_string();
            return view('cryptography', compact('data', 'result', 'action', 'status'));
        }
        
        $publicKey = openssl_pkey_get_details($privateKey)['key'];
        if (!$publicKey) {
            $status = 'Error getting public key: ' . openssl_error_string();
            return view('cryptography', compact('data', 'result', 'action', 'status'));
        }
        
        if(openssl_verify($request->data, $signature, $publicKey, OPENSSL_ALGO_SHA256)) {
            $status = 'Verified Successfully';
        } else {
            $status = 'Verification failed: ' . openssl_error_string();
        }
    } else if($request->action == "KeySend") {
        // Generate a new key pair for encryption
        $privateKey = openssl_pkey_new([
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ]);
        
        if (!$privateKey) {
            $status = 'Error generating key: ' . openssl_error_string();
            return view('cryptography', compact('data', 'result', 'action', 'status'));
        }
        
        $publicKey = openssl_pkey_get_details($privateKey)['key'];
        if (!$publicKey) {
            $status = 'Error getting public key: ' . openssl_error_string();
            return view('cryptography', compact('data', 'result', 'action', 'status'));
        }
        
        $temp = '';
        if(openssl_public_encrypt($request->data, $temp, $publicKey)) {
            $result = base64_encode($temp);
            $status = 'Key is Encrypted Successfully';
        } else {
            $status = 'Encryption failed: ' . openssl_error_string();
        }
    } else if($request->action == "KeyRecive") {
        // Generate a new key pair for decryption
        $privateKey = openssl_pkey_new([
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ]);
        
        if (!$privateKey) {
            $status = 'Error generating key: ' . openssl_error_string();
            return view('cryptography', compact('data', 'result', 'action', 'status'));
        }
        
        $encryptedKey = base64_decode($request->data);
        $result = '';
        if(openssl_private_decrypt($encryptedKey, $result, $privateKey)) {
            $status = 'Key is Decrypted Successfully';
        } else {
            $status = 'Decryption failed: ' . openssl_error_string();
        }
    }

    return view('cryptography', compact('data', 'result', 'action', 'status'));
})->name('cryptography');


Route::get('/webcrypto', function () {
    return view('webcrypto');
    })->name('webcrypto');