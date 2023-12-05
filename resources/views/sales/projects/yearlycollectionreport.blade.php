@extends('layouts.backend-layout')
@section('title', 'Yearly Collection ')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    Yearly Collection
@endsection

@section('breadcrumb-button')
    <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    {{--Total: {{ count($projects) }}--}}
@endsection

@section('content-grid', 'offset-lg-1 col-lg-10 my-3')


@section('content')
    <form action="" method="get">
        <div class="row px-2">
            <div class="col-md-1 px-1 my-1 my-md-0" data-toggle="tooltip" title="Output">
                <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                    <option value="list" selected> List </option>
                    <option value="pdf"> PDF </option>
                </select>
            </div>
            {{--<div class="col-md-3 px-1 my-1 my-md-0">--}}
                {{--<input type="text" id="project_name" name="project_name" class="form-control form-control-sm" value="{{!empty($request) ? $request->project_name : null}}" placeholder="Enter Project Name" autocomplete="off">--}}
                {{--<input type="hidden" id="project_id" name="project_id" class="form-control form-control-sm" value="{{!empty($request) ? $request->project_id : null}}">--}}
            {{--</div>--}}
            <div class="col-md-3 px-1 my-1 my-md-0">
                <input type="text" id="year" name="year" class="form-control form-control-sm" value="{{$request->year ? $request->year : now()->format('Y')}}" placeholder="Select Year" autocomplete="off">
            </div>
            <div class="col-md-1 px-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>


    <div class="tableHeading">
        <h5> <span>&#10070;</span> Yearly Collection - {{$request->year ? $request->year : now()->format('Y')}} <span>&#10070;</span> </h5>
    </div>
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Target</th>
                    <th>Up Coming <br> Project</th>
                    <th>Collection</th>
                    <th>Backlog</th>
                </tr>
            </thead>
            <tbody class="text-right">
            @php
                $totalTargets = 0;
                $totalCollections = 0;
                $totalBacklog = 0;
                $totalUpcomingCollections=0;
            @endphp
            @foreach($installments as $key => $installment)
                <tr>
                    <td class="text-center">{{$key}}</td>
                    <td>
                        @php($target = $installment)
                        @if($bookingMoneys->keys()->contains($key))
                            @php($target += $bookingMoneys[$key])
                        @endif
                        @if($downPayments->keys()->contains($key))
                            @php($target += $downPayments[$key])
                        @endif
                        @money($target)
                        @php($totalTargets+= $target)
                    </td>
                    <td>
                        @if($upComings->keys()->contains($key))
                            @money($upComings[$key])
                            @php($totalUpcomingCollections += $upComings[$key])
                        @endif
                    </td>
                    <td>
                        @if($saleCollections->keys()->contains($key))
                            @money($saleCollections[$key])
                            @php($totalCollections += $saleCollections[$key])
                        @endif
                    </td>

                    <td>
                        @if($saleCollections->keys()->contains($key))
                            @money($target - $saleCollections[$key])
                            @php($totalBacklog += $target - $saleCollections[$key])
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot class="text-right">
                <tr class="bg-warning font-weight-bold">
                    <td class="text-right">Total</td>
                    <td>@money($totalTargets)</td>
                    <td>@money($totalUpcomingCollections)</td>
                    <td>@money($totalCollections)</td>
                    <td>@money($totalBacklog)</td>
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
