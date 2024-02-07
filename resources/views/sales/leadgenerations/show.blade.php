@extends('layouts.backend-layout')
@section('title', 'Lead Generation')

@section('breadcrumb-title')
    Showing information of {{strtoupper($leadgeneration->name)}}
@endsection

@section('breadcrumb-button')
    <a href="{{ url('leadgenerations') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
{{--    <span class="text-danger">*</span> Marked are required.--}}
@endsection

@section('content-grid',null)

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                    <tr class="bg-primary"><td> <strong>Name</strong> </td> <td> <strong>{{ $leadgeneration->name}}</strong></td></tr>
                    <tr><td> <strong>Contact</strong> </td> <td> {{ $leadgeneration->country_code}}-{{ $leadgeneration->contact}}</td></tr>
                    <tr><td> <strong>Contact Alternate</strong> </td> <td> {{ $leadgeneration->contact_alternate}}</td></tr>
                    <tr><td> <strong>Email</strong> </td> <td> {{ $leadgeneration->email}}</td></tr>
                    <tr><td> <strong>Profession</strong> </td> <td> {{ $leadgeneration->profession}}</td></tr>
                    <tr><td> <strong>Company Name</strong> </td> <td> {{ $leadgeneration->company_name}}</td></tr>
                    <tr>
                        <td> <strong>Business Card</strong> </td>
                        <td>
                            @if($leadgeneration && $leadgeneration->business_card)
                                <img src="{{asset($leadgeneration->business_card)}}" alt="" width="auto" height="80px">
                            @else
                                <strong>Not Uploaded</strong>
                            @endif
                        </td>
                    </tr>
                    @php($leadStage = ['A' => 'Priority', 'B' => 'Negotiation', 'C' => 'Lead'])
                    <tr><td> <strong>Spouse Name</strong> </td> <td> {{ $leadgeneration->spouse_name}}</td></tr>
                    <tr><td> <strong>Spouse Contact</strong> </td> <td> {{ $leadgeneration->spouse_contact}}</td></tr>
                    <tr><td> <strong>Present Address</strong> </td> <td> {{ $leadgeneration->present_address}}</td></tr>
                    <tr><td> <strong>Permanent Address</strong> </td> <td> {{ $leadgeneration->permanent_address}}</td></tr>
                    <tr><td> <strong>Nationality</strong> </td> <td> {{ $leadgeneration->nationality}}</td></tr>
                    <tr><td> <strong>Lead Date</strong> </td> <td> {{ $leadgeneration->lead_date}}</td></tr>
                    <tr><td> <strong>Lead Stage</strong> </td> <td> {{ $leadStage[$leadgeneration->lead_stage] }}</td></tr>
                    <tr><td> <strong>Source Type</strong> </td> <td> {{ $leadgeneration->source_type}}</td></tr>
                    <tr><td> <strong>Project</strong> </td> <td> {{ $leadgeneration->apartment->project->name}}</td></tr>
                    <tr><td> <strong>Apartment Id</strong> </td> <td> {{ $leadgeneration->apartment->name}}</td></tr>
                    <tr><td> <strong>Offer Details</strong> </td> <td> {{ $leadgeneration->offer_details}}</td></tr>
                    <tr>
                        <td> <strong>Attachment</strong> </td>
                        <td>
                            @if($leadgeneration && $leadgeneration->attachment)
                                <img src="{{asset($leadgeneration->attachment)}}" alt="" width="auto" height="80px">
                            @else
                                <strong>Not Uploaded</strong>
                            @endif
                        </td>
                    </tr>
                    <tr><td> <strong>Remarks</strong> </td> <td> {{ $leadgeneration->remarks}}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="table-responsive">

                <table id="dataTable" class="table table-striped table-bordered">
                    <thead>
                        <tr class="bg-primary text-center"><td colspan="5"><strong>Activity/Followup</strong></td></tr>
                        <tr class="text-center">
                            <td>Date</td>
                            <td>Time From</td>
                            <td>Time Till</td>
                            <td>Reason</td>
                            <td>Feedback</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leadgeneration->followups as $followup)
                            <tr>
                            <td>{{$followup->date}}</td>
                            <td>{{$followup->time_from}}</td>
                            <td>{{$followup->time_till}}</td>
                            <td>{{$followup->reason}}</td>
                            <td>{{$followup->feedback}}</td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center"> <p class="text-muted my-2"> No Activity. </p> </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end row -->

@endsection
