@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Consumable Cost')
@section('project-name')
    <a href="#" style="color:white;">{{ $project->name }}</a>
@endsection

@section('content-grid', 'col-12')

@section('content')
    <style>
        tbody tr,
        td {
            text-align: left;
        }

        tbody td {
            margin-left: 5px;
        }
    </style>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="3">
                    <h4>Project name - {{ $project->name }}</h4>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3" style="text-align: center">
                    <h5>Work Wise Quantity</h5>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered table-responsive">
        <thead>
            <tr>
                <th>Sl. No</th>
                <th>Area/Location</th>
                <th>Work Name</th>
                {{-- <th>Quantity</th> --}}
            </tr>
        </thead>
        <tbody>
            <?php $headWiseTotalAmount = 0;
            $sl = 1; ?>
            @foreach ($boqCivilBugets as $key => $boqCivilBuget)
                <tr>
                    @php
                        $keyArray = [];
                    @endphp
                    @foreach ($boqCivilBuget as $key => $value)
                        @php
                            $keyArray[] = $key;
                        @endphp
                    @endforeach

                    <td class="text-center" rowspan="{{ $boqCivilBuget->count() }}">{{ $sl }}
                    </td>

                    <td rowspan="{{ $boqCivilBuget->count() }}">
                        @foreach ($keyArray as $key)
                            @if ($loop->first)
                                {{ $boqCivilBuget[$key][0]->boqFloorProject->floor->name }}
                            @endif
                        @endforeach
                    </td>

                    @foreach ($boqCivilBuget as $workItem)
                            {{-- @php var_dump($item->boqWork) @endphp --}}

                            <td scope="row">
                        @foreach ($workItem as $item)

                                @forelse ($item?->boqWork?->ancestors as $ancestor)
                                    {{ $ancestor->name }} ->
                                @empty
                                    not found
                                @endforelse
                                {{ $item?->boqWork?->name }}
                        @endforeach

                            </td>
                    @endforeach
                    {{-- <td>{{ $boqCivilBuget?->sum_quantity }}</td> --}}
                    @php
                        $sl++;
                        // $headWiseTotalAmount += $item?->total_amount;
                    @endphp
                    {{-- <tr style="background-color: #dbecdb">
                    <td colspan="4"></td>
                    <td><strong style="font-weight: bold;font-size: 11px;float: right;margin-right: 5px">Total Cost For
                            {{ $key }}</strong></td>
                    <td><strong>{{ number_format($headWiseTotalAmount, 2) }}</strong></td>
                </tr> --}}
                </tr>
            @endforeach
            {{--        <tr> --}}
            {{--            <td>Civil</td> --}}
            {{--            <td>@money($total_civil_cost)</td></tr> --}}
            {{--        <tr> --}}
            {{--            <td>Electronics</td> --}}
            {{--            <td>@money(0)</td> --}}
            {{--        </tr> --}}
            {{--        <tr> --}}
            {{--            <td>Sanitary</td> --}}
            {{--            <td>@money(0)</td> --}}
            {{--        </tr> --}}
            {{--        <tr class=""> --}}
            {{--            <th colspan="">Total</th> --}}
            {{--            <th colspan="">@money($total_civil_cost) Tk.</th> --}}
            {{--        </tr> --}}
        </tbody>
    </table>
@endsection
