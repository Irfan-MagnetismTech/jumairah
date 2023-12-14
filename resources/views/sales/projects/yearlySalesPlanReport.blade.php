@extends('layouts.backend-layout')
@section('title', 'Yearly Sales Plan ')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    Yearly Sales Plan Report
@endsection

@section('breadcrumb-button')
{{--    <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>--}}
@endsection

@section('sub-title')
    {{--Total: {{ count($projects) }}--}}
@endsection

@section('content-grid')


@section('content')
    <form action="" method="get">
        <div class="row px-2">
            <div class="col-md-1 px-1 my-1 my-md-0" data-toggle="tooltip" title="Output">
                <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                    <option value="list" selected> List </option>
                    <option value="pdf"> PDF </option>
                </select>
            </div>
{{--            @dd($year);--}}
            {{--<div class="col-md-3 px-1 my-1 my-md-0">--}}
                {{--<input type="text" id="project_name" name="project_name" class="form-control form-control-sm" value="{{!empty($request) ? $request->project_name : null}}" placeholder="Enter Project Name" autocomplete="off">--}}
                {{--<input type="hidden" id="project_id" name="project_id" class="form-control form-control-sm" value="{{!empty($request) ? $request->project_id : null}}">--}}
            {{--</div>--}}
            <div class="col-md-3 px-1 my-1 my-md-0">
                <input type="text" id="year" name="year" class="form-control form-control-sm" value="{{$year}}" placeholder="Select Year" autocomplete="off">
            </div>
            <div class="col-md-1 px-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    <div class="tableHeading">
        <h5> <span>&#10070;</span> Yearly Sales Plan - {{$year}} <span>&#10070;</span> </h5>
    </div>
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Particular</th>
                    <th>Hand <br> Over</th>
                    <th>Unsold</th>
                    <th>Closing <br> Inventory</th>
                    @foreach($months as $month)
                    <th>{{date('M', strtotime("$year-$month"))}}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
            </thead>
            <tbody class="text-right"> 
            @foreach($budgets as $key => $budget)
                @php $totalSales = 0; $totalBooking = 0; @endphp
                <tr>
                    <td class="text-left" rowspan="2">{{$budget['projects']}}</td>
                    <td class="text-left">Sales Value</td>
                    <td class="text-center" rowspan="2">{{date('M Y', strtotime($budget['hand_over']))}}</td>
                    <td class="text-center" rowspan="2">{{$budget['unsold']}}</td>
                    <td class="text-left" rowspan="2"></td>
                    @foreach($budget['yearlyBudgets'] as $yearlyBudget)
                        <td>@money($yearlyBudget["sales_value"])</td>
                        @php($totalSales += $yearlyBudget["sales_value"])
                    @endforeach
                    <td class="text-right"><strong>@money($totalSales)</strong></td>
                </tr>
                <tr>
                    <td class="text-left">Booking Money</td>
                    @foreach($budget['yearlyBudgets'] as $yearlyBudget)
                        <td>@money($yearlyBudget["bm"])</td>
                        @php($totalBooking += $yearlyBudget["bm"])
                    @endforeach
                    <td class="text-right"><strong>@money($totalBooking)</strong></td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-center"><strong>Total Sales Value</strong></td>
                    @php($grandTotal =0)
                    @foreach($months as $month)
                        <td class="text-right">
                            @if(array_key_exists($month,$monthWiseTotals->toArray()))
                                <strong>@money($monthWiseTotals[$month]['total_sales_value'])</strong>
                                @php($grandTotal += $monthWiseTotals[$month]['total_sales_value'])
                            @else
                                <strong>0.00</strong>
                            @endif
                        </td>
                    @endforeach
                    <td class="text-right"> <strong>@money($grandTotal)</strong></td>
                </tr>
                <tr>
                    <td colspan="5" class="text-center"><strong>Total Booking Money</strong></td>
                    @php($grandTotalBM =0)
                    @foreach($months as $month)
                        <td class="text-right">
                            @if(array_key_exists($month,$monthWiseTotals->toArray()))
                                <strong>@money($monthWiseTotals[$month]['total_bm'])</strong>
                                @php($grandTotalBM += $monthWiseTotals[$month]['total_bm'])
                            @else
                                <strong>0.00</strong>
                            @endif
                        </td>
                    @endforeach
                    <td class="text-right"> <strong>@money($grandTotalBM)</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection

@section('script')
    <script>
        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {
            $("#project_name").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "{{route('projectAutoSuggest')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    $('#project_name').val(ui.item.label);
                    $('#project_id').val(ui.item.value);
                    return false;
                }
            });

            $("#year").datepicker( {
                format: "yyyy",
                startView: "years",
                minViewMode: "years",
                todayHighlight: true,
                autoclose: true
            });
        });//document.ready
    </script>
@endsection
