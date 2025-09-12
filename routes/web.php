<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AssessmentController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\ResultCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::resource('assessments', AssessmentController::class);
    
    Route::prefix('assessments/{assessment}')->group(function () {
        Route::resource('questions', QuestionController::class);
        
        Route::prefix('questions/{question}')->group(function () {
            Route::resource('options', OptionController::class);
        });

         Route::resource('result-categories', ResultCategoryController::class);
        Route::resource('questions', QuestionController::class);
        
        Route::prefix('questions/{question}')->group(function () {
            Route::resource('options', OptionController::class);

                 // Quick Scoring Routes
            Route::get('/quick-score', [OptionController::class, 'quickScore'])->name('options.quick-score');
            Route::post('/quick-score', [OptionController::class, 'saveQuickScore'])->name('options.save-quick-score');
       
        });
    });
});

require __DIR__.'/auth.php';