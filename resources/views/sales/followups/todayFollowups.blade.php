@extends('layouts.backend-layout')
@section('title', 'Lead Generations')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Today's Followup Leads
@endsection


@section('breadcrumb-button')
    @can('leadgeneration-create')
        <a href="{{ url('leadgenerations/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($leadgenerations) }}
@endsection


@section('content')

    <form action="" method="get">
        <div class="row px-2">
            <div class="col-md-2 px-1 my-1 my-md-0">
                <input type="text" id="date" name="date" data-toggle="tooltip" title="" class="form-control form-control-sm" value="{{!empty(request()->date) ? request()->date : date('d-m-Y', strtotime(now()))}}" placeholder="Enter Days In Number" autocomplete="off">
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
        <table id="" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Prospect Name</th>
                <th>Entry Date</th>
                <th>Lead Stage</th>
                <th>Project</th>
                <th>Apartment</th>
                <th>Last Followup</th>
                <th>Entry By</th>
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
                <th>Apartment</th>
                <th>Last Followup</th>
                <th>Entry By</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($leadgenerations as $key => $leadGeneration)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td class="text-left breakWords">
                        <strong><a target="_blank" href="{{ url("leadgenerations/$leadGeneration->id") }}" data-toggle="tooltip" title="Check Details"> {{$leadGeneration->name}} </a></strong><br>
                        {{$leadGeneration->country_code}}-{{$leadGeneration->contact}}
                    </td>
                    <td>{{$leadGeneration->lead_date}}</td>
                    <td>{{$leadGeneration->lead_stage}}</td>
                    <td class="breakWords">
                        <strong>{{$leadGeneration->apartment->project->name}}</strong>
                    </td>
                    <td><strong>{{$leadGeneration->apartment->name}}</strong></td>
                    <td class="breakWords">
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
                        {{$leadGeneration->createdBy->name}}
                    </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ url("addfollowup/$leadGeneration->id") }}" data-toggle="tooltip" title="Add Activity" class="btn btn-outline-success"><i class="fas fa-plus"></i></a>
                                @can('leadgeneration-view')
                                    <a href="{{ url("leadgenerations/$leadGeneration->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                @endcan
                                @can('leadgeneration-edit')
                                    <a href="{{ url("leadgenerations/$leadGeneration->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                @endcan
                                @can('leadgeneration-delete')
                                    {!! Form::open(array('url' => "leadgenerations/$leadGeneration->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    {!! Form::close() !!}
                                @endcan
                                <a href="{{ url("leadgenerations/{$leadGeneration->id}/log") }}" data-toggle="tooltip" title="Log" class="btn btn-dark"><i class="fas fa-history"></i></a>
                            </nobr>
                        </div>
                    </td>
                </tr>
            @endforeach
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

        $(function(){
            $('#date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

        });
    </script>
@endsection
