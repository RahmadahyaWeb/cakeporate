<?php

use App\Livewire\Menu\Product;
use App\Livewire\Menu\ProductCategory;

Route::prefix('master-management')->name('master-management.')->group(function () {
    Route::get('/product-categories', ProductCategory::class)
        ->name('categories')
        ->middleware('permission:view product-category');

    Route::get('/product', Product::class)
        ->name('product')
        ->middleware('permission:view product');
});
