<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    ProductController,
    SaleController,
    ClientController,
    SupplierController,
    ReportController,
    SettingsController,
    SocialMediaController,
    HomeController
};




// Rotas de Autenticação
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Rotas Protegidas
Route::middleware(['auth'])->group(function () {
    
    Route::get('/profile/show', [ProfileController::class, 'edit'])->name('profile');
    Route::get('/profile/sh', [ProfileController::class, 'edit'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Dashboard
    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    // Produtos
    Route::prefix('products')->middleware('permission:manage-products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/', [ProductController::class, 'store'])->name('products.store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::get('/{product}/inventory-history', [ProductController::class, 'inventoryHistory'])->name('products.inventory-history');
        Route::post('/{product}/adjust-inventory', [ProductController::class, 'adjustInventory'])->name('products.adjust-inventory');
    });
    
    // Vendas
    Route::prefix('sales')->middleware('permission:manage-sales')->group(function () {
        Route::get('/', [SaleController::class, 'index'])->name('sales.index');
        Route::get('/create', [SaleController::class, 'create'])->name('sales.create');
        Route::post('/', [SaleController::class, 'store'])->name('sales.store');
        Route::get('/{sale}', [SaleController::class, 'show'])->name('sales.show');
        Route::get('/{sale}/print', [SaleController::class, 'print'])->name('sales.print');
    });
    
    // Clientes
    Route::prefix('clients')->middleware('permission:manage-clients')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('clients.index');
        Route::get('/create', [ClientController::class, 'create'])->name('clients.create');
        Route::post('/', [ClientController::class, 'store'])->name('clients.store');
        Route::get('/{client}', [ClientController::class, 'show'])->name('clients.show');
        Route::get('/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
        Route::put('/{client}', [ClientController::class, 'update'])->name('clients.update');
        Route::delete('/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    });
    
    // Fornecedores
    Route::prefix('suppliers')->middleware('permission:manage-suppliers')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('suppliers.index');
        Route::get('/create', [SupplierController::class, 'create'])->name('suppliers.create');
        //Route::post('/', [SupplierController::class, 'store'])->name('suppliers.store');
        Route::post('/teste', [SupplierController::class, 'store'])->name('suppliers.store');

        Route::get('/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
        Route::get('/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
        Route::put('/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
        Route::delete('/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
    });
    
    // Relatórios
    Route::prefix('reports')->middleware('permission:view-reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('/products', [ReportController::class, 'products'])->name('reports.products');
        Route::get('/clients', [ReportController::class, 'clients'])->name('reports.clients');
    });
    
    // Configurações
    Route::prefix('settings')->middleware('permission:manage-settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/update-company', [SettingsController::class, 'updateCompany'])->name('settings.update-company');
        Route::get('/users', [SettingsController::class, 'users'])->name('settings.users');
        Route::post('/users/{user}/update-permissions', [SettingsController::class, 'updateUserPermissions'])->name('settings.update-user-permissions');
    });
    
    // Redes Sociais
    Route::prefix('social')->middleware('permission:manage-social')->group(function () {
        Route::get('/', [SocialMediaController::class, 'index'])->name('social.index');
        Route::get('/create', [SocialMediaController::class, 'create'])->name('social.create');
        Route::post('/', [SocialMediaController::class, 'store'])->name('social.store');
        Route::get('/{post}/edit', [SocialMediaController::class, 'edit'])->name('social.edit');
        Route::put('/{post}', [SocialMediaController::class, 'update'])->name('social.update');
        Route::delete('/{post}', [SocialMediaController::class, 'destroy'])->name('social.destroy');
    });
});


require __DIR__.'/auth.php';


