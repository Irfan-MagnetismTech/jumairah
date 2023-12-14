@extends('layouts.backend-layout')
@section('title', 'Scrap Sale')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Scrap Sale
@endsection


@section('breadcrumb-button')
    <a href="{{ route('scrapSale.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($scrap_sale) }}
    @endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                    <th>#Applied Date</th>
                    <th>Project Name</th>
                    <th>SGS</th>
                    <th>Total</th>
                    <th>Action</th>
            </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>#Applied Date</th>
                    <th>Project Name</th>
                    <th>SGS</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($scrap_sale as $key => $value)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td><strong>#{{$value->applied_date}}</strong></td>
                        <td>{{$value->costCenter->name}}</td>
                        <td>{{$value->sgs}}</td>
                        <td>{{$value->grand_total}}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                  
                                    @php
                                        $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($value){
                                            $q->where([['name','SCRAP SALE'],['department_id',$value->appliedBy->department_id]]);
                                        })->wheredoesnthave('approvals',function ($q) use($value){
                                            $q->where('approvable_id',$value->id)->where('approvable_type',\App\BD\ScrapSale::class);
                                        })->orderBy('order_by','asc')->first();
                                    @endphp

                                    @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
                                        <a href="{{ url("scrapSale/approved/$value->id/1") }}" data-toggle="tooltip" title="Approve" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                    @endif

                                    @if($value->approval()->doesntExist() || auth()->user()->hasAnyRole(['admin','super-admin']))
                                        <a href="{{ route("scrapSale.edit", $value->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @if($value->approval()->doesntExist())
                                        {!! Form::open(array('url' => route("scrapSale.destroy", $value->id),'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                        {!! Form::close() !!}
                                        @endif
                                    @endif


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
