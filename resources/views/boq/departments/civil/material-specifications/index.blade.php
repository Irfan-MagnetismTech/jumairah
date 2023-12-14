@extends('boq.layout.app')
@section('title', 'BOQ - Material Specification List')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection
@section('project-name')
    <a href="{{ route('boq.project.material-specifications.index', ['project' => $project]) }}"
        style="color:white;">{{ $project->name }}</a>
@endsection

@section('breadcrumb-title')
    List of Material Specifications
@endsection

@section('content-grid', 'col-12')
@section('breadcrumb-button')
    <a href="{{ route('boq.project.material-specifications.create', ['project' => $project]) }}"
        class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

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
        329224
        1914504940
    </style>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="3">
                    <h5>{{ $project->name }}</h5>
                    <h6>{{ $project->location }}</h6>
                    <h6>Total buildup area - {{ number_format($project->boqFloorProjects()->sum('area'),2) }}  Sft, <span style="font-size: 14px">Total Land Area: <strong>{{ $project->landsize }}</strong> Khata</span></h6>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3" style="text-align: center">
                    <h5>Material Specifications</h5>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL #</th>
                <th>DESCRIPTION OF ITEM</th>
                <th>UNIT</th>
                <th>BRAND & SPECIFICATION</th>
                <th>UNIT PRICE IN TK.</th>
                <th>REMARKS</th>
            </tr>
        </thead>
        <tbody>
            @if (count($boqCivilMaterialSpecifications) > 0)
                @foreach ($boqCivilMaterialSpecifications as $key => $boqCivilMaterialSpecification)
                    <tr>
                        <td colspan="5"><strong style="font-weight: bold;font-size: 13px">{{ $key }}</strong>
                        </td>
                        <td style="float: right">
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('boq.project.editmatSpecItemHead', ['project' => $project, 'materialSpecificationItemHead' => $key]) }}"
                                        data-toggle="tooltip" title="Edit" class="btn btn-outline-warning">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form
                                        action="{{ route('boq.project.deletematSpecItemHead', ['project' => $project, 'materialSpecificationItemHead' => $key]) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </nobr>
                            </div>
                        </td>
                    </tr>
                    <?php $headWiseTotalAmount = 0;
                    $sl = 1; ?>
                    @foreach ($boqCivilMaterialSpecification as $item)
                        <tr>
                            <td class="text-center">{{ $sl }}</td>
                            <td>{{ $item?->item_name }}</td>
                            <td>{{ $item?->unit?->name }}</td>
                            <td>{{ $item?->specification }}</td>
                            <td>{{ $item?->unit_price }}</td>
                            <td>{{ $item?->remarks }}</td>
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
@endsection
