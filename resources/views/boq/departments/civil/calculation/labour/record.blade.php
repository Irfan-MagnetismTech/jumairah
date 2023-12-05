@extends('boq.calculation.labour.layout.app', ['sidebar_boq_areas' => $sidebar_boq_areas])
@section('title', 'BOQ - Floor Wise Labour Record')
@section('project-name')
    <a href="{{ route('boq.project.departments.civil.labours.calculations.index', ['project' => $project]) }}" style="color:white;">{{ $project->name }}</a>
@endsection

@section('breadcrumb-title')
    {{ $boq_area->name }}
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')
    <form action="{{ route('boq.project.departments.civil.labours.floorwise.data', ['project' => $project, 'boq_area' => $boq_area]) }}" method="get" enctype="multipart/form-data" class="custom-form">
        @include('boq.calculation.labour.record-form')
        @include('components.buttons.submit-button', ['label' => 'Show'])
    </form>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="work-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>No</th>
                            <th>Length</th>
                            <th>Breadth</th>
                            <th>Height</th>
                            <th>Total</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>No</th>
                            <th>Length</th>
                            <th>Breadth</th>
                            <th>Height</th>
                            <th>Total</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse($calculations ? $calculations->boqLabourSubLocationGroups : [] as $boqLabourSubLocationGroup)
                            <tr>
                                <td colspan="7"><b>{{ Str::ucfirst($boqLabourSubLocationGroup->name) }}</b></td>
                            </tr>
                            @forelse($boqLabourSubLocationGroup ? $boqLabourSubLocationGroup->boqLabourSubLocationGroupDetails : [] as $boqLabourSubLocationGroupDetail)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $boqLabourSubLocationGroupDetail->name }} </td>
                                    <td> {{ $boqLabourSubLocationGroupDetail->no }} </td>
                                    <td> {{ $boqLabourSubLocationGroupDetail->length }} </td>
                                    <td> {{ $boqLabourSubLocationGroupDetail->breadth }} </td>
                                    <td> {{ $boqLabourSubLocationGroupDetail->height }} </td>
                                    <td> <b>{{ $boqLabourSubLocationGroupDetail->total }}</b> </td>
                                    {{-- <td> --}}
                                    {{-- @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.configurations.material.price', 'route_key' => $boqLabourSubLocationGroup->id]) --}}
                                    {{-- </td> --}}
                                </tr>
                            @empty
                            @endforelse
                        @empty
                            <tr>
                                <td colspan="7">No data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="float-right">

                </div>
            </div>
        </div>
    </div>
@endsection
