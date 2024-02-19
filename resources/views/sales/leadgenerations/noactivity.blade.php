@extends('layouts.backend-layout')
@section('title', 'No Activity List')

@section('style')
    {{--<link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">--}}
@endsection

@section('breadcrumb-title')
    List of No Activity (More than {{!empty(request()->check_days) ? request()->check_days : 90}} Days)
@endsection


@section('breadcrumb-button')
{{--    <a href="{{ url('leadgenerations/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>--}}
@endsection

@section('sub-title')
    Total: {{ count($leadgenerations) }}
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
            <div class="col-md-3 px-1 my-1 my-md-0">
                <input type="text" id="project_name" name="project_name" class="form-control form-control-sm" value="{{!empty(request()->project_name) ? request()->project_name : null}}" placeholder="Enter Project Name" autocomplete="off">
                <input type="hidden" id="project_id" name="project_id" class="form-control form-control-sm" value="{{!empty(request()->project_id) ? request()->project_id : null}}">
            </div>
            <div class="col-md-2 px-1 my-1 my-md-0">
                <input type="number" id="check_days" name="check_days" data-toggle="tooltip" title="Enter Days In Number" class="form-control form-control-sm" value="{{!empty(request()->check_days) ? request()->check_days : 90}}" placeholder="Enter Days In Number" autocomplete="off">
            </div>
            <div class="col-md-1 px-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Prospect Name</th>
                <th>Entry Date</th>
                <th>Lead Stage</th>
                <th>Project</th>
                <th>Apartment/Space</th>
                <th>Last Followup</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th>Prospect Name</th>
                <th>Entry Date</th>
                <th>Lead Stage</th>
                <th>Project</th>
                <th>Apartment/Space</th>
                <th>Last Followup</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @php($leadStage = ['A' => 'Priority', 'B' => 'Negotiation', 'C' => 'Lead', 'D' => 'Closed Lead'])
            @forelse($leadgenerations as $key => $leadGeneration)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td class="text-left breakWords">
                        <strong><a href="{{ url("leadgenerations/$leadGeneration->id") }}" data-toggle="tooltip" title="Check Details"> {{$leadGeneration->name}} </a></strong><br>
                        {{$leadGeneration->contact}}
                    </td>
                    <td>{{$leadGeneration->lead_date}}</td>
                    <td>{{ $leadStage[$leadGeneration->lead_stage] }}</td>
                    <td class="text-left breakWords">{{$leadGeneration->apartment->project->name}}</td>
                    <td class="text-left">
                        {{$leadGeneration->apartment->name}}
                    </td>
                    <td>
                        @if($leadGeneration->followups()->exists())
                            Date: <strong>{{ $leadGeneration->followups->last()->date}}</strong> <br>
                            Duration: <strong>{{\Carbon\Carbon::now()->diffInDays($leadGeneration->followups->last()->date)}}</strong> day(s) ago.<br>
                            <hr class="m-1">
                            <strong class="text-left">{{$leadGeneration->followups->last()->feedback}}</strong>
                        @else
                            --
                        @endif
                    </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ url("addfollowup/$leadGeneration->id") }}" data-toggle="tooltip" title="Add Activity" class="btn btn-outline-success"><i class="fas fa-plus"></i></a>
                                <a href="{{ url("leadgenerations/$leadGeneration->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                <a href="{{ url("leadgenerations/$leadGeneration->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "leadgenerations/$leadGeneration->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                {!! Form::close() !!}
                            </nobr>
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="8"> <h6 class="text-muted my-2"> No matching records found. </h6> </td>
                </tr>
            @endforelse
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
        });//document.ready
    </script>
@endsection
