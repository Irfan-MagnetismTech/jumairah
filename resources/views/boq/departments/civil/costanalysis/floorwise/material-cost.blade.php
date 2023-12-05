@extends('boq.departments.civil.layout.app')

@section('project-name', $project->name)

@section('content')
    <style>
        .table-bordered td {
            border: 1px solid #a09e9e;
        }

        .numSpan {
            display: inline-block;
            width: calc(50%);
            text-align: right;

        }

        td,
        th {
            text-align: center;
        }

        .bg-white {
            background-color: #fff;
        }

        .font-bold {
            font-weight: bold;
        }

    </style>
    <div class="row">

        <form action="{{ route('boq.project.departments.civil.cost_analysis.floor_wise.material.costs', ['project' => $project]) }}" method="get" class="col-md-12">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="boq_floor_type_id">Select Floor <span class="text-danger">*</span></label>
                            <select class="form-control" id="boq_floor_id" name="boq_floor_id" required>
                                <option value="" disabled selected>Select Floor</option>
                                @foreach($boq_calc_floors as $boq_floor)
                                    <option value="{{ $boq_floor?->boq_floor_id }}" @if(request()->input('boq_floor_id') === $boq_floor?->boq_floor_id) selected @endif>{{ $boq_floor?->boqCivilCalcProjectFloor?->floor?->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="boq_work_parent_id">Select Work</label>
                            <select class="form-control" id="boq_work_parent_id" name="boq_work_parent_id">
                                <option value="" disabled selected>Select Work</option>
                                @foreach($boq_calc_works as $boq_calc_work)
                                    <option value="{{ $boq_calc_work?->boq_work_parent_id }}" @if(request()->input('boq_work_parent_id') == $boq_calc_work?->boq_work_parent_id) selected @endif>{{ $boq_calc_work?->boqParentWork?->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="py-2 btn btn-success btn-round btn-block" id="submit-button">{{ $label ?? 'Search' }}</button>
                    </div>
                    <div class="col-md-2">
                        <a type="button" class="py-2 btn btn-info btn-round btn-block" href="{{ route('boq.project.departments.civil.cost_analysis.floor_wise.material.costs', ['project' => $project]) }}">Clear</a>
                    </div>
                </div>
            </div>
            <hr>
        </form>

        <div class="col-md-12">
            <a style="float: right" target="_blank" href="{{ route('boq.project.departments.civil.cost_analysis.floor_wise.download.material.costs', ['project' => $project]) }}" data-toggle="tooltip" title="" class="btn btn-outline-danger" data-original-title="Download PDF"><i class="fas fa-file-pdf"></i></a>

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
                            <h6>Material Cost Floorwise</h6>
                            <strong>Total Land Area - {{ $project?->landsize }} Khata, Total Construction Area - {{ number_format($project->boqFloorProjects()->sum('area'),2) }}  Sft</strong>
                        </th>
                    </tr>
                    <tr>
                        <th>Work Description</th>
                        <th>Material</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th><span class="numSpan">Rate(Tk)</span></th>
                        <th><span class="numSpan">Amount(Tk)</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($material_statements as $floor_name => $work_types)
                        <tr>
                            <td colspan="8" style="background-color: #d6e5ff">
                                <h5><b>At {{ $floor_name }}</b></h5>
                            </td>
                        </tr>
                        @php
                            $total_work_amount = 0;
                        @endphp
                        @foreach ($work_types as $work_type_id => $works)
                            @if ($works->first()->first()->boq_work_id != $work_type_id)
                                <tr>
                                    <td colspan="3" style="background-color: #dbecdb">
                                        <h6><b>{{ $works?->first()?->first()?->workType?->name }}</b></h6>
                                    </td>
                                    <td style="background-color: #ecfeff" colspan="7"></td>
                                </tr>
                            @endif
                            @php
                            $total_sub_work_amount = 0;
                            $sub_work_total_amount = 0;
                            @endphp
                            @foreach ($works as $work_id => $budgets)
                                @php $total_sub_quantity = $total_wastage = $total_quantity = 0; @endphp
                                @foreach ($budgets as $key => $item)
                                    @php
                                        $ancestor_str = '';
                                        foreach ($budgets->ancestors as $id => $ancestor) {
                                            $ancestor_str .= $ancestor->name . ' > ';
                                        }
                                    @endphp
                                    @php
                                        $wastage = $item?->wastage * $item?->quantity;
                                        $total_wastage += $wastage;
                                        $total_sub_quantity += $item?->quantity;
                                        $total_quantity += $item->total_quantity + $wastage;
                                    @endphp
                                    <tr>
                                        @if ($loop->first)
                                            @php
                                                $row_span = count($budgets);
                                            @endphp
                                            <td style="text-align: center" class="bg-white" rowspan="{{ $row_span }}">
                                                {{ $ancestor_str }}
                                                <strong>
                                                    <a href="{{ route('boq.project.departments.civil.calculations.edit', ['project' => $project, 'calculation_type' => 'material', 'calculation' => $item]) }}">
                                                        {{ $item?->boqWork?->name ?? '---' }}
                                                    </a>
                                                </strong>
                                            </td>
                                        @endif
                                        <td style="text-align: left;max-width: 30%;white-space: inherit" class="bg-white">{{ $loop->index + 1 }}. &nbsp;{{ $item?->nestedMaterial?->name ?? '---' }}</td>
                                        <td class="bg-white">{{ $item?->nestedMaterial?->unit?->name ?? '---' }}</td>
                                        <td class="bg-white"><span class="numSpan" title="{{ $item?->formula_percentage }}">@money($item?->total_quantity)</span></td>
                                        <td class="bg-white"><span class="numSpan">@money($item?->rate)</span></td>
                                        <td class="bg-white"><span class="numSpan">@money($item?->total_amount)</span></td>
                                    </tr>
                                @endforeach
                                @php
                                    $total_sub_work_amount += $budgets->sum('total_amount');
                                    $total_work_amount += $budgets->sum('total_amount');
                                @endphp
                            @endforeach
                            @php
                                $sub_work_total_amount += $total_sub_work_amount;
                            @endphp
                            <tr>
                                <td colspan="4" class="bg-white font-bold"></td>
                                <td style="background-color: #f6f4d0;text-align: right" class="font-bold">Sub Total</td>
                                <td style="background-color: #dbecdb" class="font-bold"><span class="numSpan">@money($sub_work_total_amount)</span></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" style="background-color: #ccc97a;text-align: right;font-size: 12px" class="font-bold">Total Cost of {{ $floor_name }}</td>
                            <td style="background-color: #dbecdb" class="font-bold"><span class="numSpan">@money($total_work_amount)</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    @if($material_statements->count() == 0)
                    <tr>
                        <td colspan="6" class="bg-white font-bold">
                            <h6>Sorry! No Data Found</h6>
                        </td>
                    </tr>
                    @endif
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
