@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Material Specification List')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection
@section('project-name')
    <a href="{{ route('boq.project.global-material-specifications.index', ['project' => $project]) }}"
        style="color:white;">{{ $project->name }}</a>
@endsection

@section('breadcrumb-title')
    List of Global Material Specifications
@endsection

@section('content-grid', 'col-12')
@section('breadcrumb-button')
@can('boq-civil')
<a href="{{ route('boq.project.global-material-specifications.create', ['project' => $project]) }}"
    class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection
@endcan

@section('sub-title')
    Total Item Head: {{ count($boqCivilMaterialSpecifications) }}
@endsection

@section('content')
    <style>
        tbody tr,
        td {
            text-align: left;
            white-space: normal;
        }

        tbody td {
            margin-left: 5px;
        }
    </style>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="3">
                    <h5>{{ $project->name }}</h5>
                    <h6>{{ $project->location }}</h6>
                    <h6>Total buildup area - {{ number_format($project->boqFloorProjects()->sum('area'), 2) }} Sft, <span
                            style="font-size: 14px">Total Land Area: <strong>{{ $project->landsize }}</strong> Khata</span>
                    </h6>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3" style="text-align: center">
                    <h5>Global Material Specifications</h5>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="table-responsive">
        <table class="table table-bordered ">
            <thead>
                <tr>
                    <th>SL #</th>
                    <th>DESCRIPTION OF ITEM</th>
                    <th>UNIT</th>
                    <th style="width:40%">BRAND & SPECIFICATION</th>
                    <th>UNIT PRICE IN TK.</th>
                    @can('boq-civil')
                    <th>REMARKS</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @if (count($boqCivilMaterialSpecifications) > 0)
                    @foreach ($boqCivilMaterialSpecifications as $key => $boqCivilMaterialSpecification)
                        <tr>
                            <td colspan="5"><strong
                                    style="font-weight: bold;font-size: 13px">{{ $key }}</strong>
                            </td>
                            @can('boq-civil')
                            <td style="float: right">
                                <div class="icon-btn">

                                    <a href="{{ route('boq.project.editglobalmatSpecItemHead', ['project' => $project, 'materialSpecificationItemHead' => $key]) }}"
                                        data-toggle="tooltip" title="Edit" class="btn btn-outline-warning">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form
                                        action="{{ route('boq.project.deleteglobalmatSpecItemHead', ['project' => $project, 'materialSpecificationItemHead' => $key]) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                            @endcan
                        </tr>
                        <?php $headWiseTotalAmount = 0;
                        $sl = 1; ?>
                        @foreach ($boqCivilMaterialSpecification as $item)
                            <tr>
                                <td class="text-center">{{ $sl }}</td>
                                <td>{{ $item?->item_name }}</td>
                                <td>{{ $item?->unit?->name }}</td>
                                <td style="width:40%">{{ $item?->specification }}</td>
                                <td>{{ $item?->unit_price }}</td>
                                @can('boq-civil')
                                <td>{{ $item?->remarks }}</td>
                                @endcan
                            </tr>
                            @php
                                $sl++;
                                $headWiseTotalAmount += $item?->total_amount;
                            @endphp
                        @endforeach
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">No data found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
