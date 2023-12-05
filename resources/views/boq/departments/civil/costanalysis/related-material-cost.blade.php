@extends('boq.departments.civil.layout.app')

@section('project-name', $project->name)

@section('content')
    <style>
        .table-bordered td{
            border: 1px solid #a09e9e;
        }
        .numSpan {
            display: inline-block;
            width: 100px;
            text-align: right;
        }
        td,th { text-align: center; }
    </style>

    <div class="row">
        <div class="col-md-12">
            <a style="float: right" target="_blank" href="{{ route('boq.project.departments.civil.cost_analysis.floor_wise.download.related-material.costs', ['project' => $project]) }}" data-toggle="tooltip" title="" class="btn btn-outline-danger" data-original-title="Download PDF"><i class="fas fa-file-pdf"></i></a>

            <div class="table-responsive">
                <table id="work-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th colspan="8">
                            <h5>{{ $project?->name }}</h5>
                            <h6>{{ $project?->location }}</h6>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="8">
                            <h6>Related Material Cost</h6>
                            <strong>Total Land Area - {{ $project?->landsize }} Khata, Total Construction Area - {{ number_format($project->boqFloorProjects()->sum('area'),2) }}  Sft</strong>
                        </th>
                    </tr>
                    <tr>
                        <th>Particulars</th>
                        <th>Material</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th><span class="numSpan">Rate(Tk)</span></th>
                        <th><span class="numSpan">Amount(Tk)</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($material_statements as $key => $item)
                        @foreach($item as $material)
                            <tr>
                                @if ($loop->first)
                                    @php
                                        $row_span = count($item);
                                    @endphp
                                    <td style="text-align: center;font-size: 10px" class="bg-white" rowspan="{{ $row_span }}">
                                        <strong>
                                            <a href="{{ route('boq.project.departments.civil.costs.consumables.edit', ['project' => $project, 'head' => $key]) }}">{{ $key ?? '---' }}</a>
                                        </strong>
                                    </td>
                                @endif
                                <td style="text-align: left" class="bg-white">{{ $loop->index + 1 }}. &nbsp;{{ $material?->nestedMaterial?->name ?? '---' }}</td>
                                <td class="bg-white">{{ $material?->nestedMaterial?->unit?->name ?? '---' }}</td>
                                <td class="bg-white"><span class="numSpan">@money($material?->total_quantity)</span></td>
                                <td class="bg-white"><span class="numSpan">@money($material?->rate)</span></td>
                                <td class="bg-white"><span class="numSpan">@money($material?->total_amount)</span></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4"></td>
                            <td style="background-color: #f6f4d0"><strong>Total Amount</strong></td>
                            <td style="background-color: #dbecdb"><span class="numSpan"><strong>@money($item->sum('total_amount'))</strong></span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

{{--    <div class="row">--}}
{{--        <div class="col-md-12">--}}
{{--            <div class="table-responsive">--}}
{{--                <table id="work-table" class="table table-striped table-bordered">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th colspan="6"><h5>{{ $project->name }}</h5></th>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <th colspan="6"><span style="font-size: 14px">Floorwise Material & Labour Cost</span></th>--}}
{{--                    </tr>--}}
{{--                        <tr>--}}
{{--                            <th>Work Description</th>--}}
{{--                            <th>Material</th>--}}
{{--                            <th>Unit</th>--}}
{{--                            <th><span class="numSpan">Quantity</span></th>--}}
{{--                            <th><span class="numSpan">Rate (Tk)</span></th>--}}
{{--                            <th><span class="numSpan">Amount (Tk)</span></th>--}}
{{--                        </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                        @foreach ($material_labour_costs as $material_statement_key => $material_statement)--}}
{{--                            <tr>--}}
{{--                                <td colspan="9"><b>{{ $material_statement_key }}</b></td>--}}
{{--                            </tr>--}}
{{--                            @foreach ($material_statement as $work)--}}
{{--                                @foreach ($work as $key => $item)--}}
{{--                                    @php--}}
{{--                                        $wastage = $item?->wastage * $item?->quantity;--}}
{{--                                    @endphp--}}
{{--                                    <tr>--}}
{{--                                        @if ($loop->first)--}}
{{--                                            <td style="background-color: #fff" rowspan="{{ count($work) }}"><b>{{ $item?->boqWork?->name ?? '---' }}</b></td>--}}
{{--                                        @endif--}}
{{--                                        <td style="background-color: #fff">{{ $item?->nestedMaterial?->name ?? '---' }}</td>--}}
{{--                                        <td style="background-color: #fff">{{ $item?->nestedMaterial?->unit?->name ?? '---' }}</td>--}}
{{--                                        <td style="background-color: #fff"><span class="numSpan">@money($item?->quantity - $wastage)</span></td>--}}
{{--                                        <td style="background-color: #fff"><span class="numSpan">@money($item?->rate)</span></td>--}}
{{--                                        <td style="background-color: #fff"><span class="numSpan">@money($item?->total_amount)</span></td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                                <tr>--}}
{{--                                    <td style="background-color: #dbecdb;color: #000;font-weight: bold" colspan="4"></td>--}}
{{--                                    <td style="background-color: #dbecdb;color: #000;font-weight: bold" colspan="">Total Amount (Tk)</td>--}}
{{--                                    <td style="background-color: #dbecdb;color: #000;font-weight: bold"><span class="numSpan">@money($work->sum('total_amount'))</span></td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        @endforeach--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
