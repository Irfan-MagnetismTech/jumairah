@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Material Calculation List')
@section('project-name')
    <a href="{{ route('boq.project.departments.civil.calculations.index', ['project' => $project, 'calculation_type' => $calculation_type]) }}" style="color:white;">{{ $project->name }}</a>
@endsection

@section('breadcrumb-title')

@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')
    <form action="{{ route('boq.project.departments.civil.calculations.index', ['project' => $project, 'calculation_type' => $calculation_type]) }}" method="get" enctype="multipart/form-data" class="custom-form">
        @include('boq.departments.civil.calculation.record-form')
    </form>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="work-table" class="table table-striped table-bordered">
                    @if ($calculations?->boqCivilCalcWork->is_reinforcement == 0)
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Group Name</th>
                                <th>Sub Location</th>
                                <th>No</th>
                                <th>Length</th>
                                <th>Breadth</th>
                                <th>Height</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    @else
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Group Name</th>
                                <th>Sub Location</th>
                                <th>Dia</th>
                                <th>Length</th>
                                <th>No. of Member</th>
                                <th>No. of Bar</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    @endif
                    <tbody>
                    @php @endphp
                        @forelse($calculations ? $calculations->boqCivilCalcGroups : [] as $boqCivilCalcGroup)
                            @forelse($boqCivilCalcGroup ? $boqCivilCalcGroup->boqCivilCalcDetails : [] as $boqCivilCalcDetail)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    @if ($loop->first)
                                        <td rowspan="{{ $boqCivilCalcGroup->boqCivilCalcDetails->count() }}">
                                            <b>{{ Str::ucfirst($boqCivilCalcGroup->name) }}</b>
                                        </td>
                                    @endif
                                    <td> {{ $boqCivilCalcDetail->sub_location_name }} </td>
                                    <td> @money($boqCivilCalcDetail?->no_or_dia) </td>
                                    <td> @money($boqCivilCalcDetail?->length) </td>
                                    <td> @money($boqCivilCalcDetail?->breadth_or_member) </td>
                                    <td> @money($boqCivilCalcDetail?->height_or_bar) </td>
                                    <td> <b>@money($boqCivilCalcDetail?->total)</b> </td>
                                    @if ($loop->first)
                                        <td rowspan="{{ $boqCivilCalcGroup->boqCivilCalcDetails->count() }}">
                                            <div class="icon-btn">
                                                <nobr>
                                                    <a href="{{ route('boq.project.departments.civil.calculations.edit', ['project' => $project, 'calculation_type' => $calculation_type, 'calculation' => $boqCivilCalcGroup->id]) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    {{-- Will work on this later... --}}
                                                    {{-- <form action="{{ route("boq.project.departments.civil.calculations.destroy", ['project' => $project, 'calculation_type' => $calculation_type, 'calculation' =>  $boqCivilCalcGroup->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form> --}}
                                                </nobr>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                            @endforelse
                            <tr class="bg-c-yellow">
                                <td colspan="6" class="text-center">
                                </td>
                                <td class="text-center">
                                    <strong>Total</strong>
                                </td>
                                <td><strong>@money($boqCivilCalcGroup?->total)</strong></td>
                                <td></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">No data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if ($calculations?->boqCivilCalcWork->is_reinforcement == 0)
                            <tfoot>
                            <tr>
                                <th colspan="6"></th>
                                <th>Total</th>
                                <th>@money($calculations?->total)</th>
                                <th></th>
                            </tr>
                            </tfoot>
                    @else
                            <tfoot>
                            <tr>
                                <th colspan="6"></th>
                                <th>Total</th>
                                <th>@money($calculations?->total)</th>
                                <th></th>
                            </tr>
                            </tfoot>
                    @endif
                </table>
                <div class="float-right">

                </div>
            </div>
        </div>
    </div>
@endsection
