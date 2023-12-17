@extends('layouts.backend-layout')
@section('title', 'Transfer')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Name Transfer
@endsection


@section('breadcrumb-button')
    @can('sell-create')
        <a href="{{ url('name-transfers/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($allData) }}
    @endsection
    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Client</th>
                <th>Apartment</th>
                <th>Project</th>
                <th>Total Value</th>
                <th>Booking Money</th>
                <th>Downpayment</th>
                <th>Installment</th>
                <th>Attachment</th>
                <th>Status</th>
                <th>
{{--                @hasanyrole('super-admin|admin|Sales-HOD|CSD-Manager')--}}
                    Action
{{--                @endhasrole--}}
                </th>
            </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Client</th>
                    <th>Apartment</th>
                    <th>Project</th>
                    <th>Total Value</th>
                    <th>Booking Money</th>
                    <th>Downpayment</th>
                    <th>Installment</th>
                    <th>Attachment</th>
                    <th>Status</th>
                    <th>
{{--                    @hasanyrole('super-admin|admin|Sales-HOD|CSD-Manager')--}}
                        Action
{{--                    @endhasrole--}}
                    </th>

                </tr>
            </tfoot>
            <tbody>
            @foreach($allData as $key => $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td class="text-left breakWords">
                        <strong>
{{--                        @hasanyrole('super-admin|admin|Sales-HOD')--}}
                            <a href="{{ url("sells/$data->sale_id") }}">
                                {{$data->sale->sellClient->client->name ?? "Client is Empty"}}
                            </a>
{{--                        @else--}}
{{--                            {{$sell->sellClient->client->name ?? "Client is Empty"}}--}}
{{--                        @endhasrole--}}
                        </strong>
                        <br>
                    </td>
                    <td><strong>{{$data->sale->apartment->name}}</strong></td>
                    <td><strong>{{$data->sale->apartment->project->name}}</strong></td>
                    <td  class="text-right">@money($data->sale->total_value)</td>
                    <td  class="text-right">@money($data->sale->booking_money)</td>
                    <td  class="text-right">@money($data->sale->downpayment)</td>
                    <td  class="text-right">@money($data->sale->installment)</td>
                    <td  class="text-right">
                        @if($data->attachment)
                            <strong><a href="storage/{{$data->attachment}}" target="_blank"> Attachment </a></strong>
                        @endif
                    </td>
                    @php
                                    $approvals = \App\Approval\ApprovalLayerDetails::
                                        whereHas('approvalLayer', function ($q){
                                            $q->where('name','Name Transfer');
                                        })->whereDoesntHave('approvals',function ($q) use($data){
                                            $q->where('approvable_id',$data->id)->where('approvable_type',\App\Sells\NameTransfer::class);
                                        })
                                        ->orderBy('order_by','asc')->first();

                                        $TotalApproval = \App\Approval\ApprovalLayerDetails::
                                        whereHas('approvalLayer', function ($q){
                                            $q->where('name','Name Transfer');
                                        })->orderBy('order_by','asc')->get()->count();
                    @endphp
                    <td>
                        @if($data->approval()->exists())
                            @foreach($data->approval as $approval1)
                                <span class="badge @if($approval1->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                    {{ $approval1->status }} - {{$approval1->user->employee->designation->name ?? ''}}
                                </span><br>

                            @endforeach
                            @if (($data->approval->count() != $TotalApproval))
                                <span class="badge bg-warning badge-sm">Pending in - {{$approvals->designation->name ?? ''}} - {{$approvals->department->name ?? ''}}</span>
                            @endif
                        @else
                        <span class="badge bg-warning badge-sm">Pending in - {{$approvals->designation->name ?? ''}} - {{$approvals->department->name ?? ''}}</span>
                        @endif
                    </td>

                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @php
                                    $approval = \App\Approval\ApprovalLayerDetails::
                                        whereHas('approvalLayer', function ($q){
                                            $q->where('name','Name Transfer');
                                        })->whereDoesntHave('approvals',function ($q) use($data){
                                            $q->where('approvable_id',$data->id)->where('approvable_type',\App\Sells\NameTransfer::class);
                                        })
                                        ->orderBy('order_by','asc')->first();

                                    //dump($approval, auth()->user()->designation?->id)
                                @endphp
                                @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))

                                    <a href="{{ url("name-transfer-approval/$data->id/1") }}" data-toggle="tooltip" title="Approval" class="btn btn-outline-success">Approve</a>
                                @endif

{{--                                <a href="{{ url("name-transfers/$data->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>--}}
{{--                            @hasanyrole('super-admin|admin|Sales-HOD|CSD-Manager')--}}
                                    <a href="{{ url("name-transfers/$data->id/edit") }}" data-toggle="tooltip" title="Edit Sale Information" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {!! Form::open(array('url' => "name-transfers/$data->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    {!! Form::close() !!}
                                    <a href="{{ url("name-transfers/$data->id/log") }}" data-toggle="tooltip" title="Logs" class="btn btn-dark"><i class="fas fa-history"></i></a>
{{--                            @endhasanyrole--}}
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
    </script>
@endsection
