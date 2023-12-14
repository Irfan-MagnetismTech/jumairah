@extends('layouts.backend-layout')
@section('title', 'MPR Details')

@section('breadcrumb-title')
    Material Purchase Requisition (MPR) Forward
@endsection

@section('breadcrumb-button')
{!! Form::open(array('url' => "requisitionForward/$requisition->id",'method' => 'PUT', 'class'=>'custom-form')) !!}

    {{-- <a href="{{ url('requisitionForward/$requisition->id') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a> --}}
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
                    <tr style="background-color: #0C4A77;color: white"><td> <strong>MPR No.</strong> </td> <td> <strong>{{"MPR-".$requisition->mpr_no}}</strong></td></tr>
                    {{-- <tr><td> <strong>Requisition For</strong> </td> <td>{{$requisition->reason == 1 ? "Self" : "Project"}}</td></tr> --}}
                    {{-- @if($requisition->reason !="1") --}}
                        <tr><td> <strong>Project Name</strong> </td> <td> {{$requisition->project->name}}</td></tr>
                    {{-- @endif --}}
                    <tr><td> <strong>Reason</strong> </td> <td>   {{$requisition->reason}}</td></tr>
                    <tr><td> <strong>Applied Date</strong> </td> <td>  {{$requisition->applied_date}}</td></tr>
                    <tr><td> <strong>Requisition By</strong> </td> <td>  {{ $requisition->requisitionBy->name}}</td></tr>
                    <tr><td> <strong>Requisition Remarks</strong> </td> <td>  {{ $requisition->remarks}}</td></tr>
                    <tr><td> <strong>Status</strong> </td> <td class="text-c-orenge"><strong>{{ $requisition->status}}</strong></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Material Name</th>
                <th>Unit</th>
                <th>Total Estimated<br> Requirement</th>
                <th>Net Comulative<br> Received</th>
                <th>Present<br> Stock</th>
                <th>Required<br> Presently</th>
                <th>Required<br> Delivery Date</th>
                <th width="250px">Material<br> Remarks</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $requisition->requisitiondetails as $requisitiondetail)
                <tr>
                    <td> {{$requisitiondetail->nestedMaterial->name}} </td>
                    <td> {{$requisitiondetail->nestedMaterial->unit->name}} </td>
                    <td> --- </td>
                    <td> ---  </td>
                    <td> --- </td>
                    <td> {{$requisitiondetail->quantity}} </td>
                    <td> {{$requisitiondetail->required_date}} </td>
                    <td> {{$requisitiondetail->material_remarks}} </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <tbody>
                <tr>
                    <td>
                        <div class="form-group row">
                            <div class="form-checkbox col-md-4">
                                <input type="checkbox" name="csd" value="csd"> CSD
                            </div>
                            <div class="form-checkbox col-md-4" >
                                <input type="checkbox" name="eee" value="eee"> EEE
                            </div>
                            <div class="form-checkbox col-md-4" >
                                <input type="checkbox" name="gm" value="gm"> GM Supply Chain
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div> <!-- end row -->
    {!! Form::close() !!}
@endsection
