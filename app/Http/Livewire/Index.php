<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Cookie\CookieJar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class Index extends Component
{
    public $userId;

    public function render()
    {
        return view('livewire.index', [
            'users' => User::all(),
        ]);
    }

    public function listShops()
    {
        Auth::loginUsingId($this->userId);

        return redirect(route('shops.list'));
    }
}
