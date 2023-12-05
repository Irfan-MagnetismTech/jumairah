@extends('layouts.backend-layout')
@section('title', 'Inventory')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Inventory
    @else
        Add Inventory
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('bd_inventory') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if($formType == 'edit') 
        {!! Form::open(array('url' => "bd_inventory/$bd_inventory->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "bd_inventory",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="applied_date">Applied Date<span class="text-danger">*</span></label>
                    {{Form::text('applied_date', old('applied_date') ? old('applied_date') : (!empty($bd_inventory) ? $bd_inventory->applied_date : null),['class' => 'form-control','id' => 'applied_date','autocomplete'=>"off","required", 'placeholder' => 'Date'])}}
                </div>
            </div>
        </div><!-- end row -->

    <hr class="bg-success">

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
                <tr >
                    <th rowspan="2">Project Name</th>
                    <th rowspan="2">Land Size <br>as per Feasibility <br>(katha)</th>
                    <th rowspan="2">Ratio</th>
                    <th rowspan="2">Total Units</th>
                    <th colspan="2">L/O Portion</th>
                    <th colspan="2">RFPL Portion</th>
                    <th rowspan="2">Margin(%)</th>
                    <th rowspan="2">Rate</th>
                    <th rowspan="2">Parking</th>
                    <th rowspan="2">Utility</th>
                    <th rowspan="2">Other<br> Benefit</th>
                    <th rowspan="2">Remarks</th>
                    <th rowspan="2">Signing Money<br>(crore)</th>
                    <th rowspan="2">Inventory <br>Value</th>
                    <th rowspan="2">
                        <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                    </th>
                </tr>
                <tr>
                    <th >Units</th>
                    <th >Space</th>
                    <th >Units</th>
                    <th >Space</th>
                </tr>
            </thead>
            <tbody>
    
            @if(old('cost_center_id'))
                @foreach(old('cost_center_id') as $key => $materialOldData)
                    <tr>
                        <td>
                            <input type="text" name="project_name[]"   value="{{old('project_name')[$key]}}" id="project_name" class="form-control text-center form-control-sm project_name" autocomplete="off">
                            <input type="hidden" name="cost_center_id[]"   value="{{old('cost_center_id')[$key]}}" id="cost_center_id" class="form-control text-center form-control-sm cost_center_id">
                        </td>
                        <td><input type="text" name="land_size[]"  value="{{old('land_size')[$key]}}" class="form-control text-center form-control-sm land_size" autocomplete="off"></td>
                        <td><input type="text" name="ratio[]" value="{{old('ratio')[$key]}}"  class="form-control text-center form-control-sm ratio" autocomplete="off" ></td>
                        <td><input type="text" name="total_units[]" value="{{old('total_units')[$key]}}"  class="form-control text-center form-control-sm total_units" autocomplete="off" ></td>
                        <td><input type="text" name="lo_units[]" value="{{old('lo_units')[$key]}}"  class="form-control text-center form-control-sm lo_units" autocomplete="off" ></td>
                        <td><input type="text" name="lo_space[]" value="{{old('lo_space')[$key]}}"  class="form-control text-center form-control-sm lo_space" autocomplete="off" ></td>
                        <td><input type="text" name="rfpl_units[]" value="{{old('lo_units')[$key]}}"  class="form-control text-center form-control-sm lo_units" autocomplete="off" ></td>
                        <td><input type="text" name="rfpl_space[]" value="{{old('lo_space')[$key]}}"  class="form-control text-center form-control-sm lo_space" autocomplete="off" ></td>
                        <td><input type="text" name="margin[]" value="{{old('margin')[$key]}}" class="form-control text-center form-control-sm margin" autocomplete="off" ></td>
                        <td><input type="text" name="rate[]" value="{{old('rate')[$key]}}"  class="form-control text-center form-control-sm rate" autocomplete="off" tabindex="-1"></td>
                        <td><input type="text" name="parking[]" value="{{old('parking')[$key]}}"  class="form-control text-center form-control-sm parking" autocomplete="off" ></td>
                        <td><input type="text" name="utility[]" value="{{old('utility')[$key]}}"  class="form-control text-center form-control-sm utility" autocomplete="off" ></td>
                        <td><input type="text" name="other_benefit[]" value="{{old('other_benefit')[$key]}}"  class="form-control text-center form-control-sm other_benefit" autocomplete="off" ></td>
                        <td><input type="text" name="remarks[]" value="{{old('remarks')[$key]}}"  class="form-control text-center form-control-sm remarks" autocomplete="off" ></td>
                        <td><input type="text" name="signing_money[]" value="{{old('signing_money')[$key]}}"  class="form-control text-center form-control-sm signing_money" autocomplete="off" ></td>
                        <td><input type="text" name="inventory_value[]" value="{{old('inventory_value')[$key]}}"  class="form-control text-center form-control-sm inventory_value" autocomplete="off" ></td>
                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
                @endforeach
            @else
                @if(!empty($bd_inventory))
                    @foreach($bd_inventory->BdInventoryDetails as $BdInventoryDetail)
                    <tr>
                        <td>
                            <input type="text" name="project_name[]"   value="{{ !empty($BdInventoryDetail->cost_center_id) ? $BdInventoryDetail->costCenter->name : "" }}" id="project_name" class="form-control text-center form-control-sm project_name" autocomplete="off">
                            <input type="hidden" name="cost_center_id[]"   value="{{ $BdInventoryDetail->cost_center_id }}" id="cost_center_id" class="form-control text-center form-control-sm cost_center_id">
                        </td>
                        <td><input type="text" name="land_size[]"  value="{{ $BdInventoryDetail->land_size }}" class="form-control text-center form-control-sm land_size" autocomplete="off"></td>
                        <td><input type="text" name="ratio[]" value="{{ $BdInventoryDetail->ratio }}"  class="form-control text-center form-control-sm ratio" autocomplete="off" ></td>
                        <td><input type="text" name="total_units[]" value="{{ $BdInventoryDetail->total_units }}"  class="form-control text-center form-control-sm total_units" autocomplete="off" ></td>
                        <td><input type="text" name="lo_units[]" value="{{ $BdInventoryDetail->lo_units }}" class="form-control text-center form-control-sm lo_units" autocomplete="off" ></td>
                        <td><input type="text" name="lo_space[]" value="{{ $BdInventoryDetail->lo_space }}"  class="form-control text-center form-control-sm lo_space" autocomplete="off" ></td>
                        <td><input type="text" name="rfpl_units[]" value="{{ $BdInventoryDetail->rfpl_units }}"  class="form-control text-center form-control-sm lo_units" autocomplete="off" ></td>
                        <td><input type="text" name="rfpl_space[]" value="{{ $BdInventoryDetail->rfpl_space }}"  class="form-control text-center form-control-sm lo_space" autocomplete="off" ></td>
                        <td><input type="text" name="margin[]" value="{{ $BdInventoryDetail->margin }}" class="form-control text-center form-control-sm margin" autocomplete="off" ></td>
                        <td><input type="text" name="rate[]" value="{{ $BdInventoryDetail->rate }}" class="form-control text-center form-control-sm rate" autocomplete="off" tabindex="-1"></td>
                        <td><input type="text" name="parking[]" value="{{ $BdInventoryDetail->parking }}"  class="form-control text-center form-control-sm parking" autocomplete="off" ></td>
                        <td><input type="text" name="utility[]" value="{{ $BdInventoryDetail->utility }}"  class="form-control text-center form-control-sm utility" autocomplete="off" ></td>
                        <td><input type="text" name="other_benefit[]" value="{{ $BdInventoryDetail->other_benefit }}"  class="form-control text-center form-control-sm other_benefit" autocomplete="off" ></td>
                        <td><input type="text" name="remarks[]" value="{{ $BdInventoryDetail->remarks }}"  class="form-control text-center form-control-sm remarks" autocomplete="off" ></td>
                        <td><input type="text" name="signing_money[]" value="{{ $BdInventoryDetail->signing_money }}"  class="form-control text-center form-control-sm signing_money" autocomplete="off" ></td>
                        <td><input type="text" name="inventory_value[]" value="{{ $BdInventoryDetail->inventory_value }}"  class="form-control text-center form-control-sm inventory_value" autocomplete="off" ></td>
                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
                    @endforeach
                @endif
            @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="14" class="text-center">Total Inventory</td>
                    <td>{{ Form::number('total_signing_money', old('total_signing_money', $bd_inventory->total_signing_money ?? null), ['class' => 'form-control form-control-sm total_signing_money text-center', 'id' => 'total_signing_money', 'placeholder' => '0.00 ', 'readonly']) }}
                    </td>
                    <td>{{ Form::number('total_inventory_value', old('total_inventory_value', $bd_inventory->total_inventory_value ?? null), ['class' => 'form-control form-control-sm total_inventory_value text-center', 'id' => 'total_inventory_value', 'placeholder' => '0.00 ', 'readonly']) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div> <!-- end table responsive -->
    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div> <!-- end row -->
    
    {!! Form::close() !!}
@endsection


@section('script')
    <script>

        function addRow(){
            let row = `
            <tr>
                <td>
                    <input type="text" name="project_name[]" id="project_name" class="form-control text-center form-control-sm project_name" autocomplete="off">
                    <input type="hidden" name="cost_center_id[]" id="cost_center_id" class="form-control text-center form-control-sm cost_center_id">
                </td>
                <td><input type="text" name="land_size[]" class="form-control text-center form-control-sm land_size" autocomplete="off"></td>
                <td><input type="text" name="ratio[]" class="form-control text-center form-control-sm ratio" autocomplete="off" ></td>
                <td><input type="text" name="total_units[]" class="form-control text-center form-control-sm total_units" autocomplete="off" ></td>
                <td><input type="text" name="lo_units[]" class="form-control text-center form-control-sm lo_units" autocomplete="off" ></td>
                <td><input type="text" name="lo_space[]" class="form-control text-center form-control-sm lo_space" autocomplete="off" ></td>
                <td><input type="text" name="rfpl_units[]" class="form-control text-center form-control-sm lo_units" autocomplete="off" ></td>
                <td><input type="text" name="rfpl_space[]" class="form-control text-center form-control-sm lo_space" autocomplete="off" ></td>
                <td><input type="text" name="margin[]" class="form-control text-center form-control-sm margin" autocomplete="off" ></td>
                <td><input type="text" name="rate[]" class="form-control text-center form-control-sm rate" autocomplete="off" tabindex="-1"></td>
                <td><input type="text" name="parking[]" class="form-control text-center form-control-sm parking" autocomplete="off" ></td>
                <td><input type="text" name="utility[]" class="form-control text-center form-control-sm utility" autocomplete="off" ></td>
                <td><input type="text" name="other_benefit[]" class="form-control text-center form-control-sm other_benefit" autocomplete="off" ></td>
                <td><input type="text" name="remarks[]" class="form-control text-center form-control-sm remarks" autocomplete="off" ></td>
                <td><input type="text" name="signing_money[]" class="form-control text-center form-control-sm signing_money" autocomplete="off" ></td>
                <td><input type="text" name="inventory_value[]" class="form-control text-center form-control-sm inventory_value" autocomplete="off" ></td>
                <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
            </tr>
            `;
            $('#itemTable tbody').append(row);
            totalSigningMoney();
            totalInventoryValue();
        }

        // Function for calculating total Estimated Cost
        function totalSigningMoney() {
            var total = 0;
            if ($(".signing_money").length > 0) {
                $(".signing_money").each(function(i, row) {
                    var total_price = Number($(row).val());
                    total += parseFloat(total_price);
                })
            }
            $("#total_signing_money").val(total.toFixed(2));
        }

        // Function for calculating total Estimated Sales
        function totalInventoryValue() {
            var total = 0;
            if ($(".inventory_value").length > 0) {
                $(".inventory_value").each(function(i, row) {
                    var total_price = Number($(row).val());
                    total += parseFloat(total_price);
                })
            }
            $("#total_inventory_value").val(total.toFixed(2));
        }


        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            @if($formType == 'create' && !old('cost_center_id') )
                addRow();
            @endif

            $("#itemTable").on('click', ".addItem", function(){
                addRow();
            }).on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
            });

            $('#applied_date').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });


            // Function for autocompletion of progress projects
        
            $(document).on('keyup', ".project_name", function() {
                $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('scj.bdProgressBudgetProjectAutoSuggest') }}",
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
                        $(this).val(ui.item.label);
                        $(this).closest('tr').find('.cost_center_id').val(ui.item.value);
                        $(this).closest('tr').find('.project_name').val(ui.item.label);
                        return false;
                    }
                });
            });

            // Function for autocompletion of future projects
        
            $(document).on('keyup', ".future_project_name", function() {
                $(this).autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url:"{{route('scj.bdFutureBudgetProjectAutoSuggest')}}",
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
                        $(this).val(ui.item.label);
                        $(this).closest('tr').find('.future_cost_center_id').val(ui.item.value);
                        $(this).closest('tr').find('.future_project_name').val(ui.item.label);
                        return false;
                    } 
                })
            });

            $(document).on('keyup change', '.signing_money', function() {
                totalSigningMoney();
            });
            $(document).on('keyup change', '.inventory_value', function() {
                totalInventoryValue();
            });

            
        });

    </script>
@endsection
