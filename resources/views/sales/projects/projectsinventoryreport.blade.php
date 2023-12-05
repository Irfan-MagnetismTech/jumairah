@extends('layouts.backend-layout')
@section('title', 'Projects')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    Project Inventory
@endsection

@section('breadcrumb-button')
{{--    <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>--}}
@endsection

@section('sub-title')
    {{--Total: {{ count($projects) }}--}}
@endsection

@section('content')
    <form action="" method="get">
        <div class="row px-2">
            <div class="col-md-1 px-1 my-1 my-md-0" data-toggle="tooltip" title="Output">
                <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                    <option value="list" selected> List </option>
                    <option value="pdf"> PDF </option>
                </select>
            </div>
            <div class="col-md-2 px-1 my-1 my-md-0" data-toggle="tooltip" title="Project Status">
                <select name="status" id="status" class="form-control form-control-sm" required>
                    @foreach($status as $stat)
                        <option value="{{$stat}}" {{($stat == $current_status) ? "selected" : null}}>{{$stat}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 px-1 my-1 my-md-0" data-toggle="tooltip" title="Project Category">
                <select name="category" id="category" class="form-control form-control-sm" required>
                    @foreach($categories as $category)
                        <option value="{{$category}}" {{($category == $current_category) ? "selected" : null}}>{{$category}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 px-1 my-1 my-md-0">
                <input type="text" id="project_name" name="project_name" class="form-control form-control-sm" value="" placeholder="Enter Project Name" autocomplete="off">
                <input type="hidden" id="project_id" name="project_id" class="form-control form-control-sm" value="">
            </div>
            <div class="col-md-1 px-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    @if($projects)
        <div class="bg-warning mt-2 my-0 p-1">
            <h5 class="text-center"> {{$current_status}} Inventory Report </h5>
        </div>
    @endif


    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr style="vertical-align: middle">
                <th>SL</th>
                <th>Project Name</th>
                <th>Status</th>
                <th>Category</th>
                <th>Total Units</th>
                <th>Unsold Units</th>
                <th>Unsold Space</th>
                <th>Avg. Selling Price</th>
                <th>Parking+Utility</th>
                <th>Total Estimated Value</th>
            </tr>
            </thead>
            <tbody>
            @forelse($projects as $key => $project)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td class="text-left">
                        <strong><a href="{{ url("projects/$project->id") }}" target="_blank"> {{ $project->name}}</a></strong> <br>
                    </td>
                    <td>{{$project->status}}</td>
                    <td>{{$project->category}}</td>
                    <td>{{$project->apartments_count}}</td>
                    <td>{{$project->unsold_apartments_count}}</td>
                    <td>@money($project->unsold_apartments_sum_apartment_size)</td>
                    <td>@money($project->unsold_apartments_avg_apartment_rate)</td>
                    <td>@money($project->total_parking_utility)</td>
                    <td>@money($project->total_estimated_value)</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10"> <h6 class="text-muted my-3"> No Data Found Based on your query. </h6> </td>
                </tr>
            @endforelse
            </tbody>
            @if($projects->isNotEmpty())
            <tfoot>
                <tr class="text-bold">
                    <td colspan="4" class="text-right"> Total </td>
                    <td class="text-center">{{$projects->sum('apartments_count')}}</td>
                    <td class="text-center">{{$projects->sum('unsold_apartments_count')}}</td>
                    <td class="text-center">@money($projects->sum('unsold_apartments_sum_apartment_size'))</td>
                    <td class="text-center">@money($projects->sum('unsold_apartments_avg_apartment_rate'))</td>
                    <td class="text-center">@money($projects->sum('total_parking_utility'))</td>
                    <td class="text-center">@money($projects->sum('total_estimated_value'))</td>
                </tr>
            </tfoot>
            @endif
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
            }).change(function(){
                if(!$(this).val()){
                    $('#project_id').val(null);
                }
            });
        });//document.ready
    </script>
@endsection
