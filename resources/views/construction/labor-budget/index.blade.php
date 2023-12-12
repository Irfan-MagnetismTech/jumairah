@extends('layouts.backend-layout')
@section('title', 'Labor Budget')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection




@section('breadcrumb-button')
    <a href="{{ url('construction/labor-budget-pdf') }}/{{ $year }}/{{ $month }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a>
@endsection


    @section('content')
            <!-- put search form here.. -->
    <div class="row">
        <div class="col-md-12 col-xl-12 text-center">
            <img src="{{ asset(config('company_info.logo')) }}">
            <div class="clearfix"></div>
            <h6>{!! htmlspecialchars(config('company_info.company_address')) !!}</h6>
        </div>
    </div>

    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Contractor Name</th>
                    <th>Type of work</th>
                    <th>Bill no.</th>
                    <th>Billing Dept.</th>
                    <th>Bill in Audit Dept.</th>
                    <th>Bill in A/C Dept.</th>
                    <th>1st Week</th>
                    <th>2nd Week</th>
                    <th>3rd Week</th>
                    <th>4th Week</th>
                    <th>Remarks</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $bill_total = $week_total = $bill_sum = $audit_sum = $accounts_sum = $first_week = $second_week = $third_week = $fourth_week = 0;
                    $listing_project = 0;
                    $listing_project_details = count($budget_details);
                @endphp
                @forelse ($budget_details as $key => $budget_detail)

                    @foreach ($budget_detail as $data)
                        @php
                            $bill_total += $data->bill_amount;
                            if ($data->week == 1 || $data->week == 2 || $data->week == 3 || $data->week == 4)
                            $week_total += $data->bill_amount;
                        @endphp
                        @if ($data->status == "")
                            @php
                                $bill_sum += $data->bill_amount;
                            @endphp
                        @elseif ($data->status == "Accepted")
                            @php
                                $audit_sum += $data->bill_amount;
                            @endphp
                        @else
                            @php
                                $accounts_sum += $data->bill_amount;
                            @endphp
                        @endif

                        @if ($data->week === 1)
                            @php
                                $first_week += $data->bill_amount;
                            @endphp
                        @elseif ($data->week === 2)
                            @php
                                $second_week += $data->bill_amount;
                            @endphp
                        @elseif ($data->week === 3)
                            @php
                                $third_week += $data->bill_amount;
                            @endphp
                        @elseif ($data->week === 4)
                            @php
                                $fourth_week += $data->bill_amount;
                            @endphp
                        @endif

                    @endforeach
                    @foreach ($budget_detail as $data)

                        <tr >
                            @if ($loop->first)
                                <td rowspan="{{count($budget_detail)}}" style="background-color: rgb(119, 173, 11)">{{$data->project?->name}}</td>
                            @endif
                            <td>{{$data->supplier->name}}</td>
                            <td>{{$data->work_type}}</td>
                            @if (empty($data->bill_no))
                                <td>{{ "Upcome" }}</td>
                            @else
                                <td>{{ $data->bill_no }}</td>
                            @endif
                            @if ($data->status == "")
                                <td >{{$data->bill_amount}}</td>
                            @else
                                <td></td>
                            @endif

                            @if ($data->status == "Accepted")
                                <td>{{$data->bill_amount}}</td>
                            @else
                                <td></td>
                            @endif

                            @if ($data->status == "Checked")
                                <td>{{$data->bill_amount}}</td>
                            @else
                             <td></td>
                            @endif

                            @if ($data->week == 1)
                            <td style="color: red">{{$data->bill_amount}}</td>
                            @else
                            <td></td>
                            @endif
                            @if ($data->week == 2)
                            <td>{{$data->bill_amount}}</td>
                            @else
                            <td></td>
                            @endif
                            @if ($data->week == 3)
                            <td>{{$data->bill_amount}}</td>
                            @else
                            <td></td>
                            @endif
                            @if ($data->week == 4)
                            <td>{{$data->bill_amount}}</td>
                            @else
                            <td></td>
                            @endif
                            <td>Unpaid</td>
                        </tr>
                    @endforeach
                    @php
                    $listing_project++;
                    @endphp


                    @if($listing_project_details == $listing_project)

                    @foreach ($project_data as $project)
                        <tr>
                            <td style="background-color: rgb(119, 173, 11)">{{ $project->name }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                    @endif

                @empty

                @endforelse
                <tr class="bg-primary">
                    <td colspan="4">Total</td>
                    <td>{{ ($bill_sum > 0) ? $bill_sum : null }}</td>
                    <td>{{ ($audit_sum > 0) ? $audit_sum : null }}</td>
                    <td>{{ ($accounts_sum > 0) ? $accounts_sum : null }}</td>
                    <td>{{ ($first_week > 0) ? $first_week : null }}</td>
                    <td>{{ ($second_week > 0) ? $second_week : null }}</td>
                    <td>{{ ($third_week > 0) ? $third_week : null }}</td>
                    <td>{{ ($fourth_week > 0) ? $fourth_week : null }}</td>
                    <td></td>
                </tr>
                <tr class="bg-primary">
                    <td colspan="4">Total Bill Amount, Tk</td>
                    <td colspan="3">{{ ( $bill_total > 0 ) ? $bill_total : null }}</td>
                    <td colspan="6">{{ ( $week_total > 0 ) ? $week_total : null }}</td>
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

        $(document).ready(function(){
        $(".pending").click(function(){
            if (!confirm("Do you want to approve?")){
                return false;
            }
        });
    });
    </script>
@endsection
