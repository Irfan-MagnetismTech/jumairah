@extends('layouts.backend-layout')
@section('title', 'Cost Incurred')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    Cost Incurred in {{$year}}
@endsection

@section('breadcrumb-button')
    {{-- <a href="{{ url('bd-inventory-pdf') }}/{{ $bd_inventory_details[0]->bd_inventory_id }}" title="PDF" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a> --}}
@endsection


    @section('content')

            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                @php
                    $month_array = ['January','February','March','April','May','June','July','August','September','October','November','December'];
                @endphp
                <tr>
                    <th rowspan="2">SL No </th>
                    <th rowspan="2">Description</th>
                    @for ($i = 1; $i <= $total_month; $i++)
                        <th colspan="2">{{ $month_array[$i-1] }}</th>
                    @endfor

                    <th colspan="2">Total upto {{ $month_array[$total_month-1] }}</th>
                    <th rowspan="2">Yearly <br/> Targeted <br/> Budget </th>
                    <th rowspan="2">Total Yearly <br/> Achievement</th>
                    {{-- <th colspan="2">Total<br>Up to month</th> --}}
                </tr>
                <tr>
                    @for ($i = 1; $i <= $total_month; $i++)
                        <th >Target</th>
                        <th >Achivement</th>
                    @endfor
                     <th >Target</th>
                    <th >Achivement</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Cost Incurred in Tk</td>
                        @php
                            $total_target = 0;
                            $total_achievement = 0;
                            $total_target_in_sft = 0;
                            $total_achievements_in_sft = 0;
                        @endphp
                    @foreach($totalmonthlyAchievements as $key => $totalmonthlyAchievement)
                    <td>{{ $totalmonthlyAchievement['target'] }}</td>
                    <td> {{ $totalmonthlyAchievement['achievements'] }} </td>
                        @php
                            $total_target += $totalmonthlyAchievement['target'];
                            $total_achievement += $totalmonthlyAchievement['achievements'];
                            $total_target_in_sft += $totalmonthlyAchievement['target_in_sft'];
                            $total_achievements_in_sft += $totalmonthlyAchievement['achievements_in_sft'];
                        @endphp
                    @endforeach
                    <td>{{ $total_target }}</td>
                    <td>{{ $total_achievement }}</td>
                    <td>{{ $tentative_budget_total }}</td>
                    <td rowspan="2">
                        @if ($total_cost_as_per_boq && ($total_target/$total_cost_as_per_boq*$total_area_in_sft))
                            {{ number_format($total_achievements_in_sft/($total_target/$total_cost_as_per_boq*$total_area_in_sft)*100,2) }} %
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Cost Incurred in SFT</td>
                    @foreach($totalmonthlyAchievements as $key => $totalmonthlyAchievement)
                    <td> {{ number_format($totalmonthlyAchievement['target_in_sft'], 2 )}} </td>
                    <td>{{ number_format($totalmonthlyAchievement['achievements_in_sft'], 2 )}}</td>
                    @endforeach
                    <td>{{ number_format($total_target_in_sft, 2 ) }}</td>
                    <td>{{ number_format($total_achievements_in_sft, 2 ) }}</td>
                    <td>
                        @if ($total_cost_as_per_boq)
                            {{ number_format($total_target / $total_cost_as_per_boq * $total_area_in_sft, 2 ) }}
                        @else
                            N/A
                        @endif
                    </td>
                 </tr>
                <tr>
                    <td>3</td>
                    <td>In Percentage (%)</td>
                    @foreach($totalmonthlyAchievements as $key => $totalmonthlyAchievement)
                        @php
                            if ($totalmonthlyAchievement['target_in_sft']) {
                                $percentage = $totalmonthlyAchievement['achievements_in_sft'] / $totalmonthlyAchievement['target_in_sft'] * 100;
                            }else{
                                $percentage = 0;
                            }
                        @endphp
                    <td> </td>
                    <td>{{ number_format($percentage, 2 )}} %</td>
                    @endforeach
                    <td></td>
                    <td>
                        @if ($total_target_in_sft)
                            {{ number_format($total_achievements_in_sft / $total_target_in_sft * 100, 2 ) }} %
                        @else
                            N/A
                        @endif
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(window).scroll(function () {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function () {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function () {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>

@endsection
