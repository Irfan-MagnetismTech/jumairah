@extends('layouts.backend-layout')
@section('title', 'Sell Details')

@section('breadcrumb-title')
    Showing Activities of {{strtoupper($sell->sellClient->client->name)}}
@endsection

@section('breadcrumb-button')
    <a href="{{ url('sells') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid',null)

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="tableHeading">
            <h5> <span>&#10070;</span> Activities <span>&#10070;</span> </h5>
        </div>
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date (Time)</th>
                        <th> Activity Type </th>
                        <th> Reason</th>
                        <th> Client Feedback</th>
                        <th> Remarks</th>
                    </tr>
                </thead>
                <tbody class="text-left">
                    @forelse($sell->saleactivities as $saleactivity)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                <strong>{{$saleactivity->date}}</strong> <br>
                                {{\Carbon\Carbon::createFromFormat('H:i', $saleactivity->time_from)->format('h:i:a')}}- {{\Carbon\Carbon::createFromFormat('H:i', $saleactivity->time_till)->format('h:i:a')}}
                            </td>
                            <td>{{$saleactivity->activity_type}}</td>
                            <td class="breakWords"><strong>{{$saleactivity->reason}}</strong></td>
                            <td class="breakWords">{{$saleactivity->feedback}}</td>
                            <td class="breakWords">{{$saleactivity->remarks}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <h5 class="text-muted my-3 text-left"> No Record Found. </h5>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="tableHeading">
            <h5> <span>&#10070;</span> Client(s) <span>&#10070;</span> </h5>
        </div>
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                @foreach($saleClients as $sellClient)
                    <tbody class="text-left">
                    <tr>
                        <th class="text-left">Client Name </th>
                        <th class="text-left">
                            <a href="{{route('sells.show', $sell->id)}}" class="text-warning"><strong>{{$sellClient->client->name}}</strong></a>
                        </th>
                    </tr>
                    <tr>
                        <td> Contact</td>
                        <td> {{$sellClient->client->contact}} </td>
                    </tr>
                    <tr>
                        <td> Picture</td>
                        <td>
                            @if($sellClient->client->picture)
                                <img src="{{asset("storage/$sellClient->client->picture")}}" alt="" width="80px" height="auto">
                            @else
                                Not Uploaded
                            @endif
                        </td>
                    </tr>
                    @if(!$loop->last)
                        <tr class="text-center" style="border: none; background: #FFF">
                            <td colspan="2"> </td>
                        </tr>
                    @endif
                    </tbody>
                @endforeach
            </table>
        </div> <!-- end  table-responsive-->
    </div> <!-- end col-lg-- -->

    @if($sell->sellClient->client->notifications)
        <div class="col-lg-6">
            <div class="tableHeading">
                <h5> <span>&#10070;</span> System's Notifications <span>&#10070;</span> </h5>
            </div>
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Delivered Date & Time </th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sell->sellClient->client->notifications as $notification)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                <strong>{{$notification->created_at->format('d-m-Y')}}</strong> <br>
                                {{$notification->created_at->format('h:i:s a')}}
                            </td>
                            <td class="text-left breakWords">
                                @foreach($notification->data as $key => $data)
                                    <strong> {{$key}} </strong> : {{$data}} <br>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div> <!-- end row -->
@endsection

@section('script')

@endsection
