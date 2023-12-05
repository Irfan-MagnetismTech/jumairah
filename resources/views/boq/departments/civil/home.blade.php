@extends('boq.departments.civil.layout.app')
@section('project-name', $project->name)
@section('title', 'BOQ - Civil Home')

@section('content')
    <style>
        a:hover{
            text-decoration: underline;
        }
    </style>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th colspan="3">
                <h4>Project name - {{ $project->name }}</h4>
                <h6>{{ $project->location }}</h6>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="3">
                <h6>Total buildup area - {{ number_format($project->boqFloorProjects()->sum('area'),2) }}  Sft, <span style="font-size: 14px">Total Land Area: <strong>{{ $project->landsize }}</strong> Khata</span></h6>
            </td>
        </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th colspan="3"><h5>Abstract of Cost</h5></th>
        </tr>
        <tr>
            <th>Cost Head</th>
            <th>Amount</th>
            <th>Cost Per Sft</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Material Cost</td>
            <td>@money($all_cost_summary?->material_total_amount)</td>
            <td>@money(($all_cost_summary?->material_total_amount)/$total_area)</td>
        </tr>
        <tr>
            <td>Labour Cost</td>
            <td>@money($all_cost_summary?->labour_total_amount)</td>
            <td>@money(($all_cost_summary?->labour_total_amount)/$total_area)</td>
        </tr>
        <tr>
            <td>Material & Labour Cost</td>
            <td>@money($all_cost_summary?->material_labour_total_amount)</td>
            <td>@money(($all_cost_summary?->material_labour_total_amount)/$total_area)</td>
        </tr>
        <tr>
            <td>Other Cost</td>
            <td>@money($all_cost_summary?->other_total_cost)</td>
            <td>@money(($all_cost_summary?->other_total_cost)/$total_area)</td>
        </tr>
        <tr>
            <th>Total</th>
            <th>@money($total_cost) Tk.</th>
            <th>@money($total_cost/$total_area) Tk.</th>
        </tr>
        </tbody>
    </table>


{{--    <table class="table table-bordered">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th colspan="4"><h5>Price Escalation</h5></th>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <th>Escalation No</th>--}}
{{--            <th>Cost Head</th>--}}
{{--            <th>Amount</th>--}}
{{--            <th>Cost Per Sft</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @foreach($price_escalations as $index => $escalation)--}}
{{--            @php--}}
{{--                $bgColor1 = '#d4da70'; // Red color--}}
{{--                $bgColor2 = '#57d5a2'; // Green color--}}
{{--                $bgColor = ($index % 2 == 0) ? $bgColor1 : $bgColor2;--}}
{{--            @endphp--}}
{{--        <tr style="background-color: {{ $bgColor }};">--}}
{{--            <td rowspan="4"><strong>{{ $escalation->escalation_no }}</strong></td>--}}
{{--            <td>--}}
{{--                <a href="{{ route('boq.project.departments.civil.previous.revised-sheet', ['project' => $project, 'budget_type' => 'material', 'escalation_no' => $escalation->escalation_no]) }}" style="color: #303333">--}}
{{--                    Material Cost--}}
{{--                </a>--}}
{{--            </td>--}}
{{--            <td>@money($escalation->material_changed_total_amount)</td>--}}
{{--            <td>@money(($escalation->material_changed_total_amount)/$total_area)</td>--}}
{{--        </tr>--}}
{{--        <tr style="background-color: {{ $bgColor }};">--}}
{{--            <td>--}}
{{--                <a href="{{ route('boq.project.departments.civil.previous.revised-sheet', ['project' => $project, 'budget_type' => 'labour', 'escalation_no' => $escalation->escalation_no]) }}" style="color: #303333">--}}
{{--                    Labour Cost--}}
{{--                </a>--}}
{{--            </td>--}}
{{--            <td>@money($escalation->labour_changed_total_amount)</td>--}}
{{--            <td>@money(($escalation->labour_changed_total_amount)/$total_area)</td>--}}
{{--        </tr>--}}
{{--        <tr style="background-color: {{ $bgColor }};">--}}
{{--            <td>--}}
{{--                <a href="{{ route('boq.project.departments.civil.previous.revised-sheet', ['project' => $project, 'budget_type' => 'material-labour', 'escalation_no' => $escalation->escalation_no]) }}" style="color: #303333">--}}
{{--                    Material Labour Cost--}}
{{--                </a>--}}
{{--            </td>--}}
{{--            <td>@money($escalation->material_labour_changed_total_amount)</td>--}}
{{--            <td>@money(($escalation->material_labour_changed_total_amount)/$total_area)</td>--}}
{{--        </tr>--}}
{{--        <tr style="background-color: {{ $bgColor }};">--}}
{{--            <td>--}}
{{--                <a href="{{ route('boq.project.departments.civil.previous.revised-sheet', ['project' => $project, 'budget_type' => 'other', 'escalation_no' => $escalation->escalation_no]) }}" style="color: #303333">--}}
{{--                    Other Cost--}}
{{--                </a>--}}
{{--            </td>--}}
{{--            <td>@money($escalation->other_changed_total_cost)</td>--}}
{{--            <td>@money(($escalation->other_changed_total_cost)/$total_area)</td>--}}
{{--        </tr>--}}
{{--        @endforeach--}}
{{--        </tbody>--}}
{{--    </table>--}}
@endsection
