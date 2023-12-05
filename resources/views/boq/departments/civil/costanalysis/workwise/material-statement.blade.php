@extends('boq.departments.civil.layout.app')

@section('project-name', $project->name)

@section('content')
    <style>
        .table-bordered td,
        .table-bordered th {
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
            background-color: #fff
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
                            <th colspan="8">
                                <h6>Workwise Material Statement</h6>
                            </th>
                        </tr>
                        <tr>
                            <th>Work Description</th>
                            <th>Unit</th>
                            <th>Total quantity</th>
                            <th>Material</th>
                            <th>Unit</th>
                            <th><span class="numSpan">Quantity</span></th>
                            <th><span class="numSpan">Wastage</span></th>
                            <th><span class="numSpan">Total</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($material_statements as $floor_name => $work_types)
                            <tr>
                                <td colspan="8" style="background-color: #d6e5ff">
                                    <h5><b>At {{ $floor_name }}</b></h5>
                                </td>
                            </tr>
                            @foreach ($work_types as $work_type_id => $works)
                                @if ($works->first()->first()->boq_work_id != $work_type_id)
                                    <tr>
                                        <td colspan="3" style="background-color: #dbecdb">
                                            <h6><b>{{ $works?->first()?->first()?->workType?->name }}</b></h6>
                                        </td>
                                        <td style="background-color: #ecfeff" colspan="7"></td>
                                    </tr>
                                @endif
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
                                                <td class="bg-white" rowspan="{{ $row_span }}">
                                                    {{ $ancestor_str }}
                                                    <strong>{{ $item?->boqWork?->name ?? '---' }}</strong>
                                                </td>
                                                <td class="bg-white" rowspan="{{ $row_span }}">
                                                    {{ $item?->boqWork?->materialUnit?->name ?? '---' }}
                                                    @if ($budgets->boq_civil_calc?->unit_id)
                                                        <hr>
                                                        {{ $budgets->boq_civil_calc?->unit?->name }}
                                                    @endif
                                                </td>
                                                <td class="bg-white" rowspan="{{ $row_span }}">
                                                    <strong>{{ $budgets->boq_civil_calc?->total }}</strong>
                                                    @if ($budgets->boq_civil_calc?->unit_id)
                                                        <hr>
                                                        <strong>{{ $budgets->boq_civil_calc?->secondary_total }}</strong>
                                                    @endif
                                                </td>
                                            @endif
                                            <td class="bg-white">{{ $item?->nestedMaterial?->name ?? '---' }}</td>
                                            <td class="bg-white">{{ $item?->nestedMaterial?->unit?->name ?? '---' }}</td>
                                            <td class="bg-white"><span class="numSpan" title="{{ $item?->formula_percentage }}">@money($item?->quantity)</span></td>
                                            <td class="bg-white"><span class="numSpan" title="{{ $item?->wastage }}">@money($item?->wastage)</span></td>
                                            <td class="bg-white text-right"><strong>@money($item->total_quantity)</strong></td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
