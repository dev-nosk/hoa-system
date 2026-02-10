<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
}); 
// Route::get('/mainview', function () {
//     return view('mainview');
// })->middleware(['auth', 'verified'])->name('mainview');

Route::get('/mainview', [MainController::class, 'mainView'])
    ->middleware(['auth'])
    ->name('mainview');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/workgroup', [MainController::class, 'workgroupView'])
    ->middleware(['auth'])
    ->name('workgroup');

require __DIR__.'/auth.php';
