<?php

use App\Livewire\Menu\Customer;
use App\Livewire\Menu\Product;
use App\Livewire\Menu\ProductCategory;

Route::prefix('master-management')->name('master-management.')->group(function () {
    Route::get('/product-categories', ProductCategory::class)
        ->name('categories')
        ->middleware('permission:view product-category');

    Route::get('/products', Product::class)
        ->name('products')
        ->middleware('permission:view product');

    Route::get('/customers', Customer::class)
        ->name('customers')
        ->middleware('permission:view customer');
});
