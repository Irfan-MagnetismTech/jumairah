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
    <form action="{{route('admin-yearly-budgets-report')}}" method="post">
        @csrf
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

                    <th>Particular</th>
                    @foreach($months as $month)
                    <th>{{date('M', strtotime("$year-$month"))}}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
            </thead>
            <tbody class="text-right">
            @php $total = 0; @endphp
            @foreach($budgets as $key => $budget)
                @php $totalSales = 0; $totalBooking = 0; @endphp
                <tr>
                    @foreach($budget['budget_heads'] as $head)
                    @php $particular = App\Config\BudgetHead::where('id',$head)->first(); @endphp
                    <td class="text-left">{{$particular->name}}</td>
                    @endforeach
                    @foreach($budget['yearlyBudgets'] as $yearlyBudget)
                        <td>@money($yearlyBudget["amount"])</td>
                        @php($totalSales += $yearlyBudget["amount"])
                    @endforeach
                    <td class="text-right">@money($totalSales)</td>
                </tr>
                <?php $total += $totalSales; ?>
            @endforeach
            <tr>
                    <td colspan="13">Total</td>
                    <td>@money($total)</td>

                </tr>
            </tbody>

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
