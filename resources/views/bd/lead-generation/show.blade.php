@extends('layouts.backend-layout')
@section('title', 'BD Lead Details')

@section('breadcrumb-title')
    Showing information of Lead Genaration  #{{$bd_lead->id}}
@endsection

@section('breadcrumb-button')
    <a href="{{ url('bd_lead') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid',null)

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                    <tr><td> <strong>Project Category</strong> </td> <td> <strong>{{ $bd_lead->category}}</strong></td></tr>
                    <tr><td> <strong>Land Category</strong> </td> <td>  {{ $bd_lead->land_under}}</td></tr>
                    <tr><td> <strong>Lead Stage</strong> </td> <td>  {{ $bd_lead->lead_stage}}</td></tr>
                    <tr><td> <strong>Land Status</strong> </td> <td>  {{ $bd_lead->land_status}}</td></tr>
                    <tr><td> <strong>Source</strong> </td> <td>  {{ $bd_lead->source->name}}</td></tr>
                    <tr><td> <strong>Land Size</strong> </td> <td>  {{ $bd_lead->land_size}}</td></tr>
                    <tr><td> <strong>Front Road Size</strong> </td> <td>  {{ $bd_lead->front_road_size}}</td></tr>
                    {{-- <tr><td> <strong>Side Road Size</strong> </td> <td>  {{ $bd_lead->side_road_size}}</td></tr> --}}
                    <tr><td> <strong>Land Location</strong> </td> <td>  {{ $bd_lead->land_location}}</td></tr>
                    <tr><td> <strong>Remarks</strong> </td> <td>  {{ $bd_lead->remarks}}</td></tr>
                    <tr><td> <strong>Survey Report</strong> </td> <td>  <a href='{{route("bd_lead.ShowFile",\Illuminate\Support\Facades\Crypt::encryptString($bd_lead->id))}}' target="_blank">Show</a></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>Details<span>&#10070;</span> </h5>
            </div>
            <div class="table-responsive">
                <table id="supplierTable" class="table table-striped table-sm text-center table-bordered" >
                    <thead>
                    <tr>
                        <th width="300px">Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Present Address</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($bd_lead->BdLeadGenerationDetails as $key => $value )
                            <tr>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->mobile }}</td>
                                <td>{{ $value->mail }}</td>
                                <td>{{ $value->present_address }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>  <!-- supplier table  -->
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="col-md-12">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>Attachments<span>&#10070;</span> </h5>
            </div>
            <div class="table-responsive">
                <table id="supplierTable" class="table table-striped table-sm text-center table-bordered" >
                  
                    <tbody>
                        @foreach ($bd_lead->BdLeadGenerationPictures as $key => $value )
                            <tr>
                                <td>Attachment {{ $loop->iteration }}</td>
                                <td> <a href='{{route("bd_lead.attachment.ShowFile",\Illuminate\Support\Facades\Crypt::encryptString($value->id))}}' target="_blank">Show</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>  <!-- supplier table  -->
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
