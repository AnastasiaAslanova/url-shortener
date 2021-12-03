<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statistics') }} (TOP 10)
        </h2>
    </x-slot>

    <div style="margin: 10px auto; width: 50%; text-align: center;">
        @php ($date = (new DateTime(date('Y-m-01 00:00:00')))->modify('-12 months')) @endphp
        @for($i=1;$i <= 13; $i++)
            @php
            $route = request()->routeIs('statistic') ? 'statistic' : (Auth::id() ? 'myStatistic' : 'statistic');
            @endphp
            <a style="font-weight: @if($month == $date->format('n') && $year == $date->format('Y')) 700 @endif" href="{{route($route, ['month' => $date->format('n'), 'year' => $date->format('Y') ])}}">
                {{$date->format('M')}}
                @if (date('Y') !== $date->format('Y'))
                    ({{$date->format('Y')}})
                @endif
            </a>&nbsp&nbsp
            @php ($date->modify("+1 month"))
        @endfor
    </div>

    <table style="border:1px solid black; border-collapse: collapse; width: 50%; margin: auto" class="table-fixed rounded-md">
        <thead>
        <tr>
            <th class="w-4/5" style="border: 1px solid black">Short link</th>
            <th class="w-1/5" style="border: 1px solid black">Count</th>
        </tr>
        </thead>
        @foreach($statistic as $item)
            <tr>
                <td style="border: 1px solid black">
                    <div class="py-2 pl-2">
                        <span>
                            {{ route('short',['short' => $item->short_url]) }}
                        </span>
                    </div>
                </td>
                <td style="border: 1px solid black">
                    <div style="word-wrap: break-word; text-align: center" class="py-2 pl-2">
                        <span>{{$item->sum}}</span>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>

</x-app-layout>
