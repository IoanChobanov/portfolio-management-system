<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TechnologyController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('projects', ProjectController::class);

    Route::post('projects/{project}/testimonials', [TestimonialController::class, 'store'])
        ->name('testimonials.store');

    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])
        ->middleware(['auth']) 
        ->name('testimonials.destroy');
        
    Route::resource('clients', ClientController::class);

    Route::resource('technologies', TechnologyController::class);
});

require __DIR__.'/auth.php';
