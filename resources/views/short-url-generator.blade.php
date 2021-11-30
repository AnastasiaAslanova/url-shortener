<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your new url is ready') }}
        </h2>
    </x-slot>
    @if(Session::has('long'))
        <p><b>Your long URL:</b> {{ Session::get('long') }}</p>
    @endif

    @if(Session::has('short'))
        <p><b>Your short URL:</b>
            <a href="{{route('short', ['short' => Session::get('short')]) }}">
                {{ route('short', ['short' => Session::get('short')])  }}
            </a>
        </p>
    @endif
    <div class="p-6 bg-white" style="margin: auto">
    <table style="border:1px solid black; border-collapse: collapse; width: 90%; margin: auto" class="table-fixed rounded-md">
        <thead>
            <tr>
                <th class="w-4/6" style="border: 1px solid black">Your links</th>
                <th class="w-1/4" style="border: 1px solid black">Short links</th>
                <th class="w-3/3" style="border: 1px solid black">Actions</th>
            </tr>
        </thead>
            @foreach($links as $link)
        <tr>
            <td style="border: 1px solid black">
                <div style="word-wrap: break-word" class="py-2 pl-2">
                        <span> {{ $link->long_url}}</span>
                </div>
            </td>
            <td style="border: 1px solid black">
                <div class="py-2 pl-2">
                    <a href="{{route('short',['short' => $link->short_url])}}">
                        {{ route('short',['short' => $link->short_url]) }}
                    </a>
                    @if(!empty($link->expiration_date))
                        <span class="text-gray-500 text-sm">(expired: {{$link->expiration_date}})</span>
                    @endif
                </div>
            </td>
            <td style="border: 1px solid black" width:auto>
                <div style="word-wrap: break-word" class="py-2 pl-2">
                    <form method="post" action="{{route('deleteLink', ['id' => $link->id])}}">
                        @csrf
                        <button type="submit" class="inline-flex items-center bg-red-200 border-0 py-1 px-3 focus:outline-none hover:bg-red-300 rounded text-base mt-4 md:mt-0">Delete Url</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </table>
    </div>

</x-app-layout>
