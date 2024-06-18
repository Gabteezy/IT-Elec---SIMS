<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubjectController;
use App\Models\User;
use App\Models\Subject;

Route::get('/', function () {
    return view('index');
});

Route::get('/registration_form', function () {
    return view('registration_form');
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);

Route::get('/registrar_page', function () {
    $students = User::where('type', 'Student')->get();
    return view('registrar_page', ['students' => $students]);
});

Route::get('/viewDetails/{user}', function (User $user) {
    $student = $user;
    $subjects = Subject::where('student_id', $user->id)->get();
    return view('student_detail', ['student' => $student, 'subjects' => $subjects]);
});

Route::post('/updateStudent/{user}', [UserController::class, 'updateStudent']);
Route::post('/updateSubject/{subject}', [SubjectController::class, 'updateSubject']);

Route::post('/addSubject/{user}', [SubjectController::class, 'addSubject']);

Route::post('/deleteStudent/{user}', [UserController::class, 'deleteStudent']);

Route::post('/deleteSubject/{subject}', [SubjectController::class, 'deleteSubject']);
Route::post('/updateTuition/{user}', [UserController::class, 'updateTuition']);

Route::get('/cashier_page', function () {
    $students = User::where('type', 'Student')->get();
    return view('cashier_page', ['students' => $students]);
});

Route::get('/user_page', function () {
    $subjects = Subject::where('student_id', auth()->user()->id)->get();
    return view('user_page', ['subjects' => $subjects]);
});