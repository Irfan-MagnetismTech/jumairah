@extends('layouts.backend-layout')
@section('title', 'Tentative Budget')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection


@section('breadcrumb-title')
   {{-- Tentative Budget For {{ $tentative_budget->first()->first()->first()->applied_year }} --}}
@endsection

@section('breadcrumb-button')
{{--
<a href="{{ url('construction/tentative_budget') }}/{{ $tentative_budget->id }}/edit" data-toggle="tooltip" title="Edit" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-pen"></i></a>

<a href="{{ url('construction/tentative_budget_pdf') }}/{{ $tentative_budget->id }}" title="PDF" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a> --}}



@endsection


    @section('content')
            <!-- put search form here.. -->
            <div class="row">
                <div class="col-md-12 col-xl-12 text-center">

                </div>
            </div>

    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="80px" rowspan="2">Project Name</th>
                    <th colspan="2">January</th>
                    <th colspan="2">February</th>
                    <th colspan="2">March</th>
                    <th colspan="2">April</th>
                    <th colspan="2">May</th>
                    <th colspan="2">June</th>
                    <th colspan="2">July</th>
                    <th colspan="2">August</th>
                    <th colspan="2">September</th>
                    <th colspan="2">October</th>
                    <th colspan="2">November</th>
                    <th colspan="2">December</th>
                    <th rowspan="2">Total</th>
                    <th>Targeted Build <br/> up area</th>
                    <th rowspan="2">Action</th>
                </tr>
                <tr>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Sft</th>
                </tr>
                </thead>

                <tbody style="text-align: center">
                            {{-- @php
                                $material1 = $material2 = $material3 = $material4 = $material5 = $material6 = $material7 = $material8 = $material9 = $material10 = $material11 = $material12 = 0;
                                $labor1 = $labor2 = $labor3 = $labor4 = $labor5 = $labor6 = $labor7 = $labor8 = $labor9 = $labor10 = $labor11 = $labor12 = 0;
                            @endphp  --}}
                            @php
                                for ($i = 1; $i < 13; $i++){
                                    $material[$i] = 0;
                                    $labor[$i] = 0;
                                    
                                }
                                $grand_total = 0;
                                $grand_total_buildup_area = 0;
                            @endphp
                    @foreach ($tentative_budgets as $key => $tentative_budget)
                            
                        <tr>
                            @php
                                $rowtotal = 0;
                            @endphp
                            <td>{{ $tentative_budget->first()->first()->costCenter->name }}</td>
                            @for ($i = 1; $i < 13; $i++)
                                @if (isset($tentative_budget[$i]))
                                    <td>{{ $tentative_budget[$i]->first()->material_cost }}</td>
                                    <td>{{ $tentative_budget[$i]->first()->labor_cost }}</td>
                                    @php
                                        $rowtotal += $tentative_budget[$i]->first()->material_cost;
                                        $rowtotal += $tentative_budget[$i]->first()->labor_cost;
                                        $material[$i] += $tentative_budget[$i]->first()->material_cost;
                                        $labor[$i] += $tentative_budget[$i]->first()->labor_cost;
                                    @endphp
                                @else
                                    <td>0</td>
                                    <td>0</td>
                                @endif

                            @endfor
                            
                            @php
                            $boq_floor_total = $tentative_budget->first()->first()->costCenter->project->boqFloorProjects->sum('area');
                            $boq_civil_total = $tentative_budget->first()->first()->costCenter->project->boqCivilBudgets->sum('total_amount');
                            if($boq_floor_total == 0){
                                $boq_floor_total = 1;
                            }
                            if($boq_civil_total == 0){
                                $boq_civil_total = 1;
                            }
                               
                            @endphp
                            <td>{{ $rowtotal }}</td>
                            <td>{{ number_format($rowtotal/$boq_civil_total*$boq_floor_total, 2) }}</td>
                            @php
                                $grand_total += $rowtotal;
                                $grand_total_buildup_area += $rowtotal/$boq_civil_total*$boq_floor_total;
                            @endphp
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        <a href='{{ url("construction/tentative-budget-edit") }}/{{ $tentative_budget->first()->first()->applied_year }}/{{ $tentative_budget->first()->first()->cost_center_id }}' data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    </nobr>
                                    <a href="{{ url("tentativeBudgetLog") }}/{{$tentative_budget->first()->first()->applied_year}}/{{$tentative_budget->first()->first()->cost_center_id}}/{{"log"}}" data-toggle="tooltip" title="Logs" class="btn btn-dark"><i class="fas fa-history"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    {{-- @foreach ($tentative_budget->tentativeBudgetDetails as $key2 => $data)
                        <tr>
                            <td> {{$data->costCenter->name }}</td>
                            <td >{{ $data->january_material }} </td>
                            <td >{{ $data->january_labor }} </td>
                            <td> {{ $data->february_material }} </td>
                            <td> {{ $data->february_labor }} </td>
                            <td> {{ $data->march_material }} </td>
                            <td> {{ $data->march_labor }} </td>
                            <td> {{ $data->april_material }} </td>
                            <td> {{ $data->april_labor }} </td>
                            <td> {{ $data->may_material }} </td>
                            <td> {{ $data->may_labor }} </td>
                            <td> {{ $data->june_material }} </td>
                            <td> {{ $data->june_labor }} </td>
                            <td> {{ $data->july_material }} </td>
                            <td> {{ $data->july_labor }} </td>
                            <td> {{ $data->august_material }} </td>
                            <td> {{ $data->august_labor }} </td>
                            <td> {{ $data->september_material }} </td>
                            <td> {{ $data->september_labor }} </td>
                            <td> {{ $data->october_material }} </td>
                            <td> {{ $data->october_labor }} </td>
                            <td> {{ $data->november_material }} </td>
                            <td> {{ $data->november_labor }} </td>
                            <td> {{ $data->december_material }} </td>
                            <td> {{ $data->december_labor }} </td>
                            <td> {{ $data->amount }} </td>
                            <td> {{ $data->tergeted_build_up_area }} </td>
                        </tr>
                    @endforeach --}}
            </tbody>
 <tfoot>
                <tr>
                    <td colspan="1" style="text-align: center">Total Amount <br/>
                        in Tk</td>
                    @for ($i = 1; $i < 13; $i++)
                        <td style="text-align: center">{{ $material[$i] }}</td>
                        <td style="text-align: center">{{ $labor[$i] }}</td>
                    @endfor
                    <td style="text-align: center">{{ $grand_total }}</td>
                    <td style="text-align: center">{{ number_format($grand_total_buildup_area, 2) }}</td>
                    <td></td>
                </tr> 
            </tfoot>
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

        // $(document).ready(function () {
        //     $('#dataTable').DataTable({
        //         stateSave: true
        //     });
        // });

    //     $(document).ready(function(){
    //     $(".pending").click(function(){
    //         if (!confirm("Do you want to approve?")){
    //             return false;
    //         }
    //     });
    // });
    </script>
@endsection
