<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your new url is ready') }}
        </h2>
    </x-slot>
<div>
Your long url: {{ $longUrl }}
</div>
    <div>
        Your short url:
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route ('short',['short' => $shortUrl]) }}">
            {{ route ('short',['short' => $shortUrl]) }}
        </a>
    </div>

</x-app-layout>
