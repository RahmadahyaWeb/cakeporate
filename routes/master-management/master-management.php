<?php

use App\Livewire\Menu\ProductCategory;

Route::prefix('master-management')->name('master-management.')->group(function () {
    Route::get('/product-categories', ProductCategory::class)
        ->name('product-categories')
        ->middleware('permission:view product-category');
});
