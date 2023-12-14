@extends('layouts.backend-layout')
@section('title', 'Fees & Cost')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Fees & Cost
    @else
        New Fees & Cost
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('fees_cost') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => "fees_cost/$fees_cost->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "fees_cost",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif

        <div class="row">
            <div class="col-md-6 col-xl-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="location_id">Location<span class="text-danger">*</span></label>
                    {{Form::select('location_id', $locations, old('location_id') ? old('location_id') : (!empty($fees_cost->location_id) ? $fees_cost->location_id : null),['class' => 'form-control','id' => 'location_id', 'placeholder'=>"Select Location", 'autocomplete'=>"off"])}}
                </div>
            </div>
        </div><!-- end row -->
        
        <hr class="bg-success">

        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span>Reference of Fees<span>&#10070;</span> </h5>
                </div>
                <table class="table table-striped table-bordered table-sm text-center" id="referenceTable">
                    <thead>
                    <tr>
                        <th>Particulers</th>
                        <th>Rate</th>
                        <th>Remarks</th>
                        <th>
                            <button class="btn btn-success btn-sm referenceTable" type="button"><i class="fa fa-plus"></i></button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @if(old('headble_id'))
                        @foreach(old('headble_id') as $key => $materialOldData)
                            <tr>
                                <td>
                                    <input type="text" name="reference_headble_name[]"   value="{{old('reference_headble_name')[$key]}}" class="form-control text-center form-control-sm reference_headble_name">
                                    <input type="hidden" name="reference_headble_id[]" value="{{old('reference_headble_id')[$key]}}" class="form-control form-control-sm text-center reference_headble_id" required >
                                </td>
                            <td><input type="text" name="reference_rate[]"  value="{{old('reference_rate')[$key]}}" class="form-control text-center form-control-sm reference_rate" autocomplete="off"></td>
                                <td><input type="text" name="reference_remarks[]"  value="{{old('reference_remarks')[$key]}}" class="form-control text-center form-control-sm reference_remarks" autocomplete="off"></td>
                            <td><button class="btn btn-danger btn-sm deleteReference" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                            </tr>
                        @endforeach
                    @else
                        @if(isset($fees_cost) && count($fees_cost->BdFeasiRefFeesAndCostDetail))
                            @foreach($fees_cost->BdFeasiRefFeesAndCostDetail as $key => $BdFeasiFessAndCostDetail)
                            <tr>
                                <td>
                                    <input type="text" name="reference_headble_name[]"   value="{{ $BdFeasiFessAndCostDetail->headable->name }}" class="form-control text-center form-control-sm reference_headble_name">
                                    <input type="hidden" name="reference_headble_id[]" value="{{ $BdFeasiFessAndCostDetail->headble_id }}" class="form-control form-control-sm text-center reference_headble_id" required >
                                </td>
                                <td><input type="text" name="reference_rate[]"  value="{{ $BdFeasiFessAndCostDetail->rate}}" class="form-control text-center form-control-sm text-center reference_rate" autocomplete="off"></td>
                                <td><input type="text" name="reference_remarks[]"  value="{{ $BdFeasiFessAndCostDetail->remarks}}" class="form-control text-center form-control-sm text-center reference_remarks"  tabindex="-1" autocomplete="off"></td>
                                <td><button class="btn btn-danger btn-sm deleteReference" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                            </tr>
                            @endforeach
                        @endif
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <hr class="bg-success">
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span>Substation & Generator</span>&#10070;</span> </h5>
                </div>
                <table class="table table-striped table-bordered table-sm text-center" id="generatorTable">
                    <thead>
                    <tr>
                        <th>Particulers</th>
                        <th>Unit</th>
                        <th>Calculation</th>
                        <th>Rate</th>
                        <th>Quantity</th>
                        <th>Remarks</th>
                        <th>Total</th>
                        <th>
                            <button class="btn btn-success btn-sm generatorTable" type="button"><i class="fa fa-plus"></i></button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @if(old('headble_id'))
                    @foreach(old('headble_id') as $key => $materialOldData)
                        <tr>
                            <td>
                                <input type="text" name="generator_head_name[]"   value="{{old('generator_head_name')[$key]}}" class="form-control text-center form-control-sm generator_head_name">
                                <input type="hidden" name="generator_headble_id[]" value="{{old('generator_headble_id')[$key]}}" class="form-control form-control-sm text-center generator_headble_id" required >
                            </td>
                            <td><input type="text" name="unit[]" value="{{old('unit')[$key]}}" class="form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                            <td><input type="text" name="generator_calculation[]" data-toggle="tooltip" title="[ 0 - 9 ] , [ + , - , / , * , . ] is allowed only" value="{{old('generator_calculation')[$key]}}" class="form-control form-control text-center form-control-sm calculation"></td>
                            <td><input type="text" name="generator_rate[]"  value="{{old('generator_rate')[$key]}}" class="form-control text-center form-control-sm generator_rate" autocomplete="off"></td>
                            <td><input type="text" name="generator_quantity[]"  value="{{old('generator_quantity')[$key]}}" class="form-control text-center form-control-sm generator_quantity" autocomplete="off"></td>
                            <td><input type="text" name="generator_remarks[]"  value="{{old('generator_remarks')[$key]}}" class="form-control text-center form-control-sm generator_remarks" autocomplete="off"></td>
                            <td><input type="text" name="generator_total[]" value="{{old('generator_total')[$key]}}" class="form-control text-center form-control-sm generator_total"  autocomplete="off" readonly tabindex="-1"></td>
                            <td><button class="btn btn-danger btn-sm deleteGenerator" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                    @else
                        @if(isset($fees_cost) && count($fees_cost->BdFeasiGenFeesAndCostDetail))
                            @foreach($fees_cost->BdFeasiGenFeesAndCostDetail as $key => $BdFeasiFessAndCostDetail)
                            <tr>
                                <td>
                                    <input type="text" name="reference_headble_name[]"   value="{{ $BdFeasiFessAndCostDetail->headable->name }}" class="form-control text-center form-control-sm reference_headble_name">
                                    <input type="hidden" name="reference_headble_id[]" value="{{ $BdFeasiFessAndCostDetail->headable_id }}" class="form-control form-control-sm text-center reference_headble_id" required >
                                </td>
                                <td><input type="text" name="unit[]" value="{{ $BdFeasiFessAndCostDetail->headable->unit->name }}" class="form-control text-center form-control-sm text-center unit" readonly tabindex="-1"></td>
                                <td><input type="text" name="generator_calculation[]" data-toggle="tooltip" title="[ 0 - 9 ] , [ + , - , / , * , . ] is allowed only" value="{{ $BdFeasiFessAndCostDetail->calculation }}" class="form-control form-control text-center form-control-sm calculation"></td>
                                <td><input type="text" name="generator_rate[]"  value="{{ $BdFeasiFessAndCostDetail->rate }}" class="form-control text-center form-control-sm text-center generator_rate" autocomplete="off"></td>
                                <td><input type="text" name="generator_quantity[]"  value="{{ $BdFeasiFessAndCostDetail->quantity }}" class="form-control text-center form-control-sm text-center generator_quantity"  autocomplete="off"></td>
                                <td><input type="text" name="generator_remarks[]"  value="{{ $BdFeasiFessAndCostDetail->remarks}}" class="form-control text-center form-control-sm text-center generator_remarks"  tabindex="-1" autocomplete="off"></td>
                                <td><input type="text" name="generator_total[]" value="{{ $BdFeasiFessAndCostDetail->rate * $BdFeasiFessAndCostDetail->quantity }}" class="form-control text-center form-control-sm generator_total"  autocomplete="off"></td>
                                <td><button class="btn btn-danger btn-sm deleteGenerator" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                            </tr>
                            @endforeach
                        @endif
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

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
                        <input type="hidden" name="permission_headble_id[]" class="permission_headble_id" id="permission_headble_id">
                        <input type="text" name="permission_head_name[]" class="form-control text-center form-control-sm permission_head_name" autocomplete="off" required placeholder="Perticuler Name">
                    </td>
                    <td><input type="text" name="unit[]" class="form-control form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                    <td><input type="text" name="permission_calculation[]" data-toggle="tooltip" title="[ 0 - 9 ] , [ + , - , / , * , . ] is allowed only" class="form-control form-control text-center form-control-sm calculation"></td>
                    <td><input type="number" name="permission_rate[]" class="form-control text-center form-control-sm permission_rate" step="0.01"></td>
                    <td><input type="number" name="permission_quantity[]" class="form-control text-center form-control-sm permission_quantity" step="0.01"></td>
                    <td><input type="text" name="permission_remarks[]" class="form-control text-center form-control-sm permission_remarks"></td>
                    <td><input type="number" name="permission_total[]" class="form-control text-center form-control-sm permission_total" step="0.01" tabindex="-1" readonly></td>
                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            $('#itemTable tbody').append(row);
            calculateTotalValue(this);
            $("[data-toggle='tooltip']").tooltip()
        }



        function addReferenceRow(){
            let row = `
                <tr>
                    <td>
                        <input type="hidden" name="reference_headble_id[]" class="reference_headble_id" id="reference_headble_id">
                        <input type="text" name="reference_head_name[]" class="form-control text-center form-control-sm reference_head_name" autocomplete="off" required placeholder="Perticuler Name">
                    </td>
                    <td><input type="number" step="0.01" name="reference_rate[]" class="form-control text-center form-control-sm reference_rate"></td>
                    <td><input type="text" step="0.01" name="reference_remarks[]" class="form-control text-center form-control-sm reference_remarks"></td>
                    <td><button class="btn btn-danger btn-sm deleteReference" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            $('#referenceTable tbody').append(row);
            $("[data-toggle='tooltip']").tooltip()
        }

        function addGeneratorRow(){
            let row = `
                <tr>
                    <td>
                        <input type="hidden" name="generator_headble_id[]" class="generator_headble_id" id="generator_headble_id">
                        <input type="text" name="generator_head_name[]" class="form-control text-center form-control-sm generator_head_name" autocomplete="off" required placeholder="Perticuler Name">
                    </td>
                    <td><input type="text" name="unit[]" class="form-control form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                    <td><input type="text" name="generator_calculation[]" data-toggle="tooltip" title="[ 0 - 9 ] , [ + , - , / , * , . ] is allowed only" class="form-control form-control text-center form-control-sm calculation"></td>
                    <td><input type="number" step="0.01" name="generator_rate[]" class="form-control text-center form-control-sm generator_rate"></td>
                    <td><input type="number" step="0.01" name="generator_quantity[]" class="form-control text-center form-control-sm generator_quantity"></td>
                    <td><input type="text" name="generator_remarks[]" class="form-control text-center form-control-sm generator_remarks"></td>
                    <td><input type="number" name="generator_total[]" class="form-control text-center form-control-sm generator_total" tabindex="-1" readonly></td>
                    <td><button class="btn btn-danger btn-sm deleteGenerator" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            $('#generatorTable tbody').append(row);
            calculateTotalValue(this);
            $("[data-toggle='tooltip']").tooltip()
        }



            @if($formType == 'create' && !old('headble_id'))
                
                addReferenceRow();
                addGeneratorRow();
                calculateTotalValue(this);
            @endif

            $("#itemTable").on('click', ".addItem", function(){
                addRow();
                calculateTotalValue(this);

            }).on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
                calculateTotalValue(this);
            });

            $("#referenceTable").on('click', ".referenceTable", function(){
                addReferenceRow();

            }).on('click', '.deleteReference', function(){
                $(this).closest('tr').remove();
            });

            $("#generatorTable").on('click', ".generatorTable", function(){
                addGeneratorRow();
                calculateTotalValue(this);

            }).on('click', '.deleteGenerator', function(){
                $(this).closest('tr').remove();
                calculateTotalValue(this);
            });


            $(document).on('keyup change', '.generator_rate,.generator_quantity, .permission_rate, .permission_quantity, .utility_rate,.utility_quantity', function() {
                calculateTotalValue(this);
            });

            function calculateTotalValue(thisVal) {
                let permission_rate = $(thisVal).closest('tr').find('.permission_rate').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.permission_rate').val()) : 0;
                let permission_quantity = $(thisVal).closest('tr').find('.permission_quantity').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.permission_quantity').val()) : 0;
                let permission_total = (permission_rate * permission_quantity).toFixed(2);
                $(thisVal).closest('tr').find('.permission_total').val(permission_total);

                let generator_rate = $(thisVal).closest('tr').find('.generator_rate').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.generator_rate').val()) : 0;
                let generator_quantity = $(thisVal).closest('tr').find('.generator_quantity').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.generator_quantity').val()) : 0;
                let generator_total = (generator_rate * generator_quantity).toFixed(2);
                $(thisVal).closest('tr').find('.generator_total').val(generator_total);

            }

            var CSRF_TOKEN = "{{csrf_token()}}";
            $(document).on('keyup', ".permission_head_name", function(){
                $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('permissionHeadAutoSuggest') }}",
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
                        $(this).closest('tr').find('.permission_head_name').val(ui.item.label);
                        $(this).closest('tr').find('.permission_headble_id').val(ui.item.permission_headble_id);
                        $(this).closest('tr').find('.unit').val(ui.item.unit);
                    }
                });
            });

            $(document).on('keyup', ".reference_head_name", function(){
                $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('referenceHeadAutoSuggest') }}",
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
                        $(this).closest('tr').find('.reference_head_name').val(ui.item.label);
                        $(this).closest('tr').find('.reference_headble_id').val(ui.item.reference_headble_id);
                    }
                });
            });

            $(document).on('keyup', ".generator_head_name", function(){
                $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('generatorHeadAutoSuggest') }}",
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
                        $(this).closest('tr').find('.generator_head_name').val(ui.item.label);
                        $(this).closest('tr').find('.generator_headble_id').val(ui.item.generator_headble_id);
                        $(this).closest('tr').find('.unit').val(ui.item.unit);
                    }
                });
            });

            $(document).on('change','.calculation',function(){
                const pattern = /^(\d|\*|\-|\/|\+|\(|\)|\.)+$/g;
                let chewck = pattern.test($(this).val());
                if(chewck){
                    var data = eval($(this).val()).toFixed(2);
                    if(data<0){
                        data = 0;
                    }
                }else{
                    var data = 0;
                }
                $(this).closest('tr').find('.generator_rate').val(data);
                $( ".generator_rate" ).trigger( "change" );
                
            })


      
     

        $(function() { 
            document.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                }
            });
            
        }) // Document.Ready
    </script>
    
@endsection


