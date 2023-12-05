@extends('layouts.backend-layout')
@section('title', 'Labor Budget')

@section('breadcrumb-title')
    {{ empty($icmdLaborBudget) ? 'New Labor Budget' : 'Edit Labor Budget' }}
@endsection

@section('breadcrumb-button')
    <a href="{{ url('icmdLaborBudget') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    {!! Form::open(['url' => empty($icmdLaborBudget) ? route('icmdLaborBudget.store') : route('icmdLaborBudget.update', $icmdLaborBudget->id), 'method' => empty($icmdLaborBudget) ? 'POST' : 'PUT', 'class' => 'custom-form']) !!}

    <div class="row">
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="date">Date<span class="text-danger">*</span></label>
                @if(empty($icmdLaborBudget))
                {{ Form::text('date', old('date', $icmdLaborBudget->date ?? null), ['class' => 'form-control', 'id' => 'date', 'autocomplete' => 'off', 'required','readonly']) }}
                @else
                {{ Form::text('date', old('date', $icmdLaborBudget->date ?? null), ['class' => 'form-control', 'autocomplete' => 'off', 'required', 'readonly']) }}
                @endif
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_id">Project Name <span class="text-danger">*</span></label>
                {{ Form::text('project_id', old('project_id', $icmdLaborBudget->costCenter->project->name ?? null), ['class' => 'form-control', 'id' => 'project_name', 'tabindex' => -1, 'autocomplete' => 'off', 'required']) }}
                {{ Form::hidden('po_project_id', old('po_project_id', $icmdLaborBudget->costCenter->project->id ?? null), ['class' => 'form-control', 'id' => 'po_project_id']) }}
                {{ Form::hidden('cost_center_id', old('cost_center_id', $icmdLaborBudget->cost_center_id ?? null), ['class' => 'form-control', 'id' => 'cost_center_id']) }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="month">For The Month Of<span class="text-danger">*</span></label>
                @if(empty($icmdLaborBudget))
                {{ Form::text('month', old('month', $icmdLaborBudget->month ?? null), ['class' => 'form-control month', 'id' => 'month', 'autocomplete' => 'off', 'required','readonly']) }}
                @else
                {{ Form::text('month', old('month', $icmdLaborBudget->month ?? null), ['class' => 'form-control month', 'autocomplete' => 'off', 'required', 'readonly']) }}
                @endif
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="purchaseTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th rowspan='2'>Work Description<span class="text-danger">*</span></th>
                    <th rowspan='2'>No of Mason</th>
                    <th rowspan='2'>No of Helper</th>
                    <th colspan="2">Rate(Labor)<span class="text-danger">*</span></th>
                    <th rowspan='2'>Amount<span class="text-danger">*</span></th>
                    <th rowspan='2'>Remarks<span class="text-danger">*</span></th>
                    <th rowspan='2'><i class="btn btn-primary btn-sm fa fa-plus" id="addItem" onclick="addItemDtl()"> </i></th>
                </tr>
                <tr>
                    <th >Mason<span class="text-danger">*</span></th>
                    <th >Helper<span class="text-danger">*</span></th>
                </tr>
            </thead>
            <tbody>
                @forelse (old('material_id', $icmdLaborBudget->icmdLaborBudgetDetails ?? []) as $key => $value)
                    <tr>
                        <td>
                            <input type="text" name="description[]" value="{{ old("description.{$key}", $value->description ?? null) }}" class="form-control form-control-sm text-center description" readonly tabindex="-1">
                        </td>
                        <td>
                            <input type="number" name="mason_no[]" value="{{ old("mason_no.{$key}", $value->mason_no ?? null) }}" class="form-control mason_no text-center">
                        </td>
                        <td>
                            <input type="number" name="helper_no[]" value="{{ old("helper_no.{$key}", $value->helper_no ?? null) }}" class="form-control helper_no text-center" autocomplete="off">
                        </td>
                        <td>
                            <input type="number" name="mason_rate[]" value="{{ old("mason_rate.{$key}", $value->mason_rate ?? null) }}" class="form-control mason_rate text-center" min="0" step="0.05" placeholder="0">
                        </td>
                        <td>
                            <input type="number" name="helper_rate[]" value="{{ old("helper_rate.{$key}", $value->helper_rate ?? null) }}" class="form-control helper_rate text-center" min="0"  placeholder="0">
                        </td>
                        <td>
                            <input type="number" name="amount[]" value="{{ old("amount.{$key}", $value->amount ?? null) }}" class="form-control amount text-center" min="0" step="0.01" placeholder = "0" autocomplete="off" readonly required>
                        </td>
                        <td>
                            <input type="text" name="remarks[]" value="{{ old("remarks.{$key}", $value->remarks ?? null) }}" class="form-control remarks text-center" min="0" step="0.01" placeholder = "0" autocomplete="off">
                        </td>
                        <td class="text-center">
                            <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button">
                                <i class="fa fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
            <tfoot>
               
                <tr>
                    <td colspan="5" class="text-right"> Total Amount </td>
                    <td>
                        {{ Form::number('total_amount', old('total_amount', $icmdLaborBudget->final_total ?? null), ['class' => 'form-control  form-control-sm final_total text-center', 'id' => 'final_total', 'placeholder' => '0.00 ', 'readonly']) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        const material_row_data = @json(old('material_id', []));
        const CSRF_TOKEN = "{{ csrf_token() }}";

        // Function for adding new material row
        function addItemDtl() {
            var Row = `
                <tr>
                    <td><input type="text" name="description[]" class="form-control form-control-sm description text-center" tabindex="-1"></td>
                    <td><input type="text" name="mason_no[]" class="form-control mason_no text-center" autocomplete="off"></td>
                    <td><input type="text" name="helper_no[]" class="form-control helper_no text-center" autocomplete="off"></td>
                    <td><input type="number" name="mason_rate[]" class="form-control mason_rate text-center" min="0" step="0.01" placeholder = "0" autocomplete="off"></td>
                    <td><input type="number" name="helper_rate[]" class="form-control helper_rate text-center" min="0" step="0.01" placeholder = "0" autocomplete="off"></td>
                    <td><input type="number" name="amount[]" class="form-control amount text-center" min="0" step="0.01" placeholder = "0" autocomplete="off" readonly ></td>
                    <td><input type="text" name="remarks[]" class="form-control remarks text-center" tabindex="-1"></td>
                    <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" id="" type="button"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            var tableItem = $('#purchaseTable tbody').append(Row);
            calculateTotalPrice(this);
            totalOperation();
        }

        // Function for deleting a row
        function removQRow(qval) {
            var rowIndex = qval.parentNode.parentNode.rowIndex;
            document.getElementById("purchaseTable").deleteRow(rowIndex);
            totalOperation();
        }
        // Function for calculating total price
        function calculateTotalPrice(thisVal) {
            let mason_no = $(thisVal).closest('tr').find('.mason_no').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.mason_no').val()) : 0;
            let helper_no = $(thisVal).closest('tr').find('.helper_no').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.helper_no').val()) : 0;
            let mason_rate = $(thisVal).closest('tr').find('.mason_rate').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.mason_rate').val()) : 0;
            let helper_rate = $(thisVal).closest('tr').find('.helper_rate').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.helper_rate').val()) : 0;
            let total = Number((Number(mason_no) * Number(mason_rate)).toFixed(2)) + Number((Number(helper_no) * Number(helper_rate)).toFixed(2));
            console.log(total);
            $(thisVal).closest('tr').find('.amount').val(total);
            totalOperation();
        }

        // Function for calculating total price
        function totalOperation() {
            var total = 0;
            if ($(".amount").length > 0) {
                $(".amount").each(function(i, row) {
                    var total_price = Number($(row).val());
                    total += parseFloat(total_price);
                })
            }
            $("#final_total").val(total.toFixed(2));
        }

        

        


        // Date picker formatter
        $('#date,.required_date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        });
        $('#date,.month').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: "MM",
            viewMode: "months", 
            minViewMode: "months"
        });

       

      
            @if ($formType == 'create' && !old('material_id')) addItemDtl(); @endif

            $(document).on('keyup change', '.mason_no,.helper_no,.mason_rate,.helper_rate', function() {
                calculateTotalPrice(this);
            });

            $(document).on('change keyup', '#carrying_charge', function() {
                calculateFinalTotal();
            });

            $(document).on('change keyup', '#labour_charge', function() {
                calculateFinalTotal();
            });

            $(document).on('change keyup', '#discount', function() {
                calculateFinalTotal();
            });

          
           
        $(function() {
            $(document).on('change', '#supplier_id', function() {
                $('#purchaseTable tbody').find('tr').detach();
                addItemDtl();
            });


           
           

            totalOperation();

            $( "#project_name").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('scj.costCenterAutoSuggest')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                },
                select: function (event, ui) {
                    $('#project_name').val(ui.item.label);
                    $('#cost_center_id').val(ui.item.value);
                    return false;
                }
            });
        }) // Document.Ready
    </script>
@endsection
