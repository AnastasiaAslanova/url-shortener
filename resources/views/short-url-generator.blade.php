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
                <th class="w-4/5" style="border: 1px solid black">Your links</th>
                <th class="w-1/5" style="border: 1px solid black">Short links</th>
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
                </div>
            </td>
        </tr>
        @endforeach
    </table>
    </div>

</x-app-layout>
