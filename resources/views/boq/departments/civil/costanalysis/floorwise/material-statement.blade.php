@extends('boq.departments.civil.layout.app')

@section('project-name', $project->name)

@section('content')
    <style>
        .table-bordered td{
            border: 1px solid #a09e9e;
        }
        .numSpan {
            display: inline-block;
            width: calc(50%);
            text-align: right;

        }
        td,th { text-align: center; }
    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="work-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th colspan="7"><h5>{{ $project->name }}</h5></th>
                    </tr>
                    <tr>
                        <th colspan="7"><span style="font-size: 14px">Floorwise Material Statement</span></th>
                    </tr>
                        <tr>
                            <th>Material</th>
                            <th>Unit</th>
                            <th>Work</th>
                            <th>Unit</th>
                            <th><span class="numSpan">Quantity</span></th>
                            <th><span class="numSpan">Wastage</span></th>
                            <th><span class="numSpan">Total Quantity</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($material_statements as $material_statement_key => $material_statement)
                            <tr>
                                <td colspan="8" style="background-color: #d6e5ff">
                                    <h5><b>At {{ $material_statement_key }}</b></h5>
                                </td>
                            </tr>
                            @foreach ($material_statement as $work)
                                @php
                                $total_sub_quantity = 0;
                                $total_wastage = 0;
                                $total_quantity = 0;
                                @endphp
                                @foreach ($work as $key => $item)
                                    @php
                                        $wastage = $item?->wastage * $item?->quantity;
                                        $total_wastage += $wastage;
                                        $total_sub_quantity += $item?->quantity;
                                        $total_quantity += $item->total_quantity + $wastage;
                                    @endphp
                                    <tr>
                                        @if ($loop->first)
                                            <td style="background-color: #fff" rowspan="{{ count($work) }}"><strong>{{ $item?->nestedMaterial?->name ?? '---' }}</strong></td>
                                            <td style="background-color: #fff" rowspan="{{ count($work) }}">{{ $item?->nestedMaterial?->unit?->name ?? '---' }}</td>
                                        @endif
                                        <td style="background-color: #fff">{{ $item?->boqWork?->name ?? '---' }}</td>
                                        <td style="background-color: #fff">{{ $item?->boqWork?->materialUnit?->name ?? '---' }}</td>
                                        <td style="background-color: #fff"><span class="numSpan">@money($item?->quantity)</span></td>
                                        <td style="background-color: #fff"><span class="numSpan">@money($item?->wastage) (@money($item?->wastage)%)</span></td>
                                        <td style="background-color: #fff" rowspan=""><strong><span class="numSpan">@money($item->total_quantity + $wastage)</span></strong></td>
                                    </tr>
                                @endforeach
                                <tr style="background-color: #dbecdb">
                                    <td colspan="3"></td>
                                    <td><strong>Total</strong></td>
                                    <td><strong><span class="numSpan">@money($total_sub_quantity)</span></strong></td>
                                    <td><strong><span class="numSpan">@money($total_wastage)</span></strong></td>
                                    <td><strong><span class="numSpan">@money($total_quantity)</span></strong></td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
