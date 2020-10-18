<div>
    <h1 class="text-gray-600 text-center font-light tracking-wider text-4xl sm:mb-8 sm:text-6xl">
        Shop list page
    </h1>

    <ul class="flex justify-evenly">
        @foreach ($shops as $shop)
            <li class="flex-1 m-5  rounded-lg shadow-lg border-2 border-indigo-300 text-center hover:border-indigo-500 cursor-pointer">
                <a class="block p-10"
                    href="{{ route('shops.show', ['shop' => $shop->id]) }}">
                    <h3>
                        {{ $shop->name }}
                    </h3>
                </a>
            </li>
        @endforeach
    </ul>
</div>
