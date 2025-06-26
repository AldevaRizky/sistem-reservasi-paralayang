<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/', [App\Http\Controllers\Landing\BerandaController::class, 'index']);

Route::middleware(['auth', 'admin:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('paragliding-packages', \App\Http\Controllers\Admin\ParaglidingPackageController::class);
    Route::resource('camping-equipment', \App\Http\Controllers\Admin\CampingEquipmentController::class);
    Route::resource('users/admin', \App\Http\Controllers\Admin\AdminUserController::class)->names('users.admin');
    Route::resource('users/user', \App\Http\Controllers\Admin\UserUserController::class)->names('users.user');
    Route::resource('users/staff', \App\Http\Controllers\Admin\StaffUserController::class)->names('users.staff');
    Route::resource('admin/paragliding-schedules', \App\Http\Controllers\Admin\ParaglidingScheduleController::class);
});

Route::middleware(['auth', 'staff:staff'])->prefix('staff')->as('staff.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Staff\DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'verified', 'user:user'])->prefix('user')->as('user.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password');
    Route::post('/profile/password/update', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

require __DIR__ . '/auth.php';
