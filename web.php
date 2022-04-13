<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDataController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return redirect('user');
});

Route::get('user', [UserDataController::class, 'index']);
Route::post('user_signup', [UserDataController::class, 'user_signup'])->name('user.user_signup');
Route::post('user_login_process', [UserDataController::class, 'user_login_process'])->name('emp.user_login_process');
Route::group(['middleware'=>'user_auth'], function(){
    Route::get('user/dashboard', [UserDataController::class, 'dashboard']);
    Route::get('user/personal-info', [UserDataController::class, 'personal_info']);
    Route::post('user/getcity', [UserDataController::class, 'getcity'])->name('user.getcity');
    Route::post('user/manage_personal_info_process', [UserDataController::class, 'manage_personal_info_process'])->name('user.manage_personal_info_process');
    
    Route::get('user/manage-personal-info/{id}', [UserDataController::class, 'manage_personal_info']);
    
    Route::get('user/logout', function(){
        session()->forget('USER_LOGIN');
        session()->forget('USER_ID');
        session()->forget('USER_NAME');
        session()->flash('error','Logout Successfully');
    return redirect('user');
    });
    });
    

