@extends('boq.departments.civil.layout.app')
@section('project-name', $project->name)
@section('title', 'BOQ - Price Escalation')

@section('content')
{{--    <table class="table table-bordered">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th colspan="3">--}}
{{--                <h4>Project name - {{ $project->name }}</h4>--}}
{{--                <h6>{{ $project->location }}</h6>--}}
{{--            </th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        <tr>--}}
{{--            <td colspan="3">--}}
{{--                <h6>Total buildup area - {{ number_format($project->boqFloorProjects()->sum('area'),2) }}  Sft, <span style="font-size: 14px">Total Land Area: <strong>{{ $project->landsize }}</strong> Khata</span></h6>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--        </tbody>--}}
{{--    </table>--}}

    <table class="table table-bordered">
        <thead>
        <tr>
            <th colspan="13"><h5>Price Escalation:- {{ $escalation_no }}</h5></th>
        </tr>
        <tr>
            <th colspan="13"><h5>Project: {{ $project->name }}</h5> <br>
                <h6>Total Buildup Area = {{ number_format($project->boqFloorProjects()->sum('area'),2) }} sft, Date: 19-05-2023</h6>
            </th>
        </tr>
        <tr>
            <th>Sl.</th>
            <th>Material</th>
            <th>Unit</th>
            <th>Floor</th>
            <th>Till Date</th>
            <th>Initial Qty</th>
            <th>Initial Price</th>
            <th>Used Qty</th>
            <th>Revised Qty</th>
            <th>Revised Price</th>
            <th>Amount</th>
            <th>Budget Type</th>
            <th>Remarks</th>
        </tr>
        </thead>
        <tbody>
        @php
        $total_amount = 0;
        @endphp
        @foreach($escalations as $escalation)
        <tr>
            <td>{{ ++$loop->index }}</td>
            <td>{{ $escalation->material->name }}</td>
            <td>{{ $escalation->material->unit->name }}</td>
            <td>{{ $escalation->floorProject->floor->name }}</td>
            <td>{{ $escalation->till_date }}</td>
            <td>{{ $escalation->primary_qty }}</td>
            <td>{{ $escalation->primary_price }}</td>
            <td>{{ $escalation->used_qty }}</td>
            <td>{{ $escalation->revised_qty }}</td>
            <td>{{ $escalation->revised_price }}</td>
            <td class="text-right">{{ $escalation->increased_or_decreased_amount }}</td>
            <td>{{ $escalation->budget_type }}</td>
            <td>{{ $escalation->remarks }}</td>
        </tr>
        @php
        $total_amount += $escalation->increased_or_decreased_amount;
        @endphp
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th class="text-center" colspan="9">TOTAL AMOUNT</th>
            <th class="text-right">@money($total_amount)</th>
            <th class="text-right"></th>
            <th class="text-right"></th>
        </tr>
        </tfoot>
    </table>
@endsection
