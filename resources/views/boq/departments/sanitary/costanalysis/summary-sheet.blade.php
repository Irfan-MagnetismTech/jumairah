@extends('boq.layout.app')

@section('project-name', $project->name)

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
    <style>
        .dataTables_info {
            display: none !important;
        }
    </style>
@endsection

@section('breadcrumb-title')
    Material Summary List [Sanitary]
@endsection

@section('content')
    <style>
        tbody tr,
        td {
            text-align: left;
        }

        tbody td {
            margin-left: 5px;
        }

        table th,
        table td,
        table tr {
            border: 1px solid black !important;
        }

        .select2-selection {
            height: 30px !important;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <form
                action="{{ route('boq.project.departments.sanitary.cost_analysis.floor_wise.material.summary', ['project' => $project]) }}"
                method="get">
                <div class="row px-2">
                    <div class="col-md-4 px-1 my-1 my-md-0" data-toggle="tooltip" title=""
                        data-original-title="Material List">
                        <select class="form-control form-control-sm select2" autocomplete="off" name="nested_material_id">
                            <option selected="selected" disabled>Select Material</option>
                            @foreach ($material_list as $material)
                                <option value="{{ $material->material_id }}"
                                    {{ request()->input('nested_material_id') == $material->material_id ? 'selected' : '' }}>
                                    {{ $material?->material?->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 px-1 my-1 my-md-0">
                        <div class="input-group input-group-sm">
                            <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div><!-- end row -->
                <a style="float: right" target="_blank"
                    href="{{ route('boq.project.departments.sanitary.cost_analysis.floor_wise.download.material.summary', ['project' => $project]) }}"
                    data-toggle="tooltip" title="" class="btn btn-outline-danger download_pdf mb-2"
                    data-original-title="Download PDF"><i class="fas fa-file-pdf"></i></a>

            </form>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="work-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SL.</th>
                            <th>Material Name</th>
                            <th>Unit</th>
                            <th>Floor Name</th>
                            <th><span class="numSpan">Quantity</span></th>
                            <th><span class="numSpan">Total</span></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $headWiseTotalAmount = 0;
                        $sl = 1;
                        ?>
                        @foreach ($material_statements as $material_statement_key => $material_statement)
                            @foreach ($material_statement['floors'] as $material_key => $material)
                                @if ($sl % 2 == 0)
                                    <?php $row_bg_color = '#f0efed'; ?>
                                @else
                                    <?php $row_bg_color = '#c9c7c1'; ?>
                                @endif

                                <tr style="background-color: {{ $row_bg_color }};">
                                    @if ($loop->first)
                                        <td style="font-weight: bold"
                                            rowspan="{{ $loop->first ? count($material_statement['floors']) : '' }}"
                                            class="text-center">
                                            @if ($loop->first)
                                                {{ $sl }}
                                            @endif
                                        </td>
                                        <td width="40%" style="font-size: 12px"
                                            rowspan="{{ $loop->first ? count($material_statement['floors']) : '' }}"
                                            class="font-weight-bold text-center">
                                            @if ($loop->first)
                                                {{ $material_statement['material_name'] }}
                                            @endif
                                        </td>
                                        <td width="10%"
                                            rowspan="{{ $loop->first ? count($material_statement['floors']) : '' }}"
                                            style="font-weight: bold;text-align: center">
                                            {{ $material_statement['material_unit'] }}
                                        </td>
                                    @endif
                                    <td style="font-weight: bold" width="30%">
                                        {{ \Illuminate\Support\Str::limit($material?->projectWiseMaterial?->floorProject?->boqCommonFloor?->name, 50) }}
                                    </td>
                                    <td style="font-weight: bold;font-size: 12px">
                                        <span class="float-right">@money($material['gross_total_quantity'])</span>
                                    </td>
                                    @if ($loop->first)
                                        <td rowspan="{{ $loop->first ? count($material_statement['floors']) : '' }}"
                                            style="font-weight: bold;font-size: 12px;text-align: center">
                                            <span style="text-align: center">@money($material_statement['total_quantity'])</span>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            <?php $sl++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function() {
            $('#work-table').DataTable({
                stateSave: true,
                bPaginate: false,
            });

        });

        $('.select2').select2();
    </script>
@endsection
