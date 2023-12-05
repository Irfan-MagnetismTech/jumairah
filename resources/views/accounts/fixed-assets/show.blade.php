@extends('layouts.backend-layout')
@section('title', 'Supplier Bill Details')

@section('breadcrumb-title')
   Supplier Bill Details
@endsection

@section('breadcrumb-button')
    <a href="{{ url('supplierbills') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    {{--    <span class="text-danger">*</span> Marked are required.--}}
@endsection

@section('content-grid',null)

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                    <tr style="background-color: #0C4A77;color: white"><td> <strong>Project Name</strong> </td> <td> <strong>{{$supplierbill->project->name}}</strong></td></tr>
                    <tr><td> <strong>Date</strong> </td> <td>{{$supplierbill->date}}</td></tr>
                    <tr><td> <strong>Purpose</strong> </td> <td>{{$supplierbill->purpose}}</td></tr>
                    <tr><td> <strong>Applied By</strong> </td> <td> {{$supplierbill->appliedBy->name}}</td></tr>
                    <tr><td> <strong>Status</strong> </td> <td class="text-c-orenge"><strong>{{ $supplierbill->status}}</strong></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th width="140px">Select MRR<span class="text-danger"></span></th>
                <th th width="180px">PO No</th>
                <th width="100px">MPR No</th>
                <th width="180px">Supplier's Name</th>
                <th width="100px">Bill No<span class="text-danger"></span></th>
                <th width="100px">Amount<span class="text-danger"></span></th>
                <th width="100px">Office Bill No<span class="text-danger"></span></th>
                <th width="100px">Remarks<span class="text-danger"></span></th>
            </tr>
            </thead>
            <tbody>
                @foreach($supplierbill->officebilldetails as $officebilldetail)
                <tr>
                    <td>{{ $officebilldetail->mrr_no }}</td>
                    <td>{{ $officebilldetail->po_no }}</td>
                    <td>{{ $officebilldetail->mpr_no }}</td>
                    <td>{{ $officebilldetail->supplier->name }}</td>
                    <td>{{ $officebilldetail->bill_no }}</td>
                    <td>{{ $officebilldetail->amount }}</td>
                    <td>{{ $officebilldetail->office_bill_no }}</td>
                    <td>{{ $officebilldetail->remarks }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@endsection
