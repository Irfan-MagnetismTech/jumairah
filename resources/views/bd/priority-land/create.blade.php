@extends('layouts.backend-layout')
@section('title', 'Priority Land')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Priority Land
    @else
        Add Priority Land
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('priority_land') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if($formType == 'edit') 
        {!! Form::open(array('url' => "priority_land/$priority_land->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "priority_land",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="applied_date">Plan For<span class="text-danger">*</span></label>
                    {{Form::text('applied_date', old('applied_date') ? old('applied_date') : (!empty($priority_land) ? $priority_land->applied_date : null),['class' => 'form-control','id' => 'applied_date','autocomplete'=>"off","required", 'placeholder' => 'Date'])}}
                </div>
            </div>
        </div><!-- end row -->

    <hr class="bg-success">

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
            <tr>
                <th width="200px">Location</th>
                <th width="200px">Plot Reference</th>
                <th>Land Size (katha)</th>
                <th>Category</th>
                <th>Status</th>
                <th>Margin (%)</th>
                <th>Cash Benefit (Crore)</th>
                <th>Type</th>
                <th>Expected Date<br> for Deal Closing</th>
                <th>Estimated Total Cost</th>
                <th>Estimated Sales Value</th>
                <th>Expected Profit</th>

                <th>
                    <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                </th>
            </tr>
            </thead>
            <tbody>
    
            @if(old('bd_lead_generation_id'))
                @foreach(old('bd_lead_generation_id') as $key => $materialOldData)
                    <tr>
                        <td>
                            <input type="text" name="location[]"  value="{{old('location')[$key]}}" class="form-control text-center form-control-sm location" autocomplete="off" >
                            
                            <input type="hidden" name="bd_lead_generation_id[]"   value="{{old('bd_lead_generation_id')[$key]}}" id="bd_lead_generation_id" class="form-control text-center form-control-sm bd_lead_generation_id">
                        </td>
                        <td><input type="text" name="plot_reference[]"   value="{{old('plot_reference')[$key]}}" id="plot_reference" class="form-control text-center form-control-sm plot_reference" autocomplete="off" tabindex="-1">
                            <td><input type="text" name="land_size[]" value="{{old('land_size')[$key]}}"  class="form-control text-center form-control-sm land_size" autocomplete="off" tabindex="-1"></td>
                        <td><input type="text" name="category[]" value="{{old('category')[$key]}}"  class="form-control text-center form-control-sm category" autocomplete="off" ></td>
                        <td><input type="text" name="status[]" value="{{old('status')[$key]}}"  class="form-control text-center form-control-sm status" autocomplete="off" ></td>
                        <td><input type="text" name="margin[]" value="{{old('margin')[$key]}}"  class="form-control text-center form-control-sm margin" autocomplete="off" ></td>
                        <td><input type="text" name="cash_benefit[]" value="{{old('cash_benefit')[$key]}}"  class="form-control text-center form-control-sm cash_benefit" autocomplete="off" ></td>
                        <td><input type="text" name="type[]" value="{{old('type')[$key]}}"  class="form-control text-center form-control-sm type" autocomplete="off" ></td>
                        <td><input type="text" name="expected_date[]" id="expected_date" value="{{old('expected_date')[$key]}}" class="form-control text-center form-control-sm expected_date" autocomplete="off" ></td>
                        <td><input type="text" name="estimated_cost[]" value="{{old('estimated_cost')[$key]}}"  class="form-control text-center form-control-sm estimated_cost" autocomplete="off" ></td>
                        <td><input type="text" name="estimated_sales_value[]" value="{{old('estimated_sales_value')[$key]}}"  class="form-control text-center form-control-sm estimated_sales_value" autocomplete="off" ></td>
                        <td><input type="text" name="expected_profit[]" value="{{old('expected_profit')[$key]}}"  class="form-control text-center form-control-sm expected_profit" autocomplete="off" ></td>
                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
                @endforeach
            @else
                @if(!empty($priority_land))
                    @foreach($priority_land->BdPriorityLandDetails as $BdPriorityLandDetail)
                    <tr>
                        <td>
                            <input type="text" name="plot_reference[]"   value="{{ !empty($BdPriorityLandDetail->bd_lead_generation_details_id) ? $BdPriorityLandDetail->BdLeadGenerationDetail->name : "" }}" id="plot_reference" class="form-control text-center form-control-sm plot_reference" autocomplete="off">
                            <input type="hidden" name="bd_lead_generation_details_id[]" value="{{ !empty($BdPriorityLandDetail->bd_lead_generation_details_id) ? $BdPriorityLandDetail->bd_lead_generation_details_id : "" }}" id="bd_lead_generation_details_id" class="form-control text-center form-control-sm bd_lead_generation_details_id">
                        </td>
                        <td><input type="text" name="location[]"  value="{{ $BdPriorityLandDetail->BdLeadGenerationDetail->bdLeadGeneration->land_location }}" class="form-control text-center form-control-sm location" autocomplete="off" tabindex="-1" readonly></td>
                        <td><input type="text" name="land_size[]" value="{{ $BdPriorityLandDetail->BdLeadGenerationDetail->bdLeadGeneration->land_size }}"  class="form-control text-center form-control-sm land_size" autocomplete="off" readonly tabindex="-1"></td>
                        <td><input type="text" name="category[]" value="{{ $BdPriorityLandDetail->category }}"  class="form-control text-center form-control-sm category" autocomplete="off" ></td>
                        <td><input type="text" name="status[]" value="{{ $BdPriorityLandDetail->status }}"  class="form-control text-center form-control-sm status" autocomplete="off" ></td>
                        <td><input type="text" name="margin[]" value="{{ $BdPriorityLandDetail->margin }}"  class="form-control text-center form-control-sm margin" autocomplete="off" ></td>
                        <td><input type="text" name="cash_benefit[]" value="{{ $BdPriorityLandDetail->cash_benefit }}"  class="form-control text-center form-control-sm cash_benefit" autocomplete="off" ></td>
                        <td><input type="text" name="type[]" value="{{ $BdPriorityLandDetail->type }}"  class="form-control text-center form-control-sm type" autocomplete="off" ></td>
                        <td><input type="text" name="expected_date[]" id="expected_date" value="{{ $BdPriorityLandDetail->expected_date }}" class="form-control text-center form-control-sm expected_date" autocomplete="off" ></td>
                        <td><input type="text" name="estimated_cost[]" value="{{ $BdPriorityLandDetail->estimated_cost }}"  class="form-control text-center form-control-sm estimated_cost" autocomplete="off" ></td>
                        <td><input type="text" name="estimated_sales_value[]" value="{{ $BdPriorityLandDetail->estimated_sales_value }}"  class="form-control text-center form-control-sm estimated_sales_value" autocomplete="off" ></td>
                        <td><input type="text" name="expected_profit[]" value="{{ $BdPriorityLandDetail->expected_profit }}"  class="form-control text-center form-control-sm expected_profit" autocomplete="off" ></td>
                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
                    @endforeach
                @endif
            @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="9" class="text-center">Total </td>
                    <td>{{ Form::number('estimated_total_cost', old('estimated_total_cost', $priority_land->estimated_total_cost ?? null), ['class' => 'form-control form-control-sm estimated_total_cost text-center', 'id' => 'estimated_total_cost', 'placeholder' => '0.00 ', 'readonly']) }}
                    </td>
                    <td>{{ Form::number('estimated_total_sales_value', old('estimated_total_sales_value', $priority_land->estimated_total_sales_value ?? null), ['class' => 'form-control form-control-sm estimated_total_sales_value text-center', 'id' => 'estimated_total_sales_value', 'placeholder' => '0.00 ', 'readonly']) }}
                    </td>
                    <td>{{ Form::number('expected_total_profit', old('expected_total_profit', $priority_land->expected_total_profit ?? null), ['class' => 'form-control form-control-sm expected_total_profit text-center', 'id' => 'expected_total_profit', 'placeholder' => '0.00 ', 'readonly']) }}
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
                    <input type="text" name="location[]"  class="form-control text-center form-control-sm location" autocomplete="off">
                    
                    <input type="hidden" name="bd_lead_generation_id[]"    id="bd_lead_generation_id" class="form-control text-center form-control-sm bd_lead_generation_id">
                </td>
                <td><input type="text" name="plot_reference[]" id="plot_reference" class="form-control text-center form-control-sm plot_reference" autocomplete="off" tabindex="-1" readonly></td>
                <td><input type="text" name="land_size[]" class="form-control text-center form-control-sm land_size" autocomplete="off" tabindex="-1" readonly></td>
                <td><input type="text" name="category[]"   class="form-control text-center form-control-sm category" autocomplete="off" tabindex="-1" readonly></td>
                <td><input type="text" name="status[]" class="form-control text-center form-control-sm status" autocomplete="off" tabindex="-1" readonly></td>
                <td><input type="text" name="margin[]"   class="form-control text-center form-control-sm margin" autocomplete="off" ></td>
                <td><input type="text" name="cash_benefit[]"  class="form-control text-center form-control-sm cash_benefit" autocomplete="off" ></td>
                <td><input type="text" name="type[]"  class="form-control text-center form-control-sm type" autocomplete="off" ></td>
                <td><input type="text" name="expected_date[]" id="expected_date" class="form-control text-center form-control-sm expected_date" autocomplete="off" ></td>
                <td><input type="text" name="estimated_cost[]"  class="form-control text-center form-control-sm estimated_cost" autocomplete="off" ></td>
                <td><input type="text" name="estimated_sales_value[]" class="form-control text-center form-control-sm estimated_sales_value" autocomplete="off" ></td>
                <td><input type="text" name="expected_profit[]" class="form-control text-center form-control-sm expected_profit" autocomplete="off" ></td>
                <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
            </tr>
            `;
            $('#itemTable tbody').append(row);
            totalEstimatedCost();
            totalEstimatedSalesValue();
            totalExpectedProfit();
        }

        // Function for calculating total Estimated Cost
        function totalEstimatedCost() {
            var total = 0;
            if ($(".estimated_cost").length > 0) {
                $(".estimated_cost").each(function(i, row) {
                    var total_price = Number($(row).val());
                    total += parseFloat(total_price);
                })
            }
            $("#estimated_total_cost").val(total.toFixed(2));
        }

        // Function for calculating total Estimated Sales
        function totalEstimatedSalesValue() {
            var total = 0;
            if ($(".estimated_sales_value").length > 0) {
                $(".estimated_sales_value").each(function(i, row) {
                    var total_price = Number($(row).val());
                    total += parseFloat(total_price);
                })
            }
            $("#estimated_total_sales_value").val(total.toFixed(2));
        }

        // Function for calculating total Expected Profit
        function totalExpectedProfit() {
            var total = 0;
            if ($(".expected_profit").length > 0) {
                $(".expected_profit").each(function(i, row) {
                    var total_price = Number($(row).val());
                    total += parseFloat(total_price);
                })
            }
            $("#expected_total_profit").val(total.toFixed(2));
        }

        

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            @if($formType == 'create' && !old('bd_lead_generation_id') )
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

            
            $(document).on('mouseenter', '.expected_date', function(){
                $(this).datepicker({format: "yyyy-mm-dd",autoclose: true,todayHighlight: true,showOtherMonths: true});
            });


            // Function for autocompletion of progress projects
        
            $(document).on('keyup', ".location", function() {
                $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('scj.bdLeadAtoSuggest') }}",
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
                        $(this).closest('tr').find('.bd_lead_generation_id').val(ui.item.value);
                        $(this).closest('tr').find('.location').val(ui.item.label);
                        $(this).closest('tr').find('.land_size').val(ui.item.land_size);
                        $(this).closest('tr').find('.category').val(ui.item.category);
                        $(this).closest('tr').find('.status').val(ui.item.status);
                        $(this).closest('tr').find('.plot_reference').val(ui.item.ownerName);
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

            $(document).on('keyup change', '.estimated_cost', function() {
                totalEstimatedCost();
            });
            $(document).on('keyup change', '.estimated_sales_value', function() {
                totalEstimatedSalesValue();
            });
            $(document).on('keyup change', '.expected_profit', function() {
                totalExpectedProfit();
            });

            
        });

    </script>
@endsection
