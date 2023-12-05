@extends('boq.layout.app')
@section('title', 'BOQ - Abstract Sheet')
@section('project-name')
    <a href="#" style="color:white;">{{ $project->name }}</a>
@endsection

@section('content-grid', 'col-12')

@section('content')
    <style>
        .download_pdf {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 0px;
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
                    <h6>Total Construction Area - {{ number_format($project->boqFloorProjects()->sum('area'), 2) }} Sft</h6>
                    {{--                    <a style="float: right" target="_blank" href="{{ route('boq.project.download-construction-abstract-sheet.floor-wise.', ['project' => $project]) }}" data-toggle="tooltip" title="" class="btn btn-outline-danger download_pdf" data-original-title="Download PDF"><i class="fas fa-file-pdf"></i></a> --}}
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="4">
                    <h5>Abstract of Cost</h5>
                </th>
            </tr>
            <tr>
                <th>SL</th>
                <th>Cost Head</th>
                <th>Amount</th>
                <th>Cost Per Sft</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>A.</strong></td>
                <td class="text-left">
                    <a href="{{ route('boq.project.construction-cost-summary-civil', ['project' => $project]) }}"><strong>CIVIL
                            WORKS</strong></a>
                </td>
                <td class="text-right font-weight-bold">@money($total_cost)</td>
                <td class="text-right font-weight-bold">@money($total_cost / $total_area)</td>
            </tr>
            {{-- @php
        $total_civil_price_escalation = 0;
        @endphp
        @foreach ($civil_price_escalations as $index => $civil_escalation)
        <tr>
            <td></td>
            <td class="text-left">
                <a href="{{ route('boq.project.departments.civil.previous.revised-sheet', ['project' => $project, 'escalation_no' => $civil_escalation->escalation_no]) }}">Price Escalation - {{ $civil_escalation->escalation_no }}</a>
            </td>
            <td class="text-right font-weight-bold">@money($civil_escalation->changed_total_amount)</td>
            <td class="text-right font-weight-bold">@money(($civil_escalation->changed_total_amount)/$total_area)</td>
        </tr>
        @php
        $total_civil_price_escalation += $civil_escalation->changed_total_amount;
        @endphp
        @endforeach --}}
            <tr>
                <td><strong>B.</strong></td>
                <td class="text-left">
                    <a href="{{ route('boq.project.departments.sanitary.home', ['project' => $project]) }}"><strong>SANITARY
                            & PLUMBING WORKS</strong></a>
                </td>
                <td class="text-right font-weight-bold">@money($sanitery_total)</td>
                <td class="text-right font-weight-bold">@money($sanitery_total / $total_area)</td>
            </tr>
            <tr>
                <td><strong>C.</strong></td>
                <td class="text-left">
                    <a href="{{ route('boq.project.departments.electrical.home', ['project' => $project]) }}"><strong>EME
                            WORKS</strong></a>
                </td>
                <td class="text-right font-weight-bold">@money($eme_total)</td>
                <td class="text-right font-weight-bold">@money($eme_total / $total_area)</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th class="text-left">TOTAL CONSTRUCTION COST</th>
                <th class="text-right">@money($total_cost + $sanitery_total + $eme_total)</th>
                <th class="text-right">@money(($total_cost + $sanitery_total + $eme_total) / $total_area)</th>
            </tr>
        </tfoot>
    </table>

    @php
        $total_civil_price_escalation = 0;
        $changed_amount_total = 0;
    @endphp
    @foreach ($civil_price_escalations as $index => $civil_escalation)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="4" style="background-color: rgba(5, 117, 27, 0.842)">
                        <h6>Price Escalation {{ $civil_escalation->escalation_no }}</h6>
                    </th>
                </tr>
                <tr>
                    <th>SL</th>
                    <th>Cost Head</th>
                    <th>Amount</th>
                    <th>Cost Per Sft</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $civil_price = $civil_escalation->changed_total_amount;
                    if ($sanitary_price_escalation->has($index)) {
                        $sanitary_price = $sanitary_price_escalation[$index]?->total_amount;
                    }else {
                        $sanitary_price = 0;
                    }

                @endphp
                <tr>
                    <td><strong>A.</strong></td>
                    <td class="text-left">
                        <a
                            href="{{ route('boq.project.departments.civil.previous.revised-sheet', ['project' => $project, 'escalation_no' => $civil_escalation->escalation_no]) }}">CIVIL
                            WORKS</a>
                    </td>
                    <td class="text-right font-weight-bold">@money($civil_price)</td>
                    <td class="text-right font-weight-bold">@money($civil_price / $total_area)</td>
                </tr>
                <tr>
                    <td><strong>B.</strong></td>
                    <td class="text-left">
                        SANITARY & PLUMBING WORKS
                    </td>
                    <td class="text-right font-weight-bold">@money($sanitary_price)</td>
                    <td class="text-right font-weight-bold">@money($sanitary_price / $total_area)</td>
                </tr>
                <tr>
                    <td><strong>C.</strong></td>
                    <td class="text-left">EME WORKS
                    </td>
                    <td class="text-right font-weight-bold">@money(0)</td>
                    <td class="text-right font-weight-bold">@money(0)</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th class="text-left">TOTAL COST OF ESCALATION - {{ $civil_escalation->escalation_no }}</th>
                    <th class="text-right">@money($civil_price + $sanitary_price)</th>
                    <th class="text-right">@money(($civil_price + $sanitary_price) / $total_area)</th>
                </tr>
                @php
                    $changed_amount_total += $civil_price + $sanitary_price;
                @endphp
                <tr>
                    <th></th>
                    <th class="text-left">TOTAL CONSTRUCTION COST</th>
                    <th class="text-right">@money($total_cost + $sanitery_total + $eme_total + $changed_amount_total)</th>
                    <th class="text-right">@money(($total_cost + $sanitery_total + $eme_total + $changed_amount_total) / $total_area)</th>
                </tr>
            </tfoot>
        </table>
    @endforeach
@endsection
