<?php

namespace App\Http\Livewire;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShopView extends Component
{
    /**
     * @var Shop
     */
    public $shop;

    /**
     * @var bool
     */
    public $isSubscribed = false;

    /**
     * @var bool
     */
    public $isBlocked = false;

    /**
     * @var string
     */
    public $error = 'Initializing';

    public function mount(Shop $shop): void
    {
        $this->shop = $shop;
    }

    public function render(): View
    {
        return view('livewire.shop.view');
    }

    public function updateSubscription(array $subscription)
    {
        // dd($subscription);
        DB::transaction(function () use ($subscription) {
            if (!$endpoint = Arr::get($subscription, 'endpoint')) {
                $this->error = 'Unable to subscribe.';

                return;
            }
            /** @var User $user */
            $user = Auth::user();

            $user->updatePushSubscription(
                $endpoint,
                Arr::get($subscription, 'publicKey'),
                Arr::get($subscription, 'authToken'),
                Arr::get($subscription, 'contentEncoding'),
            );

            $this->shop->users()->attach($user);

            $this->error = null;
            $this->isSubscribed = true;
        });
    }

    public function removeSubscription(array $subscription)
    {
        // dd($subscription);
        DB::transaction(function () use ($subscription) {
            if (!$endpoint = Arr::get($subscription, 'endpoint')) {
                $this->error = 'Unable to subscribe.';

                return;
            }
            /** @var User $user */
            $user = Auth::user();

            $user->deletePushSubscription($endpoint);
            $this->shop->users()->detach($user);

            $this->isSubscribed = false;
        });
    }
}
