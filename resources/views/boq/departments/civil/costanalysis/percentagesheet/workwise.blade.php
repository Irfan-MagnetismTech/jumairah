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
            <a style="float: right" target="_blank" href="{{ route('boq.project.departments.civil.cost_analysis.percentage_sheet.download.workwise', ['project' => $project]) }}" data-toggle="tooltip" title="" class="btn btn-outline-danger" data-original-title="Download PDF"><i class="fas fa-file-pdf"></i></a>
            <div class="table-responsive">
                <table id="work-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th colspan="8">
                            <h5>{{ $project->name }}</h5>
                            <h6>{{ $project->location }}</h6>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="8"><span style="font-size: 14px">Workwise Percentage Sheet</span></th>
                    </tr>
                    <tr>
                        <th colspan="8"><span style="font-size: 14px">Total Land Area: <strong>{{ $project->landsize }}</strong> Khata, Total Construction Area: <strong>@money($total_areas) SFT</strong></span></th>
                    </tr>
                        <tr>
                            <th>SL</th>
                            <th>Work Description</th>
                            <th><span class="numSpan">Material Cost</span></th>
                            <th><span class="numSpan">Labour Cost</span></th>
                            <th><span class="numSpan">Material & Labour</span></th>
                            <th><span class="numSpan">Total Cost</span></th>
                            <th><span class="numSpan">Cost Per SFT</span></th>
                            <th><span class="numSpan">Cost In Percentage</span></th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $total_cost_in_percentage = 0;
                        $total_cost_per_sft = 0;
                    @endphp
                    @foreach($percentage_sheet_work_wise as $key => $work_wise_sheet)
                        @php
                            $total_cost_in_percentage += ($work_wise_sheet?->total_amount*100/$total_cost);
                            $total_cost_per_sft += $work_wise_sheet?->cost_per_sft;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $key }}</strong></td>
                            <td><span class="numSpan">@money($work_wise_sheet?->material_total_amount)</span></td>
                            <td><span class="numSpan">@money($work_wise_sheet?->labour_total_amount)</span></td>
                            <td><span class="numSpan">@money($work_wise_sheet?->material_labour_total_amount)</span></td>
                            <td><span class="numSpan">@money($work_wise_sheet?->total_amount)</span></td>
                            <td><span class="numSpan">@money($work_wise_sheet?->cost_per_sft)</span></td>
                            <td><span class="numSpan">@money($work_wise_sheet?->total_amount*100/$total_cost)</span></td>
                        </tr>
                    @endforeach

                        <tr>
                            <td>{{ $percentage_sheet_work_wise->count() + 1 }}</td>
                            <td><strong>Other Related Cost</strong></td>
                            <td>---</td>
                            <td>---</td>
                            <td>---</td>
                            <td><span class="numSpan">@money($other_related_costs)</span></td>
                            <td><span class="numSpan">@money($other_related_costs/$total_areas)</span></td>
                            <td>
                                <span class="numSpan">
                                        @if ($other_related_costs == 0)
                                        @money(0)
                                        @php
                                            $total_cost_in_percentage += 0;
                                        @endphp
                                    @else
                                        @money(($other_related_costs) * 100 /$total_cost)
                                    @endif
                                    </span>
                            </td>
                        </tr>
                        <tr style="background-color: #227447;color: #fff;font-weight: bold">
                            <td colspan="5">TOTAL COST WITH RESPECT TO CONSTRUCTION AREA</td>
                            <td colspan="" class="grand_total"><span class="numSpan">@money($total_cost)</span></td>
                            <td colspan="" class="grand_total"><span class="numSpan">@money($total_cost_per_sft + ($other_related_costs/$total_areas))</span></td>
                            <td colspan="" class="grand_total"><span class="numSpan">@money($total_cost_in_percentage + ($other_related_costs) * 100 /$total_cost)</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
