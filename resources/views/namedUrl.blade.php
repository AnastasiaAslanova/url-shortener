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
                    <form method="POST" action="{{ route('namedUrlGenerator') }}">
                        @csrf
                        <div class="flex flex-col">
                            <div class="mb-3">
                                <input name="long_url" type="text" style="height:50px;width:800px;" class="form-input px-4 py-3 rounded-md" placeholder="enter your link"/><br/>
                                @if($errors->has('long_url'))
                                    <span class="text-red-600">{{$errors->first('long_url')}}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <input name="name" type="text" style="height:50px;width:250px;" class="form-input px-4 py-3 rounded-md" placeholder="enter name for url"/><br/>
                                @if($errors->has('name'))
                                    <span class="text-red-600">{{$errors->first('name')}}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <input type="date" id="date" class="form-input px-4 py-3 rounded-md" name="date"/><br/>
                                <span class="text-gray-400 text-xs">Link expiration date</span>
                                @if($errors->has('date'))
                                    <br/>
                                    <span class="text-red-600">{{$errors->first('date')}}</span>
                                @endif
                            </div>
                            <div>
                                <x-button>
                                    {{ ('ShortUrl') }}
                                </x-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
