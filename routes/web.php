<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\stripeController;
use App\Http\Controllers\SubTaskController;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\WebFrontendController;
use App\Http\Controllers\WebReportController;
use App\Http\Controllers\WebSubtaskController;
use App\Http\Controllers\WebTaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

// Route::get('/homepage',function(){
//     return view('dashboard');
// });
Route::get('/homepage', [WebFrontendController::class, 'home']);


Route::get('/index', [ProfileController::class, 'index'])->name('index');
Route::post('/import-excel', [ProfileController::class, 'import'])->name('import.excel');


Route::get('/login', [WebAuthController::class, 'index'])->name('login');
Route::post('/login', [WebAuthController::class, 'login'])->name('login.submit');

Route::get('/register', function(){
    return view('web/register');
})->name('register');
Route::post('/register', [WebAuthController::class, 'register'])->name('register.submit');

Route::middleware('auth')->group(function(){
    Route::post('/tasks/{taskid}/add-subtask', action: [WebSubtaskController::class, 'store'])->name('store.subtask');
    Route::get('/tasks/{taskid}/edit-subtask/{subtask_id}', [SubTaskController::class, 'edit'])->name('edit.subtask');
    Route::put('/tasks/{task_id}/update-subtask/{subtask_id}', [WebSubtaskController::class, 'update'])->name('update.subtask');
    Route::delete('/tasks/{task_id}/delete-subtask/{subtask_id}', [WebSubtaskController::class, 'delete'])->name('delete.subtask');
    Route::post('/add-task', [WebTaskController::class, 'store'])->name('add.task');
    Route::post('/edit-task/{id}', [WebTaskController::class, 'edit'])->name('edit.task');
    //-------------------------//
    Route::put('/update-task/{id}', [WebTaskController::class, 'update'])->name('update.task');
    Route::delete('/delete-task/{id}', [WebTaskController::class, 'delete'])->name('delete.task');
    Route::get('/search', [WebFrontendController::class, 'search'])->name('search');
    // Page View Routes
    Route::get('/subtasks', [WebFrontendController::class, 'subtasks'])->name('subtasks.list');
    Route::get('/', [WebFrontendController::class, 'homepage'])->name('dashboard');
    Route::get('/task/{task_id}', [WebFrontendController::class, 'task_view'])->name('task.view');
    Route::get('/tasks', [WebFrontendController::class, 'task_list'])->name('tasks.list');
    Route::get('/task/{task_id}/subtask/{subtask_id}', [WebFrontendController::class, 'subtask_view'])->name('subtask.view');
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [WebFrontendController::class, 'profile'])->name('profile');
    Route::put('/update-profile/{id}', [WebAuthController::class, 'update'])->name('profile.update');
    Route::get('/dashboard/filter', [WebFrontendController::class, 'homepage'])->name('dashboard.filter');
    Route::get('/tasks/filter', [WebFrontendController::class, 'task_list'])->name('tasks.filter');
    Route::get('/report', [WebReportController::class, 'index'])->name('report.index');
    Route::post('/report/store', [WebReportController::class, 'store'])->name('report.store');
    Route::delete('report/delete/{id}', [WebReportController::class, 'delete'])->name('report.delete');
    Route::put('report/edit/{id}', [WebReportController::class, 'edit'])->name('report.edit');

    // STRIPE
    Route::post('/subscribe', [stripeController::class, 'subscribe'])->name('subscribe');
    Route::get('/success', [stripeController::class, 'success'])->name('success');
    Route::get('/cancel', [stripeController::class, 'cancel'])->name('cancel');

});