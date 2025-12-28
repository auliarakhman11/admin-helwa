<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\ClusterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UkuranController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::middleware('auth')->group(function(){
//     Route::get('/',[SosmedController::class,'admin'])->name('admin');
// Route::post('export-youtube',[SosmedController::class,'exportYoutube'])->name('exportYoutube');
// Route::post('export-instagram',[SosmedController::class,'exportInstagram'])->name('exportInstagram');

// Route::get('/logout',[AuthController::class,'logout'])->name('logout');
// });

Route::middleware('auth')->group(function () {

    //home
    // Route::get('/', [HomeController::class, 'index'])->name('home');
    //end home

    Route::middleware('hakakses:1')->group(function () {

        Route::get('bahan', [BahanController::class, 'index'])->name('bahan');
        Route::post('addBahan', [BahanController::class, 'addBahan'])->name('addBahan');
        Route::patch('editBahan', [BahanController::class, 'editBahan'])->name('editBahan');
        Route::patch('dropDataBahan', [BahanController::class, 'dropDataBahan'])->name('dropDataBahan');


        //produk
        Route::get('/products', [ProductsController::class, 'index'])->name('products');
        Route::post('/products', [ProductsController::class, 'addProduct'])->name('addProduct');
        Route::patch('/produk', [ProductsController::class, 'editProduk'])->name('editProduk');

        Route::post('/sort-produk', [ProductsController::class, 'sortProduk'])->name('sortProduk');

        Route::get('/delete-produk/{id}', [ProductsController::class, 'deleteProduk'])->name('deleteProduk');
        //end produk

        //ukuran
        Route::get('ukuran', [UkuranController::class, 'index'])->name('ukuran');
        Route::post('addUkuran', [UkuranController::class, 'addUkuran'])->name('addUkuran');
        Route::patch('editUkuran', [UkuranController::class, 'editUkuran'])->name('editUkuran');
        Route::get('deleteUkuran/{ukuran}', [UkuranController::class, 'deleteUkuran'])->name('deleteUkuran');
        //end ukuran

        //Cluster
        Route::get('cluster', [ClusterController::class, 'index'])->name('cluster');
        Route::post('addCluster', [ClusterController::class, 'addCluster'])->name('addCluster');
        Route::patch('editCluster', [ClusterController::class, 'editCluster'])->name('editCluster');
        Route::get('deleteCluster/{Cluster}', [ClusterController::class, 'deleteCluster'])->name('deleteCluster');
        //end Cluster

        //karyawan
        Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan');
        Route::post('/karyawan', [KaryawanController::class, 'addKaryawan'])->name('addKaryawan');
        Route::patch('/karyawan', [KaryawanController::class, 'editKaryawan'])->name('editKaryawan');
        Route::post('/delete-karyawan', [KaryawanController::class, 'dropKaryawan'])->name('dropKaryawan');
        Route::post('sort-karyawan', [KaryawanController::class, 'sortKaryawan'])->name('sortKaryawan');
        //end karyawan

        //user
        Route::get('user', [UserController::class, 'index'])->name('user');
        Route::post('addUser', [UserController::class, 'addUser'])->name('addUser');
        Route::patch('editUser', [UserController::class, 'editUser'])->name('editUser');
        Route::get('gantiPassword', [UserController::class, 'gantiPassword'])->name('gantiPassword');
        Route::post('editPassword', [UserController::class, 'editPassword'])->name('editPassword');
        //end user

        //penjualan
        Route::get('penjualan', [PenjualanController::class, 'index'])->name('penjualan');
        Route::post('refundInvoice', [PenjualanController::class, 'refundInvoice'])->name('refundInvoice');
        Route::post('kembalikanInvoice', [PenjualanController::class, 'kembalikanInvoice'])->name('kembalikanInvoice');
        Route::get('/', [PenjualanController::class, 'dashboard'])->name('dashboard');
        //end penjualan

        //member
        Route::get('member', [MemberController::class, 'index'])->name('member');
        Route::post('addMember', [MemberController::class, 'addMember'])->name('addMember');
        Route::patch('editMember', [MemberController::class, 'editMember'])->name('editMember');
        Route::post('dropMember', [MemberController::class, 'dropMember'])->name('dropMember');
        //end member

    });


    //block
    Route::get('forbidden-access', [AuthController::class, 'block'])->name('block');
    //endblock
    Route::get('ganti-password', [UserController::class, 'gantiPassword'])->name('gantiPassword');
    Route::post('edit-password', [UserController::class, 'editPassword'])->name('editPassword');



    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('non-active', [AuthController::class, 'nonActive'])->name('nonActive');
});




Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'login_page'])->name('loginPage');
    Route::post('login', [AuthController::class, 'login'])->name('login');
});
