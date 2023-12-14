@extends('layouts.backend-layout')
@section('title', 'Budget List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
    <style>
        #tableArea {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        table,
        table th,
        table td {
            border-spacing: 0;
            border: 1px solid #a09e9e;
        }

        table th,
        table td {
            padding: 5px;
        }

        .base_header {
            font-weight: bold;
            text-align: left;
        }

        .balance_header {
            font-weight: bold;
            padding-left: 20px;
            text-align: left;
        }

        .balance_line {
            font-weight: bold;
            padding-left: 50px;
            text-align: left;
        }

        .account_line {
            padding-left: 80px;
            text-align: left;
        }

        table tbody td:nth-child(4),
        table tbody td:nth-child(3) {
            text-align: right;
        }

        .text-right {
            text-align: right;
        }

        .text-right {
            text-align: left;
        }
    </style>

@endsection

@section('breadcrumb-title')
    Material Budget List
@endsection

@section('breadcrumb-button')
    {{-- <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}}
@endsection

@section('sub-title')
    {{-- Total: {{ count($projects) }} --}}
@endsection


@section('content')
    <form action="" method="get">
        <div class="row px-2">
            <div class="col-md-1 px-1 my-1" data-toggle="tooltip" title="Output">
                <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                    <option value="list" selected> List </option>
                    <option value="pdf"> PDF </option>
                    <option value="excel"> Excel </option>
                </select>
            </div>
            <div class="col-md-3 px-1 my-1">
                <input type="text" id="project_name" name="project_name" class="form-control form-control-sm"
                    value="{{ request()->project_name ?? null }}" placeholder="Project Name Search" autocomplete="off">
                <input type="hidden" id="project_id" name="project_id" class="form-control form-control-sm"
                    value="{{ request()->project_id ?? null }}">
            </div>
            <div class="col-md-3 px-1 my-1">
                <input type="text" id="material_name" name="material_name" class="form-control form-control-sm"
                    value="{{ request()->material_name ?? null }}" placeholder="Material Name Search" autocomplete="off">
                <input type="hidden" id="material_id" name="material_id" class="form-control form-control-sm"
                    value="{{ request()->material_id ?? null }}">
            </div>
            <div class="col-md-3 pr-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm input-group-primary">
                    {{-- <label class="input-group-addon" for="project_id">Is Allocate<span class="text-danger"></span></label> --}}
                    <input type="radio" id="civil" name="type"
                        style="height:20px; width:20px; margin-left: 30px; margin-top: 8px" value="civil"
                        {{ !empty(request()->type) && request()->type == 'civil' ? 'checked' : '' }}>
                    <label style="margin-left: 5px; margin-top: 12px" for="civil">Civil</label><br>

                    <input type="radio" id="sanitary" name="type"
                        style="height:20px; width:20px; margin-left: 30px; margin-top: 8px" value="sanitary"
                        {{ !empty(request()->type) && request()->type == 'sanitary' ? 'checked' : '' }}>
                    <label style="margin-left: 5px; margin-top: 12px" for="sanitary">Sanitary</label><br>

                    <input type="radio" id="eme" name="type"
                        style="height:20px; width:20px; margin-left: 30px; margin-top: 8px" value="eme"
                        {{ !empty(request()->type) && request()->type == 'eme' ? 'checked' : '' }}>
                    <label style="margin-left: 5px; margin-top: 12px" for="eme">EME</label><br>
                </div>
            </div>
            <div class="col-md-1 px-1 my-1">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    @if ($material_statements)
    {{-- <h2 class="text-center"> {{request()->line_name ?? null}} </h2> --}}
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
                                {{ \Illuminate\Support\Str::limit($material?->boqCivilCalcProjectFloor?->boqCommonFloor?->name, 50) }}
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
    @endif

@endsection

@section('script')
    <script>
        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {

            $("#project_name").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('scj.projectAutoSuggestWithoutBOQ') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#project_name').val(ui.item.label);
                    $('#project_id').val(ui.item.project_id);
                    return false;
                }
            }).change(function() {
                if (!$(this).val()) {
                    $('#project_id').val(null);
                }
            });

            $("#material_name").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('materialAutoSuggest') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#material_name').val(ui.item.label);
                    $('#material_id').val(ui.item.material_id);
                    return false;
                }
            }).change(function() {
                if (!$(this).val()) {
                    $('#material_id').val(null);
                }
            });

        }); //document.ready
    </script>
@endsection
