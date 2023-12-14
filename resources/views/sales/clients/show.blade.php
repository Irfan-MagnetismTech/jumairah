@extends('layouts.backend-layout')
@section('title', 'Client')

@section('breadcrumb-title')
    Showing information of {{strtoupper($client->name)}}
@endsection

@section('breadcrumb-button')
    <a href="{{ url('clients') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
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
                <tr class="bg-success"><td> <strong>Client Name</strong> </td> <td> <strong>{{ $client->name}}</strong></td></tr>
                <tr>
                    <td> <strong>Client Picture</strong> </td>
                    <td>
                        @if($client && $client->picture)
                            <img src="{{asset("storage/$client->picture")}}" alt="" width="auto" height="80px">
                        @else
                            <strong>Not Uploaded</strong>
                        @endif
                    </td>
                </tr>
                <tr><td> <strong>Father's Name</strong> </td> <td> {{ $client->father_name}}</td></tr>
                <tr><td> <strong>Mother's Name</strong> </td> <td> {{ $client->mother_name}}</td></tr>
                <tr><td> <strong>Spouse Name</strong> </td> <td> {{ $client->spouse_name}}</td></tr>
                <tr><td> <strong>Date of Birth</strong> </td> <td> {{ $client->dob}}</td></tr>
                <tr><td> <strong>Marriage Anniversary</strong> </td> <td> {{ $client->marriage_anniversary}}</td></tr>
                <tr><td> <strong>Nationality</strong> </td> <td> {{ $client->nationality}}</td></tr>
                <tr><td> <strong>Occupation</strong> </td> <td> {{ $client->profession}}</td></tr>
                <tr><td> <strong>Present Address</strong> </td> <td class="breakWords"> {{ $client->present_address}}</td></tr>
                <tr><td> <strong>Permanent Address</strong> </td> <td class="breakWords"> {{ $client->permanent_address}}</td></tr>
                <tr><td> <strong>Email</strong> </td> <td> {{ $client->email}}</td></tr>
                <tr><td> <strong>Contact</strong> </td> <td> {{ $client->contact}}</td></tr>
                <tr><td> <strong>Office Contact</strong> </td> <td> {{ $client->contact_alternate}}</td></tr>
                <tr><td> <strong>Spouse Contact</strong> </td> <td> {{ $client->spouse_contact}}</td></tr>
                <tr><td> <strong>TIN</strong> </td> <td>{{ $client->tin}}</td></tr>
                <tr><td> <strong>Authorized Name</strong> </td> <td> {{ $client->auth_name}}</td></tr>
                <tr><td> <strong>Authorized Address</strong> </td> <td> {{ $client->auth_address}}</td></tr>
                <tr><td> <strong>Authorized Conatct </strong> </td> <td> {{ $client->auth_contact}}</td></tr>
                <tr><td> <strong>Authorized Email</strong></td> <td>  {{ $client->auth_email}}</td></tr>

                <tr><td> <strong>Client Profile</strong> </td>
                    <td>
                        @if($client->client_profile)
                            <a href="{{ asset("storage/$client->client_profile")}}" target="_blank">Click To see</a>
                        @else
                            <strong>Not Uploaded</strong>
                        @endif
                    </td>
                </tr>
                <tr>

                    <td> <strong>Authorized Picture</strong> </td>
                    <td>
                        @if($client && $client->auth_picture)
                            <img src="{{asset("storage/$client->auth_picture")}}" alt="" width="auto" height="80px">
                        @else
                            <strong>Not Uploaded</strong>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
{{--        <div class="table-responsive">--}}
{{--            <table id="dataTable" class="table table-striped table-bordered">--}}
{{--                <tbody class="text-left">--}}
{{--                    <tr class="bg-success"><td> <strong>Name</strong> </td> <td> <strong>{{ $client->name}}</strong></td></tr>--}}
{{--                    <tr>--}}
{{--                        <td> <strong>Client Picture</strong> </td>--}}
{{--                        <td><img src="{{asset($client->picture)}}" alt="" width="auto" height="80px"></td>--}}
{{--                    </tr>--}}
{{--                    <tr><td> <strong>Father's Name</strong> </td> <td> {{ $client->father_name}}</td></tr>--}}
{{--                    <tr><td> <strong>Mother's Name</strong> </td> <td> {{ $client->mother_name}}</td></tr>--}}
{{--                    <tr><td> <strong>Spouse Name</strong> </td> <td> {{ $client->spouse_name}}</td></tr>--}}
{{--                    <tr><td> <strong>Date of Birth</strong> </td> <td> {{ $client->dob}}</td></tr>--}}
{{--                    <tr><td> <strong>Marriage Anniversary</strong> </td> <td> {{ $client->marriage_anniversary}}</td></tr>--}}
{{--                    <tr><td> <strong>Nationality</strong> </td> <td> {{ $client->nationality}}</td></tr>--}}
{{--                    <tr><td> <strong>Occupation</strong> </td> <td> {{ $client->profession}}</td></tr>--}}
{{--                    <tr><td> <strong>Present Address</strong> </td> <td> {{ $client->present_address}}</td></tr>--}}
{{--                    <tr><td> <strong>Permanent Address</strong> </td> <td> {{ $client->permanent_address}}</td></tr>--}}
{{--                    <tr><td> <strong>Email</strong> </td> <td> {{ $client->email}}</td></tr>--}}
{{--                    <tr><td> <strong>Contact</strong> </td> <td> {{ $client->contact}}</td></tr>--}}
{{--                    <tr><td> <strong>Office Contact</strong> </td> <td> {{ $client->contact_alternate}}</td></tr>--}}
{{--                    <tr><td> <strong>TIN</strong> </td> <td>{{ $client->tin}}</td></tr>--}}
{{--                    <tr><td> <strong>Authorized Name</strong> </td> <td> {{ $client->auth_name}}</td></tr>--}}
{{--                    <tr><td> <strong>Authorized Address</strong> </td> <td> {{ $client->auth_address}}</td></tr>--}}
{{--                    <tr><td> <strong>Authorized Contact </strong> </td> <td> {{ $client->auth_contact}}</td></tr>--}}
{{--                    <tr><td> <strong>Email</strong></td> <td>  {{ $client->auth_email}}</td></tr>--}}
{{--                    <tr>--}}
{{--                        <td> <strong>Authorized Picture</strong> </td>--}}
{{--                        <td> <a href="{{asset($client->auth_picture)}}" target="_blank">Click To see</a></td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td> <strong>Client Profile</strong> </td>--}}
{{--                        <td> <a href="{{asset($client->client_profile)}}" target="_blank">Click To see</a></td>--}}
{{--                    </tr>--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}
    </div>
    <div class="col-lg-6">
        <p class="text-center font-weight-bold">Information of Nominee</p>
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered text-center">
                <thead>
                <tr>
                    <th>Sl.</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Relation</th>
                    <th>Address</th>
                    <th>Picture</th>
                </tr>
                </thead>
                <tbody>
                @foreach($client->clientNominee as $nominee)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$nominee->nominee_name}}</td>
                        <td>{{$nominee->age}}</td>
                        <td>{{$nominee->relation}}</td>
                        <td>{{$nominee->address}}</td>
                        <td>
                            @if($nominee->nominee_picture)
                                <img src="{{asset("storage/$nominee->nominee_picture")}}" alt="" width="auto" height="80px">
                            @else
                                <strong>Not Uploaded</strong>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
{{--        <div class="table-responsive">--}}
{{--            <table id="dataTable" class="table table-striped table-bordered">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                <th>Sl.</th>--}}
{{--                <th>Name</th>--}}
{{--                <th>Age</th>--}}
{{--                <th>Relation</th>--}}
{{--                <th>Address</th>--}}
{{--                <th>Picture</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody class="text-left">--}}
{{--                    @foreach($client->clientNominee as $nominee)--}}
{{--                        <tr>--}}
{{--                            <td>{{$loop->iteration}}</td>--}}
{{--                            <td>{{$nominee->name}}</td>--}}
{{--                            <td>{{$nominee->age}}</td>--}}
{{--                            <td>{{$nominee->relation}}</td>--}}
{{--                            <td>{{$nominee->address}}</td>--}}
{{--                            <td>--}}
{{--                                @if($nominee->nominee_picture)--}}
{{--                                    <img src="{{asset($nominee->nominee_picture)}}" alt="" width="auto" height="80px">--}}
{{--                                @else--}}
{{--                                    <strong>Not Uploaded</strong>--}}
{{--                                @endif--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}
    </div>
</div> <!-- end row -->

@endsection

@section('script')

@endsection
