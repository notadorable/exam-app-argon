<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\MasterQuestionController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');
	Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
	Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
	Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
	Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
	Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
	Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
	Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
	Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
	Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
	Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
	Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
	Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
	Route::get('/{page}', [PageController::class, 'index'])->name('page');
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');

	Route::get('/question/index', [MasterQuestionController::class, 'index'])->name('question');
	Route::get('/question/create', [MasterQuestionController::class, 'create'])->name('question.create');
	Route::post('/question', [MasterQuestionController::class, 'store'])->name('question.store');
	Route::get('/question/{subtest_id}', [MasterQuestionController::class, 'show'])->name('question.show');
	Route::get('/question/{subtest_id}/edit', [MasterQuestionController::class, 'edit'])->name('question.edit');
	Route::put('/question/{subtest_id}', [MasterQuestionController::class, 'update'])->name('question.update');
	Route::delete('/question/{subtest_id}', [MasterQuestionController::class, 'destroy'])->name('question.destroy');

	Route::get('/project/index', [ProjectController::class, 'index'])->name('project');
	Route::get('/project/create', [ProjectController::class, 'create'])->name('project.create');
	Route::post('/project', [ProjectController::class, 'store'])->name('project.store');
	Route::get('/project/{id}', [ProjectController::class, 'show'])->name('project.show');
	Route::get('/project/{id}/edit', [ProjectController::class, 'edit'])->name('project.edit');
	Route::put('/project/{id}', [ProjectController::class, 'update'])->name('project.update');
	Route::delete('/project/{id}', [ProjectController::class, 'destroy'])->name('project.destroy');

    Route::get('/participant/index', [ParticipantController::class, 'index'])->name('participant');
    Route::post('/participant/upload', [ParticipantController::class, 'upload'])->name('participant.upload');


    Route::get('/exam/index', [ExamController::class, 'index'])->name('exam');
    Route::get('/exam/question/{subtest_id}/{participant_id}', [ExamController::class, 'question'])->name('exam.question');
    Route::post('/exam/submit', [ExamController::class, 'submit'])->name('exam.submit');
});
