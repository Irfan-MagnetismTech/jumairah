@extends('boq.departments.civil.layout.app')
@section('project-name', $project->name)
@section('title', 'BOQ || Civil || Material Calculation')

@section('breadcrumb-button')
    {{--    <a href="{{ route('boq.project.departments.civil.calculations.index', ['project' => $project, 'calculation_type' => $calculation_type]) }}" class="btn btn-out-dashed btn-sm btn-warning">--}}
    {{--        <i class="fas fa-database"></i>--}}
    {{--    </a>--}}
@endsection

@section('content')
    <style>
        table.table-bordered {
            border: 1px solid black;
            margin-top: 5px;
        }

        table.table-bordered>thead>tr>th {
            border: 1px solid black;
        }

        table.table-bordered>tbody>tr>td {
            border: 1px solid black;
        }

        .input-text {
            border: none;
            width: 100%;
            height: 25px;
            display: block;
        }

        .input-fx {
            border-bottom: none;
            width: 100%;
            border-left: none;
            border-right: none;
            border-top: 1px solid black;
            height: 25px;
            display: none;
        }

        .font-bold {
            font-weight: bold;
        }

        .direction-ltr {
            text-align: right;
            direction: ltr;
        }

        .readonly {
            background-color: #e9ecef;
        }

        .bg-transparent {
            background-color: transparent;
            color: white;
        }

        .sub-total {
            background-color: #dbecdb;
        }

        .child-add-btn {
            background: transparent;
            border: none;
            width: 100%;
            height: 100%;
            cursor: pointer;
            color: #116A7B;
        }

        .child-delete-btn {
            background: transparent;
            border: none;
            width: 100%;
            height: 100%;
            cursor: pointer;
            color: #ff0000;
        }

        .material_checkbox{
            width: 15px;
            height: 15px;
            margin-right: 5px;
            margin-left: 5px
        }

        .material_checkbox_label {
            display: inline-flex;
            margin-right: 0px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #116A7B;
            border: 1px solid #116A7B;
            color: #fff;
        }

    </style>
    <form id="form" method="POST" enctype="multipart/form-data" class="custom-form">
        @csrf
        <!-- Work & Location -->
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="tableHeading">
                        <h5> <span>&#10070;</span>Area & Work type<span>&#10070;</span> </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="calculation_type" value="{{ $calculation_type }}">
                            <input type="hidden" name="final_total" id="final_total">
                        </div>
                        <!-- Location -->
                        <div class="row">
                            <div class="col-xl-12 col-md-12">

                            </div>
                        </div>

                        <div class="row m-0 mb-2" style="background-color: #dadada;border-radius: 2px">
                            <div class="col-xl-12 col-md-12" style="">
                                <h6 class="mt-3" style="color: #0C4A77;display: inline-flex;font-size: 11px">
                                    <span>
                                        <span class="text-capitalize">{{ $boq_civil_budghet?->boqCivilCalcFloorType?->name }} -></span>
                                         @foreach($workTree as $tree)
                                            <span>{{ $tree?->name }} @if($boq_civil_budghet?->boq_work_id != $tree?->id) -> @endif</span>
                                        @endforeach
                                    </span>
                                </h6>
                                <div class="float-right m-2">
                                    <a title="Create new calculation" href="{{ route('boq.project.departments.civil.calculations.create', ['project' => $project, 'calculation_type' => $calculation_type]) }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>

                        <div style="display: none">
                            <div class="row">
                                <div class="col-xl-12 col-md-12">
                                    <div class="input-group input-group-sm input-group-primary">
                                        <label class="input-group-addon" for="location-type">Location Type<span class="text-danger">*</span></label>
                                        <select class="form-control location_type" id="location-type" name="boq_floor_type[]" required>
                                            <option value="" disabled selected>--Select an Option--</option>
                                            @foreach ($boq_floor_types as $boq_floor_type)
                                                <option value="{{ $boq_floor_type->id }}" @if($boq_civil_budghet?->boq_floor_type_id == $boq_floor_type->id) selected @endif>{{ $boq_floor_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-md-12">
                                    <div class="input-group input-group-sm input-group-primary">
                                        <label class="input-group-addon" for="boq_floor_id">Sub Location<span class="text-danger">*</span></label>
                                        <select class="form-control boq_floor_id" id="boq_floor_id" name="boq_floor_id" required>
                                            <option value="" disabled selected>--Select an Option--</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Work -->
                            <div class="row">
                                <div class="col-xl-12 col-md-12" id="works-table">
                                    <div class="input-group input-group-sm input-group-primary" id="work-0">
                                        <label class="input-group-addon" for="work_id">Select Work<span class="text-danger">*</span></label>
                                        <select class="form-control work_id first_work" id="work_id" name="work_id[]">
                                            <option value="">--Select an Option--</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{--                        @if($calculation_type != "labour")--}}
                            <div class="row mb-1">
                                <div class="col-xl-12 col-md-12">
                                    <a href="#" id="copy-from-btn" style="font-weight: bold" data-toggle="modal" data-target="#default-Modal"> Copy From </a>
                                </div>
                            </div>
                        </div>
                        {{--                        @endif--}}
                        {{--                        @if($calculation_type != "labour")--}}
                        <div class="row m-0">
                            <div class="col-xl-12 col-md-12 p-2 bg-default" style="border-radius: 4px">
                                <center>
                                    <div class="row m-0">
                                        <div class="col-xl-12 col-md-12" style="">
                                            <h6 class="" style="color: #0C4A77;display: inline-flex"><span><i title="Hide" style="cursor: pointer" class="fa fa-eye-slash fa-lg calculation_material_list_hide" aria-hidden="true"></i></span> -- Material List -- <span><i title="Show" style="cursor: pointer" class="fa fa-eye fa-lg calculation_material_list_show" aria-hidden="true"></i></span></h6>
                                            {{--                                            <span class="text-danger">Note: Please uncheck material if you do not want to calculate the material...</span>--}}
                                        </div>
                                    </div>
                                </center>
                                <div class="table-responsive calculation_material_list_table">
                                    <table class="table table-striped table-bordered" id="work_material_list_table">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th style="width: 46%;word-wrap:break-word">Material Name</th>
                                            <th style="width: 18%;word-wrap:break-word">
                                                Price/Rate
                                            </th>
                                            <th style="width: 18%;word-wrap:break-word">Ratio</th>
                                            <th style="width: 18%;word-wrap:break-word">
                                                <span><i title="Hide" style="cursor: pointer" class="fa fa-eye-slash fa-sm calculation_material_wastage_hide mr-1" aria-hidden="true"></i></span> Wastage
                                                <span><i title="Hide" style="cursor: pointer" class="fa fa-eye fa-sm calculation_material_wastage_show ml-1" aria-hidden="true"></i></span>
                                            </th>
                                            {{--                                            <th><i class="btn btn-primary btn-sm fa fa-plus add-material-list-row" style="float: right"></i></th>--}}
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        </tfoot>
                                        <tbody class="work_material_list">

                                        </tbody>
                                    </table>
                                </div>

                                {{--                                <div class="work_material_list">--}}

                                {{--                                </div>--}}
                            </div>
                        </div>
                        {{--                        @endif--}}
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>

        <!-- Material Formula, Price & wastage -->
        {{-- <div class="mt-4 row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="tableHeading">
                        <h5> <span>&#10070;</span>Material Formula, Price & Wastage<span>&#10070;</span> </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="formula_table">
                            <thead>
                                <tr>
                                    <th> Material </th>
                                    <th> Unit </th>
                                    <th> Amount (%) </th>
                                    <th> Price (Tk) </th>
                                    <th> Wastage (%) </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="formula">
                                    <td>
                                        <span>Grey Cement</span>
                                    </td>
                                    <td>
                                        <span>Bag</span>
                                    </td>
                                    <td>
                                        <span>22 %</span>
                                    </td>
                                    <td>
                                        <span>12 Tk</span>
                                    </td>
                                    <td>
                                        <span>3 %</span>
                                    </td>
                                    <td>
                                        <a href="#">Change</a>
                                    </td>
                                </tr>
                                <tr class="formula">
                                    <td>
                                        <span>Sy. Sand (F.M 2.5)</span>
                                    </td>
                                    <td>
                                        <span>CFT</span>
                                    </td>
                                    <td>
                                        <span>42 %</span>
                                    </td>
                                    <td>
                                        <span>15</span>
                                    </td>
                                    <td>
                                        <span>35 %</span>
                                    </td>
                                    <td>
                                        <a href="#">Change</a>
                                    </td>
                                </tr>
                                <tr class="formula">
                                    <td>
                                        <span>Singles 3/4'</span>
                                    </td>
                                    <td>
                                        <span>CFT</span>
                                    </td>
                                    <td>
                                        <span>83 %</span>
                                    </td>
                                    <td>
                                        <span>12 Tk</span>
                                    </td>
                                    <td>
                                        <span>10 %</span>
                                    </td>
                                    <td>
                                        <a href="#">Change</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Calculation V2.1.0 -->
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="tableHeading">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <h5>
                                    <span>&#10070;</span>
                                    {{ $calculation_type ?? '' }} Calculations (<span id="workUnitSpan"></span>)
                                    <span>&#10070;</span>
                                </h5>
                            </div>
                            <div class="col-md-1">
                                <svg id="calculation-loader" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--eos-icons" width="32" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M12 2A10 10 0 1 0 22 12A10 10 0 0 0 12 2Zm0 18a8 8 0 1 1 8-8A8 8 0 0 1 12 20Z" opacity=".5"></path>
                                    <path fill="currentColor" d="M20 12h2A10 10 0 0 0 12 2V4A8 8 0 0 1 20 12Z">
                                        <animateTransform attributeName="transform" dur="1s" from="0 12 12" repeatCount="indefinite" to="360 12 12" type="rotate"></animateTransform>
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{--                    @if($calculation_type == "labour")--}}
                    {{--                        <div class="card-body">--}}
                    {{--                            <!-- Calculations -->--}}
                    {{--                            <div class="mt-1 row">--}}
                    {{--                                <div class="col-md-12">--}}
                    {{--                                    <table class="table" id="">--}}
                    {{--                                        <thead>--}}
                    {{--                                        <tr>--}}
                    {{--                                            <th> Quantity <span class="text-danger">*</span></th>--}}
                    {{--                                            <th> Rate <span class="text-danger">*</span></th>--}}
                    {{--                                            <th> Total Amount <span class="text-danger">*</span></th>--}}
                    {{--                                        </tr>--}}
                    {{--                                        </thead>--}}
                    {{--                                        <tbody>--}}
                    {{--                                        <tr>--}}
                    {{--                                            <td>--}}
                    {{--                                                <input class="form-control labour_quantity" name="quantity" type="text" value="{{ $statement?->quantity }}" readonly>--}}
                    {{--                                                <input type="hidden" name="id" value="{{ $statement?->id }}">--}}
                    {{--                                            </td>--}}
                    {{--                                            <td>--}}
                    {{--                                                <input class="form-control rate" name="rate" type="text" value="{{ $statement?->rate }}">--}}
                    {{--                                            </td>--}}
                    {{--                                            <td>--}}
                    {{--                                                <input readonly class="form-control total_amount" type="text" value="{{ $statement?->total_amount }}">--}}
                    {{--                                            </td>--}}
                    {{--                                        </tr>--}}
                    {{--                                        <tr>--}}
                    {{--                                            <td>--}}
                    {{--                                                <input class="form-control labour_quantity" name="labour_quantity" type="text" readonly>--}}
                    {{--                                                <input type="hidden" class="labour_quantity_id" name="labour_quantity_id">--}}
                    {{--                                            </td>--}}
                    {{--                                            <td>--}}
                    {{--                                                <input class="form-control labour_rate" name="labour_rate" type="number" autocomplete="off">--}}
                    {{--                                            </td>--}}
                    {{--                                            <td>--}}
                    {{--                                                <input readonly class="form-control labour_total_amount" type="text">--}}
                    {{--                                            </td>--}}
                    {{--                                        </tr>--}}
                    {{--                                        </tbody>--}}
                    {{--                                        <tfoot>--}}
                    {{--                                        <tr>--}}
                    {{--                                            <th> Quantity <span class="text-danger">*</span></th>--}}
                    {{--                                            <th> Rate <span class="text-danger">*</span></th>--}}
                    {{--                                            <th> Total Amount <span class="text-danger">*</span></th>--}}
                    {{--                                        </tr>--}}
                    {{--                                        </tfoot>--}}
                    {{--                                    </table>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    @else--}}
                    <div class="card-body">
                        <table class="table table-bordered" id="calculation_table">
                            <thead>
                            <tr>
                                <th></th>
                                <th> Location </th>
                                <th class="calc_no_or_dia"> No <span class="text-danger">*</span></th>
                                <th class="calc_length"> Length </th>
                                <th class="calc_breadth_member"> Breadth </th>
                                <th class="calc_height_bar"> Height </th>
                                <th> Sub-total </th>
                                <th><i class="btn btn-primary btn-sm fa fa-plus" id="calc-add-btn"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="6" class="text-right">Primary Total:</th>
                                <th>
                                    <input type="number" id="grand-total" value="0.00" step="any" class="input-text direction-ltr font-bold bg-transparent" readonly>
                                </th>
                                <th class="workUnit"></th>
                            </tr>
                            {{--                                <tr>--}}
                            {{--                                    <th colspan="6" class="text-right">Secondary Total:</th>--}}
                            {{--                                    <th>--}}
                            {{--                                        <input type="number" id="secondary-total" value="0.00" step="any" class="input-text direction-ltr font-bold bg-transparent" readonly>--}}
                            {{--                                        <input type="text" id="secondary-total-fx" value="" placeholder="fx" step="any" class="input-text direction-ltr font-bold bg-transparent">--}}
                            {{--                                    </th>--}}
                            {{--                                    <th>--}}
                            {{--                                        <select id="secondary_units"> </select>--}}
                            {{--                                    </th>--}}
                            {{--                                </tr>--}}
                            </tfoot>
                        </table>
                    </div>
                    {{--                    @endif--}}
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>

        <!-- Modal -->

        <div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Copy From
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5> Select Location </h5>
                        <select class="form-control mt-2 copy_from_floor" id="modal-location">
                            <option>Select Location</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <span style="color:#ff0000">Caution. Your existing data might be overwritten.</span>
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                            Close
                        </button>
                        <button type="button" id="copy-paste" class="btn btn-primary waves-effect waves-light">
                            Copy
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @include('components.buttons.submit-button', ['label' => 'Save'])
    </form>
    <br>
@endsection

@section('script')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        /* ======================================== GOLBAL VARIABLES START ======================================== */
        {{--let measurementKeys = @json($measurement_keys);--}}
        {{--let is_reinforcement = @json($is_reinforcement);--}}
        let allDias = @json($boq_reinforcement_measurements);
        let diaWeight = @json($measurement_keys);
        let workDetails = {};
        let lastWorkId = -1;
        let fxId = "";
        const UNIT_TYPES = {
            "material": "material_unit",
            "labour": "labour_unit",
            "material-labour": "material_labour_unit",
        };
        const PROJECT = @json($project->id);
        let BOQ_CIVIL_BUDGHET = @json($boq_civil_budghet);
        let MATERIAL_LIST = [];
        let WORK_MATERIAL_LIST = null;
        const CALCULATION_TYPE = @json($calculation_type);
        let WORK_UNIT = "";
        const _TOKEN = "{{ csrf_token() }}";
        const CALCULATION_LOADER = $('#calculation-loader');
        const CALCULATION_STORE = "{{ route('boq.project.departments.civil.calculations.store', ['project' => $project, 'calculation_type' => $calculation_type]) }}";
        const BOQ_WORK_BY_WORK_ID_URL = "{{ route('boq.project.departments.civil.configurations.get_boq_work_by_work_id', $project) }}";
        const PREVIOUS_CALCULATION_LIST_URL = "{{ route('boq.project.departments.civil.previous.calculation.list', $project) }}";
        const PREVIOUS_MATERIAL_LIST_URL = "{{ route('boq.project.departments.civil.previous.material.list', $project) }}";
        const BOQ_SUB_WORK_BY_WORK_ID_URL = "{{ route('boq.project.departments.civil.configurations.get_boq_sub_work_by_work_id', $project) }}";
        const GET_FLOOR_BY_TYPE_URL = "{{ route('boq.project.departments.civil.get_floor_by_type', $project) }}";
        const FLOOR_COPY_URL = "{{ route('boq.project.departments.civil.get_floor_for_copy', $project) }}";
        const BOQ_WORK_BY_LOCATION_TYPE_URL = "{{ route('boq.project.departments.civil.get_work_by_location_type', $project) }}";
        const GET_UNITS = "{{ route('boq.project.departments.civil.get_units', $project) }}";
        /* ======================================== GOLBAL VARIABLES END   ======================================== */

        let PREVIOUS_GROUP_WISE_MATERIAL = null;




        /* ======================================== LOCATION SELECTION START ======================================== */
        function appendLocationOptions(data) {
            const BOQ_FLOOR_ID = $("#boq_floor_id");

            BOQ_FLOOR_ID.empty();

            if (isObjectEmpty(data)) {
                BOQ_FLOOR_ID.append('<option value="" selected disabled>--Select an Option--</option>');
            } else {
                BOQ_FLOOR_ID.append('<option value="" selected disabled>--Select an Option--</option>');
                data.forEach(function(item) {
                    let selected = "";
                    if(item?.id == BOQ_CIVIL_BUDGHET?.boq_work_parent_id) {
                        selected = "selected";
                    } else {
                        selected = "";
                    }

                    BOQ_FLOOR_ID.append(
                        '<option value="' + item.id + '" selected>' + item.name + "</option>"
                    );
                });
            }
        }

        function populateLocationModel(locations) {
            const modalLocation = $('#modal-location');
            modalLocation.empty();
            modalLocation.append('<option value="" selected disabled>--Select an Option--</option>');
            locations.forEach(function(item) {
                modalLocation.append(
                    '<option value="' + item.id + '">' + item.name + "</option>"
                );
            });
        }

        async function getFloorByType(floorTypeId) {
            const response = await axios.post(GET_FLOOR_BY_TYPE_URL, {
                floor_type: floorTypeId,
                _token: "{{ csrf_token() }}",
            });

            appendLocationOptions(response.data);
        }

        async function getFloorForCopy() {
            const floorTypeId = $('#location-type').val();
            const floorId = $('.boq_floor_id').val();
            const workId = $('.work_id').last().val();

            const response = await axios.post(FLOOR_COPY_URL, {
                work_id: workId,
                floor_type: floorTypeId,
                floor_id: floorId,
                _token: "{{ csrf_token() }}",
            });

            populateLocationModel(response.data);
        }

        $("#location-type").on("change", function() {
            getFloorByType($(this).val());
            getWorkByLocationType($(this).val());
        });

        $('.boq_floor_id').on('change', function() {
            getPreviousCalculations(workDetails);
        });
        /* ======================================== LOCATION SELECTION END   ======================================== */




        /* ======================================== WORK SELECTION START   ======================================== */
        function appendSubWork(workId, trId, subWorks) {
            var rowCount = $('#works-table div').length;

            for (let i = trId + 1; i <= rowCount; i++) {
                $('#work-' + i).remove();
            }

            let options = "";

            for (let i = 0; i < subWorks.length; i++) {
                options += `<option value="${subWorks[i].id}">${subWorks[i].name}</option>`;
            }

            let row = `<div class="input-group input-group-sm input-group-primary" id="work-${trId + 1}">
                        <label class="input-group-addon" for="work_id">Select Work<span class="text-danger">*</span></label>
                        <select class="form-control work_id" id="work_id" name="work_id[]">
                            <option value="" disabled selected>--Select an Option--</option>
                            ${options}
                        </select>
                    </div> `;

            if (!isObjectEmpty(subWorks)) {
                $('#works-table').append(row);
            }
        }

        /* Appends calculation row */
        function appendCalculationRow() {
            let row = `
                <tr>
                 <td>
                    <input class="material_checkbox nested_material_id_list" name="nested_material_id_list[]" type="checkbox">
                 </td>
                    <td width="70%">
                        <select class="form-control nested_material_id" name="nested_material_id[]" required>
                             <option value="">Select Material</option>
                                @foreach ($nested_materials as $single_material)
            <option value="{{ $single_material->id }}" @if ($single_material->id == old('nested_material_id', $materialFormula->nested_material_id ?? -1)) selected @endif>{{ $single_material->name }}</option>
                                    @if (count($single_material->children) > 0)
            @include('boq.departments.civil.configurations.materialformula.submaterial', ['nested_materials' => $single_material->children, 'prefix' => '-'])
            @endif
            @endforeach
            </select>
        </td>
<td>
                                        <input type="text" class="form-control nested_material_price_list" id="nested_material_price_list" name="nested_material_price_list[]" required>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control nested_material_ratio_list" value="1" id="nested_material_ratio_list" name="nested_material_ratio_list[]" required>
                                    </td>
                                   <td>
                                        <input type="number" step=".01" class="form-control nested_material_wastage_list" value="0" id="nested_material_wastage_list" name="nested_material_wastage_list[]" required>
                                        <input type="hidden" class="form-control is_additional_material" value="1" id="is_additional_material" name="is_additional_material[]" required>
                                    </td>

</tr>
`;

            $('#work_material_list_table tbody').append(row);
        }


        /* Adds and removes calculation row on click */
        $("#work_material_list_table")
            .on('click', '.add-material-list-row', () => {
                appendCalculationRow();
                $('.nested_material_id').select2();
            })
            .on('click', '.remove-material-list-row', function() {
                $(this).closest('tr').remove();
            })
            .on('change', '.nested_material_id', function() {
                $(this).closest('tr').find('.nested_material_id_list').val($(this).val());
            });

        function getWorkMaterialList(work,previous_materials) {

            let list = "";
            //alert(work?.boq_work_unit?.name);
            WORK_MATERIAL_LIST = work?.boq_material_formulas;

            $.each(work?.boq_material_formulas, function(index, item) {
                list += `<tr>
                                                <td>
                                                    <input type="checkbox" checked style="display: none" class="material_checkbox" name="nested_material_id_list[]" ${(Object.values(previous_materials).includes(item.nested_material_id)) ? 'checked' : ''} value="${item.nested_material_id}">
                                                    <span style="color: #0a0302">${index + 1}</span>
                                                </td>
                                                <td>
                                                    <a href="{{ url('/') }}/nestedmaterials/${item.material.id}/edit">${item.material.name}</a>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control nested_material_price_list" id="nested_material_price_list" value="${(item?.civil_budget !== null) ? (item?.civil_budget?.rate) : item?.material?.material_price_wastage?.price}" name="nested_material_price_list[]" required>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control nested_material_ratio_list" value="${(item?.civil_budget !== null) ? (item?.civil_budget?.formula_percentage) : item?.percentage_value}" id="nested_material_ratio_list" name="nested_material_ratio_list[]" required>
                                                </td>
                                               <td>
                                                    <input type="number" step=".01" class="form-control nested_material_wastage_list" value="${(item?.civil_budget !== null) ? (item?.civil_budget?.wastage) : item?.wastage }" id="nested_material_wastage_list" name="nested_material_wastage_list[]" required>
                                                    <input type="hidden" class="form-control is_additional_material" value="0" id="is_additional_material" name="is_additional_material[]" required>
                                                </td>


                                            </tr>`;
            });

            $.each(work?.additional_materials, function(index, item) {

                list += `<tr>
                                                <td>
                                                    <input class="material_checkbox" name="nested_material_id_list[]" ${(Object.values(previous_materials).includes(item.nested_material_id)) ? 'checked' : ''} value="${item.nested_material_id}" type="checkbox">
                                                </td>
                                                <td>
                                                    <span style="color: black">${item?.nested_material?.name}</span>
                                                </td>
                                        <td>
                                            <input type="text" class="form-control nested_material_price_list" id="nested_material_price_list" value="${(item?.rate)}" name="nested_material_price_list[]" required>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control nested_material_ratio_list" value="${(item?.formula_percentage)}" id="nested_material_ratio_list" name="nested_material_ratio_list[]" required>
                                                </td>
                                               <td>
                                                    <input type="number" step=".01" class="form-control nested_material_wastage_list" value="${(item?.wastage)}" id="nested_material_wastage_list" name="nested_material_wastage_list[]" required>
                                                    <input type="hidden" class="form-control is_additional_material" value="${(item?.is_additional_material)}" id="is_additional_material" name="is_additional_material[]" required>
                                                </td>


                                            </tr>`;
            });

            if(work?.boq_work_unit === null){
                $('#workUnitSpan').text('');
            } else{
                $('#workUnitSpan').text(work?.boq_work_unit?.name);
            }

            if(list === ""){
                $('.work_material_list').html('<tr><td colspan="5" class="text-center text-danger font-bold">No Material Found</td></tr>');
            } else{
                $('.work_material_list').html(list);
            }
            $('.nested_material_id').select2();

            // $.each(work?.boq_material_formulas, function(index, item) {
            //     list += `<label class="checkbox-inline material_checkbox_label" style="color: #0a0302;font-weight: 600">
            //                 <input class="material_checkbox" name="nested_material_id_list[]" type="checkbox" ${(Object.values(previous_materials).includes(item.nested_material_id)) ? 'checked' : ''} value="${item.nested_material_id}">${item.material.name}
            //             </label>`;
            // });
            // if(list === ""){
            //     $('.work_material_list').html('<span class="text-danger font-bold">No Material Found</span>');
            // } else{
            //     $('.work_material_list').html(list);
            // }

        }

        function populateFirstWork(works) {
            const FIRST_WORK = $('.first_work');
            FIRST_WORK.empty();
            FIRST_WORK.append('<option value="" selected disabled>--Select an Option--</option>');
            works.forEach(function(item) {
                if (item.calculation_type === CALCULATION_TYPE) {
                    FIRST_WORK.append(
                        '<option value="' + item.id + '">' + item.name + "</option>"
                    );
                }
            });
        }

        async function getWorkDetails(formData,data2) {

            let response = await axios.post(BOQ_WORK_BY_WORK_ID_URL, {
                _token: "{{ csrf_token() }}",
                work_id: BOQ_CIVIL_BUDGHET?.boq_work_id,
                boq_floor_id: BOQ_CIVIL_BUDGHET?.boq_floor_id,
                budget_type: BOQ_CIVIL_BUDGHET?.budget_type,
                project_id: BOQ_CIVIL_BUDGHET?.project_id,
            });
            workDetails = await response.data;
            setUnit();
            getWorkMaterialList(workDetails,data2);
            await getPreviousCalculations(workDetails);
        }

        async function getSubWorkByWork(workId, trId) {
            try {
                let boqFloorId = $('.boq_floor_id').val();
                let formData = {
                    _token: "{{ csrf_token() }}",
                    work_id: workId,
                    boq_floor_id: boqFloorId,
                    budget_type: CALCULATION_TYPE,
                    project_id: PROJECT,
                };
                const response = await axios.post(BOQ_SUB_WORK_BY_WORK_ID_URL, formData);
                const data = await response.data;

                const response2 = await axios.post(PREVIOUS_MATERIAL_LIST_URL, formData);
                const data2 = await response2.data;

                appendSubWork(workId, trId, data);
                getWorkMaterialList(data,data2);

                if (isObjectEmpty(data)) {
                    getWorkDetails(formData,data2);
                    lastWorkId = workId;
                } else {
                    lastWorkId = -1;
                }
            } catch (error) {
                console.log("Get Sub work", error);
                //alert("No data found. Please try again later.");
            } finally {}
        }

        async function getWorkByLocationType(floorType) {

            try {
                let formData = {
                    _token: "{{ csrf_token() }}",
                    floor_type: floorType,
                    calculation_type: CALCULATION_TYPE,
                };
                const response = await axios.post(BOQ_WORK_BY_LOCATION_TYPE_URL, formData);
                const data = await response.data;
                populateFirstWork(data);
            } catch (error) {
                console.log("Get Work By Location Type: ", error);
                //alert("No data found. Please try again later.");
            } finally {}
        }

        $('#works-table').on('change', '.work_id', function() {
            let workId = $(this).val();
            let trId = parseInt($(this).closest('div').attr('id').split('-')[1]);

            getSubWorkByWork(workId, trId);
            getFloorForCopy();
        });
        /* ======================================== WORK SELECTION END ======================================== */




        /* ======================================== CALCULATION OPTION START ======================================== */
        function appendCalculationGroup(value = {}) {
            const lastGroup = $(".group").last().attr('id');
            const groupId = lastGroup ? parseInt(lastGroup.split('-')[1]) + 1 : 1;
            const groupName = `group-${groupId}`;
            const groupMaterialName = `group-material-${groupId}`;

            let materialList = "";

            WORK_MATERIAL_LIST?.forEach(function(item) {
                //check if item.nested_material_id is in value.boq_civil_calc_group_materials
                let selected = false;
                value?.boq_civil_calc_group_materials?.forEach(function(item2) {
                    if (item2?.material_id === item?.nested_material_id) {
                        selected = true;
                    }
                });
                materialList += `<option value="${item?.nested_material_id}" ${(selected) ? 'selected' : ''}>${item?.material?.name}</option>`;
            });

            const group = `<tr id="${groupMaterialName}" class="group_material">
                                <td style="font-weight: bold">${groupId}</td>
                                <td colspan="7">
                                    <select required name="group_wise_selected_material" id="" class="form-control group_wise_selected_material" multiple="multiple">
                                        <option value="">Select Material</option>
                                        ${materialList}
                                     </select>
                                    <input type="hidden" value="${value?.id ?? -1}" class="group_id">
                                </td>
                           </tr>
                           <tr id="${groupName}" class="group">
                                <td>
                                     <button type="button" class="group-copy-btn">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </td>
                                <td colspan="7">
                                    <input type="text" value="${value?.name ?? ''}" placeholder="Enter Group Name" class="input-text font-bold group_name">
                                    <input type="hidden" value="${value?.id ?? -1}" class="group_id">
                                </td>
                           </tr>`;

            $('#calculation_table tbody').append(group);

            // work_material_name select2 with some style
            $('.group_wise_selected_material').select2({
                placeholder: "Select Material",
                allowClear: true,
                dropdownParent: $('#calculation_table')
            });

            return groupName;
        }

        function appendCalculationChild(groupName = "", tr = null, value = {}, last = false, isReinforcement = false, isCopying = false) {
            const childName = `child-${groupName}`;
            const child = `
                <tr class="${childName} child">
                    <td>
                        <a class="copy-child-btn" style="cursor:pointer; color:skyblue;">
                            <i class="fa fa-copy"></i>
                        </a>
                    </td>
                    <td>
                        <input type="text" value="${value?.sub_location_name ?? ''}" placeholder="Enter Location" class="input-text sub_location_name">
                    </td>
                    <td>
                        ${generateNoOrDia(value, isReinforcement)}
                    </td>
                    <td>
                        <input type="number" value="${value?.length ?? 1}" step="any" placeholder="Enter Length" class="length block input-text direction-ltr">
                        <input type="text" value="${value?.length_fx ?? ''}" placeholder="Fx" tabindex="-1" class="length-fx block input-fx">
                    </td>
                    <td>
                        <input type="number" value="${value?.breadth_or_member ?? 1}" step="any" placeholder="Enter Breadth" class="breadth_or_member input-text direction-ltr">
                        <input type="text" value="${value?.breadth_or_member_fx ?? ''}" placeholder="Fx" tabindex="-1" class="breadth_or_member-fx block input-fx">
                    </td>
                    <td>
                        <input type="number" value="${value?.height_or_bar ?? 1}" step="any" placeholder="Enter Height" class="height_or_bar input-text direction-ltr">
                        <input type="text" value="${value?.height_or_bar_fx ?? ''}" placeholder="Fx" tabindex="-1" class="height_or_bar-fx block input-fx">
                    </td>
                    <td class="readonly">
                        <input type="text" value="0.00" step="any" class="row-total input-text direction-ltr font-bold readonly" readonly>
                    </td>
                    <td style="display:flex; width: 100%; height: 100%; border: none">
                        <button type="button" class="child-delete-btn">
                           <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="child-add-btn">
                            <i class="fa fa-plus"></i>
                        </button>
                    </td>
                </tr>
           `;
            const groupTotal = `
                <tr id="total-${groupName}" class="sub-total">
                    <td colspan="6" class="font-bold text-right"> Sub-total: </td>
                    <td colspan="">
                        <input type="text" id="subtotal-${groupName}" value="0.00" step="any" class="input-text text-right sub-total font-bold" readonly>
                    </td>
                    <td class="font-bold unit"></td>
                </tr>
            `;

            if (isCopying) {
                $('#calculation_table tbody').append(groupTotal);
            } else if (!isObjectEmpty(value)) {
                $('#calculation_table tbody').append(child);
                if (last) {
                    $('#calculation_table tbody').append(groupTotal);
                }
            } else {
                if (tr) {
                    let newRow = $(tr).clone();
                    $(tr).after(newRow);
                } else {
                    $('#calculation_table tbody').append(child);
                    $('#calculation_table tbody').append(groupTotal);
                }
            }

            return childName;
        }

        function addBothGroupAndChild(isReinforcement = false, type = "new", copyFrom = "") {
            if (type === "new") {
                let groupName = appendCalculationGroup();
                appendCalculationChild(groupName, null, {}, false, isReinforcement);
                changeCalculationType();
            } else if (type === "copy" && copyFrom) {
                const group = $(`#${copyFrom}`);
                const groupValue = {
                    name: group?.find('.group_name')?.val() ?? "",
                    id: -1,
                };
                const groupName = appendCalculationGroup(groupValue, copyFrom);
                const copyFromChild = `child-${copyFrom} child`;
                const childName = `child-${groupName} child`;
                const childs = $(`.child-${copyFrom}`);
                const clonedChilds = [];

                $(`.child-${copyFrom}`).each(function() {
                    let clonedRow = $(this).clone();
                    clonedRow.removeClass(copyFromChild);
                    clonedRow.addClass(childName);
                    clonedChilds.push(clonedRow);
                })

                while (clonedChilds.length) {
                    let clonedRow = clonedChilds.shift();
                    $('#calculation_table tbody').append(clonedRow);
                }

                appendCalculationChild(groupName, null, {}, false, isReinforcement, true);
                changeCalculationType();
                calculate();
                setUnit();
            }
        }

        function calculateSFT(obj) {
            const {
                LENGTH,
                BREADTH,
                HEIGHT,
            } = obj;

            if (BREADTH.val() == "" || (LENGTH.val() == "" && HEIGHT.val() == "")) {
                return 0;
            } else if (LENGTH.val() != "") {
                return parseFloat(BREADTH.val()) * parseFloat(LENGTH.val());
            } else if (HEIGHT.val() != "") {
                return parseFloat(BREADTH.val()) * parseFloat(HEIGHT.val());
            } else {
                return 0;
            }
        }

        function calculateCFT(obj) {
            const {
                LENGTH,
                BREADTH,
                HEIGHT,
            } = obj;

            if (BREADTH.val() == "" || LENGTH.val() == "" || HEIGHT.val() == "") {
                return 0;
            } else {
                return parseFloat(BREADTH.val()) * parseFloat(LENGTH.val()) * parseFloat(HEIGHT.val());
            }
        }

        function calculateRFT(obj) {
            const {
                LENGTH,
                HEIGHT,
            } = obj;

            if (LENGTH.val() != "") {
                return LENGTH.val();
            } else if (HEIGHT.val() != "") {
                return HEIGHT.val();
            } else {
                return 0;
            }
        }

        function calculate() {
            let total = 0;
            let groupName = "";

            $('.group').each(function() {
                groupName = $(this).attr('id');
                let groupTotal = 0;

                $(`.child-${groupName}`).each(function() {
                    const NO = $(this).find('.no_or_dia').val();
                    const LENGTH = $(this).find('.length');
                    const BREADTH = $(this).find('.breadth_or_member');
                    const HEIGHT = $(this).find('.height_or_bar');
                    const calc = {
                        LENGTH,
                        BREADTH,
                        HEIGHT
                    };
                    let no_or_dia = NO == '' ? 0 : (workDetails.is_reinforcement ? (diaWeight[NO] ?? 0) : NO);
                    let rowTotal = 0;
                    let calculationType = [];

                    if (WORK_UNIT === 'sft') {
                        rowTotal = no_or_dia * calculateSFT(calc);
                    } else if (WORK_UNIT === 'cft') {
                        rowTotal = no_or_dia * calculateCFT(calc);
                    } else if (WORK_UNIT === 'rft') {
                        rowTotal = no_or_dia * calculateRFT(calc);
                    } else if (WORK_UNIT === 'no') {
                        rowTotal = parseFloat(no_or_dia);
                    } else {
                        let length = LENGTH.val() != "" ? LENGTH.val() : 1;
                        let breadth_or_member = BREADTH.val() != "" ? BREADTH.val() : 1;
                        let height_or_bar = HEIGHT.val() != "" ? HEIGHT.val() : 1;
                        rowTotal = parseFloat(no_or_dia) * parseFloat(length) * parseFloat(breadth_or_member) * parseFloat(height_or_bar);
                    }

                    $(this).find('.row-total').val(rowTotal.toFixed(2));
                    groupTotal += rowTotal;
                });
                $(`#subtotal-${groupName}`).val(groupTotal.toFixed(2));
                total += groupTotal;
            });

            $('#grand-total').val(total.toFixed(2));
            calculateSecondaryTotal();
        }

        function calculateSecondaryTotal() {
            let secondaryValue = $('#secondary-total-fx').val();

            if (secondaryValue === "") {
                $('#secondary_units').prop('required', false);
                return;
            }

            try {
                const total = eval(secondaryValue);
                const grandTotal = $('#grand-total').val();
                $('#secondary-total').val(parseFloat(total * grandTotal).toFixed(2));
                $('#secondary_units').prop('required', true);
            } catch (err) {
                alert('Invalid expression');
                console.error("expression", err);
            }
        }

        function changeCalculationInput(inputArr, isReadonly) {
            inputArr.forEach(function(item) {
                item.attr('readonly', isReadonly);
                item.prop('required', !isReadonly);
                if (isReadonly) {
                    item.addClass('readonly');
                    item.closest('td').addClass('readonly');
                } else {
                    item.removeClass('readonly');
                    item.closest('td').removeClass('readonly');
                }
            });
        }

        function changeCalculationType() {
            const noOrDia = $('.no_or_dia');
            const length = $('.length');
            const breadthOrMember = $('.breadth_or_member');
            const heightOrBar = $('.height_or_bar');

            // if (workDetails?.is_reinforcement || WORK_UNIT === 'cft') {
            //     changeCalculationInput([noOrDia, length, breadthOrMember, heightOrBar], false);
            // } else if (WORK_UNIT === 'sft') {
            //     changeCalculationInput([noOrDia, length, breadthOrMember], false);
            //     changeCalculationInput([heightOrBar], true);
            // } else if (WORK_UNIT === 'rft') {
            //     changeCalculationInput([noOrDia, heightOrBar], false);
            //     changeCalculationInput([length, breadthOrMember], true);
            // }
        }

        function generateNoOrDia(value, isReinforcement) {
            let diaOptions = ``;
            allDias?.forEach(function(item) {
                const selected = item?.id == value?.boq_reinforcement_measurement_id ? 'selected' : '';
                diaOptions += `<option value="${item?.id}" ${selected}>${item?.dia}</option>`;
            });
            const diaDropdown = `
                <select class="no_or_dia no_or_dia_select" required style="border: none">
                    <option value="">Select dia</option>
                    ${diaOptions}
                </select>
            `;
            const no = `
                <input type="text" value="${value?.no_or_dia ?? ''}" required step="any" placeholder="Enter No." class="no_or_dia input-text direction-ltr">
                <input type="text" value="${value?.no_or_dia_fx ?? ''}" placeholder="Fx" tabindex="-1" class="no_or_dia-fx block input-fx">
            `;
            const noOrDia = isReinforcement ? diaDropdown : no;

            return noOrDia;
        }

        function hideInputFx() {
            $('.height_or_bar-fx').hide();
            $('.no_or_dia-fx').hide();
            $('.length-fx').hide();
            $('.breadth_or_member-fx').hide();
        }

        $('#calc-add-btn').on('click', () => {
            addBothGroupAndChild(workDetails.is_reinforcement);
            setUnit();
        });

        $(document).on('click', '.child-add-btn', function() {
            const tr = $(this).closest('tr');
            const groupName = "group-" + tr.attr('class').split('-')[2];

            appendCalculationChild(groupName, tr);
            changeCalculationType();
            calculate();
            hideInputFx();
        });

        $(document).on('click', '.child-delete-btn', function() {

            const tr = $(this).closest('tr');
            const classNames = tr.attr('class').split(' ');
            const groupName = "group-" + classNames[0].split('-')[2];
            const countClass = $(`.${classNames[0]}`).length;

            if (countClass == 1) {
                if (!confirm('Are you sure you want to delete this group?')) {
                    return;
                }
                $(`#total-${groupName}`).remove();
                $(`#${groupName}`).remove();
                tr.prev().remove();
            }

            if ($(`.group`).length == 0) {
                addBothGroupAndChild(workDetails?.is_reinforcement);
            }

            tr.remove();
            calculate();
        });

        $(document).on('click', '.group-copy-btn', function() {
            const groupName = $(this).closest("tr").attr('id');
            addBothGroupAndChild(workDetails?.is_reinforcement, "copy", groupName);
            calculate();
        });

        $(document).on('click', '.copy-child-btn', function() {
            const tr = $(this).closest('tr');
            const clonedRow = tr.clone();
            const childName = tr.attr('class').split(' ')[0];
            const lastChild = $(`.${childName}`).last();
            $(lastChild).after(clonedRow);

            calculate();
        });

        $(document).on('keyup', '.no_or_dia, .length, .breadth_or_member, .height_or_bar', function() {
            $(this).closest('td').find('.input-fx').val("");
            calculate();
        });

        $(document).on('change', '.no_or_dia, .length, .breadth_or_member, .height_or_bar', function() {
            $(this).closest('td').find('.input-fx').val("");
            calculate();
        });

        $(document).on('focus', '.sub_location_name, .group_name, #calc-add-btn, .work_id, .boq_floor_id, .location_type', function() {
            $('.no_or_dia-fx').hide();
            $('.length-fx').hide();
            $('.breadth_or_member-fx').hide();
            $('.height_or_bar-fx').hide();
        });

        $(document).on('focus', '.no_or_dia, .length, .breadth_or_member, .height_or_bar', function() {
            hideInputFx();
            $(this).closest('td').find('.input-fx').show();
        });
        $(document).on('keypress', '.no_or_dia-fx, .length-fx, .breadth_or_member-fx, .height_or_bar-fx', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                $(this).closest('td').find('.input-fx').hide();
                let value = "";

                try {
                    value = eval($(this).val())
                } catch (e) {
                    alert('Invalid expression');
                    console.error("expression", e);
                }

                $(this).closest('td').find('.input-text').val(value);
                calculate();
            }
        });
        $(document).on('change', '.no_or_dia_select', () => calculate());

        $(document).on('click', '#copy-from-btn', () => getFloorForCopy());
        $(document).on('click', '#copy-paste', function() {
            getPreviousCalculations(workDetails, $('.copy_from_floor').val());
            $('#default-Modal').modal('hide');
        });
        /* ======================================== CALCULATION OPTION END ======================================== */




        /* ======================================== GLOBAL FUNCTIONS START ======================================== */
        function isObjectEmpty(obj) {
            return Object.keys(obj).length === 0;
        }

        function setUnit(secondaryUnit = "") {
            WORK_UNIT = workDetails[UNIT_TYPES[CALCULATION_TYPE]]?.name?.toLowerCase() ?? "";
            $('.unit').html(WORK_UNIT?.toUpperCase());

            getSecondaryUnits(workDetails[UNIT_TYPES[CALCULATION_TYPE]]?.id, secondaryUnit);

            return WORK_UNIT;
        }

        async function getSecondaryUnits(exceptUnitId = null, selectedUnit = "") {
            try {
                let formData = {
                    _token: "{{ csrf_token() }}",
                    except_unit_id: exceptUnitId
                };
                const response = await axios.post(GET_UNITS, formData);
                const data = await response.data;

                const SECONDARY_UNITS = $('#secondary_units');
                SECONDARY_UNITS.empty();

                SECONDARY_UNITS.append(`<option value="">None</option>`);

                data.forEach(unit => {
                    SECONDARY_UNITS.append(`<option value="${unit.id}">${unit.name}</option>`);
                });
                SECONDARY_UNITS.val(selectedUnit).change();
            } catch (error) {
                console.log("Get Units", error);
                // alert("No data found. Please try again later.");
            } finally {}
        }

        function generatePreviousCalculation(data, workDetails) {
            $("#calculation_table tbody").empty();

            // if(data.length == 0) {
            //     $('.labour_quantity').val(0);
            //     $('.labour_quantity_id').val(0);
            //     $('.labour_rate').val(0);
            //     $('.labour_total_amount').val(0);
            //     //return;
            // }

            const isReinforcement = workDetails?.is_reinforcement ? true : false;

            if (data?.boq_civil_calc_groups?.length == 0 || isObjectEmpty(data)) {
                addBothGroupAndChild(isReinforcement);
                setUnit();
                calculate();
                return;
            }

            data?.boq_civil_calc_groups?.forEach(function(item) {
                const groupName = appendCalculationGroup(item);
                const length = item?.boq_civil_calc_details?.length ?? 0;
                let iteration = 1;
                item?.boq_civil_calc_details?.forEach(function(child) {
                    appendCalculationChild(groupName, null, child, (iteration === length), isReinforcement);
                    iteration++;
                });
            });

            setUnit(data?.unit_id?.toString() ?? '');

            $('#secondary-total-fx').val(data?.secondary_total_fx ?? '');
            calculate();
            changeCalculationType();

            // if(CALCULATION_TYPE == 'labour'){
            //     $('.labour_quantity').val(data?.quantity);
            //     $('.labour_quantity_id').val(data?.id);
            //     $('.labour_rate').val(data?.rate);
            //     $('.labour_total_amount').val(data?.total_amount.toFixed(2));
            //
            // } else{
            //     const isReinforcement = workDetails?.is_reinforcement ? true : false;
            //
            //     if (data?.boq_civil_calc_groups?.length == 0 || isObjectEmpty(data)) {
            //         addBothGroupAndChild(isReinforcement);
            //         setUnit();
            //         calculate();
            //         return;
            //     }
            //
            //     data?.boq_civil_calc_groups?.forEach(function(item) {
            //         const groupName = appendCalculationGroup(item);
            //         const length = item?.boq_civil_calc_details?.length ?? 0;
            //         let iteration = 1;
            //         item?.boq_civil_calc_details?.forEach(function(child) {
            //             appendCalculationChild(groupName, null, child, (iteration === length), isReinforcement);
            //             iteration++;
            //         });
            //     });
            //
            //     setUnit(data?.unit_id?.toString() ?? '');
            //
            //     $('#secondary-total-fx').val(data?.secondary_total_fx ?? '');
            //     calculate();
            //     changeCalculationType();
            // }
        }

        //labour rate on change
        // $(document).on('change keyup', '.labour_rate', function() {
        //     $('.labour_total_amount').val(($('.labour_quantity').val() * $('.labour_rate').val()).toFixed(2));
        // });

        function prepareCalculationData() {
            let data = {};

            $('.group').each(function(groupIndex, GroupElement) {
                let groupName = $(this).attr('id');
                let groupNameInput = $(this).find('.group_name').val() ?? "";
                let groupID = $(this).find('.group_id').val() ?? -1;
                let groupTotal = parseFloat($(`#subtotal-${groupName}`).val()) ?? 0;
                let groupMaterialList = null;
                $('.group_material').each(function(materialIndex, materialElement) {
                    if (groupIndex === materialIndex) {
                        //group_wise_selected_material
                        groupMaterialList = $(this).find('.group_wise_selected_material').val();
                    }
                });

                let groupData = [];

                $(`.child-${groupName}`).each(function() {
                    const noOrDia = $(this).find('.no_or_dia');
                    let childName = $(this).attr('class').split(' ')[0];
                    let childData = {};

                    childData['location'] = $(this).find('.input-text').val();
                    childData['boq_reinforcement_measurement_id'] = workDetails?.is_reinforcement ? parseInt(noOrDia.val()) : null;
                    childData['no_or_dia'] = !workDetails?.is_reinforcement ? noOrDia.val() : diaWeight[noOrDia.val()] ?? null;
                    childData['no_or_dia_fx'] = $(this).find('.no_or_dia-fx').val();
                    childData['length'] = parseFloat($(this).find('.length').val() ?? 0);
                    childData['length_fx'] = $(this).find('.length-fx').val();
                    childData['breadth_or_member'] = parseFloat($(this).find('.breadth_or_member').val());
                    childData['breadth_or_member_fx'] = $(this).find('.breadth_or_member-fx').val();
                    childData['height_or_bar'] = parseFloat($(this).find('.height_or_bar').val());
                    childData['height_or_bar_fx'] = $(this).find('.height_or_bar-fx').val();
                    childData['row_total'] = parseFloat($(this).find('.row-total').val());

                    groupData.push(childData);
                });

                data[groupName] = {
                    group_name: groupNameInput,
                    group_id: groupID,
                    group_total: groupTotal,
                    group_data: groupData,
                    group_material_list: groupMaterialList,
                };
            });

            return data;
        }

        async function getPreviousCalculations(workDetails, copyFromFloorId = null) {
            try {
                let boqFloorId = $('.boq_floor_id').val();
                CALCULATION_LOADER.show();

                if (boqFloorId === "") return;

                const formData = {
                    _token: "{{ csrf_token() }}",
                    work_id: BOQ_CIVIL_BUDGHET?.boq_work_id ?? -1,
                    boq_floor_id: BOQ_CIVIL_BUDGHET?.boq_floor_id,
                    calculation_type: CALCULATION_TYPE,
                    project_id: BOQ_CIVIL_BUDGHET?.project_id,
                };

                const response = await axios.post(PREVIOUS_CALCULATION_LIST_URL, formData);
                PREVIOUS_GROUP_WISE_MATERIAL = response.data?.boq_civil_calc_groups ?? null;
                generatePreviousCalculation(response.data, workDetails);
            } catch (error) {
                console.error("getPreviousCalculations", error);
                // alert('No data found. Please try again later.');
            } finally {
                CALCULATION_LOADER.hide();
            }
        }

        async function save(formData) {
            try {
                CALCULATION_LOADER.show();
                const response = await axios.post(CALCULATION_STORE, formData);
                alert("Data Saved Successfully");
                getPreviousCalculations(workDetails);
            } catch (error) {
                console.log(error);
                alert("Something went wrong!");
            } finally {
                $('#calculation-form').find('input, textarea, select').prop('disabled', false);
                $('#calculation-form').find('button').prop('disabled', false);
                CALCULATION_LOADER.hide();
            }
        }


        // material list show and hide
        $(document).on('click', '.calculation_material_list_show', function() {
            // slide down slowly table tbody  calculation_material_list_table
            $('.calculation_material_list_table').slideDown();
        });

        $(document).on('click', '.calculation_material_list_hide', function() {
            // slide up and hide a table on click icon jquery
            $('.calculation_material_list_table').slideUp();

        });

        // material wastage show and hide
        $(document).on('click', '.calculation_material_wastage_show', function() {
            // add css with nested_material_wastage_list
            $('.nested_material_wastage_list').css('display', 'block');
        });

        $(document).on('click', '.calculation_material_wastage_hide', function() {
            // add css with nested_material_wastage_list
            $('.nested_material_wastage_list').css('display', 'none');

        });


        $(document).on('submit', '#form', function(event) {
            event.preventDefault();
            if($('.material_checkbox:checkbox:checked').length === 0) {
                alert('Please select at least one material');
                return;
            }

            let formData = {};

            formData["_token"] = '{{ csrf_token() }}';
            formData["calculation"] = prepareCalculationData();
            formData["boq_floor_id"] = BOQ_CIVIL_BUDGHET?.boq_floor_id;
            formData["boq_floor_type_id"] = BOQ_CIVIL_BUDGHET?.boq_floor_type_id;
            formData["work_type_id"] = BOQ_CIVIL_BUDGHET?.work_type_id;
            formData["work_id"] = BOQ_CIVIL_BUDGHET?.boq_work_id;
            formData["grand_total"] = parseFloat($('#grand-total').val());
            formData["secondary_total"] = parseFloat($('#secondary-total').val());
            formData["secondary_total_fx"] = $('#secondary-total-fx').val();
            formData["unit_id"] = $('#secondary_units').val();

            // formData["labour_quantity_id"] = $('.labour_quantity_id').val();
            // formData["labour_quantity"] = $('.labour_quantity').val();
            // formData["labour_rate"] = $('.labour_rate').val();
            // formData["labour_total_amount"] = $('.labour_total_amount').val();

            let materialArray = [];

            $('.material_checkbox:checkbox:checked').map(function () {
                //return this.value;
                let obj = {
                    material_id: this.value,
                    material_price: $(this).closest("tr").find(".nested_material_price_list").val(),
                    material_ratio: $(this).closest("tr").find(".nested_material_ratio_list").val(),
                    material_wastage: $(this).closest("tr").find(".nested_material_wastage_list").val(),
                };
                materialArray.push(obj);
            }).get();

            formData['selected_material_list'] = materialArray;

            $.each(formData["calculation"], function (key, value) {
                let finalMaterialList = [];
                $.each(value?.group_material_list, function (key, value) {
                    // find from formData['selected_material_list'] where material_id === value
                    let material = formData['selected_material_list'].find(material => material.material_id === value);
                    if (material) {
                        let obj = {
                            material_id: material.material_id,
                            material_price: material.material_price,
                            material_ratio: material.material_ratio,
                            material_wastage: material.material_wastage,
                        };
                        finalMaterialList.push(obj);
                    }
                });
                value['final_material_list'] = finalMaterialList;
            });

            // formData['selected_material_price_list'] = $(".material_checkbox:checkbox:checked").map(function() {
            //     return $(this).closest("tr").find(".nested_material_price_list").val();
            // }).get();
            //
            // formData['selected_material_ratio_list'] = $(".material_checkbox:checkbox:checked").map(function() {
            //     return $(this).closest("tr").find(".nested_material_ratio_list").val();
            // }).get();
            //
            // formData['selected_material_wastage_list'] = $(".material_checkbox:checkbox:checked").map(function() {
            //     return $(this).closest("tr").find(".nested_material_wastage_list").val();
            // }).get();
            //
            // formData['is_additional_material'] = $(".material_checkbox:checkbox:checked").map(function() {
            //     return $(this).closest("tr").find(".is_additional_material").val();
            // }).get();


            save(formData);
        })

        $(document).on('keypress', '#secondary-total-fx', function(event) {
            if (event.which == 13) {
                event.preventDefault();
                calculateSecondaryTotal();
            }
        });

        async function getPreviousMaterialAndCalculationForUpdate(workId){

            try {
                let boqFloorId = $('.boq_floor_id').val();
                let formData = {
                    _token: "{{ csrf_token() }}",
                    work_id: workId,
                    boq_floor_id: boqFloorId,
                    budget_type: CALCULATION_TYPE,
                    project_id: PROJECT,
                };
                const response = await axios.post(BOQ_SUB_WORK_BY_WORK_ID_URL, formData);
                const data = await response.data;

                const response2 = await axios.post(PREVIOUS_MATERIAL_LIST_URL, formData);
                const data2 = await response2.data;

                //appendSubWork(workId, trId, data);
                getWorkMaterialList(data,data2);

                if (isObjectEmpty(data)) {
                    await getWorkDetails(formData,data2);
                    lastWorkId = workId;
                } else {
                    lastWorkId = -1;
                }
            } catch (error) {
                console.log("Get Sub work", error);
                //alert("No data found. Please try again later.");
            } finally {}

        }

        $(document).ready(function() {

            //new code for edit

            //get value of class name location_type
            let locationTypeId = $('.location_type').val();
            getFloorByType(locationTypeId);
            getWorkByLocationType(locationTypeId);

            let workId = BOQ_CIVIL_BUDGHET?.boq_work_id;

            //getSubWorkByWork(workId);
            //getFloorForCopy();
            getPreviousMaterialAndCalculationForUpdate(workId);

            //new code for edit



            addBothGroupAndChild();
            CALCULATION_LOADER.hide();
            $('.work_material_list').html('<tr><td colspan="5" class="text-center text-danger font-bold">No Material Found</td></tr>');
            setTimeout(function() {
                getSecondaryUnits();
            }, 800);
        });
        /* ======================================== GLOBAL FUNCTIONS END ======================================== */
    </script>
@endsection
