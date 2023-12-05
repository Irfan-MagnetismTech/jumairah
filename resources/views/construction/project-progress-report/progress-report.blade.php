@extends('layouts.backend-layout')
@section('title', 'Project Progress Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Project Progress Report
@endsection

@section('content')
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th rowspan="2">SL No</th>
                    <th rowspan="2">Project Name</th>
                    <th rowspan="2">Date of <br>Inception</th>
                    <th rowspan="2">Estimated date <br>of Completion</th>
                    <th rowspan="2">Total area in SFT</th>
                    <th rowspan="2">Total cost as per BOQ</th>
                    <th colspan="3">Target</th>
                    <th colspan="3">Achivement</th>
                    <th rowspan="2">% of <br>target</th>
                    <th rowspan="2">% of <br>completion</th>
                    <th rowspan="2">Per SFT <br>Cost</th>
                    <th rowspan="2">Monthly <br>Target Area</th>
                    <th rowspan="2">Monthly <br>Achivement <br>Area</th>
                    <th rowspan="2">Total Buildup Area</th>
                    <th rowspan="2">Remainning<br> portion (sft)</th>
                    <th rowspan="2">% of completion</th>
                    <th rowspan="2">% of remaining (in sft)</th>
                </tr>
                <tr>

                    <th>Labor Cost</th>
                    <th>Material Cost</th>
                    <th>Total Cost</th>
                    <th>Labor Cost</th>
                    <th>Material Cost</th>
                    <th>Total Cost</th>
                </tr>
                <tr class="text-center">
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>
                    <td>7</td>
                    <td>8</td>
                    <td>9</td>
                    <td>10</td>
                    <td>11</td>
                    <td>12</td>
                    <td>13</td>
                    <td>14</td>
                    <td>15</td>
                    <td>16</td>
                    <td>17</td>
                    <td>18</td>
                    <td>19</td>
                    <td>20</td>
                    <td>21</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $key => $project)
                    @php
                        $tentative_budget_total = $projects[$key]['tentative_budget_labor_cost'] + $projects[$key]['tentative_budget_material_cost'];
                        $total_achivement_cost = $projects[$key]['labors'] + $projects[$key]['material'] ?? '';
                        $remaining_portion_in_sft = $projects[$key]['totalConstructionArea'] - $projects[$key]['cumulative_total_buildup_area'];
                    @endphp
                    <tr>
                        <td> {{ $loop->iteration }}</td>
                        <td> {{ $projects[$key]['costCenter'] }}</td>
                        <td> {{ $projects[$key]['inceptionDate'] ?? '' }}</td>
                        <td> {{ $projects[$key]['completionDate'] ?? '' }}</td>
                        <td> {{ $projects[$key]['totalConstructionArea'] ?? '' }}</td>
                        <td> {{ number_format($projects[$key]['total_projet_cost'], 2) ?? '' }}</td>
                        <td> {{ $projects[$key]['tentative_budget_labor_cost'] }}</td>
                        <td> {{ $projects[$key]['tentative_budget_material_cost'] }}</td>
                        <td> {{ $tentative_budget_total }} </td>
                        <td> {{ $projects[$key]['labors'] ?? '' }}</td>
                        <td> {{ $projects[$key]['material'] ?? '' }}</td>
                        <td> {{ $total_achivement_cost }}</td>

                        <td>
                            @if ($projects[$key]['total_projet_cost'] > 0 && $tentative_budget_total > 0)
                                @php
                                    $percent_of_target = ($tentative_budget_total / $projects[$key]['total_projet_cost']) * 100;
                                    echo number_format($percent_of_target, 2) . '%';
                                    // echo $percent_of_target;
                                @endphp
                            @endif

                        </td>
                        <td>
                            @if ($projects[$key]['total_projet_cost'] > 0 && $total_achivement_cost > 0)
                                @php
                                    $percent_of_completion = ($total_achivement_cost / $projects[$key]['total_projet_cost']) * 100;
                                    echo number_format($percent_of_completion, 2) . '%';
                                @endphp
                            @endif
                        </td>
                        <td>
                            @if ($projects[$key]['total_projet_cost'] > 0 && $projects[$key]['totalConstructionArea'] > 0)
                                @php
                                    $per_sft_cost = $projects[$key]['total_projet_cost'] / $projects[$key]['totalConstructionArea'];
                                    echo number_format($per_sft_cost, 2);
                                @endphp
                            @endif
                        </td>
                        <td>
                            @if ($projects[$key]['total_projet_cost'] > 0 && $tentative_budget_total > 0)
                                @php
                                    $percent_of_target = ($tentative_budget_total / $projects[$key]['total_projet_cost']) * 100;
                                    $monthly_target_area = $percent_of_target* $projects[$key]['totalConstructionArea'];
                                    echo number_format($monthly_target_area, 2);
                                @endphp
                            @endif
                        </td>
                        <td>
                            @if ($projects[$key]['total_projet_cost'] > 0 && $total_achivement_cost > 0)
                                @php
                                    $percent_of_completion = ($total_achivement_cost / $projects[$key]['total_projet_cost']) * 100;
                                    $monthly_achivement_area = number_format($percent_of_completion, 2) * $projects[$key]['totalConstructionArea'];
                                    echo number_format($monthly_achivement_area, 2);
                                @endphp
                            @endif
                        </td>
                        <td>{{ $projects[$key]['cumulative_total_buildup_area'] }}</td>
                        <td> {{ $remaining_portion_in_sft }} </td>
                        <td>
                            @if ($projects[$key]['cumulative_total_buildup_area'] > 0 && $projects[$key]['totalConstructionArea'] > 0)
                                @php
                                    $percent_of_total_completion = ($projects[$key]['cumulative_total_buildup_area'] / $projects[$key]['totalConstructionArea']) * 100;
                                    echo number_format($percent_of_total_completion, 2) . '%';
                                @endphp
                            @endif
                        </td>
                        <td>
                            @if ($remaining_portion_in_sft > 0 && $projects[$key]['totalConstructionArea'] > 0)
                                @php
                                    $percent_of_total_remainning = ($remaining_portion_in_sft / $projects[$key]['totalConstructionArea']) * 100;
                                    echo number_format($percent_of_total_remainning, 2) . '%';
                                @endphp
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function() {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>

@endsection
