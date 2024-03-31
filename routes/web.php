<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ClientHomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Routing\RouteRegistrar;

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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::post('them-san-pham', [ClientHomeController::class, 'add_ajax'])->name('cart.add.ajax');

Route::get('trang/gioi-thieu', [PageController::class, 'introduce']);
Route::get('trang/lien-he', [PageController::class, 'contact'])->name('contact');


Route::get('bai-viet', [PostController::class, 'post']);
Route::get('bai-viet/{slug}/{id}.html', [PostController::class, 'detail'])->name('post.detail');
// Route::get('page', [PageController::class, 'page']);

Route::post('cart/add/{id}', [CartController::class, 'add'])->name('cart.add'); // 2 đường dẫn giống nhau, post để thêm sản phẩm vào Cart khi tuỳ chỉnh qty
Route::get('cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('them-san-pham', [CartController::class, 'add_ajax'])->name('cart.add.ajax');
Route::get('gio-hang.html', [CartController::class, 'show'])->name('cart.show');
Route::get('cart/delete/{rowId}', [CartController::class, 'delete'])->name('cart.delete');
Route::get('cart/destroy', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

Route::get('thanh-toan-hang', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('thanh-toan-hang-{id}', [CheckoutController::class, 'checkout_fast'])->name('checkout_fast');
Route::post('in/district', [CheckoutController::class, 'handle_ajax_district'])->name('handle_ajax_district');
Route::post('in/wards', [CheckoutController::class, 'handle_ajax_wards'])->name('handle_ajax_wards');

// Route::get('thanh', [CheckoutController::class, 'handle_ajax'])->name('handle_ajax');
Route::get('dat-hang-thanh-cong.html', [CheckoutController::class, 'success'])->name('order.success');
Route::post('/confirm_checkout', [CheckoutController::class, 'confirm_checkout'])->name('confirm_checkout');



Route::get('/', [ClientHomeController::class, 'home'])->name('client.home');
Route::post('dm-san-pham/{slug}/{cat_id}', [ProductController::class, 'product_cat'])->name('product.cat');
Route::get('dm-san-pham/{slug}/{cat_id}', [ProductController::class, 'product_cat'])->name('product.cat');
Route::get('san-pham', [ProductController::class, 'show'])->name('product.show');      // khi show thường
Route::post('san-pham', [ProductController::class, 'show'])->name('product.show.seach'); // Khi có keyword seach product
Route::get('seach-dm', [ProductController::class, 'show']); // Tìm kiếm theo danh mục 
Route::post('seach-dm', [ProductController::class, 'show']);
Route::get('san-pham/{slug}/{id}.html', [ProductController::class, 'detail'])->name('product.detail');
Route::post('show-san-pham-seach', [ProductController::class, 'seach_product_ajax'])->name('seach.product.ajax');
// Route::get('show-san-pham-seach', [ProductController::class, 'seach_product_ajax'])->name('seach.product.ajax');





// ======== ADMIN ============================================
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show']);
    Route::get('/admin', [DashboardController::class, 'show']);

    Route::get('/admin/user/list', [AdminUserController::class, 'list'])->can('user.view');
    Route::get('/admin/user/add', [AdminUserController::class, 'add'])->can('user.add');
    Route::post('/admin/user/store', [AdminUserController::class, 'store'])->can('user.add');
    Route::get('/admin/user/delete/{id}', [AdminUserController::class, 'delete'])->name('delete_user')->can('user.delete');
    Route::get('/admin/user/action', [AdminUserController::class, 'action'])->can('user.delete');
    Route::get('/admin/user/edit/{user}', [AdminUserController::class, 'edit'])->name('user.edit')->can('user.edit');
    Route::post('/admin/user/update/{user}', [AdminUserController::class, 'update'])->name('user.update')->can('user.edit');

    // === Module Page ===//
    Route::get('/admin/page/list', [AdminPageController::class, 'list'])->can('page.view');
    Route::get('/admin/page/add', [AdminPageController::class, 'add'])->can('page.add');
    Route::post('/admin/page/store', [AdminPageController::class, 'store'])->name('page.store')->can('page.add');
    Route::get('/admin/page/edit/{id}', [AdminPageController::class, 'edit'])->name('page.edit')->can('page.edit');
    Route::post('/admin/page/update/{id}', [AdminPageController::class, 'update'])->name('page.update')->can('page.edit');
    Route::get('/admin/page/delete/{id}', [AdminPageController::class, 'delete'])->name('page.delete')->can('page.delete');
    Route::post('/admin/page/active', [AdminPageController::class, 'active'])->name('active')->can('page.delete');

    // === Module Post ====
    # Cat Post
    Route::get('/admin/post/cat/list', [AdminPostController::class, 'list_cat'])->can('post.view');
    Route::post('/admin/post/cat/add', [AdminPostController::class, 'add_cat'])->name('post.cat.add')->can('post.add');
    Route::get('/admin/post/cat/edit/{id}', [AdminPostController::class, 'edit_cat'])->name('post.cat.edit')->can('post.edit');
    Route::post('/admin/post/cat/update/{id}', [AdminPostController::class, 'update_cat'])->name('post.cat.update')->can('post.edit');
    Route::get('/admin/post/cat/delete/{id}', [AdminPostController::class, 'delete_cat'])->name('post.cat.delete')->can('post.delete');
    # Post
    Route::get('/admin/post/list', [AdminPostController::class, 'list'])->can('post.view');
    Route::get('/admin/post/edit/{id}', [AdminPostController::class, 'edit'])->name('post.edit')->can('post.edit');
    Route::post('/admin/post/update/{id}', [AdminPostController::class, 'update'])->name('post.update')->can('post.edit');
    Route::get('/admin/post/add', [AdminPostController::class, 'add'])->name('post.add')->can('product.add');
    Route::post('/admin/post/store', [AdminPostController::class, 'store'])->name('post.store')->can('post.add');
    Route::get('/admin/post/delete/{id}', [AdminPostController::class, 'delete'])->name('post.delete')->can('post.delete');
    Route::post('/admin/post/action', [AdminPostController::class, 'action'])->name('post.action')->can('post.delete');
    // ==== Module Product =====
    # Cat Product
    Route::get('admin/product/cat/list', [AdminProductController::class, 'cat_list'])->can('product.view');
    Route::get('admin/product/cat/add', [AdminProductController::class, 'cat_list'])->can('product.add');
    Route::post('admin/product/cat/store', [AdminProductController::class, 'cat_store'])->name('cat_product.store')->can('product.add');
    Route::get('admin/product/cat/edit/{id}', [AdminProductController::class, 'cat_edit'])->name('product.cat.edit')->can('product.edit');
    Route::post('admin/product/cat/update/{id}', [AdminProductController::class, 'cat_update'])->name('product.cat.update')->can('product.edit');
    Route::get('admin/product/cat/delete/{id}', [AdminProductController::class, 'cat_delete'])->name('product.cat.delete')->can('product.delete');
    # Product
    Route::get('admin/product/list', [AdminProductController::class, 'list'])->can('product.view');
    Route::get('admin/product/add', [AdminProductController::class, 'add'])->name('product.add')->can('product.add');
    Route::post('admin/product/store', [AdminProductController::class, 'store'])->name('product.store')->can('product.add');
    Route::get('admin/product/delete/{id}', [AdminProductController::class, 'delete'])->name('product.delete')->can('product.delete');
    Route::get('admin/product/edit/{id}', [AdminProductController::class, 'edit'])->name('product.edit')->can('product.edit');
    Route::post('admin/product/update/{id}', [AdminProductController::class, 'update'])->name('product.update')->can('product.edit');
    // Route::get('admin/test', [AdminProductController::class, 'test']);
    Route::post('admin/product/action', [AdminProductController::class, 'action'])->name('product.action')->can('product.delete');

    // ==== Module Order ====== 
    Route::post('admin/order/update-status', [AdminOrderController::class, 'update_status_order'])->name('update.status.order')->can('order.view');
    Route::get('admin/order/list', [AdminOrderController::class, 'list'])->can('order.view');
    Route::get('admin/order/edit/{id}', [AdminOrderController::class, 'edit'])->name('order.edit')->can('order.edit');
    Route::post('admin/order/update/{id}', [AdminOrderController::class, 'update'])->name('order.update')->can('order.edit');
    Route::get('admin/order/detail/{id}', [AdminOrderController::class, 'detail'])->name('order.detail')->can('order.view');
    Route::get('admin/order/delete/{id}', [AdminOrderController::class, 'delete'])->name('order.delete')->can('order.delete');
    Route::post('admin/order/action', [AdminOrderController::class, 'action'])->name('order.action')->can('order.delete');

    
    // ==== Module Permission ===========
    Route::get('admin/permission/add', [PermissionController::class, 'add'])->name('permission.add');//->can('permission.add');
    Route::post('admin/permission/store', [PermissionController::class, 'store'])->name('permission.store');//->can('permission.add');
    Route::get('admin/permission/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit')->can('permission.edit');
    Route::post('admin/permission/update/{id}', [PermissionController::class, 'update'])->name('permission.update')->can('permission.edit');
    Route::get('admin/permission/delete/{id}', [PermissionController::class, 'delete'])->name('permission.delete')->can('permission.delete');
    // ====== Role ==========
    Route::get('admin/role/list', [RoleController::class, 'list'])->name('role.list')->can('role.view');
    Route::get('admin/role/add', [RoleController::class, 'add'])->name('role.add')->can('role.add');
    Route::post('admin/role/store', [RoleController::class, 'store'])->name('role.store')->can('role.add');
    Route::get('admin/role/edit/{role}', [RoleController::class, 'edit'])->name('role.edit')->can('role.edit');
    Route::post('admin/role/update/{role}', [RoleController::class, 'update'])->name('role.update')->can('role.edit');
    Route::get('admin/role/delete/{role}', [RoleController::class, 'delete'])->name('role.delete')->can('role.delete');



    
    # Tích hợp quản lý file
    Route::group(['prefix' => 'laravel-filemanager'], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

});


