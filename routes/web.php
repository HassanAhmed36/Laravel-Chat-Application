<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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
    if (Auth::check()) {
        return redirect()->back();
    }
    return view('index');
})->name('index');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/rigester', [AuthController::class, 'rigester'])->name('rigester');
Route::post('/submit-rigester', [AuthController::class, 'SubmitRigester'])->name('submit.register');
Route::post('/submit-login', [AuthController::class, 'SubmitLogin'])->name('submit.login');

Route::middleware(['CheckAuth'])->group(function () {
    Route::get('/Search-User', [UserController::class, 'searchUser'])->name('search.user');
    Route::get('/chat/{id}', [MessageController::class, 'showChat'])->name('chat');
    Route::get('/load-messages', [MessageController::class, 'LoadChat'])->name('load.message');
    Route::post('/send-messages', [MessageController::class, 'SendMessages'])->name('send.message');
    Route::get('/show-profile/{id}', [UserController::class, 'showProfile'])->name('show.Profile');
    Route::post('/update-profile/{id}', [UserController::class, 'updateProfile'])->name('update.Profile');
    Route::get('/get-recent-user', [MessageController::class, 'GetRecentChat'])->name('get.recent.user');
    Route::post('/seen-message', [MessageController::class, 'SeenMessage'])->name('seen.message');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
