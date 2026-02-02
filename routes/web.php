<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsAdminController;
use App\Http\Controllers\WishlistController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// -------------------- FRONTEND --------------------
Route::get('/', [HomeController::class, 'index']);
Route::get('/trang-chu', [HomeController::class, 'index']);
Route::post('/tim-kiem', [HomeController::class, 'search']);
Route::post('/preferences', [HomeController::class, 'update_preferences']);
Route::get('/shop.html', [PageController::class, 'shop']);
Route::get('/contact-us.html', [PageController::class, 'contact']);
Route::get('/tin-tuc', [NewsController::class, 'index']);
Route::get('/tin-tuc/{news_slug}', [NewsController::class, 'show']);

// Danh mục sản phẩm trang chủ
Route::get('/danh-muc-san-pham/{slug_category_product}', [CategoryProduct::class, 'show_category_home']);
Route::get('/thuong-hieu-san-pham/{brand_slug}', [BrandProduct::class, 'show_brand_home']);
Route::get('/chi-tiet-san-pham/{product_slug}', [ProductController::class, 'details_product']);

// -------------------- BACKEND --------------------
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/dashboard', [AdminController::class, 'show_dashboard']);
Route::get('/logout', [AdminController::class, 'logout']);
Route::post('/admin-dashboard', [AdminController::class, 'dashboard']);

// -------------------- CATEGORY PRODUCT --------------------
Route::get('/add-category-product', [CategoryProduct::class, 'add_category_product']);
Route::get('/edit-category-product/{category_product_id}', [CategoryProduct::class, 'edit_category_product']);
Route::get('/delete-category-product/{category_product_id}', [CategoryProduct::class, 'delete_category_product']);
Route::get('/all-category-product', [CategoryProduct::class, 'all_category_product']);

Route::get('/unactive-category-product/{category_product_id}', [CategoryProduct::class, 'unactive_category_product']);
Route::get('/active-category-product/{category_product_id}', [CategoryProduct::class, 'active_category_product']);

Route::post('/save-category-product', [CategoryProduct::class, 'save_category_product']);
Route::post('/update-category-product/{category_product_id}', [CategoryProduct::class, 'update_category_product']);

// -------------------- BRAND PRODUCT --------------------
Route::get('/add-brand-product', [BrandProduct::class, 'add_brand_product']);
Route::get('/edit-brand-product/{brand_product_id}', [BrandProduct::class, 'edit_brand_product']);
Route::get('/delete-brand-product/{brand_product_id}', [BrandProduct::class, 'delete_brand_product']);
Route::get('/all-brand-product', [BrandProduct::class, 'all_brand_product']);

Route::get('/unactive-brand-product/{brand_product_id}', [BrandProduct::class, 'unactive_brand_product']);
Route::get('/active-brand-product/{brand_product_id}', [BrandProduct::class, 'active_brand_product']);

Route::post('/save-brand-product', [BrandProduct::class, 'save_brand_product']);
Route::post('/update-brand-product/{brand_product_id}', [BrandProduct::class, 'update_brand_product']);

// -------------------- PRODUCT --------------------
Route::get('/add-product', [ProductController::class, 'add_product']);
Route::get('/edit-product/{product_id}', [ProductController::class, 'edit_product']);
Route::get('/delete-product/{product_id}', [ProductController::class, 'delete_product']);
Route::get('/all-product', [ProductController::class, 'all_product']);

Route::get('/unactive-product/{product_id}', [ProductController::class, 'unactive_product']);
Route::get('/active-product/{product_id}', [ProductController::class, 'active_product']);

Route::post('/save-product', [ProductController::class, 'save_product']);
Route::post('/update-product/{product_id}', [ProductController::class, 'update_product']);
Route::post('/add-product-gallery/{product_id}', [ProductController::class, 'add_product_gallery']);
Route::get('/delete-product-gallery/{gallery_id}', [ProductController::class, 'delete_product_gallery']);

// -------------------- NEWS ADMIN --------------------
Route::get('/add-news', [NewsAdminController::class, 'add_news']);
Route::get('/all-news', [NewsAdminController::class, 'all_news']);
Route::get('/edit-news/{news_id}', [NewsAdminController::class, 'edit_news']);
Route::get('/delete-news/{news_id}', [NewsAdminController::class, 'delete_news']);
Route::get('/unactive-news/{news_id}', [NewsAdminController::class, 'unactive_news']);
Route::get('/active-news/{news_id}', [NewsAdminController::class, 'active_news']);
Route::post('/save-news', [NewsAdminController::class, 'save_news']);
Route::post('/update-news/{news_id}', [NewsAdminController::class, 'update_news']);

// -------------------- CART --------------------
Route::post('/update-cart-quantity', [CartController::class, 'update_cart_quantity']);
Route::post('/save-cart', [CartController::class, 'save_cart']);
Route::get('/show-cart', [CartController::class, 'show_cart']);
Route::get('/delete-to-cart/{rowId}', [CartController::class, 'delete_to_cart']);

// -------------------- WISHLIST --------------------
Route::get('/wishlist', [WishlistController::class, 'index']);
Route::post('/wishlist/add', [WishlistController::class, 'add']);
Route::get('/wishlist/remove/{product_id}', [WishlistController::class, 'remove']);

// -------------------- CHECKOUT --------------------
Route::get('/login-checkout', [CheckoutController::class, 'login_checkout']);
Route::get('/logout-checkout', [CheckoutController::class, 'logout_checkout']);
Route::post('/add-customer', [CheckoutController::class, 'add_customer']);
Route::post('/order-place', [CheckoutController::class, 'order_place']);
Route::post('/login-customer', [CheckoutController::class, 'login_customer']);
Route::get('/checkout', [CheckoutController::class, 'checkout']);
Route::get('/payment', [CheckoutController::class, 'payment']);
Route::post('/save-checkout-customer', [CheckoutController::class, 'save_checkout_customer']);

// -------------------- ORDER --------------------
Route::get('/manage-order', [CheckoutController::class, 'manage_order']);
Route::get('/view-order/{orderId}', [CheckoutController::class, 'view_order']);
Route::post('/update-order-status/{orderId}', [CheckoutController::class, 'update_order_status']);
Route::post('/update-payment-status/{orderId}', [CheckoutController::class, 'update_payment_status']);
Route::get('/delete-order/{orderId}', [CheckoutController::class, 'delete_order']);
