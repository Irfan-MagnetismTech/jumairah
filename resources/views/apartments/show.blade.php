@extends('layouts.backend-layout')
@section('title', 'Apartment')

@section('breadcrumb-title')
    Showing information of {{strtoupper($apartment->name)}}
@endsection

@section('breadcrumb-button')
    <a href="{{ url('apartments') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
{{--    <span class="text-danger">*</span> Marked are required.--}}
@endsection

@section('content-grid', 'col-md-12 col-lg-10 offset-lg-1')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <tbody class="text-left">
                    <tr class="bg-success"><td> <strong>Apartment ID</strong> </td> <td> <strong>{{ $apartment->name}}</strong></td></tr>
                    <tr><td> <strong>Project Name</strong> </td> <td> {{$apartment->project->name}}</td></tr>
                    <tr><td> <strong>Apartment Type</strong> </td> <td> {{$apartment->apartment_type}}</td></tr>
                    <tr><td> <strong>Apartment Status</strong> </td>
                        <td>
                            @if($apartment->sell)
                                <button class="btn btn-success btn-sm" disabled> Sold </button>
                            @else
                                <button class="btn btn-dark btn-sm" disabled> Unsold </button>
                            @endif
                        </td>
                    </tr>
                    <tr><td> <strong>Type</strong> </td> <td> {{ $apartment->type->type_name}}</td></tr>
                    <tr><td> <strong>Floor</strong> </td> <td> {{ $apartment->floor}}</td></tr>
                    <tr><td> <strong>Face</strong> </td> <td> {{ $apartment->face}}</td></tr>
                    <tr><td> <strong>Owner</strong> </td> <td> {{$apartment->owner  == 2 ? "LandOwner" : "Jumairah Holdings Ltd"}}</td></tr>
                    <tr><td> <strong>Apartment Size</strong> </td> <td> @money($apartment->apartment_size)</td></tr>
                    @if($apartment->owner  == 1)
                    <tr><td> <strong>Apartment Rate(SFT)</strong> </td> <td> @money($apartment->apartment_rate)</td></tr>
                    <tr><td> <strong>Apartment Value</strong> </td> <td> @money( $apartment->apartment_value)</td></tr>
                    <tr><td> <strong>Number of Parking</strong> </td> <td> {{ $apartment->parking_no}}</td></tr>
                    <tr><td> <strong>Parking Rate</strong> </td> <td> @money( $apartment->parking_rate)</td></tr>
                    <tr><td> <strong>Parking Price</strong> </td> <td> @money( $apartment->parking_price)</td></tr>
                    <tr><td> <strong>Number of Utility </strong> </td> <td> {{ $apartment->utility_no}}</td></tr>
                    <tr><td> <strong>Utility Rate</strong> </td> <td>@money($apartment->utility_rate)</td></tr>
                    <tr><td> <strong>Utility Fees</strong> </td> <td> @money( $apartment->utility_fees)</td></tr>
                    <tr><td> <strong>Number of Reserve</strong> </td> <td> {{ $apartment->reserve_no}}</td></tr>
                    <tr><td> <strong>Reserve Rate </strong> </td> <td> @money( $apartment->reserve_rate)</td></tr>
                    <tr><td> <strong>Reserve Fund</strong></td> <td>  @money( $apartment->reserve_fund)</td></tr>
                    <tr><td> <strong>Others</strong> </td> <td> @money( $apartment->others)</td></tr>
                    <tr><td> <strong>Total Price</strong> </td> <td> @money( $apartment->total_value)</td></tr>

                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div> <!-- end row -->


@endsection
