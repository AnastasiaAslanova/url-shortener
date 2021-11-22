<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Enter url to convert:
                    <form action="{{ route('urlGenerator') }}">
                        <input name="long_url" type="text" style="height:42px;width:1180px;" placeholder="enter url"/>
                        @if($errors->has('long_url'))
                            {{$errors->first('long_url')}}
                        @endif
                        <x-button class="ml-4">
                            {{ ('ShortUrl') }}
                        </x-button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
