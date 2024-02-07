@extends('layouts.backend-layout')
@section('title', 'Project Wise Lead Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
    <style>
        #tableArea{margin-top: 10px;margin-bottom: 10px;}
        table, table th, table td {border-spacing: 0;border: 1px solid #a09e9e;}
        table th, table td{padding:5px;}
        .base_header{font-weight: bold; text-align: left;}
        .balance_header{font-weight: bold; padding-left:20px; text-align: left; }
        .balance_line{ font-weight: bold; padding-left:50px; text-align: left; }
        .account_line{ padding-left:80px;  text-align: left; }
        table tbody td:nth-child(4),table tbody td:nth-child(3){
            text-align: right;
        }
        .text-right{
            text-align: right;
        }
        .text-right{
            text-align: left;
        }
        .account_row{display: none}
    </style>

@endsection

@section('breadcrumb-title')
    Project Wise Categories Report
@endsection

@section('breadcrumb-button')
    {{-- <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}}
@endsection

@section('sub-title')
    {{--Total: {{ count($projects) }}--}}
@endsection


@section('content')
    <form action="" method="get">
        <div class="row px-2">
            <div class="col-md-1 px-1 my-1" data-toggle="tooltip" title="Output">
                <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                    <option value="list" selected> List </option>
                    <option value="pdf"> PDF </option>
                </select>
            </div>
            <div class="col-md-2 px-1 my-1" id="fromDateArea">
                <input type="month" id="month" name="month" class="form-control form-control-sm" value="{{!empty($request->month) ? date('Y-m', strtotime($request->month)): ''}}" placeholder="From Date" autocomplete="off">
            </div>
            <div class="col-md-1 px-1 my-1">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>
    <br>
    @if($projectleads)
    {{-- <h2 class="text-center"> </h2> --}}
    <div class="table-responsive">
        <table style="width: 100%">
            <thead>
                <tr style="text-align: center; background:#116A7B; color: white; font-weight: bold">
                    <td>#</td>
                    <td>Project Name </td>
                    <td>Location </td>
                    <td> Priority Stage </td>
                    <td> Negotiation Stage </td>
                    <td> Lead Stage </td>
                    <td> Closed Lead</td>
                    <td> Total Leads </td>
                </tr>
            </thead>
            <tbody>
                @foreach ($projectleads as $key => $lead)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-left"> {{ $lead['projectName'] }} </td>
                        <td class="text-left"> {{ $lead['projectLocation'] }} </td>
                        <td class="text-right"> {{ $lead['leadStages']->has('A') ? $lead['leadStages']['A'] : 0 }} </td>
                        <td class="text-right"> {{ $lead['leadStages']->has('B') ? $lead['leadStages']['B'] : 0 }} </td>
                        <td class="text-right"> {{ $lead['leadStages']->has('C') ? $lead['leadStages']['C'] : 0 }} </td>
                        <td class="text-right"> {{ $lead['leadStages']->has('D') ? $lead['leadStages']['D'] : 0 }} </td>
                        <td class="text-right"> {{ $lead['projectTotalLeads'] }} </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-warning">
                    <td class="text-right" colspan="3"> <strong> Total </strong> </td>
                    <td class="text-right"> {{ $projectleads->pluck('leadStages')->pluck('A')->sum() }}</td>
                    <td class="text-right"> {{ $projectleads->pluck('leadStages')->pluck('B')->sum() }}</td>
                    <td class="text-right"> {{ $projectleads->pluck('leadStages')->pluck('C')->sum() }}</td>
                    <td class="text-right"> {{ $projectleads->pluck('leadStages')->pluck('D')->sum() }}</td>
                    <td class="text-right"> {{ $projectleads->pluck('projectTotalLeads')->sum() }} </td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endif
@endsection

@section('script')
    <script>
        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {
            $('#month').on('change', function(){
                $("#fromDate").val('');
                $("#tillDate").val('');
            })
        });//document.ready
    </script>
@endsection
