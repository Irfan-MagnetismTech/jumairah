@extends('layouts.backend-layout')
@section('title', 'Material Servicing')

@section('breadcrumb-title')
        Material Servicing
@endsection

@section('breadcrumb-button')
    <a href="{{ url('boq/MaterialServincing/index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    <hr class="bg-success">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
            <tr>
                <th>Item Name <span class="text-danger">*</span></th>
                <th>Purchase</th>
                <th>Purchase Date<span class="text-danger">*</span></th>
                <th>MTRF</th>
                <th>MTRF<br>Date</th>
                <th>Servicing Done</th>
                <th>Present Status</th>
                <th>Comment</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($MaterialServicing as $key1 => $values)
                    @foreach ($values as $key => $value)
                        <tr>
                            <td>{{ $value->first()->fixedAsset->tag }}</td>
                            <td>{{ $value->first()->fixedAsset->materialReceive->purchaseorder->supplier->name ?? '' }}</td>
                            <td>{{ $value->first()->fixedAsset->materialReceive->purchaseorder->date ?? '' }}</td>
                            <td>{{ $value->first()->movementdetails->last()->movementRequisition->toCostCenter->name ?? ''}}</td>
                            <td>{{ $value->first()->movementdetails->last()->movementRequisition->date ?? ''  }}</td>
                            <td>{{ $value->flatten()->count('id')}}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div> <!-- end table responsive -->
@endsection


@section('script')
    <script>

    </script>
@endsection
