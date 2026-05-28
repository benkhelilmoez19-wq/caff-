<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReservationController;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ici se trouvent toutes les routes de votre application "Caffée Rajel Kbir".
| Elles sont chargées par le RouteServiceProvider.
|
*/

// ==========================================
// 1. VITRINE PUBLIQUE
// ==========================================

Route::get('/', function () { 
    $categories = Category::with('products')->get();
    return view('index', compact('categories')); 
})->name('home');

Route::get('/index', function () { 
    $categories = Category::with('products')->get();
    return view('index', compact('categories')); 
});

// Vue publique détail produit (vitrine client, sans auth)
Route::get('/products/{id}', [ProductController::class, 'showPublic'])->name('products.show.public');

// ==========================================
// 2. RÉSERVATIONS CLIENT
// ==========================================
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

// Routes pour les clients connectés (voir leurs réservations)
Route::middleware(['auth'])->group(function () {
    Route::get('/mes-reservations', [ReservationController::class, 'myReservations'])->name('reservations.my');
    Route::patch('/mes-reservations/{id}/annuler', [ReservationController::class, 'cancelByClient'])->name('reservations.cancel');
});

// ==========================================
// 3. AUTHENTIFICATION
// ==========================================

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==========================================
// 4. ESPACE ADMINISTRATION (PROTÉGÉ)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // Tableau de bord
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // ------------------------------------------
    // A. CRUD PRODUITS
    // ------------------------------------------
    Route::resource('admin/products', ProductController::class)->names([
        'index'   => 'products.index',
        'create'  => 'products.create',
        'store'   => 'products.store',
        'show'    => 'products.show',
        'edit'    => 'products.edit',
        'update'  => 'products.update',
        'destroy' => 'products.destroy',
    ]);

    // ------------------------------------------
    // B. CRUD UTILISATEURS
    // ------------------------------------------
    Route::get('/admin/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/admin/users/create', [AdminController::class, 'create'])->name('users.create');
    Route::post('/admin/users', [AdminController::class, 'store'])->name('users.store');
    Route::get('/admin/users/{id}', [AdminController::class, 'show'])->name('users.show');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');

    // ------------------------------------------
    // C. GESTION DES CATÉGORIES
    // ------------------------------------------
    Route::resource('admin/categories', CategoryController::class)->names([
        'index'   => 'categories.index',
        'store'   => 'categories.store',
        'update'  => 'categories.update',
        'destroy' => 'categories.destroy',
    ]);

    // ------------------------------------------
    // D. RÉSERVATIONS DE TABLES (ADMIN)
    // ------------------------------------------
    Route::get('/admin/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/admin/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::patch('/admin/reservations/{id}/status', [ReservationController::class, 'updateStatus'])->name('reservations.updateStatus');
    Route::delete('/admin/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    // ------------------------------------------
    // E. GESTION DES TABLES (RESTAURANT)
    // ------------------------------------------
    Route::get('/admin/tables', [ReservationController::class, 'manageTables'])->name('tables.index');
    Route::post('/admin/tables', [ReservationController::class, 'storeTable'])->name('tables.store');
    Route::put('/admin/tables/{id}', [ReservationController::class, 'updateTable'])->name('tables.update');
    Route::delete('/admin/tables/{id}', [ReservationController::class, 'destroyTable'])->name('tables.destroy');
});

// ==========================================
// 5. ROUTES DE TEST ET DEBUG (OPTIONNEL)
// ==========================================
if (app()->environment('local')) {
    Route::get('/debug/tables', function () {
        $tables = \App\Models\ReservationData::all();
        return response()->json($tables);
    });
    
    Route::get('/debug/reservations', function () {
        $reservations = \App\Models\Table::with(['user', 'tableData'])->get();
        return response()->json($reservations);
    });
}