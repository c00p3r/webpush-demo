<div>
    <h3 class="text-2xl font-medium leading-10 mb-4">Choose a shop</h3>

    <div class="mb-4">
        <select
            class="bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
            name="shopId"
            wire:model="shopId">

            <option value="null" disabled selected>Select shop</option>

            @foreach ($shops as $shop)
                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
            @endforeach
        </select>
    </div>

    @if ($shopId)
        @if($users->isEmpty())
            <div class="flex">
                <div class="flex-initial bg-orange-400 text-white font-bold px-4 py-3" role="alert">
                    <p>No users subscribed for this shop</p>
                </div>
            </div>
        @else
            <h3 class="text-2xl font-medium leading-10 mb-4">Now choose who you want to send notification to</h3>

            <div class="mb-4">
                <select
                    class="bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                    name="userId"
                    wire:model="userId">

                    <option value="null" disabled selected>Select user</option>

                    @if(count($users) > 1)
                        <option value="all">All users</option>
                    @endif

                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->email }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button
                    class="bg-indigo-500 hover:bg-indigo-400 focus:outline-none text-white font-bold text-xl px-4 py-2 rounded-lg shadow"
                    wire:click="sendNotification"
                >Send</button>
            </div>
        @endif
    @endif
</div>
