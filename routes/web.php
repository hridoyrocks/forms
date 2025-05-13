<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicFormController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ফর্ম রাউট
    Route::resource('forms', FormController::class);
    Route::get('forms/{form}/shareable', [FormController::class, 'shareableLink'])->name('forms.shareable');
    
    // লিড রাউট (নেস্টেড)
    Route::get('forms/{form}/leads', [LeadController::class, 'index'])->name('forms.leads.index');
    Route::get('forms/{form}/leads/{lead}', [LeadController::class, 'show'])->name('forms.leads.show');
    Route::delete('forms/{form}/leads/{lead}', [LeadController::class, 'destroy'])->name('forms.leads.destroy');
    Route::get('forms/{form}/leads/download/csv', [LeadController::class, 'downloadCsv'])->name('forms.leads.download.csv');
});

// পাবলিক ফর্ম রাউট (অথেনটিকেশন ছাড়া)
Route::get('public/forms/{form}', [PublicFormController::class, 'show'])->name('forms.public.show');
Route::post('public/forms/{form}/submit', [LeadController::class, 'store'])->name('forms.public.submit');
Route::get('public/forms/{form}/thank-you', [PublicFormController::class, 'thankYou'])->name('forms.public.thank-you');

require __DIR__.'/auth.php';