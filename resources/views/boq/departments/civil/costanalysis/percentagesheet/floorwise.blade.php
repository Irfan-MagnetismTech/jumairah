@extends('boq.departments.civil.layout.app')

@section('project-name', $project->name)

@section('content')
    <style>
        .table-bordered td {
            border: 1px solid #a09e9e;
        }

        .numSpan {
            display: inline-block;
            width: 100px;
            text-align: right;

        }

        td,
        th {
            text-align: center;
        }

    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="work-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th colspan="8">
                                <h5>{{ $project->name }}</h5>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="8"><span style="font-size: 14px">Floorwise Percentage Sheet</span></th>
                        </tr>
                        <tr>
                            <th colspan="8"><span style="font-size: 14px">Total Construction Area: <strong>@money($total_areas) SFT</strong></span></th>
                        </tr>
                        <tr>
                            <th>SL</th>
                            <th>Floor Description</th>
                            {{-- <th><span class="numSpan">Material Cost</span></th>
                            <th><span class="numSpan">Labour Cost</span></th>
                            <th><span class="numSpan">Material & Labour</span></th> --}}
                            <th><span class="numSpan">Total Cost</span></th>
                            <th><span class="numSpan">Cost Per SFT</span></th>
                            <th><span class="numSpan">Cost In Percentage</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_cost_per_sft = 0;
                            $total_cost_in_percentage = 0;
                        @endphp
                        @foreach ($percentage_sheet_floor_wise as $floor_wise_sheet)
                            @php
                                $total_cost_per_sft += ($floor_wise_sheet?->material_total_amount + $floor_wise_sheet?->labour_total_amount + $floor_wise_sheet?->material_labour_total_amount) / $total_areas;
                                $total_cost_percentage = ($floor_wise_sheet?->material_total_amount + $floor_wise_sheet?->labour_total_amount + $floor_wise_sheet?->material_labour_total_amount) * 100;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $floor_wise_sheet?->boqCivilCalcProjectFloor?->boqCommonFloor?->name ?? '---' }}</strong></td>
                                {{-- <td><span class="numSpan">@money($floor_wise_sheet?->material_total_amount)</span></td>
                                <td><span class="numSpan">@money($floor_wise_sheet?->labour_total_amount)</span></td>
                                <td><span class="numSpan">@money($floor_wise_sheet?->material_labour_total_amount)</span></td> --}}
                                <td><span class="numSpan">@money($floor_wise_sheet?->material_total_amount + $floor_wise_sheet?->labour_total_amount + $floor_wise_sheet?->material_labour_total_amount)</span></td>
                                <td><span class="numSpan">@money(($floor_wise_sheet?->material_total_amount + $floor_wise_sheet?->labour_total_amount + $floor_wise_sheet?->material_labour_total_amount)/$total_areas)</span></td>
                                <td>
                                    <span class="numSpan">
                                        @if ($floor_wise_sheet?->material_total_amount + $floor_wise_sheet?->labour_total_amount + $floor_wise_sheet?->material_labour_total_amount == 0)
                                            @money(0)
                                            @php
                                                $total_cost_in_percentage += 0;
                                            @endphp
                                        @else
                                            @money(($floor_wise_sheet?->material_total_amount + $floor_wise_sheet?->labour_total_amount + $floor_wise_sheet?->material_labour_total_amount) * 100 /$total_cost)
                                            @php
                                                $total_cost_in_percentage += (($floor_wise_sheet?->material_total_amount + $floor_wise_sheet?->labour_total_amount + $floor_wise_sheet?->material_labour_total_amount) * 100) / $total_cost;
                                            @endphp
                                        @endif
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        <tr style="background-color: #116A7B;color: #fff;font-weight: bold">
                            <td colspan="2">TOTAL COST WITH RESPECT TO CONSTRUCTION AREA</td>
                            <td colspan="" class="grand_total"><span class="numSpan">@money($total_cost)</span></td>
                            <td colspan="" class="grand_total"><span class="numSpan">@money($total_cost_per_sft)</span></td>
                            <td colspan="" class="grand_total"><span class="numSpan">@money($total_cost_in_percentage)</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
