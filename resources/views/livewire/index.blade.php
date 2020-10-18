<div>
    <div class="mx-auto text-center text-2xl font-medium leading-10">
        <h1 class="text-3xl font-bold">Hi there!</h1>
        <h3>If you're an <em class="text-green-500">admin</em>, please, follow this link:</h3>
        <h3>
            <a
                class="no-underline hover:underline text-blue-400"
                href="{{ route('admin_panel') }}"
            >Admin Panel</a>
        </h3>
        <h3>If you're a <em class="text-pink-500">user</em>, please, introduce yourself:</h3>
    </div>

    <div class="flex justify-center">
        <div class="mx-auto p-8">
            <label>
                <select
                    class="block w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                    name="userId"
                    wire:model="userId"
                    wire:change="listShops">

                    <option value="null" disabled selected>Select user</option>

                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->email }}</option>
                    @endforeach
                </select>
            </label>
        </div>
    </div>

</div>
