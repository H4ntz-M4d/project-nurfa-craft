<?php 
use App\Http\Controllers\Admin\InvoiceOrderController;
use App\Http\Controllers\Admin\PengeluaranController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\ProdukDiLihatController;
?><?php

use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\KategoriProdukController;
use App\Http\Controllers\Admin\PostinganBlogController;
use App\Http\Controllers\Admin\PostTentangKamiController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\StokController;
use App\Http\Controllers\Admin\StokRecordController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\VariantProduk;
use App\Http\Controllers\Customers\AboutController;
use App\Http\Controllers\Customers\BlogController;
use App\Http\Controllers\Customers\ContactController;
use App\Http\Controllers\Customers\HomeController;
use App\Http\Controllers\Customers\KeranjangController;
use App\Http\Controllers\Customers\ProdukCustomerController;
use App\Http\Controllers\Customers\ProdukDetailController;
use App\Http\Controllers\Customers\TransaksiController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleUsers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TransaksiRecordController;
use App\Http\Controllers\Customers\ChatbotController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\Admin\ReportOmsetController;

Route::get('/dashboard', [Dashboard::class, 'index'])
->middleware(['auth', 'verified', RoleUsers::class.':admin'])->name('dashboard');

Route::middleware(['auth', 'verified', RoleUsers::class.':admin'])->group(function () {

    // begin widget card dashboard
    Route::get('/chart/daily-sales', [Dashboard::class, 'getDailySales']);
    Route::get('/dashboard/daily-income', [Dashboard::class, 'getDailyIncome']);
    Route::get('/chart/month-sales', [Dashboard::class, 'getMonthSales']);
    Route::get('/dashboard/order-total', [Dashboard::class, 'getMonthOrderTotal']);
    Route::get('/dashboard/total-customers', [Dashboard::class, 'getTotalCustomers']);
    Route::get('/dashboard/produk-stat', [Dashboard::class, 'getProdukStat']);
    Route::get('/dashboard/pesanan', [Dashboard::class, 'getPesanan']);


    // Route::get('/profile', [ProfileController::class, 'view'])->name('profile.edit');
    // Route::get('/profile/{slug}', [ProfileController::class, 'edit'])->name('profile.update');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Begin Route user
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users-data', [UsersController::class, 'data'])->name('user.data'); // json data user
    Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
    Route::delete('/users-delete-selected', [UsersController::class, 'destroySelected'])->name('users.destroySelected');
    // end Route user

    // Begin Route Karyawan
    Route::get('/list-karyawan', [KaryawanController::class, 'index'])->name('karyawan.list');
    Route::get('/karyawan-data', [KaryawanController::class, 'data'])->name('karyawan.data'); // json data karyawan
    
    Route::get('/karyawan-view/{slug}', [KaryawanController::class, 'view'])->name('karyawan.view');
    Route::get('/karyawan-settings/{slug}', [KaryawanController::class, 'edit'])->name('karyawan.edit');
    Route::post('/karyawan/store', [KaryawanController::class, 'store'])->name('karyawan.store');
    
    Route::post('/update-karyawan/{slug}', [KaryawanController::class, 'update'])->name('karyawan.update');

    Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
    Route::delete('/karyawan-delete-selected', [KaryawanController::class, 'destroySelected'])->name('karyawan.destroySelected');
    // End Route Karyawan

    // begin route customers
    Route::get('/list-customers', [CustomersController::class, 'index'])->name('customers.index');
    Route::get('/customers-data', [CustomersController::class, 'data'])->name('customers.data'); // json data karyawan
    Route::get('/orders-view/{slug}', [CustomersController::class, 'dataOrders'])->name('customers-orders.data'); // json data karyawan
    Route::get('/customers-view/{slug}', [CustomersController::class, 'view'])->name('customers.view'); // json data karyawan
    Route::post('/customers/store', [CustomersController::class, 'store'])->name('customers.store');
    Route::delete('/customers/{id}', [CustomersController::class, 'destroy'])->name('customers.destroy');
    Route::delete('/customers-delete-selected', [CustomersController::class, 'destroySelected'])->name('customers.destroySelected');
    // end route customers

    // begin route kategori
    Route::get('/list-kategori', [KategoriProdukController::class, 'index'])->name('kategori.index');
    Route::get('/kategori-data', [KategoriProdukController::class, 'data'])->name('kategori.data'); // json data kategori
    Route::get('/kategori-add', [KategoriProdukController::class, 'create'])->name('kategori.add-data');
    Route::get('/kategori-edit/{slug}', [KategoriProdukController::class, 'edit'])->name('kategori.edit-data');
    Route::post('/kategori-update/{slug}', [KategoriProdukController::class, 'update'])->name('kategori.update');
    Route::post('/kategori-store', [KategoriProdukController::class, 'store'])->name('kategori.store');
    Route::delete('/kategori/{slug}', [KategoriProdukController::class, 'destroy'])->name('kategori.destroy');
    Route::delete('/kategori-delete-selected', [KategoriProdukController::class, 'destroySelected'])->name('kategori.destroySelected');

    // begin route Produk
    Route::get('/list-produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk-data', [ProdukController::class, 'data'])->name('produk.data'); // json data produk

    Route::get('/produk-add', [ProdukController::class, 'create'])->name('produk.add-data');
    Route::post('/produk-store', [ProdukController::class, 'store'])->name('produk.store');
    
    Route::get('/produk-edit/{slug}', [ProdukController::class, 'edit'])->name('produk.edit-data');
    Route::post('/produk-update/{slug}', [ProdukController::class, 'update'])->name('produk.update');
    
    Route::get('/produk-variant/{slug}', [ProdukController::class, 'kelolaVariant'])->name('produk.variant.data');
    Route::post('/produk-variant/{slug}/variant/store', [ProdukController::class, 'storeVariant'])->name('produk.variant.store');

    Route::get('/produk/get-gambar/{slug}', [ProdukController::class, 'getGambar'])->name('produk.getGambar');
    Route::post('/produk/upload-gambar', [ProdukController::class, 'uploadGambar'])->name('produk.gambar');

    Route::delete('/produk/{slug}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    Route::delete('/produk-delete-selected', [ProdukController::class, 'destroySelected'])->name('produk.destroySelected');

    // begin route pesanan
    Route::get('/list-pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan-data', [PesananController::class, 'data'])->name('pesanan.data'); // json data pesanan
    Route::put('/pesanan-updateStatus', [PesananController::class, 'updateStatus'])->name('pesanan.update'); // json data pesanan

    // begin route Stocks
    Route::get('/list-stocks-produk', [StokController::class, 'index'])->name('stocks.index');
    Route::get('/stocks-produk-data', [StokController::class, 'data'])->name('stocks.produk.data'); // json data home banner
    Route::post('/stocks/store', [StokController::class, 'store'])->name('stocks.store');
    Route::delete('/stocks/{slug}', [StokController::class, 'destroy'])->name('stocks.destroy');
    Route::delete('/stocks-delete-selected', [StokController::class, 'destroySelected'])->name('stocks.destroySelected');

    // laporan stok
    Route::get('/list-stocks-record', [StokRecordController::class, 'index'])->name('stocks-record.index');
    Route::get('/stocks-data', [StokRecordController::class, 'data'])->name('stocks-record.data');
    
    // begin view-product
    Route::get('/list-view-product', [ProdukDiLihatController::class, 'index'])->name('view-product.index');
    Route::get('/view-product-data', [ProdukDiLihatController::class, 'data'])->name('view-product.data');

    // begin Transactions record
    Route::get('/list-transactions-record', [TransaksiRecordController::class, 'index'])->name('transaksi.index');
    Route::get('/transactions-data', [TransaksiRecordController::class, 'data'])->name('transaksi.data');
    Route::get('/invoice-users/{slug}/{order_id}', [InvoiceOrderController::class, 'invoiceOrderCustomers'])->name('transaksi.invoice');

    // begin route pengeluaran
    Route::get('/list-pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::get('/pengeluaran-data', [PengeluaranController::class, 'data'])->name('pengeluaran.data'); // json data pengeluaran
    Route::post('/pengeluaran-store', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
    Route::get('/detail-pengeluaran/{slug}', [PengeluaranController::class, 'getDetail'])->name('pengeluaran.detail');
    Route::put('/pengeluaran-update/{slug}', [PengeluaranController::class, 'update'])->name('pengeluaran.update');
    Route::delete('/pengeluaran/{slug}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.delete');
    Route::delete('/pengeluaran-delete-selected', [PengeluaranController::class, 'destroySelected'])->name('pengeluaran.destroySelected');

    
    // begin route report omset tahunan
    Route::get('/list-report-omset-tahunan', [ReportOmsetController::class, 'index'])->name('report-omzet.index');
    Route::get('/report-omset-tahunan/data', [ReportOmsetController::class, 'data'])->name('report-omzet.data');
    Route::get('/cetak-report-omzet/{tahun}', [ReportOmsetController::class, 'cetakReportOmzet'])->name('report-omzet.cetak');
    Route::get('/grafik-report-omzet/{tahun}', [ReportOmsetController::class, 'grafikTahunan'])->name('report.omzet.grafik');
    Route::get('/grafik-produk-terlaris/{tahun}', [ReportOmsetController::class, 'grafikProdukTerlaris'])->name('report.produk.grafik');


    // begin route home banner
    Route::get('/home-banner', [HomeBannerController::class, 'index'])->name('home-banner.index');
    Route::get('/home-banner-data', [HomeBannerController::class, 'data'])->name('home-banner.data'); // json data home banner
    Route::post('/home-banner/store', [HomeBannerController::class, 'store'])->name('home-banner.store');
    Route::put('/home-banner/{id}', [HomeBannerController::class, 'update'])->name('home-banner.update');
    Route::delete('/home-banner/{slug}', [HomeBannerController::class, 'destroy'])->name('home-banner.destroy');
    Route::delete('/home-banner-delete-selected', [HomeBannerController::class, 'destroySelected'])->name('home-banner.destroySelected');

    // begin route post blog
    Route::get('/blog-post', [PostinganBlogController::class, 'index'])->name('blog-post.index');
    Route::get('/blog-post-data', [PostinganBlogController::class, 'data'])->name('blog-post.data'); // json data post blog
    Route::get('/blog-post-create', [PostinganBlogController::class, 'create'])->name('blog-post.create');
    Route::get('/blog-post-edit/{slug}', [PostinganBlogController::class, 'edit'])->name('blog-post.edit');
    Route::post('/blog-post-add', [PostinganBlogController::class, 'store'])->name('blog-post.add');
    Route::post('/blog-post-update/{slug}', [PostinganBlogController::class, 'update'])->name('blog-post.edit');
    Route::delete('/blog-post/{slug}', [PostinganBlogController::class, 'destroy'])->name('home-banner.destroy');
    Route::delete('/blog-post-delete-selected', [PostinganBlogController::class, 'destroySelected'])->name('home-banner.destroySelected');

    // begin route variant
    Route::get('/list-variant', [VariantProduk::class, 'index'])->name('variant.index');
    Route::get('/variant-data', [VariantProduk::class, 'data'])->name('variant.data'); // json data home banner
    Route::post('/variant/store', [VariantProduk::class, 'store'])->name('variant.store');
    Route::delete('/variant/{slug}', [VariantProduk::class, 'destroy'])->name('variant.destroy');
    Route::delete('/variant-delete-selected', [VariantProduk::class, 'destroySelected'])->name('variant.destroySelected');

    // begin route Tentang Kami
    Route::get('/list-about', [PostTentangKamiController::class, 'index'])->name('about.index');
    Route::get('/about-data', [PostTentangKamiController::class, 'data'])->name('about.data'); // json data home banner
    Route::get('/about-create', [PostTentangKamiController::class, 'create'])->name('about.create');
    Route::get('/about-edit/{slug}', [PostTentangKamiController::class, 'edit'])->name('about.edit');
    Route::post('/about-update/{slug}', [PostTentangKamiController::class, 'update'])->name('about.update');
    Route::post('/about/store', [PostTentangKamiController::class, 'store'])->name('about.store');
    Route::delete('/about/{slug}', [PostTentangKamiController::class, 'destroy'])->name('about.destroy');
    Route::delete('/about-delete-selected', [PostTentangKamiController::class, 'destroySelected'])->name('about.destroySelected');

});

Route::middleware(['auth', 'verified', RoleUsers::class.':customers'])->group(function () {

    
    Route::get('/produk-shop-detail/{slug?}', [ProdukDetailController::class, 'index'])->name('produk-shop.detail');
    Route::post('/produk/check-variant', [ProdukDetailController::class, 'checkVariant'])->name('produk-shop.check-variant');

    Route::post('/keranjang-add', [ProdukDetailController::class, 'addToCart'])->name('produk-shop.cart-add');

    //shopping cart
    Route::get('/shopping/{slug?}', [KeranjangController::class, 'index'])->name('shopping');
    Route::delete('/delete-shopping-cart/{slug?}', [KeranjangController::class, 'deleteItem'])->name('shopping.delete');
    Route::post('/update-shopping-cart', [KeranjangController::class, 'updateCart'])->name('shopping.update');

    // begin transaksi
    Route::post('/checkout', [TransaksiController::class, 'storeTransaction'])->name('checkout');
    Route::put('/update-transaksi/{slug}', [TransaksiController::class, 'updateStatus'])->name('update-transaksi');
    Route::delete('/delete-keranjang/{slug}', [TransaksiController::class, 'deleteKeranjang'])->name('checkout.delete-keranjang');
    
    // begin history order
    Route::get('/history-order/{slug}', [TransaksiController::class, 'historyOrders'])->name('history.orders');
    Route::get('/invoice-order/{slug}/{invoice}', [TransaksiController::class, 'invoiceUser'])->name('invoice');

    // begin blog
    Route::get('/blog-detail/{slug}', [BlogController::class, 'detail'])->name('blog.detail');
    Route::post('/blog/store-comment', [BlogController::class, 'storeComment'])->name('blog.store-comment');

    Route::get('/get-provinsi', [KeranjangController::class, 'getProvinsi']);
    Route::get('/get-kabupaten/{id}', [KeranjangController::class, 'getKabupaten']);
    
});
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/', [HomeController::class, 'index'])->name('home');

//product detail
Route::get('/product', [ProdukCustomerController::class, 'index'])->name('product.index');

Route::get('/product/kategori/{id}', [ProdukCustomerController::class, 'sortByCategory'])->name('product.sort-by-category');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');

Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');

Route::post('/ask-ai', [ChatbotController::class, 'askAI'])->name('chatbot')->withoutMiddleware(VerifyCsrfToken::class);

require __DIR__.'/auth.php';
