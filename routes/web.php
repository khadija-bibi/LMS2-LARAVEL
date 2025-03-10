<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function(){

    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // // Student Routes
    // Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    // Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    // Route::put('/students/store', [StudentController::class, 'store'])->name('students.store');
    // Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    // Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    // Route::get('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

    // // Teacher Routes
    // Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    // Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    // Route::put('/teachers/store', [TeacherController::class, 'store'])->name('teachers.store');
    // Route::get('/teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    // Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('teachers.update');
    // Route::get('/teachers/{id}', [TeacherController::class, 'destroy'])->name('teachers.destroy');

    // // Course Routes
    // Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    // Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    // Route::put('/courses/store', [CourseController::class, 'store'])->name('courses.store');
    // Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    // Route::put('/courses/{id}', [CourseController::class, 'update'])->name('courses.update');
    // Route::get('/courses/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');

    //                 //Course Content Routes
    // Route::get('/courses/{id}/manage-content', [CourseController::class, 'manageContent'])->name('courses.manage-content');
    // Route::post('/courses/{id}/add-content', [CourseController::class, 'storeContent'])->name('courses.store-content');
    // Route::get('/courses/content/{id}', [CourseController::class, 'deleteContent'])->name('courses.delete-content');

    // // Assignments Routes
    // Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    // Route::get('/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
    // Route::put('/assignments/store', [AssignmentController::class, 'store'])->name('assignments.store');
    // Route::get('/assignments/{id}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
    // Route::put('/assignments/{id}', [AssignmentController::class, 'update'])->name('assignments.update');
    // Route::get('/assignments/{id}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');

    // Route::get('assignments/{id}/download', [AssignmentController::class, 'download'])->name('assignments.download');
    //                     //Assignment Submissions Routes
    // Route::get('assignments/{id}/submit', [AssignmentController::class, 'submitForm'])->name('assignments.submit-form');
    // Route::post('assignments/{id}/submit', [AssignmentController::class, 'submit'])->name('assignments.submit');
    // Route::get('/assignments/{id}/delete-submission', [AssignmentController::class, 'deleteSubmission'])->name('assignments.delete-submission');

});
Route::middleware(['auth','role:admin|teacher|student'])->group(function () {
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');

});
// Route::middleware(['auth','role:admin|teacher'])->group(function () {

// });
Route::middleware(['auth','role:teacher|student'])->group(function () {
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('assignments/{id}/download', [AssignmentController::class, 'download'])->name('assignments.download');
    Route::get('/courses/{id}/manage-content', [CourseController::class, 'manageContent'])->name('courses.manage-content');
    Route::get('/assignments/{id}/submit', [AssignmentController::class, 'submitForm'])->name('assignments.submit-form');

});
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::put('/students/store', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::get('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    Route::put('/teachers/store', [TeacherController::class, 'store'])->name('teachers.store');
    Route::get('/teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::get('/teachers/{id}', [TeacherController::class, 'destroy'])->name('teachers.destroy');

    // Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::put('/courses/store', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{id}', [CourseController::class, 'update'])->name('courses.update');
    Route::get('/courses/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');
});

Route::middleware(['auth', 'role:student'])->group(function () {
    // Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    // Route::get('/courses/{id}/manage-content', [CourseController::class, 'manageContent'])->name('courses.manage-content');

    // Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    // Route::get('assignments/{id}/download', [AssignmentController::class, 'download'])->name('assignments.download');
    // Route::get('/assignments/{id}/submit', [AssignmentController::class, 'submitForm'])->name('assignments.submit-form');
    Route::post('/assignments/{id}/submit', [AssignmentController::class, 'submit'])->name('assignments.submit');
    Route::get('/assignments/{id}/delete-submission', [AssignmentController::class, 'deleteSubmission'])->name('assignments.delete-submission');
});

Route::middleware(['auth', 'role:teacher'])->group(function () {
    // Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');

    // Route::get('/courses/{id}/manage-content', [CourseController::class, 'manageContent'])->name('courses.manage-content');
    Route::post('/courses/{id}/add-content', [CourseController::class, 'storeContent'])->name('courses.store-content');
    Route::get('/courses/content/{id}', [CourseController::class, 'deleteContent'])->name('courses.delete-content');

    Route::get('/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::put('/assignments/store', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::get('/assignments/{id}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
    Route::put('/assignments/{id}', [AssignmentController::class, 'update'])->name('assignments.update');
    Route::get('/assignments/{id}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');

    // Route::get('/assignments/{id}/submit', [AssignmentController::class, 'submitForm'])->name('assignments.submit-form');

});



