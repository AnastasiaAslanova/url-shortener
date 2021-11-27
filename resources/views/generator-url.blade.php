<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('URL shortener') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-2">Enter url to convert:</div>
                    <form method="POST" action="{{ route('urlGenerator') }}">
                        @csrf
                        <input name="type" value="{{ $type ?? 'simpleShort' }}" type="hidden" >
                        <input name="long_url" type="text" style="height:50px;width:800px;" placeholder="enter url" class="form-input px-4 py-3 mb-3 rounded-md"/>
                        @if($errors->has('long_url'))
                            {{$errors->first('long_url')}}
                        @endif
                        <p>
                            <input type="date" id="date" name="date" class="form-input px-4 py-3 mb-3 rounded-md"/>
                        </p>
                        <x-button>&nbsp
                            {{ ('ShortUrl') }}
                        </x-button>
                    </form>
                    <br/>
            </div>
        </div>
    </div>
</x-app-layout>
