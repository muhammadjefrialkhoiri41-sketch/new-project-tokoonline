<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KeranjangController;


Route::get('/v1/auth/google/callback', [CustomerController::class, 'callback']);

Route::get('/', function () {
    return redirect('/v1');
});

Route::prefix('v1')->group(function () {

    
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::get('/redirect', [CustomerController::class, 'redirect'])->name('redirect');
        Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');
    });

   
    Route::controller(KategoriController::class)->group(function () {
        Route::get('/', 'beranda')->name('home');
        Route::get('/kategori/{id}', 'produk')->name('kategori.produk');
    });

    Route::controller(ProdukController::class)->group(function () {
        Route::get('/produk/beli/{id}', 'beli')->name('produk.beli');
    });

   
    Route::middleware('auth:customer')->group(function () {

        
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    
        Route::prefix('pesanan')->name('pesanan.')->controller(PesananController::class)->group(function () {
            Route::post('/store', 'store')->name('store');
            Route::get('/detail/{id}', 'detail')->name('detail');
            Route::post('/update/{id}', 'updatePesanan')->name('update');
            Route::get('/batal/{id}', 'batal')->name('batal');
        });

        Route::get('/cek-pesanan', [PesananController::class, 'cekPesanan'])->name('cek.pesanan');
        Route::get('/checkout', [KeranjangController::class, 'checkoutForm'])->name('checkout.form');
        Route::post('/checkout', [KeranjangController::class, 'checkout'])->name('checkout');
    });

     Route::prefix('keranjang')->name('keranjang.')->group(function () {
                Route::get('/', [KeranjangController::class, 'index'])->name('index');
                Route::get('/tambah/{id}', [KeranjangController::class, 'tambah'])->name('tambah');
                Route::get('/hapus/{id}', [KeranjangController::class, 'hapus'])->name('hapus');
            });

    
    Route::prefix('backend')->name('backend.')->group(function () {

        Route::controller(LoginController::class)->group(function () {
            Route::get('/login', 'loginBackend')->name('login');
            Route::post('/login', 'authenticateBackend')->name('login.post');
        });

        Route::middleware('auth')->group(function () {

            
            Route::get('/beranda', [BerandaController::class, 'berandaBackend'])->name('beranda');
            Route::post('/logout', [LoginController::class, 'logoutBackend'])->name('logout');

            
            Route::prefix('customer')->name('customer.')->group(function () {
                Route::get('/', [AdminCustomerController::class, 'index'])->name('index');
                Route::get('/blokir/{id}', [AdminCustomerController::class, 'blokir'])->name('blokir');
                Route::get('/aktifkan/{id}', [AdminCustomerController::class, 'aktifkan'])->name('aktifkan');
                Route::delete('/{id}', [AdminCustomerController::class, 'destroy'])->name('destroy');
            });

            
            Route::resources([
                'user' => UserController::class,
                'kategori' => KategoriController::class,
                'produk' => ProdukController::class,
                'pesanan' => PesananController::class,
            ]);

            
            Route::get('/pesanan/{id}/proses', [PesananController::class, 'proses'])
                ->name('pesanan.proses');

            Route::get('/pesanan/{id}/tolak', [PesananController::class, 'tolak'])
                ->name('pesanan.tolak');

          
            Route::prefix('foto-produk')
                ->name('foto_produk.')
                ->controller(ProdukController::class)
                ->group(function () {
                    Route::post('/store', 'storeFoto')->name('store');
                    Route::delete('/{id}', 'destroyFoto')->name('destroy');
                });
        });
    });
});