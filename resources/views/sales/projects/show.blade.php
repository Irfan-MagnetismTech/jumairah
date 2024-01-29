@extends('layouts.backend-layout')
@section('title', 'Project')

@section('breadcrumb-title')
    Showing information of {{strtoupper($project->name)}}
@endsection

@section('breadcrumb-button')
    <a href="{{ url('projects') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
{{--    <span class="text-danger">*</span> Marked are required.--}}
@endsection

@section('content-grid',null)

@section('content')
@php($currentUser = auth()->user())
<div class="row">
    <div class="col-lg-6 table-responsive">
        <table id="" class="table table-striped table-bordered text-center">
            <thead>
                <tr class="bg-success" style="background-color: #116A7B !important;">
                    <td colspan="{{$project->types+1}}">
                        <strong style="font-size: 14px">{{ $project->name}} (Residential)</strong> <br> {{ $project->location}}</td>
                </tr>
                <tr class="bg-warning">
                    <td style="width: 20px!important;">Floor</td>
                    @foreach($project->projectType as $type)
                        <td> {{$type->type_name}}</td>
                    @endforeach
                </tr>
            </thead>
            <tfoot>
                <tr class="bg-warning">
                    <td style="width: 20px!important;">Floor</td>
                    @foreach($project->projectType as $type)
                        <td> {{$type->type_name}}</td>
                    @endforeach
                </tr>
            </tfoot>
{{--            @php($i = $project->storied)--}}
            @if($project->category!='Residential cum Commercial')
                <?php
                    $i = $project->storied;
                    $loopStart = 0;
                    $cloopStart = 0;
                    $j = 0;
                ?>
            @else
                <?php
                    $i = $project->res_storied_to ?? $project->storied;
                    $j = $project->com_storied_to;
                    $loopStart = $project->res_storied_from - 1;
                    $cloopStart = $project->com_storied_from - 1;
                ?>

            @endif
            @while($i > $loopStart)
                <tr>
                    <td>{{$i}}</td>
                    @foreach($project->projectType as $type)
                        @if($project->apartments)
                            <td>
                                @foreach($project->apartments as $apartment)
                                    @if($type->type_name."-".$i == $apartment->name)
                                        @if($apartment->owner == 1)
                                            <h6 class="m-0">{{$apartment->name}} </h6>
                                            Size (SFT): @money($apartment->apartment_size)
                                            <h6 class="m-0">{{$apartment->owner == 1 ? config('company_info.company_fullname') : "Land Owner"}}</h6>
                                            @if($apartment->sell)
                                                <p class="m-1"><strong class="px-1 bg-danger rounded">SOLD</strong> <br></p>
                                                <strong class="breakWords">Client :
                                                    @if ($currentUser->hasrole(['CSD-Manager']))
                                                        <a href="{{ route('csd.sales-client-list') }}">
                                                            {{$apartment->sell->sellClient->client->name}}
                                                        </a>
                                                    @else
                                                    <a href="{{route('sells.show', $apartment->sell->id)}}" target="_blank">
                                                        {{$apartment->sell->sellClient->client->name}}
                                                    </a>
                                                    @endif
                                                </strong>
                                            @else
                                                <p class="m-1"><strong class="px-1 bg-success rounded">UNSOLD</strong> <br></p>
                                            @endif
                                        @else
                                            {{$apartment->name}} <br> Size (SFT): @money($apartment->apartment_size) <br>
                                            {{$apartment->owner == 1 ?  config('company_info.company_fullname') : "Land Owner"}}
                                        @endif
                                    @endif
                                @endforeach
                            </td>
                        @else
                            <td> Not Allotted Yet. </td>
                        @endif
                    @endforeach
                </tr>
                @php($i--)
            @endwhile
        </table>
    </div>
    <div class="col-lg-6">
        <table id="dataTable" class="table table-bordered text-center">
            <thead>
            <tr class="bg-info">
                <td  style="font-size: 14px;background-color: #116A7B !important;" colspan="{{count($project->parkings)}}"><strong >Parking of {{$project->name}} </strong> </td>
            </tr>
            </thead>
            @forelse($project->parkings as $parking)
                <tr>
                    @foreach($parking->parkingDetails as $parkingDetail)
                    {{-- @dd($parkingDetail); --}}
                        <td class="breakWords text-center {{$parkingDetail->parking_owner =="JHL" ? 'bg-success' : null}}" style="float: left;width:85px;height: 90px">
                            <h6 style="font-size: 14px;font-weight: 600;"> {{$parkingDetail->parking_name}}</h6>
                            @if($parkingDetail->soldParking->parking_rate)
                                <p class="text-center"><span class="label label-danger"><strong>SOLD</strong></span></p>
                                @if($parkingDetail->parking_owner=="JHL")
                                <strong style="font-size: 14px;color: #053225;">{{$parkingDetail->parking_owner}}</strong>
                                @else
                                    <strong class="text-danger">{{$parkingDetail->parking_owner}}</strong>
                                @endif
                            @else
                                <p class="text-center"><span class="label label-primary"><strong>UNSOLD</strong></span></p>
                                @if($parkingDetail->parking_owner=="JHL")
                                    <strong style="font-size: 14px;color: #053225;">{{$parkingDetail->parking_owner}}</strong>
                                @else
                                    <strong class="text-danger">{{$parkingDetail->parking_owner}} </strong>
                                @endif
                            @endif
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td>Not Allotted Yet.</td>
                </tr>
            @endforelse
        </table>
    </div>
    <div class="col-md-12">
        <table id="dataTable" class="table table-striped table-bordered text-center">
            <thead>
            <tr class="bg-success" style="background-color: #116A7B !important;">
                <td colspan="{{$maxValue > 0 ? $maxValue+1 : 2}}">
                    <strong style="font-size: 14px">{{ $project->name}} (Commercial)</strong> <br> {{ $project->location}}
                </td>
            </tr>
            <tr class="bg-warning">
                <td style="width: 20px!important;">Floor</td>
                <td colspan="{{$maxValue > 0 ? $maxValue : 0}}"></td>
            </tr>
            </thead>
            <tbody>
            @while($j > $cloopStart)
                <tr>
                    <td>{{$j}}</td>
                    @foreach($commercialApartments as $key => $commercialApartment)
                        @if($j == $key)
                            @foreach($commercialApartment as $apartment)
                                <td>
                                    {{--                        @if($type->type_name."-".$i == $apartment->name)--}}
                                    @if($apartment->owner == 1)
                                        <h6 class="m-0">{{$apartment->name}} </h6>
                                        Size (SFT): @money($apartment->apartment_size)
                                        <h6 class="m-0">{{$apartment->owner == 1 ?  config('company_info.company_fullname') : "Land Owner"}}</h6>
                                        @if($apartment->sell)
                                            <p class="m-1"><strong class="px-1 bg-danger rounded">SOLD</strong> <br></p>
                                            <strong class="breakWords">Client :

                                                    <a @can('project-create') href="{{route('sells.show', $apartment->sell->id)}}" target="_blank" @endcan >
                                                        {{$apartment->sell->sellClient->client->name}}
                                                    </a>

                                            </strong>
                                        @else
                                            <p class="m-1"><strong class="px-1 bg-success rounded">UNSOLD</strong> <br></p>
                                        @endif
                                    @else
                                        {{$apartment->name}} <br>
                                        Size (SFT): @money($apartment->apartment_size) <br>
                                        {{$apartment->owner == 1 ?  config('company_info.company_fullname') : "Land Owner"}}
                                    @endif
                                    {{--                        @endif--}}
                                </td>
                            @endforeach
                        @endif
                    @endforeach
                </tr>
                @php($j--)
            @endwhile
            </tbody>
        </table>
    </div>
    @can('project-create')
    <div class="col-lg-12">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <tbody class="text-left">
                    <tr class="bg-success"><td> <strong>Project Name</strong> </td> <td> <strong>{{ $project->name}}</strong></td></tr>
                    <tr><td> <strong>Location</strong> </td> <td> {{ $project->location}}</td></tr>
                    <tr><td> <strong>Project Status</strong> </td> <td> {{ $project->status}}</td></tr>
                    <tr><td> <strong>Category</strong> </td> <td> {{ $project->category}}</td></tr>
                    <tr><td> <strong>Signing Date</strong> </td> <td> {{ $project->signing_date}}</td></tr>
                    <tr><td> <strong>CDA Approval Date</strong> </td> <td> {{ $project->cda_approval_date}}</td></tr>
                    <tr><td> <strong>Inauguration Date</strong> </td> <td> {{ $project->innogration_date}}</td></tr>
                    <tr><td> <strong>Handover Date</strong> </td> <td> {{ $project->handover_date}}</td></tr>
                    <tr><td> <strong>Types</strong> </td> <td> {{ $project->types}}</td></tr>
                    <tr><td> <strong>Storied</strong> </td> <td> {{ $project->storied}}</td></tr>
                    <tr><td> <strong>Basement</strong> </td> <td> {{ $project->basement}}</td></tr>
                    <tr><td> <strong>Lift</strong> </td> <td> {{ $project->lift}}</td></tr>
                    <tr><td> <strong>Generator (KBA) </strong> </td> <td> {{ $project->generator}}</td></tr>
                    <tr><td> <strong>Land Size (Katha)</strong> </td> <td>  @money($project->landsize)</td></tr>
                    <tr><td> <strong>Buildup Areaa (SFT)</strong> </td> <td> @money($project->buildup_area)</td></tr>
                    <tr><td> <strong>Saleable area (SFT)</strong> </td> <td>  @money($project->sellable_area)</td></tr>
                    <tr><td> <strong>Land Owner Share</strong> </td> <td>{{ $project->landowner_share}}</td></tr>
                    <tr><td> <strong>Developer Share</strong> </td> <td> {{ $project->developer_share}}</td></tr>
                    <tr><td> <strong>Landowner saleable Area (SFT)</strong> </td> <td> @money($project->lO_sellable_area)</td></tr>
                    <tr><td> <strong>Developer saleable Area (SFT)</strong> </td> <td> @money ($project->developer_sellable_area)</td></tr>
                    <tr><td> <strong>Units</strong></td> <td>  {{ $project->units}}</td></tr>
                    <tr><td> <strong>Landowner Unit</strong> </td> <td> {{ $project->landowner_unit}}</td></tr>
                    <tr><td> <strong>Developer Unit</strong> </td> <td> {{ $project->developer_unit}}</td></tr>
                    <tr><td> <strong>Parking</strong></td> <td>  {{ $project->parking}}</td></tr>
                    <tr><td> <strong>Landowner Parking</strong> </td> <td> {{ $project->landowner_parking}}</td></tr>
                    <tr><td> <strong>Developer Parking</strong> </td> <td> {{ $project->developer_parking}}</td></tr>
                    <tr><td> <strong>LandOwner Cash</strong> </td> <td> @money($project->landowner_cash_benefit) </td></tr>
                    <tr><td> <strong>Rebate Charge (%)</strong> </td> <td> @money($project->rebate_charge) </td></tr>
                    <tr><td> <strong>Delay Charge(%)</strong> </td> <td> @money($project->delay_charge) </td></tr>
                    <tr><td> <strong>Rental Compensation(%)</strong> </td> <td> @money($project->rental_compensation) </td></tr>
                    <tr><td> <strong>Project Features</strong> </td> <td> {{ $project->features}}</td></tr>
                    <tr><td> <strong>Project Cost</strong> </td> <td> @money($project->project_cost)</td></tr>


                    <tr><td> <strong>Agreement</strong></td>
                        <td>
                            @if($project->agreement)
                                <a href="{{ asset($project->agreement) }}" target="_blank">Click To see</a>
                            @else
                                <strong>Not Uploaded</strong>
                            @endif
                        </td>
                    </tr>
                    <tr><td> <strong>Floor Plan</strong> </td>
                        <td>
                            @if($project->floor_plan)
                                <a href="{{asset($project->floor_plan)}}" target="_blank">Click To see</a>
                            @else
                                <strong>Not Uploaded</strong>
                            @endif
                        </td>
                    </tr>
                    <tr><td> <strong>Others</strong></td>
                        <td>
                            @if($project->others)
                                <a href="{{asset($project->others)}}" target="_blank">Click To see</a>
                            @else
                                <strong>Not Uploaded</strong>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endcan
</div> <!-- end row -->
@can('project-create')
<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered text-center">
                <thead>
                <tr class="bg-success">
                    <th>#</th>
                    <th>Apartment<br>ID</th>
                    <th>Apartment<br>Size</th>
                    <th>Apartment<br>Rate</th>
                    <th>Apartment<br>Value</th>
                    <th>Parking</th>
                    <th>Utility</th>
                    <th>Reserve</th>
                    <th>Others</th>
                    <th>Total Price</th>
                    <th>Sold Price </th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody class="text-center">
                @if($project->apartments)
                    @forelse($inventories as $inventory)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$inventory->name}}</td>
                            <td class="text-right">@money($inventory->apartment_size)</td>
                            <td class="text-right">@money($inventory->apartment_rate)</td>
                            <td class="text-right">@money($inventory->apartment_value)</td>
                            <td class="text-right">@money($inventory->parking_price)</td>
                            <td class="text-right">@money($inventory->utility_fees)</td>
                            <td class="text-right">@money($inventory->reserve_fund)</td>
                            <td class="text-right">@money($inventory->others)</td>
                            <td class="text-right">@money($inventory->total_value)</td>
                            <td class="text-right">
                                @if($inventory->sell)
                                    @money($inventory->sell->total_value)
                                @else
                                    ---
                                @endif
                            </td>
                            <td>
                                @if($inventory->sell)
                                    <a href="{{route('sells.show', $inventory->sell->id)}}" target="_blank" class="btn btn-success btn-sm">Sold</a>
                                @else
                                    <button class="btn btn-dark btn-sm" disabled> Unsold </button>
                                @endif
                            </td>

                        </tr>
                    @empty

                    @endforelse
                    <tr class="bg-c-lite-green">
                        <td colspan="2">Total</td>
                        <td  class="text-right"><strong>@money($inventories->sum('apartment_size'))</strong></td>
                        <td  class="text-right"><strong>@money($inventories->sum('apartment_rate'))</strong></td>
                        <td  class="text-right"><strong>@money($inventories->sum('apartment_value'))</strong></td>
                        <td  class="text-right"><strong>@money($inventories->sum('parking_price'))</strong></td>
                        <td class="text-right"><strong>@money($inventories->sum('utility_fees'))</strong></td>
                        <td class="text-right"><strong>@money($inventories->sum('reserve_fund'))</strong></td>
                        <td class="text-right"><strong>@money($inventories->sum('others'))</strong></td>
                        <td class="text-right"> <strong> @money($inventories->sum('total_value')) </strong> </td>
                        <td class="text-right"><strong>@money($inventories->sum('sell.total_value'))</strong></td>
                        <td></td>
                    </tr>
                    <tr class="bg-warning">
                        <td colspan="12">
                            <h5>
                                @php($projectValue = $project->apartments->sum('total_value'))
                                Project Value : @money($projectValue) <br>
                            </h5>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div> <!-- end row -->
@endcan

@endsection

@section('script')

@endsection
