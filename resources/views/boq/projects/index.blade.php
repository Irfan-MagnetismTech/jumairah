@extends('boq.layout.app')
@section('title', 'BOQ - Project Home')
@section('project-name')
    <a href="#" style="color:white;">{{ $project->name }}</a>
@endsection

@section('content-grid', 'col-12')

@section('content')
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
                <td colspan="3">
                    <h6>Total buildup area - {{ number_format($project->boqFloorProjects()->sum('area'), 2) }} Sft</h6>
                </td>
            </tr>
            @if ($project->boqFloorProjects()->sum('area') <= 0)
                <tr>
                    <td colspan="3">
                        <strong class="text-danger"><span class="text-danger">*</span> Please input build up area for this
                            project</strong>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <table class="table table-bordered">
        <thead>
            <tr>
                {{--            <th>Parts</th> --}}
                <th>Summary Report</th>
                {{--            <th>Total Budget</th> --}}
            </tr>
        </thead>
        <tbody>
            <tr>
                {{--            <td>Civil</td> --}}
                <td>
                    <ul style="text-align: left;margin-left: 20px;line-height: 25px">
                        <li>
                            <strong>1.<a style="margin-left: 5px"
                                    href="{{ route('boq.project.construction-abstract-sheet', ['project' => $project]) }}">Abstract</a></strong>
                        </li>
                        <li><strong>2.<a href="#"> Material Summary</a></strong>
                            <ol type="A">
                                <li><a style="margin-left: 5px"
                                        href="{{ route('boq.project.departments.civil.cost_analysis.floor_wise.material.summary', ['project' => $project]) }}">Civil</a>
                                </li>
                                <li><a style="margin-left: 5px"
                                        href="{{ route('boq.project.departments.electrical.cost_analysis.floor_wise.material.summary', ['project' => $project]) }}">EME</a>
                                </li>
                                <li><a style="margin-left: 5px"
                                        href="{{ route('boq.project.departments.sanitary.cost_analysis.floor_wise.material.summary', ['project' => $project]) }}">Sanitary</a>
                                </li>
                            </ol>
                        </li>
                        <li>3.<a style="margin-left: 5px"
                                href="{{ route('boq.project.material-specifications.index', ['project' => $project]) }}">Material
                                Specification Sheet</a></li>
                        <li>4. Material Price List
                            <ol type="A">
                                <li>
                                    <a style="margin-left: 5px"
                                        href="{{ route('boq.project.departments.civil.configurations.projectwise-material-price.index', ['project' => $project]) }}">Civil</a>
                                </li>
                                <li>
                                    <a href="{{ route('boq.project.departments.electrical.configurations.projectwise-material-price.index', ['project' => $project]) }}"
                                        style="margin-left: 5px">EME
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('boq.project.departments.sanitary.configurations.projectwise-material-price.index', ['project' => $project]) }}"
                                        style="margin-left: 5px">Sanitary</a>
                                </li>
                            </ol>
                        </li>

                        {{--                    <li>4.<a style="margin-left: 5px" href="{{ route('boq.project.construction-cost-summary', ['project' => $project]) }}" target="_blank">Cost Summary</a></li> --}}
                        {{--                    <li>4.<a style="margin-left: 5px" target="_blank" href="{{ route('boq.project.departments.civil.cost_analysis.percentage_sheet.floorwise', ['project' => $project]) }}">Percentage Sheet Floor Wise</a></li> --}}
                        {{--                    <li>5.<a style="margin-left: 5px" target="_blank" href="{{ route('boq.project.departments.civil.cost_analysis.percentage_sheet.workwise', ['project' => $project]) }}">Percentage Sheet Item Wise</a></li> --}}
                    </ul>
                </td>
                {{--            <td>@money($total_civil_cost)</td></tr> --}}
                {{--        <tr> --}}
                {{--            <td>EME</td> --}}
                {{--            <td>---</td> --}}
                {{--            <td>@money($emeAmount = $BoqEmeCalculationDetails->sum('total_amount'))</td> --}}
                {{--        </tr> --}}
                {{--        <tr> --}}
                {{--            <td>Sanitary</td> --}}
                {{--            <td>---</td> --}}
                {{--            <td>@money($sanitaryAmount = $project->sanitaryBudgetSummary->total_amount ?? 0)</td> --}}
                {{--        </tr> --}}
            <tr class="">
                <th colspan="">Summary Report</th>
            </tr>
        </tbody>
    </table>
@endsection
