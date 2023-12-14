@extends('layouts.backend-layout')
@section('title', 'SIN Details')

@section('breadcrumb-title')
    Store Issue Note Details
@endsection

@section('breadcrumb-button')
    <a href="{{ url('storeissues') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
@endsection

@section('content-grid',null)

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                    <tr style="background-color: #0C4A77;color: white"><td> <strong>SIN No.</strong> </td> <td> <strong>{{$storeissue->sin_no}}</strong></td></tr>
                    <tr><td> <strong>SRf No.</strong> </td> <td>{{$storeissue->srf_no}}</td></tr>
                    <tr><td> <strong>Project Name</strong> </td> <td>{{$storeissue->costCenter->name}}</td></tr>
                    <tr><td> <strong>Date</strong> </td> <td>{{$storeissue->date}}</td></tr>
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
                <th>Material Code</th>
                <th>Unit</th>
                <th>Ledger Folio No.</th>
                <th>Quantity</th>
                <th width="200px">Purpose of Works</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $storeissue->storeissuedetails as $storeissuedetail)
                <tr>
                    <td> {{$storeissuedetail->nestedMaterials->name}} </td>
                    <td> --- </td>
                    <td> {{$storeissuedetail->nestedMaterials->unit->name}} </td>
                    <td> {{$storeissuedetail->ledger_folio_no}} </td>
                    <td> {{$storeissuedetail->issued_quantity}} </td>
                    <td> {{$storeissuedetail->purpose}} </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
