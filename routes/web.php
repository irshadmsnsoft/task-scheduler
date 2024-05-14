<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;


// Route::group(['middleware' => 'web'], function () {
//     Route::get('/{any}', function () {
//         return view('main');
//     })->where('any', '^(?!home|login|register).*$'); // Redirect all routes except /home, /login, /register
// });

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', function () {
    return view('auth.register');
});
 Route::controller(TaskController::class)->group(function(){
        Route::get('/get-tasks', 'allTasks')->name('main-task');
        Route::post('/add-task', 'store')->name('add-task');
        Route::get('/edit-task/{id}', 'editTask')->name('edit-task');
        Route::post('/update-task/{id}', 'updateTask')->name('update-task');
        Route::delete('/delete-task/{id}', 'destroy')->name('delete-task');
        //Assign Task
        Route::get('/get-assign-tasks', 'allAssignTasks')->name('main-assign-task');
        Route::post('/add-assign-task', 'assignTaskStore')->name('add-assign-task');
        Route::get('/edit-assign-task/{id}', 'editAssignTask')->name('edit-assign-task');
        Route::post('/update-assign-task/{id}', 'updateAssignTask')->name('update-assign-task');
        //for assign tasks
        Route::get('/tasks', 'tasks');
        Route::get('/users', 'users');
    });
Auth::routes(); // This includes default authentication routes (/login, /register, etc.)
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




Route::get('/{any}', function () {
    return view('main');
});