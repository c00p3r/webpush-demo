<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'vapidPublicKey' => config('webpush.vapid.public_key'),
        ]) !!};
    </script>
</head>

<body class="bg-gray-100 h-screen antialiased leading-none font-sans">

<div class="container mx-auto py-10">
    {{ $slot }}
</div>

<div class="absolute bottom-0 right-0 bg-gray-200 p-2">
    <ul class="flex flex-row space-x-2">
        <li>
            <a href="https://laravel.com" class="no-underline hover:underline text-sm font-normal text-teal-800" title="Laravel">Laravel</a>
        </li>
        <li>
            <a href="https://laravel-livewire.com" class="no-underline hover:underline text-sm font-normal text-teal-800" title="Livewire">Livewire</a>
        </li>
        <li>
            <a href="https://tailwindcss.com" class="no-underline hover:underline text-sm font-normal text-teal-800" title="Tailwind">Tailwind</a>
        </li>
    </ul>
</div>

@livewireScripts
@stack('scripts')

</body>
</html>
