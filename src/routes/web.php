<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\ScreenController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ReservationController;
use App\Http\Controllers\User\MypageController;
use App\Models\Screen;
use Carbon\Carbon;

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

Route::get('/', function () {
    $start = Carbon::now()->startOfMonth();
    $end = Carbon::now()->addMonths(3)->endOfMonth();
    // 当月から3か月分のScreenを取得。日付の昇順で取得する。
    $screens = Screen::with(['movie'])->whereBetween('screening_date', [$start, $end])->orderBy('screening_date', 'asc')->get();

    return view('index')->with(['screens' => $screens,]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//---------------------------Admin Routes--------------------------------//
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');

Route::middleware('auth:admin')->group(function () {
  Route::get('/admin/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
  Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::middleware('auth:admin')->group(function () {
  Route::get('/admin/movies', [MovieController::class, 'index'])->name('admin.movies.index');
  Route::get('/admin/movies/show/{movie}', [MovieController::class, 'show'])->name('admin.movies.show');
  Route::get('/admin/movies/create', [MovieController::class, 'create'])->name('admin.movies.create');
  Route::post('/admin/movies/store', [MovieController::class, 'store'])->name('admin.movies.store');
  Route::get('/admin/movies/edit/{movie}', [MovieController::class, 'edit'])->name('admin.movies.edit');
  Route::patch('/admin/movies/update/{movie}', [MovieController::class, 'update'])->name('admin.movies.update');
  Route::delete('/admin/movies/destroy/{movie}', [MovieController::class, 'destroy'])->name('admin.movies.destroy');
});

Route::middleware('auth:admin')->group(function () {
  Route::get('/admin/screens', [ScreenController::class, 'index'])->name('admin.screens.index');
  Route::get('/admin/screens/create/{movie_id}', [ScreenController::class, 'create'])->name('admin.screens.create');
  Route::post('/admin/screens/store/{movie_id}', [ScreenController::class, 'store'])->name('admin.screens.store');
  Route::get('/admin/screens/show/{screen_id}', [ScreenController::class, 'show'])->name('admin.screens.show');
});

//---------------------------User Routes--------------------------------//
Route::middleware('auth')->group(function () {
  Route::get('/user', [UserController::class, 'index'])->name('user.index');
});

Route::middleware('auth')->group(function () {
  Route::get('/user/reserve/create/{screen_id}', [ReservationController::class, 'reserve_create'])->name('user.reserve.create');
  Route::post('/user/reserve/store', [ReservationController::class, 'reserve_store'])->name('user.reserve.store');
  Route::get('/user/reserve/fix', [ReservationController::class, 'reserve_fix'])->name('user.reserve.fix');
});

Route::middleware('auth')->group(function () {
  Route::get('/user/mypage', [MypageController::class, 'index'])->name('user.mypage.index');
  Route::post('/user/mypage/reserve_cancel', [MypageController::class, 'reserve_cancel'])->name('user.mypage.reserve_cancel');
});

require __DIR__.'/auth.php';
