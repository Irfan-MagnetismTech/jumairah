@extends('layouts.backend-layout')
@section('title', 'Projects')

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
Projects Details Summary
@endsection

@section('breadcrumb-button')
<a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
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
                {{-- <option value="pdf"> PDF </option> --}}
            </select>
        </div>
        <div class="col-md-2 px-1 my-1 my-md-0" data-toggle="tooltip" title="Project Status">
            <select name="status" id="status" class="form-control form-control-sm" required>
                @foreach($status as $stat)
                <option value="{{$stat}}" {{($stat == $current_status) ? "selected" : null}}>{{$stat}}</option>
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
    <h5 class="text-center"> {{$current_status}} Projects Report </h5>
</div>
@endif

<div class="table-responsive">
    <table id="dataTable" class="table table-striped table-bordered">
        <thead>
            <tr style="vertical-align: middle">
                <th>SL</th>
                <th>Project Name</th>
                <th>Land Size<br>(Katha)</th>
                <th>Story</th>
                <th>Agreement<br>Date</th>
                <th>Cash</th>
                <th>Rent</th>
                <th>Ratio <br> (LO/Dev)</th>
                <th>Plan <br>Approval</th>
                <th>Launching <br> Date</th>
                <th>Proposed <br>Handover</th>
                <th>Construction<br> Area</th>
                <th>Saleable <br>Area</th>
                <th>Saleable <br>Area(Dev)</th>
                <th>Saleable <br>Unit (Dev)</th>
                <th>Unit<br> Sold</th>
                <th>Balance</th>
                <th>%<br> of Sales</th>
                <th> Sold Unit Value </th>
                <th>Cash<br> Inflow</th>
                <th>Cash<br> Outflow</th>
                <th>Diff<br>(in & out)</th>
                <th>Yet to <br> Receive</th>                
                {{-- <th>%<br>Construction</th> --}}
                <th>% inflow</th>
                <th>Project <br> Value</th>
                <th>Unsold <br> Inventory</th>
                {{-- <th>Expected <br> Profit</th> --}}
                <th>Cost</th>
                {{-- <th>%<br>Profit</th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $key => $project)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td class="text-left">
                    <strong><a href="{{ url("projects/$project->id") }}" target="_blank"> {{ $project->name}}</a></strong> <br>
                </td>
                <td>{{$project->landsize}}</td>
                <td>{{$project->storied}}</td>
                <td>{{$project->signing_date}}</td>
                <td>@money($project->landowner_cash_benefit)</td>
                <td> -- </td>
                <td> {{$project->landowner_share}} / {{$project->developer_share}} </td>
                <td>{{$project->cda_approval_date}}</td>
                <td>{{$project->innogration_date}}</td>
                <td>{{$project->handover_date}}</td>
                <td class="text-right">@money($project->buildup_area)</td>
                <td class="text-right">@money($project->sellable_area)</td>
                <td class="text-right">@money($project->developer_sellable_area)</td>
                <td> {{$project->apartments_count}}</td>
                <td>
                    {{$project->sells_count}}
                </td>
                <td>
                    {{$project->apartments_count - $project->sells_count}}
                </td>

                <td>{{ $project->apartments_count ? number_format((($project->sells_count / $project->apartments_count) * 100), 2)."%" : null}}</td>
                <td>
                    @money($project->total_sold_value)
                </td>
                <td class="text-right">
                    @php $collectionAmount = 0; @endphp
                    @if($project->sells)
                    @money($collectionAmount = $project->sells->sum('sales_collections_sum_received_amount'))
                    @endif
                </td>
                <td>{{ $project->costCenter->ledgers_sum_dr_amount }}</td>
                <td>
                    {{$project->sells->sum('sales_collections_sum_received_amount') - $project->costCenter->ledgers_sum_dr_amount }} 
                </td>
                <td class="text-right">
                    @money($project->total_sold_value - $project->sells->pluck('salesCollections')->collapse()->sum('received_amount'))
                </td>                
                {{-- <td> -- </td> --}}
                <td>{{ $collectionAmount > 0 ? number_format((($collectionAmount / $project->total_sold_value) * 100), 2)."%" : null}}</td>
                <td class="text-right">@money($project->apartments_sum_total_value) <br>  </td>
                <td class="text-right">@money($project->unsold_apartments_sum_total_value)</td>
                {{-- <td> -- </td> --}}
                <td class="text-right">
                    @money($project->project_cost)
                </td>
                {{-- <td>--</td> --}}
            </tr>
            @empty
            <tr>
                <td colspan="29">
                    <h5 class="text-muted my-3 text-left"> No Data Found Based on your query. </h5>
                </td>
            </tr>
            @endforelse
        </tbody>
        <tfoot class="text-right">
            <tr class="bg-warning">
                <td colspan="11" class="text-right"> Total </td>
                <td>@money($projects->pluck('buildup_area')->sum())</td>
                <td>@money($projects->pluck('sellable_area')->sum())</td>
                <td>@money($projects->pluck('developer_sellable_area')->sum())</td>
                <td>
                    {{$projects->pluck('apartments_count')->sum()}}
                </td>
                <td>
                    {{$projects->pluck('sells_count')->sum()}}
                </td>
                <td>
                    {{$projects->pluck('apartments_count')->sum() - $projects->pluck('sells_count')->sum()}}
                </td>
                <td></td>
                <td>
                    @money($projects->sum('total_sold_value'))
                </td>
                <td>
                    @php 
                        $cashInflow = $projects->pluck('sells')->collapse()->sum('sales_collections_sum_received_amount'); 
                    @endphp  
                    @money($cashInflow)
                </td>
                <td>                    
                    @php 
                        $cashOutflow = $projects->pluck('costCenter')->sum('ledgers_sum_dr_amount'); 
                    @endphp
                    @money($cashOutflow)
                </td>
                <td>
                    @money($cashInflow - $cashOutflow)
                </td>
                <td>
                    @money($projects->sum('apartments_sum_total_value') - $projects->pluck('sells')->collapse()->pluck('salesCollections')->collapse()->sum('received_amount'))
                </td>                
                {{-- <td></td> --}}
                <td></td>
                <td class="text-right">@money($projects->sum('apartments_sum_total_value'))</td>
                <td class="text-right">@money($projects->sum('unsold_apartments_sum_total_value'))</td>
                {{-- <td> </td> --}}
                <td>@money($projects->sum('project_cost'))</td>
                {{-- <td></td> --}}
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
            source: function(request, response) {
                $.ajax({
                    url: "{{route('projectAutoSuggest')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $('#project_name').val(ui.item.label);
                $('#project_id').val(ui.item.value);
                return false;
            }
        });
    }); //document.ready
</script>
@endsection