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
    <style>
        .input_field {
          width: 100%;
          overflow: hidden;
          white-space: nowrap;
          text-overflow: ellipsis;
        }
      </style>
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
            <div class="col-xl-12 col-md-12 table-responsive">
                <div class="tableHeading w-100">
                    <h5> <span>&#10070;</span>Permission Fees & Utility<span>&#10070;</span> </h5>
                </div>
                <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
                    <thead>
                        <tr>
                            <th width="30%">Particulers</th>
                            <th width="5%">Unit</th>
                            <th width="10%">Calculation</th>
                            <th width="10%">Rate</th>
                            <th width="10%">Quantity</th>
                            <th width="10%">Remarks</th>
                            <th width="10%">Total</th>
                            <th width="5%">Add/Remove</th>
                        </tr>
                    </thead>
                    <tbody>

                    @if ($formType == 'create' && !old('permission_headble_id'))
                        @foreach ($data as $key => $val )
                            @php
                                $data = str_replace(' ', '_', $key);
                            @endphp
                            <tr>
                                <td class="text-center" colspan="6">
                                    <b>{{$key}}</b>
                                    <input type="hidden" name="permission_head_name_key[]" value="{{$key}}"  class="form-control text-center form-control-sm permission_head_name" autocomplete="off" required placeholder="Perticuler Name">
                                </td>
                                <td></td>
                                <td><button class="btn btn-success btn-sm addItem" type="button" onclick="addRow('{{$key}}','{{$data}}')"><i
                                    class="fa fa-plus"></i></button>
                                </td>
                            </tr>
                            
                            @foreach ($val as $kk=>$value )
                                <tr>
                                    <td>
                                        <input type="hidden" name="permission_headble_id[{{$key}}][]" value="{{$value->id}}" class="permission_headble_id" id="permission_headble_id">
                                        <input type="text" name="permission_head_name[{{$key}}][]" value="{{$value->name}}" class="form-control text-center form-control-sm permission_head_name {{$data}}" autocomplete="off" required placeholder="Perticuler Name">
                                    </td>
                                    <td><input type="text" name="unit[{{$key}}][]" value="{{$value->unit->name}}" class="form-control form-control text-center form-control-sm unit input_field " readonly tabindex="-1"></td>
                                    <td><input type="text" name="permission_calculation[{{$key}}][]" data-toggle="tooltip" title="[ 0 - 9 ] , [ + , - , / , * , . ] is allowed only" class="form-control form-control text-center form-control-sm calculation input_field"></td>
                                    <td><input type="number" name="permission_rate[{{$key}}][]" class="form-control text-center form-control-sm permission_rate input_field" step="0.01"></td>
                                    <td><input type="number" name="permission_quantity[{{$key}}][]" class="form-control text-center form-control-sm permission_quantity input_field" step="0.01"></td>
                                    <td><input type="text" name="permission_remarks[{{$key}}][]" class="form-control text-center form-control-sm permission_remarks input_field"></td>
                                    <td><input type="number" name="permission_total[{{$key}}][]" class="form-control text-center form-control-sm permission_total input_field {{$data.'_total'}}" step="0.01" tabindex="-1" readonly></td>
                             
                                    <td><button class="btn btn-danger btn-sm deleteItem" type="button"><i
                                        class="fa fa-minus"></i></button></td>
                                </tr>
                                @if ($loop->last)
                                    <tr>
                                        <td colspan="6">Total</td>
                                        <td>
                                            <input type="number" name="permission_sub_total[{{$key}}]" class="form-control text-center form-control-sm input_field {{$data.'_sub_total'}}" step="0.01" tabindex="-1" readonly>
                                        </td>
                                        <td></td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                                <tr>
                                    <td colspan="6">Grand Total</td>
                                    <td>
                                        <input type="number" name="permission_grand_total" class="form-control text-center form-control-sm input_field {{'grand_total'}}" step="0.01" tabindex="-1" readonly>
                                    </td>
                                </tr>
                    @endif
                   

                    @if(old('permission_headble_id'))
                        @foreach(old('permission_headble_id') as $key => $datas)
                                @php
                                        $data_name = str_replace(' ', '_', $key);
                                @endphp
                            <tr>
                                <td class="text-center" colspan="6">
                                    <b>{{$key}}</b>
                                    <input type="hidden" name="permission_head_name_key[]" value="{{$key}}"  class="form-control text-center form-control-sm permission_head_name" autocomplete="off" required placeholder="Perticuler Name">
                                </td>
                                <td></td>
                                <td><button class="btn btn-success btn-sm addItem" type="button" onclick="addRow('{{$key}}','{{$data}}')"><i
                                    class="fa fa-plus"></i></button>
                                </td>
                            </tr>
                            
                            @foreach ($datas as $kk => $data)
                                <tr>
                                    <td>
                                        <input type="text" name="permission_head_name[{{$key}}][]" value="{{old('permission_head_name')[$key][$kk]}}" class="form-control text-center form-control-sm permission_headble_name {{$data_name}}">
                                        <input type="hidden" name="permission_headble_id[{{$key}}][]" value="{{old('permission_headble_id')[$key][$kk]}}" class="form-control form-control-sm text-center permission_headble_id" required >
                                    </td>
                                    <td><input type="text" name="unit[{{$key}}][]" value="{{old('unit')[$key][$kk]}}" class="form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                                    <td><input type="text" name="permission_calculation[{{$key}}][]" data-toggle="tooltip" title="[ 0 - 9 ] , [ + , - , / , * , . ] is allowed only" value="{{old('permission_calculation')[$key][$kk]}}" class="form-control form-control text-center form-control-sm calculation input_field"></td>
                                    <td><input type="text" name="permission_rate[{{$key}}][]" value="{{old('permission_rate')[$key][$kk]}}" class="form-control text-center form-control-sm permission_rate input_field" autocomplete="off"></td>
                                    <td><input type="text" name="permission_quantity[{{$key}}][]" value="{{old('permission_quantity')[$key][$kk]}}" class="form-control text-center form-control-sm permission_quantity input_field" autocomplete="off"></td>
                                    <td><input type="text" name="permission_remarks[{{$key}}][]" value="{{old('permission_remarks')[$key][$kk]}}" class="form-control text-center form-control-sm permission_remarks input_field" autocomplete="off"></td>
                                    <td><input type="text" name="permission_total[{{$key}}][]" value="{{old('permission_total')[$key][$kk]}}" class="form-control text-center form-control-sm permission_total input_field {{$data_name.'_total'}}"  autocomplete="off" readonly tabindex="-1"></td>
                                    <td><button class="btn btn-danger btn-sm deleteItem" type="button"><i
                                        class="fa fa-minus"></i></button></td>
                                    
                                </tr>

                                @if ($loop->last)
                                    <tr>
                                        <td colspan="6">Total</td>
                                        <td>
                                            <input type="number" name="permission_sub_total[{{$key}}]" value="{{old('permission_sub_total')[$key]}}" class="form-control text-center form-control-sm input_field {{$data_name.'_sub_total'}}" step="0.01" tabindex="-1" readonly>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                            <tr>
                                <td colspan="6">Grand Total</td>
                                <td>
                                    <input type="number" name="permission_grand_total" class="form-control text-center form-control-sm input_field {{'grand_total'}}" step="0.01" tabindex="-1" readonly value="{{old('permission_grand_total')}}">
                                </td>
                            </tr>
                    @else
                        @if(isset($fees_cost) && count($fees_cost->BdFeasiFessAndCostDetail))
                            @php
                                $grand_total = 0;
                            @endphp
                            @foreach ($details as $key => $values )
                            @php
                                $data = str_replace(' ', '_', $key);
                                $data = str_replace('&','and',$data);
                                $total = 0;
                            @endphp
                                <tr>
                                    <td class="text-center" colspan="6">
                                        <b>{{$key}}</b>
                                        <input type="hidden" name="permission_head_name_key[]" value="{{$key}}"  class="form-control text-center form-control-sm permission_head_name" autocomplete="off" required placeholder="Perticuler Name">
                                    </td>
                                    <td></td>
                                    <td><button class="btn btn-success btn-sm addItem" type="button" onclick="addRow('{{$key}}','{{$data}}')"><i
                                        class="fa fa-plus"></i></button>
                                    </td>
                                </tr>
                               
                                @foreach ($values as $kk => $val)
                                    <tr>
                                        <td>
                                            <input type="text" name="permission_head_name[{{$key}}][]"   value="{{ $val->headable?->name ?? '' }}" class="form-control text-center form-control-sm permission_headble_name {{$data}}">
                                            <input type="hidden" name="permission_headble_id[{{$key}}][]" value="{{ $val->headble_id }}" class="form-control form-control-sm text-center permission_headble_id" required >
                                        </td>
                                        <td><input type="text" name="unit[{{$key}}][]"  value="{{ $val?->headable?->unit?->name ?? ''}}" class="form-control text-center form-control-sm text-center unit" readonly tabindex="-1"></td>
                                        <td><input type="text" name="permission_calculation[{{$key}}][]" data-toggle="tooltip" title="[ 0 - 9 ] , [ + , - , / , * , . ] is allowed only" value="{{ $val->calculation }}" class="form-control form-control text-center form-control-sm calculation input_field"></td>
                                        <td><input type="text" name="permission_rate[{{$key}}][]"  value="{{ $val->rate}}" class="form-control text-center form-control-sm text-center permission_rate input_field" autocomplete="off"></td>
                                        <td><input type="text" name="permission_quantity[{{$key}}][]"  value="{{ $val->quantity}}" class="form-control text-center form-control-sm text-center permission_quantity input_field" autocomplete="off"></td>
                                        <td><input type="text" name="permission_remarks[{{$key}}][]"  value="{{ $val->remarks}}" class="form-control text-center form-control-sm text-center permission_remarks input_field"  tabindex="-1" autocomplete="off"></td>
                                        <td><input type="text" name="permission_total[{{$key}}][]" value="{{ $val->rate * $val->quantity }}" class="form-control text-center form-control-sm permission_total input_field {{$data.'_total'}}"  autocomplete="off"></td>
                                        <td><button class="btn btn-danger btn-sm deleteItem" type="button"><i
                                            class="fa fa-minus"></i></button></td>
                                    </tr>
                                    @php
                                        $total += ($val->rate * $val->quantity);
                                    @endphp
                                    @if ($loop->last)
                                        @php
                                            $grand_total += $total;
                                        @endphp
                                        <tr>
                                            <td colspan="6">Total</td>
                                            <td>
                                                <input type="number" name="permission_sub_total[{{$key}}]" class="form-control text-center form-control-sm input_field {{$data.'_sub_total'}}" step="0.01" tabindex="-1" readonly value="{{ $total }}">
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                            <tr>
                                <td colspan="6">Grand Total</td>
                                <td>
                                    <input type="number" name="permission_grand_total" class="form-control text-center form-control-sm input_field {{'grand_total'}}" step="0.01" tabindex="-1" readonly value="{{ $grand_total }}">
                                </td>
                            </tr>
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
        
        function addRow(ky,cls){
            let row = `
            <tr>
                <td>
                    <input type="hidden" name="permission_headble_id[${ky}][]" value="" class="permission_headble_id" id="permission_headble_id">
                    <input type="text" name="permission_head_name[${ky}][]" value="" class="form-control text-center form-control-sm permission_head_name ${cls}" autocomplete="off" required placeholder="Perticuler Name">
                </td>
                <td><input type="text" name="unit[${ky}][]" value="" class="form-control form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                <td><input type="text" name="permission_calculation[${ky}][]" data-toggle="tooltip" title="[ 0 - 9 ] , [ + , - , / , * , . ] is allowed only" class="form-control form-control text-center form-control-sm input_field calculation"></td>
                <td><input type="number" name="permission_rate[${ky}][]" class="form-control text-center form-control-sm permission_rate input_field" step="0.01"></td>
                <td><input type="number" name="permission_quantity[${ky}][]" class="form-control text-center form-control-sm permission_quantity input_field" step="0.01"></td>
                <td><input type="text" name="permission_remarks[${ky}][]" class="form-control text-center form-control-sm permission_remarks input_field"></td>
                <td><input type="number" name="permission_total[${ky}][]" class="form-control text-center form-control-sm permission_total input_field ${cls+'_total'}" step="0.01" tabindex="-1" readonly></td>
                <td> <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button">
                                    <i class="fa fa-minus"></i>
                                </button>
                </td>
            </tr>
            `;
            let className = "."+cls+"_sub_total";
            $(className).closest('tr').before(row);
            // $('#itemTable tbody').append(row);
            calculateTotalValue(this);
        }

            @if($formType == 'create' && !old('headble_id'))
                    calculateTotalValue(this);
            @endif

            $("#itemTable").on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
            });

            


            $(document).on('keyup change', '.generator_rate,.generator_quantity, .permission_rate, .permission_quantity, .utility_rate,.utility_quantity', function() {
                calculateTotalValue(this);
                calculate_permission_fee_sub_total();
                calculate_utility_fee_sub_total();
                grand_total();
            });

            function calculate_permission_fee_sub_total(){
                let Total = 0;
                $('.Permission_Fees_total').each(function(index,element){
                    Total += Number($(element).val()) ?? 0;
                })
                $('.Permission_Fees_sub_total').val(Total);
            }

            function calculate_utility_fee_sub_total(){
                let Total = 0;
                $('.Utility_total').each(function(index,element){
                    Total += Number($(element).val()) ?? 0;
                })
                $('.Utility_sub_total').val(Total);
            }
            
            function grand_total(){
                let grand = (Number($('.Permission_Fees_sub_total').val()) ?? 0) + (Number($('.Utility_sub_total').val()) ?? 0);
                $('.grand_total').val(grand);
            }

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

            $('.calculation').on('change',function(){
                const pattern = /^(\d|\*|\-|\/|\+|\(|\)|\.)+$/g;
                let value = ($(this).val().trim().replace(/\s/g, ''));
                let chewck = pattern.test(value);
                if(chewck){
                    var data = eval($(this).val());
                    if(data<0){
                        data = 0;
                    }
                }else{
                    var data = 0;
                }
                $(this).closest('tr').find('.permission_rate').val(data.toFixed(2));
                $( ".permission_rate" ).trigger( "change" );
            })


            var CSRF_TOKEN = "{{csrf_token()}}";
            $(document).on('keyup', ".permission_head_name", function(){
                let type = $(this).attr("class").split(' ').filter(function(value) {
                            return value !== "ui-autocomplete-input" && value !== "ui-autocomplete-loading";
                        }).pop();
                $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('permissionHeadAutoSuggestwithType') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                search: request.term,
                                type
                            },
                            headers: {
                                'X-CSRF-TOKEN': CSRF_TOKEN
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

 

        
     

        $(function() { 
            document.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                }
            });
            // increaseSize();
            // $(document).on('.input_field','keyup',function(){
            //     increaseSize(this);
            // })

                // $('.input_field').keypress(function() {
                //     var txtWidth = $(this).attr('size');
                //     var cs = $(this).val().length-6;
                //     txtWidth = parseInt(txtWidth);
                //     if(cs>txtWidth){
                //     $(this).attr('size',txtWidth+5);    }
                // });
                // });
                setAll();
            $(document).on('keyup','.input_field',setAll)
            
           

        }) // Document.Ready
           
        // function increaseSize(a){
            
        //     }
        function setAll(){
                        document.querySelectorAll('.input_field').forEach(item => {
		        item.style.width = Math.max(item.value.length, 20) + "ch";
            });

        //dynamically set the new width with a minimum width of 20ch as you type
                document.querySelectorAll('.input_field').forEach(item => {
                    item.addEventListener('input', event => {
                        item.style.width = Math.max(item.value.length, 20) + "ch"; 
                    });
            });
                    }
    </script>
    
@endsection


