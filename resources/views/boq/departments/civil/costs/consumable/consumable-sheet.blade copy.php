
@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Consumable Cost')
@section('project-name')
    <a href="#" style="color:white;">{{ $project->name }}</a>
@endsection

@section('content-grid', 'col-12')
@section('breadcrumb-button')
    <a href="{{ route('boq.project.departments.civil.costs.consumables.create', ['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('content')
    <style>
        tbody tr,td{
            text-align: left;
        }

        tbody td{
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
                <h5>Consumable Cost</h5>
            </td>
        </tr>
        @if($project->boqFloorProjects()->sum('area') <= 0)
            <tr>
                <td colspan="3">
                    <strong class="text-danger"><span class="text-danger">*</span> Please input build up area for this project</strong>
                </td>
            </tr>
        @endif
        </tbody>
    </table>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Sl. No</th>
            <th>Particulars</th>
            <th>Unit</th>
            <th>Quantity</th>
            <th>Rate/Unit</th>
            <th>Amount In Tk.</th>
        </tr>
        </thead>
        <tbody>

        @foreach($consumables as $key => $consumable)
            <tr>
                <td colspan="2"><strong style="font-weight: bold;font-size: 13px">{{ $key }}</strong></td>
            </tr>
            <?php $headWiseTotalAmount = 0;$sl = 1; ?>
            @foreach($consumable as $item)
                <tr>
                    <td class="text-center">{{  $sl }}</td>
                    <td>{{ $item?->nestedMaterial?->name }}</td>
                    <td>{{ $item?->nestedMaterial?->unit?->name }}</td>
                    <td>{{ $item?->total_quantity }}</td>
                    <td>{{ $item?->rate }}</td>
                    <td>{{ number_format($item?->total_amount,2) }}</td>
                </tr>
                @php $sl++; $headWiseTotalAmount += $item?->total_amount; @endphp
            @endforeach
            <tr style="background-color: #dbecdb">
                <td colspan="4"></td>
                <td><strong style="font-weight: bold;font-size: 11px;float: right;margin-right: 5px">Total Cost For {{ $key }}</strong></td>
                <td><strong>{{ number_format($headWiseTotalAmount,2) }}</strong></td>
            </tr>
        @endforeach
{{--        <tr>--}}
{{--            <td>Civil</td>--}}
{{--            <td>@money($total_civil_cost)</td></tr>--}}
{{--        <tr>--}}
{{--            <td>Electronics</td>--}}
{{--            <td>@money(0)</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td>Sanitary</td>--}}
{{--            <td>@money(0)</td>--}}
{{--        </tr>--}}
{{--        <tr class="">--}}
{{--            <th colspan="">Total</th>--}}
{{--            <th colspan="">@money($total_civil_cost) Tk.</th>--}}
{{--        </tr>--}}
        </tbody>
    </table>
@endsection
