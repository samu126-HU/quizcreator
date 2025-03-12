<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('quizzes', function () {
    return Inertia::render('Quizzes');
})->middleware(['auth', 'verified'])->name('quizzes');

Route::get('quizcreator', function () {
    return Inertia::render('QuizCreator');
})->middleware(['auth', 'verified'])->name('quizcreator');

Route::get('categorycreator', function () {
    return Inertia::render('CategoryCreator');
})->middleware(['auth', 'verified'])->name('categorycreator');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
