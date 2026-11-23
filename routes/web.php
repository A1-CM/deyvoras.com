<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ContractWorkspaceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'site.home')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1')->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/invite/{token}', [TeamController::class, 'showAccept'])->name('invites.accept');
Route::post('/invite/{token}', [TeamController::class, 'accept'])->middleware('throttle:10,1')->name('invites.accept.store');

Route::middleware('auth')->group(function () {
    Route::get('/workspace', DashboardController::class)->name('dashboard');
    Route::get('/reports', ReportController::class)->name('reports.index');
    Route::get('/activity', ActivityController::class)->name('activity.index');
    Route::middleware('can:manage-team')->group(function () {
        Route::get('/team', [TeamController::class, 'index'])->name('team.index');
        Route::post('/team/invitations', [TeamController::class, 'invite'])->name('team.invitations.store');
        Route::put('/team/{user}/role', [TeamController::class, 'updateRole'])->name('team.roles.update');
        Route::delete('/team/invitations/{invitation}', [TeamController::class, 'cancelInvitation'])->name('team.invitations.cancel');
    });
    Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.index');
    Route::get('/contracts/compare', [ContractController::class, 'compare'])->name('contracts.compare');
    Route::middleware('can:manage-contracts')->get('/contracts/create', [ContractController::class, 'create'])->name('contracts.create');
    Route::middleware('can:manage-contracts')->post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
    Route::get('/contracts/{contract}/download', [ContractController::class, 'download'])->name('contracts.download');
    Route::get('/contracts/{contract}/versions/{version}/download', [ContractController::class, 'downloadVersion'])->name('contracts.versions.download');
    Route::middleware('can:manage-contracts')->get('/contracts/{contract}/edit', [ContractController::class, 'edit'])->name('contracts.edit');
    Route::get('/contracts/{contract}', [ContractController::class, 'show'])->name('contracts.show');
    Route::middleware('can:manage-contracts')->group(function () {
        Route::put('/contracts/{contract}', [ContractController::class, 'update'])->name('contracts.update');
        Route::post('/contracts/{contract}/archive', [ContractController::class, 'archive'])->name('contracts.archive');
        Route::post('/contracts/{contract}/clauses', [ContractWorkspaceController::class, 'storeClause'])->name('clauses.store');
        Route::put('/contracts/{contract}/clauses/{clause}', [ContractWorkspaceController::class, 'updateClause'])->name('clauses.update');
        Route::post('/contracts/{contract}/clauses/{clause}/verify', [ContractWorkspaceController::class, 'verifyClause'])->name('clauses.verify');
        Route::post('/contracts/{contract}/obligations', [ContractWorkspaceController::class, 'storeObligation'])->name('obligations.store');
        Route::post('/contracts/{contract}/obligations/{obligation}/toggle', [ContractWorkspaceController::class, 'toggleObligation'])->name('obligations.toggle');
        Route::post('/contracts/{contract}/review', [ContractWorkspaceController::class, 'toggleReview'])->name('contracts.review');
    });
});
