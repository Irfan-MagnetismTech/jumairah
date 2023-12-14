
@extends('boq.layout.app')
@section('title', 'BOQ - Civil Cost Summary')
@section('project-name')
    <a href="#" style="color:white;">{{ $project->name }}</a>
@endsection

@section('content-grid', 'col-12')

@section('content')
    <style>
        .download_pdf{
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 0px;
        }
    </style>
    <style>
        .table td {
            padding-left: 20px !important;
        }
        a {
            font-size: 12px;
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
            <td colspan="3" style="position: relative">
                <h6>Total Land Area - {{ $project->landsize }} Kata</h6>
                <h6>Total Construction Area - {{ number_format($project->boqFloorProjects()->sum('area'),2) }}  Sft</h6>
                <a style="float: right" target="_blank" href="{{ route('boq.project.download-construction-cost-summary-civil', ['project' => $project]) }}" data-toggle="tooltip" title="" class="btn btn-outline-danger download_pdf" data-original-title="Download PDF"><i class="fas fa-file-pdf"></i></a>
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
    <?php
    $emeAmount = $BoqEmeCalculationDetails->sum('total_amount');
    $sanitaryAmount = $project->sanitaryBudgetSummary->total_amount ?? 0;
    $totalConstructionCostPercentage = (($sanitaryAmount + $total_civil_cost + $emeAmount)/$project->boqFloorProjects()->sum('area')) ?? 0;
    ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th colspan="3" style="font-size: 16px">COST SUMMARY</th>
        </tr>
        <tr>
            <th>SL NO</th>
            <th>NAME OF ITEM</th>
            <th>AMOUNT IN (TK)</th>
        </tr>
        </thead>
        <tbody style="text-align: left">
                <tr style="font-weight: bold">
                    <td>A.</td>
                    <td>PILING WORKS</td>
                    <td></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>
                        <a id="pilingworkmateriallink" href="#">PILING WORKS (Materials)</a>
                    </td>
                    <td style="text-align: center">@money($material_piling_amount)</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>
                        <a id="pilingworklabourlink" href="#">PILING WORKS (Labour)</a>
                    </td>
                    <td style="text-align: center">@money($labour_piling_amount)</td>
                </tr>
                <tr style="font-weight: bold">
                    <td>B.</td>
                    <td>CIVIL WORKS</td>
                    <td></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>
                        <a href="{{ route('boq.project.departments.civil.cost_analysis.floor_wise.material.costs', ['project' => $project]) }}">CIVIL WORKS (Material Cost)</a>
                    </td>
                    <td style="text-align: center">@money($all_cost_summary?->material_total_amount)</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>
                        <a href="{{ route('boq.project.departments.civil.cost_analysis.floor_wise.labour.costs', ['project' => $project]) }}">CIVIL WORKS (Labour Cost)</a>
                    </td>
                    <td style="text-align: center">@money($all_cost_summary?->labour_total_amount)</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>
                        <a href="{{ route('boq.project.departments.civil.cost_analysis.floor_wise.material_labour.costs', ['project' => $project]) }}">CIVIL WORKS (Material & Labour Cost)</a>
                    </td>
                    <td style="text-align: center">@money($all_cost_summary?->material_labour_total_amount)</td>
                </tr>
                <tr style="font-weight: bold">
                    <td>C.</td>
                    <td>OTHER COST</td>
                    <td></td>
                </tr>

                @foreach($other_related_costs as $costHead => $amount)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>
                            <a href="{{ route('boq.project.departments.civil.cost_analysis.floor_wise.related_material.costs', ['project' => $project]) }}">
                                {{ $costHead }}
                            </a>
                        </td>
                        <td style="text-align: center">{{ number_format($amount,2) }}</td>
                    </tr>
                @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="3">COST SUMMARY</th>
        </tfoot>
    </table>

    <form id="pilingMaterialForm" action="{{ route('boq.project.departments.civil.cost_analysis.floor_wise.material.costs', ['project' => $project]) }}" method="get" class="col-md-12">

        <input type="hidden" name="boq_floor_id" value="">
        <input type="hidden" name="boq_work_parent_id" value="{{ $material_piling_budget_id?->boq_work_parent_id }}">
        <hr>
    </form>

    <form id="pilingLabourForm" action="{{ route('boq.project.departments.civil.cost_analysis.floor_wise.labour.costs', ['project' => $project]) }}" method="get" class="col-md-12">

        <input type="hidden" name="boq_floor_id" value="">
        <input type="hidden" name="boq_work_parent_id" value="{{ $labour_piling_budget_id?->boq_work_parent_id }}">
        <hr>
    </form>

@endsection

@section('script')
    <script>
        $('#pilingworkmateriallink').on('click', function () {
            $('#pilingMaterialForm').submit();
        });

        $('#pilingworklabourlink').on('click', function () {
            $('#pilingLabourForm').submit();
        });
    </script>
@endsection
