@extends('layouts.backend-layout')
@section('title', 'EME Bill List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of EME Bills
@endsection

@section('breadcrumb-button')
    <a href="{{ url('eme/bills/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($constructionBills) }}
    @endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead class="">
                <tr>
                    <th>SL</th>
                    <th> Date </th>
                    <th> Title </th>
                    <th> Work For </th>
                    <th> Project </th>
                    <th> Supplier </th>
                    <th> Bill No </th>
                    <th> Reference No </th>
                    <th> Bill Amount </th>
                    <th> Prepared By </th>
                    <th> Status </th>
                    <th> Action </th>
                </tr>
            </thead>

            <tbody>
            @foreach($constructionBills as $constructionBill)

            @if ($constructionBill->is_saved == 1 || (auth()->user()->id == $constructionBill->user_id && $constructionBill->is_saved == 0))
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$constructionBill->bill_received_date ?? null}}</td>
                    <td>{{$constructionBill->title ?? null}}</td>
                    <td>{{$constructionBill->emeWorkorder?->workorder_for ?? null}}</td>
                    <td>{{$constructionBill->project->name ?? null}}</td>
                    <td>{{$constructionBill->supplier->name ?? null}}</td>
                    @if (empty($constructionBill->bill_no ?? null))
                    <td>{{ "Upcome" }}</td>
                    @else
                    <td>{{$constructionBill->bill_no ?? null}}</td>
                    @endif
                    <td>{{$constructionBill->reference_no ?? null}}</td>
                    <td>{{$constructionBill->bill_amount ?? null}}</td>
                    <td>{{$constructionBill->preparedBy->name ?? null}}</td>
                    {{-- @php
                        $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($constructionBill){
                            $q->where([['name','CONSTRUCTION BILL'],['department_id',$constructionBill->preparedBy->department_id]]);
                        })->whereDoesntHave('approvals',function ($q) use($constructionBill){
                            $q->where('approvable_id',$constructionBill->id)->where('approvable_type',\App\Billing\ConstructionBill::class);
                        })->orderBy('order_by','asc')->first();
                    @endphp
                    <td>
                        @if(->approval()->exists())
                            @foreach($constructionBill->approval as $approval)
                                <span class="badge @if($approval->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                    {{ $approval->status }} - {{$approval->user->employee->department->name ?? ''}} - {{$approval->user->employee->designation->name ?? ''}}
                                </span><br>
                            @endforeach
                        @else
                            <span class="badge bg-warning badge-sm">{{ 'Pending' }}</span>
                        @endif
                    </td> --}}

                    @php
                        $approvals = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($constructionBill){
                            $q->where([['name','EME BILL'],['department_id',$constructionBill->preparedBy->department_id]]);
                        })->whereDoesntHave('approvals',function ($q) use($constructionBill){
                            $q->where('approvable_id',$constructionBill->id)->where('approvable_type',\App\Billing\ConstructionBill::class);
                        })->orderBy('order_by','asc')->get();

                        $TotalApproval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($constructionBill){ $q->where([['name','EME BILL'],['department_id',$constructionBill->preparedBy->department_id]]);
                        })->orderBy('order_by','asc')->get()->count();
                    @endphp
                    <td>
                        @if($constructionBill->approval()->exists())
                            @foreach($constructionBill->approval as $approval1)
                                <span class="badge @if($approval1->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                    {{ $approval1->status }} - {{$approval1->user->employee->department->name ?? ''}} - {{$approval1->user->employee->designation->name ?? ''}}
                                </span><br>
                            @endforeach
                            @if (($constructionBill->approval->count() != $TotalApproval))
                                <span class="badge bg-warning badge-sm">Pending in {{$approvals->first()->designation->name ?? ''}} - {{$approvals->first()->department->name ?? ''}}</span>
                            @endif
                        @else
                            <span class="badge bg-warning badge-sm">Pending in {{$approvals->first()->designation->name ?? ''}} - {{$approvals->first()->department->name ?? ''}}</span>
                        @endif
                    </td>

                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @if ($constructionBill->is_saved == 0)
                                    <a href="{{ url("eme/bills/$constructionBill->id/edit") }}" data-toggle="tooltip" title="Edit Draft" class="btn btn-outline-secondary"><i class="fas fa-pen"></i></a>
                                    {!! Form::open(array('url' => "eme/bills/$constructionBill->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    {!! Form::close() !!}
                                @else
                                    @php
                                    $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($constructionBill){
                                        $q->where([['name','EME BILL'],['department_id',$constructionBill->appliedBy->department_id]]);
                                    })->whereDoesntHave('approvals',function ($q) use($constructionBill){
                                        $q->where('approvable_id',$constructionBill->id)->where('approvable_type',\App\Billing\ConstructionBill::class);
                                    })->orderBy('order_by','asc')->first();
                                    @endphp
                                    @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
                                    <a href="{{ url("eme/eme-bill-approval/$constructionBill->id/1") }}" data-toggle="tooltip" title="Approval" class="btn btn-outline-success">Approve</a>
                                    @endif
                                    @if($constructionBill->approval()->doesntExist() || auth()->user()->hasAnyRole(['admin','super-admin']))
                                    <a href="{{ url("eme/bills/$constructionBill->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>

                                        @if($constructionBill->approval()->doesntExist())
                                        {!! Form::open(array('url' => "eme/bills/$constructionBill->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                        {!! Form::close() !!}
                                        @endif
                                    @endif
                                    <a href="{{ url("eme/bills/$constructionBill->id") }}" data-toggle="tooltip" title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                        <a href="{{ url("eme/bills/pdf/$constructionBill->id") }}" data-toggle="tooltip" title="PDF" class="btn btn-outline-primary"><i class="fas fa-file"></i></a>
                                @endif

                            </nobr>
                        </div>
                    </td>
                </tr>
            @endif
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
