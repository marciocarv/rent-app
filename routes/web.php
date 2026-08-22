<?php

use App\Http\Middleware\EnsureUserIsLandlord;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TicketController;
use App\Http\Middleware\EnsureUserIsTenant;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});


// Grouping routes that require the user to be logged in and verified
Route::middleware(['auth', 'verified', EnsureUserIsLandlord::class])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('properties', PropertyController::class);
    Route::resource('units', UnitController::class);
    Route::resource('tenants', TenantController::class);
    Route::resource('contracts', ContractController::class);
    Route::get('/contracts/{contract}/document', [App\Http\Controllers\ContractController::class, 'document'])->name('contracts.document');
    Route::patch('/contracts/{contract}/terminate', [App\Http\Controllers\ContractController::class, 'terminate'])->name('contracts.terminate');
    Route::get('/financeiro', [TransactionController::class, 'index'])->name('transactions.index');
    Route::patch('/financeiro/{transaction}/pay', [TransactionController::class, 'markAsPaid'])->name('transactions.pay');
    Route::post('/financeiro/despesas', [TransactionController::class, 'storeExpense'])->name('transactions.storeExpense');
    Route::get('/manutencao', [TicketController::class, 'index'])->name('tickets.index');
    Route::patch('/manutencao/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['web', 'auth', 'verified', EnsureUserIsTenant::class])->group(function () {
    Route::get('/meu-imovel', [TenantController::class, 'dashboard'])->name('tenants.dashboard');
    Route::post('/meu-imovel/chamados', [TenantController::class, 'storeTicket'])->name('tenant.tickets.store');
});

require __DIR__.'/auth.php';
