@extends('layouts.backend-layout')
@section('title', 'Monthly budget report')
@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection
@section('breadcrumb-title')
Monthly budget report
@endsection
@section('breadcrumb-button')
{{--    <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>--}}
@endsection
@section('sub-title')
{{--Total: {{ count($projects) }}--}}
@endsection
@section('content-grid')
@section('content')
<form action="{{route('admin-monthly-budgets-report')}}" method="post">
    @csrf
    <div class="row px-2">
        <div class="col-md-1 px-1 my-1 my-md-0" data-toggle="tooltip" title="Output">
            <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                <option value="list" selected> List </option>
                <option value="pdf"> PDF </option>
            </select>
        </div>
        <div class="col-md-3 px-1 my-1 my-md-0">
            {{ Form::month('month', old('month') ? old('month') : (!empty($query_month) ? $query_month : now()->format('m')), ['class' => 'form-control form-control-sm', 'id' => 'yeamonthr', 'autocomplete' => 'off', 'required', 'placeholder' => 'Month', ]) }}
        </div>
        <div class="col-md-1 px-1 my-1 my-md-0">
            <div class="input-group input-group-sm">
                <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
            </div>
        </div>
        </div><!-- end row -->
    </form>
    <div class="tableHeading">
        <h5> <span>&#10070;</span> Yearly Sales Plan - {{$query_month}} <span>&#10070;</span> </h5>
    </div>
    <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Particular</th>
                        <th>Week One</th>
                        <th>Week Two</th>
                        <th>Week Three</th>
                        <th>Week Four</th>
                        <th>Week Five</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody class="text-right">
                    @php $total = 0; @endphp
                    @if (!empty($budgets->adminMonthlyBudgetDetails))
                    @foreach($budgets->adminMonthlyBudgetDetails as $key => $budget)
                    @php $totalSales = 0; $totalBooking = 0; @endphp
                    <tr>
                        <td class="text-left">{{$budget->budgetHead->name }}</td>
                        <td class="text-left">{{$budget->week_one}}</td>
                        <td class="text-left">{{$budget->week_two}}</td>
                        <td class="text-left">{{$budget->week_three}}</td>
                        <td class="text-left">{{$budget->week_four}}</td>
                        <td class="text-left">{{$budget->week_five}}</td>
                        <td>@money($budget->week_one + $budget->week_two + $budget->week_three + $budget->week_four + $budget->week_five)</td>
                    </tr>
                    @endforeach
                    @endif
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
