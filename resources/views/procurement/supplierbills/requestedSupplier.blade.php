@extends('layouts.backend-layout')
@section('title', 'Requested Supplier Bill List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Requested Supplier Bill
@endsection


@section('sub-title')
    Total: {{ $supplierbills->total() }}
    @endsection

    @section('content')

            <!-- put search form here.. -->

    @php
        $iteration = ($supplierbills->currentPage() - 1 ) * $supplierbills->perPage() ;
    @endphp
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Request Date</th>
                <th>Project Name</th>
                <th>Supplier Name</th>
                <th>Bill No</th>
                <th>Applied By</th>
                <th>Purpose</th>
                <th>Amount</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th>Request Date</th>
                <th>Project Name</th>
                <th>Supplier Name</th>
                <th>Bill No</th>
                <th>Applied By</th>
                <th>Purpose</th>
                <th>Amount</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($currentItems as $kk => $supplierbill)
                <tr>
                    <td rowspan="{{ count($supplierbill) }}">{{++$iteration }}</td>
                    <td rowspan="{{ count($supplierbill) }}">{{$kk}}</td>
                    @php
                        $total = 0;
                         foreach ($supplierbill as $key => $val){
                            $total += $val['final_total'];
                         }
                    
                    @endphp
                    @foreach ($supplierbill as $key => $val)
                    <td>{{ $val['cost_center']['name'] }} </td>
                    <td>{{ $val['officebilldetails'][0]['supplier']['name'] }} </td>
                    <td>{{ $val['bill_no'] }} </td>
                    <td>{{$val['applied_by']['name']}} </td>
                    <td>{{$val['purpose']}} </td>
                    <td>{{ $val['final_total'] }} </td>
                    @if($loop->first)
                        <td rowspan="{{ count($supplierbill) }}">{{$total}}</td>
                    @endif
                    <td>
                        <div class="icon-btn">
                            <nobr>
                            {{-- <a href="{{ url("supplierBillReject/$val[id]") }}" data-toggle="tooltip" title="Reject" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a> --}}
                            </nobr>
                        </div> 
                    </td>
                    @if(!$loop->last)
                        </tr>
                    @endif
                    @endforeach
                    
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $supplierbills->links() }}
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
        $(document).on('click',function(){
            $('.date,.required_date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            })
        })
       
    </script>
@endsection
