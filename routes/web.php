<?php

use App\Http\Livewire\AdminPanel;
use App\Http\Livewire\Index;
use App\Http\Livewire\ShopList;
use App\Http\Livewire\ShopView;
use Illuminate\Support\Facades\Route;

Route::get('/', Index::class)
    ->name('index');

Route::get('/admin', AdminPanel::class)
    ->name('admin_panel');

Route::group([
    'as' => 'shops.',
    'prefix' => 'shops',
    'middleware' => 'auth',
], function () {
    Route::get('/', ShopList::class)
        ->name('list');

    Route::get('/{shop}', ShopView::class)
        ->name('show');
});

