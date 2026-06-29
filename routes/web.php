<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

// CONTROLLER ADMIN
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => redirect()->route('login'));

/*
|--------------------------------------------------------------------------
| FRONTEND (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/about', function () {
    return view('frontend.about');
})->name('frontend.about');

/*
|--------------------------------------------------------------------------
| AUTH USER (CUSTOMER)
|--------------------------------------------------------------------------
*/

// LOGIN PAGE
/*
|--------------------------------------------------------------------------
| AUTH USER (CUSTOMER)
|--------------------------------------------------------------------------
*/

// LOGIN PAGE
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// LOGIN PROCESS (FIXED FOR CUSTOM STAFF & USER NOTIFICATIONS)
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'login_as' => 'required|in:user,admin'
    ]);

    // === 1. ADMIN LOGIN (Dengan proteksi notifikasi khusus staff) ===
    if ($request->login_as == 'admin') {
        // Cek apakah email terdaftar di tabel Staff
        $staff = \App\Models\Staff::where('email', $request->email)->first();

        // JIKA EMAIL ADMIN/STAFF TIDAK TERDAFTAR DI DATABASE
        if (!$staff) {
            return back()->with([
                'error' => 'Anda bukan bagian staff kopikala.'
            ])->withInput($request->only('email', 'login_as'));
        }

        // JIKA EMAIL ADA, LANJUTKAN PROSESNYA KE AUTHCONTROLLER UNTUK CEK STATUS & PASSWORD
        return app(AuthController::class)->login($request);
    }

    // === 2. USER LOGIN ===
    if ($request->login_as == 'user') {
        // Cek apakah email user terdaftar di database
        $user = \App\Models\User::where('email', $request->email)->first();

        // JIKA USER TIDAK TERDAFTAR
        if (!$user) {
            return back()->with([
                'error' => 'Akun belum terdaftar.'
            ])->withInput($request->only('email', 'login_as'));
        }

        // JIKA USER TERDAFTAR, COBA COCOKKAN PASSWORD
        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('menu')->with('success', 'Login berhasil!');
        }

        // JIKA PASSWORD USER SALAH
        return back()->with([
            'error' => 'Email atau password salah.'
        ])->withInput($request->only('email', 'login_as'));
    }

    return back()->with('error', 'Pilihan login tidak valid.');
})->name('login.submit');

// GOOGLE LOGIN USER
Route::get('/auth/google/user', [AuthController::class, 'redirectToGoogleUser'])->name('google.login');
Route::get('/auth/google/user/callback', [AuthController::class, 'handleGoogleCallbackUser'])->name('google.callback');

// REGISTER USER
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6'
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return back()->with('success','Registrasi berhasil!');
})->name('register.submit');

// LOGOUT USER
Route::post('/logout-user', function () {
    Auth::guard('web')->logout();
    return redirect()->route('login');
})->name('logout.user');

/*
|--------------------------------------------------------------------------
| FRONTEND (USER LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web'])->group(function(){
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/menu', fn() => view('frontend.menu'))->name('menu');
    Route::get('/sobatkala', function () {
        return view('frontend.sobatkala');
    })->name('frontend.sobatkala');
    Route::get('/order', [TransactionController::class, 'createFrontend'])->name('frontend.order');
    Route::post('/orders', [TransactionController::class, 'storeFrontend'])->name('frontend.store');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/update-branch', [CartController::class, 'updateBranch'])->name('cart.branch');
    Route::post('/cart/update-qty', [CartController::class, 'updateQty'])->name('cart.qty');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');

    Route::get('/orders/{transaction}/confirmation', [TransactionController::class, 'confirmation'])->name('frontend.confirmation');
    Route::get('/orders/{order_id}/detail', [TransactionController::class, 'orderDetail'])->name('frontend.detail');

    Route::get('/payment', [PaymentController::class, 'index'])->name('payment.payment1');
    Route::get('/payment/data', [PaymentController::class, 'data'])->name('payment.data');
    Route::post('/payment/data/store', [PaymentController::class, 'storeData'])->name('payment.store.data');
    Route::get('/payment/method', [PaymentController::class, 'method'])->name('payment.method');
    Route::post('/payment-success', [PaymentController::class, 'success'])->name('payment.success');

    Route::get('/my-orders', [TransactionController::class, 'myOrders'])->name('orders.my');
    Route::get('/my-orders/{id}', [TransactionController::class, 'orderDetail'])->name('orders.order_detail');

    Route::get('/transactions/{order_id}/check-status', [TransactionController::class, 'checkStatus'])->name('transactions.checkStatus');
});

Route::get('/orders/{id}/receipt', [TransactionController::class, 'downloadReceipt'])->name('orders.receipt');

/*
|--------------------------------------------------------------------------
| BACKEND (ADMIN ONLY) - FULL RBAC SYSTEM (DATABASE MATCHED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:staff'])->group(function () {

    // ==========================================
    // 1. PUBLIC BACKEND / PROFILE
    // ==========================================
    Route::get('/admin/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
    Route::put('/admin/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');


    // ==========================================
    // 2. DASHBOARD ACCESS (DIPISAH PER PERMISSION)
    // ==========================================
    Route::middleware(['check.permission:Main Dashboard'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::middleware(['check.permission:Semeru Dashboard'])->group(function () {
        Route::get('/semeru/dashboard', [DashboardController::class, 'semeruDashboard'])->name('semeru.dashboard');
    });

    Route::middleware(['check.permission:Djuanda Dashboard'])->group(function () {
        Route::get('/djuanda/dashboard', [DashboardController::class, 'djuandaDashboard'])->name('djuanda.dashboard');
    });


    // ==========================================
    // 3. CATEGORIES & PRODUCTS MANAGEMENT
    // ==========================================
    Route::middleware(['check.permission:Products'])->group(function () {
        Route::resource('products', ProductController::class);
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });


    // ==========================================
    // 4. BRANCHES MANAGEMENT
    // ==========================================
    Route::middleware(['check.permission:Kopikala Branch'])->group(function () {
        Route::resource('branch', BranchController::class);
    });


    // ==========================================
    // 5. STOCKS MANAGEMENT (DIPISAH CABANG)
    // ==========================================
    // Stock Umum / Pusat
    Route::middleware(['check.permission:Stock'])->group(function () {
        Route::resource('stock', StockController::class)->except(['show']);
        Route::get('/stock/last-updated', [StockController::class, 'lastUpdated'])->name('stock.last-updated');
        Route::get('stock/{id}', [StockController::class, 'show'])->name('stock.show');
        Route::get('/branch/{branch}/stock', [StockController::class, 'branchStock'])->name('branch.stock');
    });

    // ================= FIX SEMERU STOCK (CRUD BRANCH) =================
    // Dimasukkan ke dalam proteksi middleware Semeru Staff agar aman
  // ================= FIX SEMERU STOCK (CRUD BRANCH) =================
    Route::middleware(['check.permission:Semeru Staff'])->group(function () {
        Route::prefix('semeru/stock')->group(function () {
            Route::get('/', [StockController::class, 'semeruIndex'])->name('semeru.stock');
            Route::get('/create', [StockController::class, 'semeruCreate'])->name('semeru.stock.create');
            Route::post('/store', [StockController::class, 'storeSemeru'])->name('semeru.stock.store');
            Route::get('/{id}', [StockController::class, 'semeruShow'])->name('semeru.stock.show');
            Route::get('/{id}/edit', [StockController::class, 'semeruEdit'])->name('semeru.stock.edit');
            Route::put('/{id}', [StockController::class, 'semeruUpdate'])->name('semeru.stock.update');
            Route::delete('/{id}', [StockController::class, 'semeruDestroy'])->name('semeru.stock.destroy');
        });
    });

    // ================= FIX DJUANDA STOCK (CRUD BRANCH) =================
    // TAMBAHKAN BLOK INI DI BAWAH SEMERU STOCK:
    Route::middleware(['check.permission:Djuanda Staff'])->group(function () {
        Route::prefix('djuanda/stock')->group(function () {
            
            // Rute Index Djuanda
            Route::get('/', [StockController::class, 'djuandaIndex'])
                ->name('djuanda.stock');

            // Rute CRUD Djuanda
            Route::get('/create', [StockController::class, 'djuandaCreate'])
                ->name('djuanda.stock.create');

            Route::post('/store', [StockController::class, 'storeDjuanda'])
                ->name('djuanda.stock.store');

            Route::get('/{id}', [StockController::class, 'djuandaShow'])
                ->name('djuanda.stock.show');

            Route::get('/{id}/edit', [StockController::class, 'djuandaEdit'])
                ->name('djuanda.stock.edit');

            Route::put('/{id}', [StockController::class, 'djuandaUpdate'])
                ->name('djuanda.stock.update');

            Route::delete('/{id}', [StockController::class, 'djuandaDestroy'])
                ->name('djuanda.stock.destroy');
        });
    });

    // ==========================================
    // 6. TRANSACTIONS MANAGEMENT (DIPISAH KASIR CABANG)
    // ==========================================
    Route::middleware(['check.permission:Main Transaction'])->group(function () {
        Route::resource('transactions', TransactionController::class);
        Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.detail');
        Route::post('/transactions/{order_id}/status', [TransactionController::class, 'updateStatus'])->name('transactions.updateStatus');
        Route::get('/transactions/export/excel', [TransactionController::class, 'exportExcel'])->name('transactions.export.excel');
        Route::get('/transactions/export/pdf', [TransactionController::class, 'exportPdf'])->name('transactions.export.pdf');
    });

    Route::middleware(['check.permission:Semeru Transaction'])->group(function () {
        Route::get('/semeru/transaction', [TransactionController::class, 'semeruTransactions'])->name('semeru.transaction');
    });

    Route::middleware(['check.permission:Djuanda Transaction'])->group(function () {
        Route::get('/djuanda/transaction', [TransactionController::class, 'djuandaTransactions'])->name('djuanda.transaction');
    });


    // ==========================================
    // 7. STAFF MANAGEMENT (DIPISAH PER OPERASIONAL)
    // ==========================================
    Route::middleware(['check.permission:Staff'])->group(function () {
        Route::resource('staff', StaffController::class);
    });

    Route::middleware(['check.permission:Semeru Staff'])->group(function () {
        Route::get('/semeru/staff', [StaffController::class, 'semeru'])->name('semeru.staff');
    });

    Route::middleware(['check.permission:Djuanda Staff'])->group(function () {
        Route::get('/djuanda/staff', [StaffController::class, 'djuanda'])->name('djuanda.staff');
    });


    // ==========================================
    // 8. ROLES MANAGEMENT (RBAC Settings)
    // ==========================================
    Route::middleware(['check.permission:Role'])->group(function () {
        Route::resource('roles', RoleController::class);
    });

});

/*
|--------------------------------------------------------------------------
| LOGOUT ADMIN
|--------------------------------------------------------------------------
*/
Route::post('/logout-admin', [AuthController::class, 'logout'])->name('logout.admin');

Route::post('/logout', function () {
    Auth::guard('staff')->logout();
    Auth::guard('web')->logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');