<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\SubTaskController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Payload -> name, email, password
Route::post('/register', [AuthController::class, 'register']);
//Payload -> email, password
Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    //-------------------------//
    //Payload -> name, password
    Route::put('/update-profile/{id}', [AuthController::class, 'update'])->name('update.profile');
    //-------------------------//
    //For Testing
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/index', [AuthController::class, 'index']);
    //-------------------------//
    //Payload -> title, description, deadline
    Route::post('/add-task', [TaskController::class, 'store'])->name('task.add');
    Route::post('/edit-task/{id}', [TaskController::class, 'edit'])->name('task.edit');
    //-------------------------//
    //Payload -> title, description, deadline, status_id
    Route::put('/update-task/{id}', [TaskController::class, 'update'])->name('task.update');
    Route::delete('/delete-task/{id}', [TaskController::class, 'delete'])->name('task.delete');
    //-------------------------//
    //Payload -> title, description, task_type_id, deadline OR days
    Route::post('/tasks/{taskid}/add-subtask', [SubTaskController::class, 'store'])->name('subtask.store');
    Route::get('/tasks/{taskid}/edit-subtask/{subtask_id}', [SubTaskController::class, 'edit'])->name('subtask.edit');
    Route::delete('/tasks/{taskid}/delete-subtask/{subtask_id}', [SubTaskController::class, 'delete'])->name('subtask.delete');
    //-------------------------//
    //Payload -> title, description, task_type_id, status_id, deadline OR days
    Route::put('/tasks/{taskid}/update-subtask/{subtask_id}', [SubTaskController::class, 'update'])->name('subtask.update');

    //-------------------------//

    //Pages
    Route::get('/dashboard', [FrontendController::class, 'homepage']);
    Route::get('/epiclist', [FrontendController::class, 'task_list'])->name('task.list');
    Route::get('/task/{task_id}', [FrontendController::class, 'task_view']);
    Route::get('subtasks', [FrontendController::class, 'subtasks']);
    Route::get('/task/{task_id}/subtask/{subtask_id}', [FrontendController::class, 'subtask_view']);
});
