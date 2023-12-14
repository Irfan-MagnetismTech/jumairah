@extends('boq.calculation.material-labour.layout.app', ['sidebar_boq_areas' => $sidebar_boq_areas])
@section('title', 'BOQ - Floor Wise Labour Record')
@section('project-name')
    <a href="{{ route('boq.project.departments.civil.materialsAndLabours.calculations.index', ['project' => $project]) }}" style="color:white;">{{ $project->name }}</a>
@endsection

@section('breadcrumb-title')
    {{ $boq_area->name }}
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')
    <form action="{{ route('boq.project.departments.civil.materialsAndLabours.floorwise.data', ['project' => $project, 'boq_area' => $boq_area]) }}" method="get" enctype="multipart/form-data" class="custom-form">
        @include('boq.calculation.material-labour.record-form')
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
                        @forelse($calculations ? $calculations->boqMaterialLabourSubLocationGroups : [] as $boqMaterialLabourSubLocationGroup)
                            <tr>
                                <td colspan="7"><b>{{ Str::ucfirst($boqMaterialLabourSubLocationGroup->name) }}</b></td>
                            </tr>
                            @forelse($boqMaterialLabourSubLocationGroup ? $boqMaterialLabourSubLocationGroup->boqMaterialLabourSubLocationGroupDetails : [] as $boqMaterialLabourSubLocationGroupDetail)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $boqMaterialLabourSubLocationGroupDetail->name }} </td>
                                    <td> {{ $boqMaterialLabourSubLocationGroupDetail->no }} </td>
                                    <td> {{ $boqMaterialLabourSubLocationGroupDetail->length }} </td>
                                    <td> {{ $boqMaterialLabourSubLocationGroupDetail->breadth }} </td>
                                    <td> {{ $boqMaterialLabourSubLocationGroupDetail->height }} </td>
                                    <td> <b>{{ $boqMaterialLabourSubLocationGroupDetail->total }}</b> </td>
                                    {{-- <td> --}}
                                    {{-- @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.configurations.material.price', 'route_key' => $boqMaterialLabourSubLocationGroup->id]) --}}
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
