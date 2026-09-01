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

Route::post('/webhook/mercadopago', [\App\Http\Controllers\SubscriptionController::class, 'webhook'])
    ->name('webhook.mercadopago');


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
    Route::post('/templates/defaults', [App\Http\Controllers\ContractTemplateController::class, 'generateDefaults'])->name('templates.defaults');
    Route::resource('templates', App\Http\Controllers\ContractTemplateController::class);
    Route::post('/contracts/{contract}/document/finalize', [App\Http\Controllers\ContractController::class, 'finalizeDocument'])
    ->name('contracts.document.finalize');
    Route::post('/contracts/{contract}/document/sign-landlord', [App\Http\Controllers\ContractController::class, 'signLandlord'])
    ->name('contracts.document.sign-landlord');
    Route::get('/planos', function () {
        return view('plans.index');
    })->name('plans.index');
    Route::post('/planos/checkout/{plan}/{cycle}', [\App\Http\Controllers\SubscriptionController::class, 'checkout'])
    ->name('plans.checkout');
    Route::get('/plans/callback/{plan}/{cycle}', [\App\Http\Controllers\SubscriptionController::class, 'callback'])->name('plans.callback');
    Route::get('/perfil', [\App\Http\Controllers\ProfileController::class, 'index'])
    ->name('profile.index');
    Route::put('/perfil/senha', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])
    ->name('profile.password');
    Route::get('/api/cupons/check', [\App\Http\Controllers\CouponController::class, 'check'])->middleware('auth')->name('api.coupons.check');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['web', 'auth', 'verified', EnsureUserIsTenant::class])->group(function () {
    Route::get('/meu-imovel', [TenantController::class, 'dashboard'])->name('tenants.dashboard');
    Route::post('/meu-imovel/chamados', [TenantController::class, 'storeTicket'])->name('tenant.tickets.store');
    Route::get('/tenant/contracts/{contract}', [App\Http\Controllers\TenantContractController::class, 'show'])->name('tenant.contracts.show');
    Route::post('/tenant/contracts/{contract}/sign', [App\Http\Controllers\TenantContractController::class, 'sign'])->name('tenant.contracts.sign');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::put('/admin/users/{user}/plan', [\App\Http\Controllers\AdminController::class, 'updateUserPlan'])->name('admin.users.plan');
    Route::get('/admin/cupons', [\App\Http\Controllers\CouponController::class, 'index'])->name('admin.coupons.index');
    Route::post('/admin/cupons', [\App\Http\Controllers\CouponController::class, 'store'])->name('admin.coupons.store');
    Route::delete('/admin/cupons/{coupon}', [\App\Http\Controllers\CouponController::class, 'destroy'])->name('admin.coupons.destroy');
});

require __DIR__.'/auth.php';
