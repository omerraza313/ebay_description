<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Artisan;
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


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('checkUser');

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    // Redirect to the login page
    return Redirect::to('/login');
});

// Route::get('login_page', [FormController::class, 'login_page'])->name('login_page');

Route::group(['middleware' => ['auth']], function(){

    Route::get('/list', [FormController::class, 'index'])->name('index.list');
    Route::get('/form', [FormController::class, 'showForm'])->name('show.form');
    Route::post('/process-form', [FormController::class, 'processForm'])->name('process.form');
    Route::get('/view-html/{id}', [FormController::class, 'viewHtml'])->name('view.html');
    
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dash');
    
    Route::get('/admin/attributes', [AttributeController::class, 'attributes'])->name('admin.attributes');
    Route::get('/admin/attributes/add', [AttributeController::class, 'addAttribute'])->name('admin.attribute.add');
    Route::post('/admin/attributes/add', [AttributeController::class, 'createAttribute'])->name('admin.attribute.create');
    Route::get('/admin/attributes/{attribute}/edit', [AttributeController::class, 'editAttribute'])->name('admin.attribute.edit');
    Route::put('/admin/attributes/{attribute}/update', [AttributeController::class, 'updateAttribute'])->name('admin.attribute.update');
    Route::delete('/admin/attributes/{attribute}', [AttributeController::class, 'destroy'])->name('admin.attribute.destroy');
    
    Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('/admin/category/add', [CategoryController::class, 'addCategory'])->name('admin.category.add');
    Route::post('/admin/category/add', [CategoryController::class, 'createCategory'])->name('admin.category.create');
    Route::get('/admin/category/{id}/edit', [CategoryController::class, 'editCategory'])->name('admin.category.edit');
    Route::put('/admin/categories/{category}', [CategoryController::class, 'updateCategory'])->name('admin.category.update');
    Route::delete('/admin/category/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    
    Route::get('/autocomplete/categories', [CategoryController::class, 'autocomplete'])->name('category.autocomplete');
    
    Route::get('admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('admin/users/add', [AdminController::class, 'addUser'])->name('admin.users.add');
    Route::post('admin/users/add', [AdminController::class, 'storeUser'])->name('admin.users.add');
    Route::get('admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.delete');
    
    Route::get('/admin/product', [ProductController::class, 'index'])->name('admin.product');
    Route::get('/admin/product/add', [ProductController::class, 'addProduct'])->name('admin.product.add');
    Route::post('/admin/product/add', [ProductController::class, 'createProduct'])->name('admin.product.create');
    Route::get('/admin/product/{id}/edit', [ProductController::class, 'editProduct'])->name('admin.product.edit');
    Route::put('admin/product/{product}', [ProductController::class, 'updateProduct'])->name('admin.product.update');
    Route::get('/admin/product/delete/gallery-image/{image}', [ProductController::class, 'deleteGalleryImage']);
    // Route::post('/admin/product/delete/gallery-image/{imageId}', [ProductController::class, 'deleteGalleryImage'])->name('admin.product.delete.gallery-image');
    // Route::get('/admin/product/copy-layout/{id}', [ProductController::class, 'copyLayout'])->name('admin.product.copyLayout');
    Route::delete('/admin/product/{id}', [ProductController::class, 'destroy'])->name('admin.product.destroy');

    Route::get('admin/product/preview/{id}', [ProductController::class, 'productPreview'])->name('admin.product.preview');

    Route::delete('/admin/product/delete-attribute/{attributeId}', [ProductController::class, 'deleteAttribute'])->name('admin.delete.attribute');

});

Route::get('/clear_cache', function () {
    Artisan::call('optimize:clear');
    dd('Cache cleared');
});
// Route::get('/storage_link', function () {
//     Artisan::call('storage:link');
//     dd('Storage Linked');
// });
// Route::get('/form', function(){
//     return view('front.form');
// });

// Route::get('/product-layout', function(){
//     return view('front.product_layout');
// });

