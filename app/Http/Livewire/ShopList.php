<?php

namespace App\Http\Livewire;

use App\Models\Shop;
use Livewire\Component;

class ShopList extends Component
{
    public function render()
    {
        return view('livewire.shop.list', [
            'shops' => Shop::all(),
        ]);
    }
}
