@extends('boq.calculation.layout.app', ['sidebar_boq_areas' => $sidebar_boq_areas])
@section('title', 'BOQ - Floor Wise Record')
@section('project-name')
    <a href="{{ route('boq.project.departments.civil.materials.calculations.index', ['project' => $project]) }}" style="color:white;">{{ $project->name }}</a>
@endsection

@section('breadcrumb-title')
    {{ $boq_area->name }}
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')
{{--    <form action="{{ route('boq.project.departments.civil.materials.floorwise.data',["project" => $project,"boq_area" => $boq_area]) }}" method="get" enctype="multipart/form-data" class="custom-form">--}}
{{--        @include('boq.calculation.record-form')--}}
{{--        @include('components.buttons.submit-button', ['label' => 'Show'])--}}
{{--    </form>--}}
{{--    <br>--}}
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="work-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Dia</th>
                            <th>Length</th>
                            <th>Member No</th>
                            <th>Bar No</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Dia</th>
                        <th>Length</th>
                        <th>Member No</th>
                        <th>Bar No</th>
                        <th>Quantity</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($calculations as $calculation)
                        <tr>
                            <td colspan="7"><b>{{ \Illuminate\Support\Str::ucfirst($calculation->boq_area->boqCommonFloor->name ?? '') }}</b></td>
                        </tr>
                        @foreach($calculation?->boqReinforcementDetails as $boqReinforcementDetail)
                            <tr>
                                <td> {{ $loop->iteration }} </td>
                                <td> {{ $boqReinforcementDetail->name }} </td>
                                <td> {{ $boqReinforcementDetail->dia }} </td>
                                <td> {{ $boqReinforcementDetail->length }} </td>
                                <td> {{ $boqReinforcementDetail->member_no }} </td>
                                <td> {{ $boqReinforcementDetail->bar_no }} </td>
                                <td> <b>{{ $boqReinforcementDetail->quantity }}</b> </td>
                            </tr>
                        @endforeach
                    @endforeach
                    @if(count($calculations)==0)
                        <tr>
                            <td colspan="7">no Data Found</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="float-right">

                </div>
            </div>
        </div>
    </div>
@endsection
