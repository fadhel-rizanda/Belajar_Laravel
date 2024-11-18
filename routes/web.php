<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('posts.index');// ubah ke post file
// })->name('home');
// shorter version, namun hanya digunakan jika tidak membutuhkan action

// Route::view('/', 'posts.index')->name('home'); ubah karena pada post.index sudah mengarah ke homenya sehingga tidak perlu 2 kali
Route::redirect('/', 'posts');// agar setiap kali masuk ke halaman home maka akan diarahkan ke halaman posts

Route::middleware('auth')->group(function(){// middleware digunakan utnuk memastikan bahwa  middleware telah dijalankan terlebih dahulu
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard'); // middleware verified ditambahkan verrifikasdi email
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // email verification
    Route::get('/email/verify', [AuthController::class, 'verifyNotice'])->name('verification.notice');// jangan diubah
    // handler
    Route::get('/email/verify/{id}/{hash}',[AuthController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');
    // resending email
    Route::post('/email/verification-notification', [AuthController::class, 'verifyHandler'])->middleware(['throttle:6,1'])->name('verification.send'); // throtle digunakan utnuk avoid ddos
});

Route::middleware('guest')->group(function(){ // untuk implementasi middleware lebih efektif dibandingkan harus ->middleware('auth') satu2
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register'); // jadi dia nyari class didalem file authConteroller

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::resource('/posts', PostController::class);

Route::get('/{user}/posts', [DashboardController::class, 'userPosts'])->name('post.user');