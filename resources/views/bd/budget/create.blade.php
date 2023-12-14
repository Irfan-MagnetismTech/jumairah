@extends('layouts.backend-layout')
@section('title', 'Monthly Budget')
@section('breadcrumb-title')
@if($formType == 'edit')
Edit Monthly Budget
@else
Add Monthly Budget
@endif
@endsection
@section('breadcrumb-button')
<a href="{{ url('bd_budget') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection
@section('sub-title')
<span class="text-danger">*</span> Marked are required.
@endsection
@section('content-grid', null)
@section('content')
@if($formType == 'edit')
{!! Form::open(array('url' => "bd_budget/$bd_budget->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
@else
{!! Form::open(array('url' => "bd_budget",'method' => 'POST', 'class'=>'custom-form')) !!}
@endif
<div class="row">
    <div class="col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="applied_date">Budget For<span class="text-danger">*</span></label>
            {{Form::text('applied_date', old('applied_date') ? old('applied_date') : (!empty($bd_budget) ? $bd_budget->applied_date : now()->format('Y-m-d')),['class' => 'form-control','id' => 'applied_date','autocomplete'=>"off","required", 'placeholder' => 'Date'])}}

            
        </div>
    </div>
    <div class="col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="month">Month<span class="text-danger">*</span></label>
            {{Form::text('month', old('month') ? old('month') : (!empty($bd_budget) ? $bd_budget->month : now()->format('m')),['class' => 'form-control','id' => 'month','autocomplete'=>"off","required", 'placeholder' => 'Date'])}}
        </div>
    </div>
    </div><!-- end row -->
    <hr class="bg-success">
    <div class="tableHeading">
        <h5> <span>&#10070;</span>Projects in Progress<span>&#10070;</span> </h5>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
                <tr>
                    <th width="200px">Project Name</th>
                    <th>Particulers</th>
                    <th>Remarks</th>
                    <th>Budget Amount</th>
                    <th>
                        <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody>
                
                @if(old('progress_cost_center_id'))
                @foreach(old('progress_cost_center_id') as $key => $materialOldData)
                <tr>
                    <td>
                        <input type="text" name="progress_project_name[]"   value="{{old('progress_project_name')[$key]}}" id="progress_project_name" class="form-control text-center form-control-sm progress_project_name" autocomplete="off">
                        <input type="hidden" name="progress_cost_center_id[]"   value="{{old('progress_cost_center_id')[$key]}}" id="progress_cost_center_id" class="form-control text-center form-control-sm progress_cost_center_id">
                    </td>
                    <td>
                        <input type="text" id="progress_particulers" name="progress_particulers[]"  value="{{old('progress_particulers')[$key]}}" class="form-control text-center form-control-sm progress_particulers" autocomplete="off" tabindex="-1">
                        <datalist id="progress_particulers">
                        @foreach($particulars as $particular)
                        <option value{{$particular->id}}>{{$particular->name}}</option>
                        @endforeach
                        </datalist>
                    </td>
                    
                    <td><input type="text" name="progress_remarks[]" value="{{old('progress_remarks')[$key]}}"  class="form-control text-center form-control-sm progress_remarks" autocomplete="off" tabindex="-1"></td>
                    <td><input type="number" name="progress_amount[]" value="{{old('progress_amount')[$key]}}" class="form-control text-center form-control-sm progress_amount" autocomplete="off" tabindex="-1"></td>
                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
                @endforeach
                @else
                @if(!empty($bd_budget))
                @foreach($bd_budget->BdProgressBudget as $BdProgressBudgetDetails)
                <tr>
                    <td>
                        <input type="text" name="progress_project_name[]"   value="{{ !empty($BdProgressBudgetDetails->progress_cost_center_id) ? $BdProgressBudgetDetails->costCenter->name : "" }}" id="progress_project_name" autocomplete="off" class="form-control text-center form-control-sm progress_project_name">
                        <input type="hidden" name="progress_cost_center_id[]" value="{{ !empty($BdProgressBudgetDetails->progress_cost_center_id) ? $BdProgressBudgetDetails->progress_cost_center_id : "" }}" id="progress_cost_center_id" class="form-control form-control-sm text-center progress_cost_center_id" >
                    </td>
                    <td>
                        <input type="text" list="progress_particulers" name="progress_particulers[]"  value="{{ $BdProgressBudgetDetails->progress_particulers }}" class="form-control text-center form-control-sm text-center progress_particulers" autocomplete="off" tabindex="-1">
                        <datalist id="progress_particulers">
                        @foreach($particulars as $particular)
                        <option value{{$particular->id}}>{{$particular->name}}</option>
                        @endforeach
                        </datalist>
                    </td>
                    
                    <td><input type="text" name="progress_remarks[]" value="{{ $BdProgressBudgetDetails->progress_remarks }}"  class="form-control text-center form-control-sm progress_remarks" autocomplete="off"></td>
                    <td><input type="number" name="progress_amount[]" value="{{ $BdProgressBudgetDetails->progress_amount }}" class="form-control text-center form-control-sm progress_amount" autocomplete="off" tabindex="-1"></td>
                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
                @endforeach
                @endif
                @endif
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2" class="text-right">Total </td>
                <td>{{ Form::number('progress_total_amount', old('progress_total_amount', $bd_budget->progress_total_amount ?? null), ['class' => 'form-control form-control-sm progress_total_amount text-center', 'id' => 'progress_total_amount', 'placeholder' => '0.00 ', 'readonly']) }}
                </td>
            </tr>
            </tfoot>
        </table>
        </div> <!-- end table responsive -->
        <br><br>
        <div class="tableHeading">
            <h5> <span>&#10070;</span>Future Projects<span>&#10070;</span> </h5>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm text-center" id="itemTableFuture">
                <thead>
                    <tr>
                        <th width="200px">Project Name</th>
                        <th>Particulers</th>
                        <th>Remarks</th>
                        <th>Budget Amount</th>
                        <th>
                            <button class="btn btn-success btn-sm addItemFuture" type="button"><i class="fa fa-plus"></i></button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if(old('future_cost_center_id'))
                    @foreach(old('future_cost_center_id') as $key => $materialOldData)
                    <tr>
                        <td>
                            <input type="text" name="future_project_name[]"   value="{{old('future_project_name')[$key]}}" id="future_project_name" class="form-control text-center form-control-sm future_project_name" autocomplete="off">
                            <input type="hidden" name="future_cost_center_id[]"   value="{{old('future_cost_center_id')[$key]}}" id="future_cost_center_id" class="form-control text-center form-control-sm future_cost_center_id">
                        </td>
                        <td>
                            <input type="text" list="future_particulers" name="future_particulers[]"  value="{{old('future_particulers')[$key]}}" class="form-control text-center form-control-sm future_particulers" autocomplete="off" tabindex="-1">
                            <datalist id="future_particulers">
                            @foreach($particulars as $particular)
                            <option value{{$particular->id}}>{{$particular->name}}</option>
                            @endforeach
                            </datalist>
                        </td>
                        <td><input type="text" name="future_remarks[]" value="{{old('future_remarks')[$key]}}"  class="form-control text-center form-control-sm future_remarks" autocomplete="off" tabindex="-1"></td>
                        <td><input type="number" name="future_amount[]" value="{{old('future_amount')[$key]}}" class="form-control text-center form-control-sm future_amount" autocomplete="off" tabindex="-1"></td>
                        <td><button class="btn btn-danger btn-sm deleteItemFuture" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
                    @endforeach
                    @else
                    @if(!empty($bd_budget))
                    @foreach($bd_budget->BdFutureBudget as $BdFutureBudgetDetails)
                    <tr>
                        <td>
                            <input type="text" name="future_project_name[]"   value="{{ !empty($BdFutureBudgetDetails->future_cost_center_id) ? $BdFutureBudgetDetails->costCenter->name : "" }}" id="future_project_name" autocomplete="off" class="form-control text-center form-control-sm future_project_name">
                            <input type="hidden" name="future_cost_center_id[]" value="{{ !empty($BdFutureBudgetDetails->future_cost_center_id) ? $BdFutureBudgetDetails->future_cost_center_id : "" }}" id="future_cost_center_id" class="form-control form-control-sm text-center future_cost_center_id" >
                        </td>
                        <td>
                            <input type="text" list="future_particulers" name="future_particulers[]"  value="{{ $BdFutureBudgetDetails->future_particulers }}" class="form-control text-center form-control-sm text-center future_particulers" autocomplete="off" tabindex="-1">
                            <datalist id="future_particulers">
                            @foreach($particulars as $particular)
                            <option value{{$particular->id}}>{{$particular->name}}</option>
                            @endforeach
                            </datalist>
                        </td>
                        <td><input type="text" name="future_remarks[]" value="{{ $BdFutureBudgetDetails->future_remarks ?? 0 }}"  class="form-control text-center form-control-sm future_remarks"></td>
                        <td><input type="number" name="future_amount[]" value="{{ $BdFutureBudgetDetails->future_amount }}" class="form-control text-center form-control-sm future_amount" autocomplete="off" tabindex="-1"></td>
                        <td><button class="btn btn-danger btn-sm deleteItemFuture" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
                    @endforeach
                    @endif
                    @endif
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2" class="text-right">Total </td>
                    <td>{{ Form::number('future_total_amount', old('future_total_amount', $bd_budget->future_total_amount ?? null), ['class' => 'form-control form-control-sm future_total_amount text-center', 'id' => 'future_total_amount', 'placeholder' => '0.00 ', 'readonly']) }}
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
                        <input type="text" name="progress_project_name[]" id="progress_project_name" class="form-control text-center form-control-sm progress_project_name" autocomplete="off">
                        <input type="hidden"  name="progress_cost_center_id[]" id="progress_cost_center_id" class="form-control text-center form-control-sm progress_cost_center_id">
                    </td>
                    <td>
                    <input type="text" list="progress_particulers" name="progress_particulers[]" class="form-control text-center form-control-sm progress_particulers" autocomplete="off" tabindex="-1">
                        <datalist id="progress_particulers">
                        @foreach($particulars as $particular)
                        <option value{{$particular->id}}>{{$particular->name}}</option>
                        @endforeach
                        </datalist>
                    </td>
                    <td><input type="text" name="progress_remarks[]"  class="form-control text-center form-control-sm progress_remarks" autocomplete="off" tabindex="-1"></td>
                    <td><input type="number" name="progress_amount[]"  class="form-control text-center form-control-sm progress_amount" autocomplete="off" tabindex="-1"></td>
                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
                `;
                $('#itemTable tbody').append(row);
                totalOperationProgress();
                }
                function addRowFuture(){
                let row = `
                <tr>
                    <td>
                        <input type="text" name="future_project_name[]" id="future_project_name" class="form-control text-center form-control-sm future_project_name" autocomplete="off">
                        <input type="hidden" name="future_cost_center_id[]" id="future_cost_center_id" class="form-control text-center form-control-sm future_cost_center_id">
                    </td>
                    <td>
                    <input type="text" list="future_particulers" name="future_particulers[]" class="form-control text-center form-control-sm future_particulers" autocomplete="off" tabindex="-1">
                        <datalist id="future_particulers">
                            @foreach($particulars as $particular)
                            <option value{{$particular->id}}>{{$particular->name}}</option>
                            @endforeach
                            </datalist>
                    </td>
                    <td><input type="text" name="future_remarks[]"  class="form-control text-center form-control-sm future_remarks" autocomplete="off" tabindex="-1"></td>
                    <td><input type="number" name="future_amount[]"  class="form-control text-center form-control-sm future_amount" autocomplete="off" tabindex="-1"></td>
                    <td><button class="btn btn-danger btn-sm deleteItemFuture" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
                `;
                $('#itemTableFuture tbody').append(row);
                totalOperationFuture();
                }
                // Function for calculating total Progress price
                function totalOperationProgress() {
                var total = 0;
                if ($(".progress_amount").length > 0) {
                $(".progress_amount").each(function(i, row) {
                var total_price = Number($(row).val());
                total += parseFloat(total_price);
                })
                }
                $("#progress_total_amount").val(total.toFixed(2));
                }
                // Function for calculating total Progress price
                function totalOperationFuture() {
                var total = 0;
                if ($(".future_amount").length > 0) {
                $(".future_amount").each(function(i, row) {
                var total_price = Number($(row).val());
                total += parseFloat(total_price);
                })
                }
                $("#future_total_amount").val(total.toFixed(2));
                }
                var CSRF_TOKEN = "{{csrf_token()}}";
                $(function(){
                @if($formType == 'create' && !old('progress_cost_center_id') && !old('future_cost_center_id'))
                addRow();
                addRowFuture();
                @endif
                $("#itemTable").on('click', ".addItem", function(){
                addRow();
                }).on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
                });
                $("#itemTableFuture").on('click', ".addItemFuture", function(){
                addRowFuture();
                }).on('click', '.deleteItemFuture', function(){
                $(this).closest('tr').remove();
                });
                $('#applied_date').datepicker({format: "yyyy-mm-dd",autoclose: true,todayHighlight: true,showOtherMonths: true});
                // Function for autocompletion of progress projects
                
                $(document).on('keyup', ".progress_project_name", function() {
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
                $(this).closest('tr').find('.progress_cost_center_id').val(ui.item.value);
                $(this).closest('tr').find('.progress_project_name').val(ui.item.label);
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
                $(document).on('keyup change', '.progress_amount', function() {
                totalOperationProgress();
                });
                $(document).on('keyup change', '.future_amount', function() {
                totalOperationFuture();
                });
                });
                </script>
                @endsection