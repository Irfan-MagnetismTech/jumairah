@extends('layouts.backend-layout')
@section('title', 'Supplier Bill Details')

@section('breadcrumb-title')
   Supplier Bill Details
@endsection

@section('breadcrumb-button')
    <a href="{{ url('supplierbills') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection


@section('content-grid',null)

@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                    <tr style="background-color: #0C4A77;color: white"><td> <strong>Project Name</strong> </td> <td> <strong>{{$supplierbill->costCenter->name}}</strong></td></tr>
                    <tr><td> <strong>Date</strong> </td> <td>{{$supplierbill->date}}</td></tr>
                    <tr><td> <strong>Purpose</strong> </td> <td>{{$supplierbill->purpose}}</td></tr>
                    <tr><td> <strong>Applied By</strong> </td> <td> {{$supplierbill->appliedBy->name}}</td></tr>
                    <tr><td> <strong>Bill No</strong> </td> <td class="text-c-orenge"><strong>{{ $supplierbill->bill_no}}</strong></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th >MRR<span class="text-danger"></span></th>
                <th >PO No</th>
                <th >MPR No</th>
                <th >Supplier's Name</th>
                <th >Remarks<span class="text-danger"></span></th>
                <th >Amount<span class="text-danger"></span></th>
            </tr>
            </thead>
            <tbody>
                @foreach($supplierbill->officebilldetails as $officebilldetail)
                <tr>
                    <td>{{ $officebilldetail->mrr_no }}</td>
                    <td>{{ $officebilldetail->po_no }}</td>
                    <td>{{ $officebilldetail->mpr_no }}</td>
                    <td>{{ $officebilldetail->supplier->name }}</td>
                    <td>{{ $officebilldetail->remarks }}</td>
                    <td>{{ $officebilldetail->amount }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right"> Carrying Cost </td>
                    <td class="text-center">@money($supplierbill->carrying_charge)</td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right"> Labour Charge </td>
                    <td class="text-center">@money($supplierbill->labour_charge)</td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right"> Discount </td>
                    <td class="text-center">@money($supplierbill->discount)</td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right"> Total Amount </td>
                    <td class="text-center">@money($supplierbill->final_total)</td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection

