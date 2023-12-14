@extends('boq.departments.electrical.layout.app')
@section('title', 'BOQ - Eme')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    Summary
@endsection
@section('breadcrumb-button')
    @can('project-create')
        <a href="{{ route('boq.project.departments.electrical.load_calculations.index', ['project' => $project ]) }}" data-toggle="tooltip" title="Index" class="btn btn-out-dashed btn-sm btn-primary"><i class="fas fa-eye"></i></a>
        <a href="{{ route('boq.project.departments.electrical.load_calculations.create',['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-success" data-toggle="tooltip" title="Create New"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
@endsection

@section('content')
            <!-- put search form here.. -->
    @php
        $calculation_type = ['Common','typical','generator'];
        $project_type = ['Residential','Commercial','Residential_cum_commercial'];
        $project_wise_general_total = [];
    @endphp

    @foreach ($boqemeloadcalculation as $key => $grpvalues)
    <div class="table-responsive">
        <table id="" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th colspan="5" class="text-center">
                        <span>
                            {{ $project_type[$key] }}
                        </span>
                    </th>
                </tr>
                <tr>
                    <th colspan="5" class="text-center">
                        <span>
                            Summary Of Load Calculation
                        </span>
                    </th>
                </tr>
                <tr>
                    <th>SL</th>
                    <th style="width: 250px;word-wrap:break-word">Description</th>
                    <th style="width: 250px;word-wrap:break-word">Units</th>
                    <th style="width: 250px;word-wrap:break-word">Total Load Of Unit</th>
                    <th style="width: 250px;word-wrap:break-word">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $general_total = 0;
                    $generator_total = 0;
                    $common_service = 0;
                    $calculation_type_array = $grpvalues->pluck('calculation_type')->toArray();
                    $generator_exist = in_array(2,$calculation_type_array);
                @endphp
            @foreach($grpvalues as $key1 => $data)
                @if ($data->calculation_type == 0)
                    <tr>
                        <td>1</td>
                        <td>Common Service</td>
                        <td></td>
                        <td>{{ $data->total_demand_wattage }}</td>
                        <td>{{ $data->demand_percent }} % Demand Load</td>
                    </tr>
                    @php
                        $general_total += $data->total_demand_wattage;
                        $common_service = $data->total_demand_wattage;
                    @endphp
                @endif
            @endforeach
            @foreach($grpvalues as $key1 => $data)
                @if ($data->calculation_type == 1)
                    <tr>
                        <td>2</td>
                        <td>Typical Service</td>
                        <td></td>
                        <td>{{ $data->total_demand_wattage }}</td>
                        <td>{{ $data->demand_percent }} % Demand Load</td>
                    </tr>
                    @php
                            $general_total += $data->total_demand_wattage;
                    @endphp
                @endif
            @endforeach
            <tr>
                <td colspan="3" class="text-right">Total</td>
                <td>{{ $general_total }}</td>
                <td>KW</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td>{{  $general_total / 0.8 }}</td>
                <td>KVA</td>
            </tr>
            </tbody>
        </table>
        @php
            $project_wise_general_total[] = [
                                        'type' => $key,
                                        'kw'   => $general_total,
                                        'kva'  => ($general_total / 0.8)
                                            ];
        @endphp
        @if ($generator_exist)
            <table id="" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th colspan="6" class="text-center">
                            <span>
                               Genarator Capacity Calculation
                            </span>
                        </th>
                    </tr>
                    <tr>
                        <th>SL</th>
                        <th style="width: 250px;word-wrap:break-word">Description</th>
                        <th style="width: 250px;word-wrap:break-word">Load/Units</th>
                        <th style="width: 250px;word-wrap:break-word">Quantity</th>
                        <th style="width: 250px;word-wrap:break-word">Connected Load</th>
                        <th style="width: 250px;word-wrap:break-word">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($grpvalues as $key1 => $data)
                    @if ($data->calculation_type == 2)
                        @php
                            $effective_rate = $data->genarator_efficiency ?? 0;
                        @endphp
                        @foreach ($data->boq_eme_load_calculations_details->groupBy('material_id') as $kk => $ata)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ata->first()->material->name }}</td>
                                <td>{{ $load = $ata->first()->load }}</td>
                                <td>{{ $qty = $ata->flatten()->sum('qty') }}</td>
                                <td>{{ $load * $qty / 1000 }}</td>
                                <td>As Per Specification</td>
                                @php
                                    $generator_total += $load * $qty / 1000;
                                @endphp
                            </tr>
                        @endforeach
                    @endif
                @endforeach
                    <tr>
                        <td colspan="4" class="text-right">Total</td>
                        <td>{{ $generator_total }}</td>
                        <td>KW</td>
                    </tr>
                    <tr>
                        <td colspan="4">Common Service</td>
                        <td>{{  $common_service }}</td>
                        <td>KW</td>
                    </tr>

                    <tr>
                        <td colspan="4">Load For generator for above calculation</td>
                        <td>{{ $generator_total + $common_service }}</td>
                        <td>KW</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td>{{ ($generator_total + $common_service) / 0.8}}</td>
                        <td>KVA</td>
                    </tr>
                    <tr>
                        <td colspan="4">Considering {{ $effective_rate }}% efficiency</td>
                        <td>{{ (($generator_total + $common_service) / 0.8) * $effective_rate / 100}}</td>
                        <td>KVA</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>

@endforeach
<div class="table-responsive">
    <table id="" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th colspan="6" class="text-center">
                    <span>
                       Residential Cum Commercial Load Calculation
                    </span>
                </th>
            </tr>
            <tr>
                <th>SL</th>
                <th style="word-wrap:break-word">Details</th>
                <th style="word-wrap:break-word">KVA</th>
                <th style="word-wrap:break-word">KW</th>
            </tr>
        </thead>
        <tbody>
    @php
        $total_kva = 0;
        $total_kw = 0;
    @endphp
@foreach ($project_wise_general_total as $key => $value)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td style="word-wrap:break-word">{{ $project_type[$value['type']] }}</td>
            <td style="word-wrap:break-word">{{ $value['kva'] }}</td>
            <td style="word-wrap:break-word">{{ $value['kw'] }}</td>
        </tr>
        @php
            $total_kva += $value['kva'];
            $total_kw += $value['kw'];
        @endphp
@endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align: right;">Total</td>
                <td style="word-wrap:break-word;text-align: center;">{{ $total_kva }}</td>
                <td style="word-wrap:break-word;text-align: center;">{{ $total_kw }}</td>
            </tr>
        </tfoot>
    </table>
@endsection
@section('script')
    <script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(window).scroll(function () {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function () {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function () {
            $('#dataTable').DataTable({
                stateSave: true,
                bPaginate: false
            });
        });
    </script>
@endsection
