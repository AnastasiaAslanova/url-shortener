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
                    Select the type of your future link:
                    <form method="GET" action="{{ route('choice') }}">
                        @csrf
                        <div class="flex flex-col">
                            <div class="py-4">
                                <label><input class="form-radio" type="radio" checked name="type" value="simpleShort"/> simple short link</label>
                            </div>
                            <div class="pb-4">
                                <label><input type="radio" name="type" value="shortWithKey"/> with key </label>
                            </div>
                            <div class="pb-4">
                                <label><input type="radio" name="type" value="namedShort"/> with name</label>
                            </div>
                            <div>
                                <x-button>{{ ('Next') }}</x-button>
                            </div>
                        </div>
                    </form>
                </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
