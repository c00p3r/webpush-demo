<?php

namespace App\Http\Livewire;

use App\Models\Shop;
use App\Models\User;
use App\Notifications\ShopGoodsUpdate;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class AdminPanel extends Component
{
    /**
     * @var int
     */
    public $shopId;

    /**
     * @var User[]|Collection
     */
    public $users;

    /**
     * @var int
     */
    public $userId;

    /**
     * @var Shop[]|Collection
     */
    public $shops;

    public function render()
    {
        $this->shops = Shop::all();
        return view('livewire.admin-panel');
    }

    public function updatedShopId($shopId): void
    {
        $this->users = Shop::query()->find($shopId)->users;
    }

    public function getShopProperty()
    {
        return $this->shops->find($this->shopId);
    }

    public function getUserProperty()
    {
        return $this->users->find($this->userId);
    }

    public function sendNotification()
    {
        if ($this->userId === 'all') {
            $this->users->each(function ($user) {
                $user->notify(new ShopGoodsUpdate($this->shop));
            });
        } else {
            $this->user->notify(new ShopGoodsUpdate($this->shop));
        }
    }
}
