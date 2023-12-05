@extends('layouts.backend-layout')
@section('title', 'Yearly Budget')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Yearly Budget
    @else
        Add Yearly Budget
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('bd_yearly_budget') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if($formType == 'edit') 
        {!! Form::open(array('url' => "bd_yearly_budget/$bd_yearly_budget->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "bd_yearly_budget",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="applied_date">Budget For<span class="text-danger">*</span></label>
                    {{Form::text('applied_date', old('applied_date') ? old('applied_date') : (!empty($bd_yearly_budget) ? $bd_yearly_budget->applied_date : null),['class' => 'form-control','id' => 'applied_date','autocomplete'=>"off","required", 'placeholder' => 'Date'])}}
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
                <th>January</th>
                <th>February</th>
                <th>March</th>
                <th>April</th>
                <th>May</th>
                <th>June</th>
                <th>July</th>
                <th>August</th>
                <th>September</th>
                <th>October</th>
                <th>November</th>
                <th>December</th>
                <th>Total</th>
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
                        <td><input type="text" name="progress_particulers[]"  value="{{old('progress_particulers')[$key]}}" class="form-control text-center form-control-sm progress_particulers" autocomplete="off" ></td>
                        <td><input type="text" name="progress_remarks[]" value="{{old('progress_remarks')[$key]}}"  class="form-control text-center form-control-sm progress_remarks" autocomplete="off" ></td>
                        <td><input type="text" name="progress_january[]" value="{{old('progress_january')[$key]}}"  class="form-control text-center form-control-sm progress_january" autocomplete="off" ></td>
                        <td><input type="text" name="progress_february[]" value="{{old('progress_february')[$key]}}"  class="form-control text-center form-control-sm progress_february" autocomplete="off" ></td>
                        <td><input type="text" name="progress_march[]" value="{{old('progress_march')[$key]}}"  class="form-control text-center form-control-sm progress_march" autocomplete="off" ></td>
                        <td><input type="text" name="progress_april[]" value="{{old('progress_april')[$key]}}"  class="form-control text-center form-control-sm progress_april" autocomplete="off" ></td>
                        <td><input type="text" name="progress_may[]" value="{{old('progress_may')[$key]}}"  class="form-control text-center form-control-sm progress_may" autocomplete="off" ></td>
                        <td><input type="text" name="progress_june[]" value="{{old('progress_june')[$key]}}"  class="form-control text-center form-control-sm progress_june" autocomplete="off" ></td>
                        <td><input type="text" name="progress_july[]" value="{{old('progress_july')[$key]}}"  class="form-control text-center form-control-sm progress_july" autocomplete="off" ></td>
                        <td><input type="text" name="progress_august[]" value="{{old('progress_august')[$key]}}"  class="form-control text-center form-control-sm progress_august" autocomplete="off" ></td>
                        <td><input type="text" name="progress_september[]" value="{{old('progress_september')[$key]}}"  class="form-control text-center form-control-sm progress_september" autocomplete="off" ></td>
                        <td><input type="text" name="progress_october[]" value="{{old('progress_october')[$key]}}"  class="form-control text-center form-control-sm progress_october" autocomplete="off" ></td>
                        <td><input type="text" name="progress_november[]" value="{{old('progress_november')[$key]}}"  class="form-control text-center form-control-sm progress_november" autocomplete="off" ></td>
                        <td><input type="text" name="progress_december[]" value="{{old('progress_december')[$key]}}"  class="form-control text-center form-control-sm progress_december" autocomplete="off" ></td>
                        <td><input type="number" name="progress_amount[]" value="{{old('progress_amount')[$key]}}" class="form-control text-center form-control-sm progress_amount" autocomplete="off" tabindex="-1"></td>
                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
                @endforeach
            @else
                @if(!empty($bd_yearly_budget))
                    @foreach($bd_yearly_budget->BdProgressYearlyBudget as $BdProgressYearlyBudgetDetails)

                        <tr>
                            <td>
                                <input type="text" name="progress_project_name[]"   value="{{ !empty($BdProgressYearlyBudgetDetails->progress_cost_center_id) ? $BdProgressYearlyBudgetDetails->costCenter->name : "" }}" id="progress_project_name" autocomplete="off" class="form-control text-center form-control-sm progress_project_name">
                                <input type="hidden" name="progress_cost_center_id[]" value="{{ !empty($BdProgressYearlyBudgetDetails->progress_cost_center_id) ? $BdProgressYearlyBudgetDetails->progress_cost_center_id : "" }}" id="progress_cost_center_id" class="form-control form-control-sm text-center progress_cost_center_id" >
                            </td>
                            <td><input type="text" name="progress_particulers[]"  value="{{ $BdProgressYearlyBudgetDetails->progress_particulers }}" class="form-control text-center form-control-sm text-center progress_particulers" autocomplete="off" tabindex="-1"></td>
                            <td><input type="text" name="progress_remarks[]" value="{{ $BdProgressYearlyBudgetDetails->progress_remarks }}"  class="form-control text-center form-control-sm progress_remarks" autocomplete="off"></td>
                            <td><input type="text" name="progress_january[]" value="{{ $BdProgressYearlyBudgetDetails->progress_january }}"  class="form-control text-center form-control-sm progress_january" autocomplete="off" ></td>
                            <td><input type="text" name="progress_february[]" value="{{ $BdProgressYearlyBudgetDetails->progress_february }}"  class="form-control text-center form-control-sm progress_february" autocomplete="off" ></td>
                            <td><input type="text" name="progress_march[]" value="{{ $BdProgressYearlyBudgetDetails->progress_march }}"  class="form-control text-center form-control-sm progress_march" autocomplete="off" ></td>
                            <td><input type="text" name="progress_april[]" value="{{ $BdProgressYearlyBudgetDetails->progress_april }}"  class="form-control text-center form-control-sm progress_april" autocomplete="off" ></td>
                            <td><input type="text" name="progress_may[]" value="{{ $BdProgressYearlyBudgetDetails->progress_may }}"  class="form-control text-center form-control-sm progress_may" autocomplete="off" ></td>
                            <td><input type="text" name="progress_june[]" value="{{ $BdProgressYearlyBudgetDetails->progress_june }}"  class="form-control text-center form-control-sm progress_june" autocomplete="off" ></td>
                            <td><input type="text" name="progress_july[]" value="{{ $BdProgressYearlyBudgetDetails->progress_july }}"  class="form-control text-center form-control-sm progress_july" autocomplete="off" ></td>
                            <td><input type="text" name="progress_august[]" value="{{ $BdProgressYearlyBudgetDetails->progress_august }}"  class="form-control text-center form-control-sm progress_august" autocomplete="off" ></td>
                            <td><input type="text" name="progress_september[]" value="{{ $BdProgressYearlyBudgetDetails->progress_september }}"  class="form-control text-center form-control-sm progress_september" autocomplete="off" ></td>
                            <td><input type="text" name="progress_october[]" value="{{ $BdProgressYearlyBudgetDetails->progress_october }}" class="form-control text-center form-control-sm progress_october" autocomplete="off" ></td>
                            <td><input type="text" name="progress_november[]" value="{{ $BdProgressYearlyBudgetDetails->progress_november }}"  class="form-control text-center form-control-sm progress_november" autocomplete="off" ></td>
                            <td><input type="text" name="progress_december[]" value="{{ $BdProgressYearlyBudgetDetails->progress_december }}"  class="form-control text-center form-control-sm progress_december" autocomplete="off" ></td>
                            <td><input type="number" name="progress_amount[]" value="{{ $BdProgressYearlyBudgetDetails->progress_amount }}" class="form-control text-center form-control-sm progress_amount" autocomplete="off" tabindex="-1"></td>
                            <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @endif
            @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="15" class="text-center">Total </td>
                    <td>{{ Form::number('progress_total_amount', old('progress_total_amount', $bd_yearly_budget->progress_total_amount ?? null), ['class' => 'form-control form-control-sm progress_total_amount text-center', 'id' => 'progress_total_amount', 'placeholder' => '0.00 ', 'readonly']) }}
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
                <th>January</th>
                <th>February</th>
                <th>March</th>
                <th>April</th>
                <th>May</th>
                <th>June</th>
                <th>July</th>
                <th>August</th>
                <th>September</th>
                <th>October</th>
                <th>November</th>
                <th>December</th>
                <th>Total</th>
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
                        <td><input type="text" name="future_particulers[]"  value="{{old('future_particulers')[$key]}}" class="form-control text-center form-control-sm future_particulers" autocomplete="off" tabindex="-1"></td>
                        <td><input type="text" name="future_remarks[]"      value="{{old('future_remarks')[$key]}}"     class="form-control text-center form-control-sm future_remarks"     autocomplete="off" tabindex="-1"></td>
                        <td><input type="text" name="future_january[]"      value="{{old('future_january')[$key]}}"     class="form-control text-center form-control-sm future_january"     autocomplete="off" ></td>
                        <td><input type="text" name="future_february[]"     value="{{old('future_february')[$key]}}"    class="form-control text-center form-control-sm future_february"    autocomplete="off" ></td>
                        <td><input type="text" name="future_march[]"        value="{{old('future_march')[$key]}}"       class="form-control text-center form-control-sm future_march"       autocomplete="off" ></td>
                        <td><input type="text" name="future_april[]"        value="{{old('future_april')[$key]}}"       class="form-control text-center form-control-sm future_april"       autocomplete="off" ></td>
                        <td><input type="text" name="future_may[]"          value="{{old('future_may')[$key]}}"         class="form-control text-center form-control-sm future_may"         autocomplete="off" ></td>
                        <td><input type="text" name="future_june[]"         value="{{old('future_june')[$key]}}"        class="form-control text-center form-control-sm future_june"        autocomplete="off" ></td>
                        <td><input type="text" name="future_july[]"         value="{{old('future_july')[$key]}}"        class="form-control text-center form-control-sm future_july"        autocomplete="off" ></td>
                        <td><input type="text" name="future_august[]"       value="{{old('future_august')[$key]}}"      class="form-control text-center form-control-sm future_august"      autocomplete="off" ></td>
                        <td><input type="text" name="future_september[]"    value="{{old('future_september')[$key]}}"   class="form-control text-center form-control-sm future_september"   autocomplete="off" ></td>
                        <td><input type="text" name="future_october[]"      value="{{old('future_october')[$key]}}"     class="form-control text-center form-control-sm future_october"     autocomplete="off" ></td>
                        <td><input type="text" name="future_november[]"     value="{{old('future_november')[$key]}}"    class="form-control text-center form-control-sm future_november"    autocomplete="off" ></td>
                        <td><input type="text" name="future_december[]"     value="{{old('future_december')[$key]}}"    class="form-control text-center form-control-sm future_december"    autocomplete="off" ></td>
                        <td><input type="number" name="future_amount[]"     value="{{old('future_amount')[$key]}}"      class="form-control text-center form-control-sm future_amount"      autocomplete="off" tabindex="-1"></td>
                        <td><button class="btn btn-danger btn-sm deleteItemFuture" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
                @endforeach
            @else
                @if(!empty($bd_yearly_budget))
                    @foreach($bd_yearly_budget->BdFutureYearlyBudget as $BdFutureYearlyBudgetDetail)
                        <tr>
                            <td>
                                <input type="text" name="future_project_name[]"   value="{{ !empty($BdFutureYearlyBudgetDetail->future_cost_center_id) ? $BdFutureYearlyBudgetDetail->costCenter->name : "" }}" id="future_project_name" autocomplete="off" class="form-control text-center form-control-sm future_project_name">
                                <input type="hidden" name="future_cost_center_id[]" value="{{ !empty($BdFutureYearlyBudgetDetail->future_cost_center_id) ? $BdFutureYearlyBudgetDetail->future_cost_center_id : "" }}" id="future_cost_center_id" class="form-control form-control-sm text-center future_cost_center_id" >
                            </td>
                            <td><input type="text" name="future_particulers[]"  value="{{ $BdFutureYearlyBudgetDetail->future_particulers }}" class="form-control text-center form-control-sm text-center future_particulers" autocomplete="off" tabindex="-1"></td>
                            <td><input type="text" name="future_remarks[]" value="{{ $BdFutureYearlyBudgetDetail->future_remarks }}"  class="form-control text-center form-control-sm future_remarks"></td>
                            <td><input type="text" name="future_january[]"      value="{{ $BdFutureYearlyBudgetDetail->future_january }}"               class="form-control text-center form-control-sm future_january"     autocomplete="off" ></td>
                            <td><input type="text" name="future_february[]"     value="{{ $BdFutureYearlyBudgetDetail->future_february }}"    class="form-control text-center form-control-sm future_february"    autocomplete="off" ></td>
                            <td><input type="text" name="future_march[]"        value="{{ $BdFutureYearlyBudgetDetail->future_march }}"       class="form-control text-center form-control-sm future_march"       autocomplete="off" ></td>
                            <td><input type="text" name="future_april[]"        value="{{ $BdFutureYearlyBudgetDetail->future_april }}"       class="form-control text-center form-control-sm future_april"       autocomplete="off" ></td>
                            <td><input type="text" name="future_may[]"          value="{{ $BdFutureYearlyBudgetDetail->future_may }}"         class="form-control text-center form-control-sm future_may"         autocomplete="off" ></td>
                            <td><input type="text" name="future_june[]"         value="{{ $BdFutureYearlyBudgetDetail->future_june }}"        class="form-control text-center form-control-sm future_june"        autocomplete="off" ></td>
                            <td><input type="text" name="future_july[]"         value="{{ $BdFutureYearlyBudgetDetail->future_july }}"        class="form-control text-center form-control-sm future_july"        autocomplete="off" ></td>
                            <td><input type="text" name="future_august[]"       value="{{ $BdFutureYearlyBudgetDetail->future_august }}"      class="form-control text-center form-control-sm future_august"      autocomplete="off" ></td>
                            <td><input type="text" name="future_september[]"    value="{{ $BdFutureYearlyBudgetDetail->future_september }}"   class="form-control text-center form-control-sm future_september"   autocomplete="off" ></td>
                            <td><input type="text" name="future_october[]"      value="{{ $BdFutureYearlyBudgetDetail->future_october }}"     class="form-control text-center form-control-sm future_october"     autocomplete="off" ></td>
                            <td><input type="text" name="future_november[]"     value="{{ $BdFutureYearlyBudgetDetail->future_november }}"    class="form-control text-center form-control-sm future_november"    autocomplete="off" ></td>
                            <td><input type="text" name="future_december[]"     value="{{ $BdFutureYearlyBudgetDetail->future_december }}"    class="form-control text-center form-control-sm future_december"    autocomplete="off" ></td>
                            <td><input type="number" name="future_amount[]" value="{{ $BdFutureYearlyBudgetDetail->future_amount }}" class="form-control text-center form-control-sm future_amount" autocomplete="off" tabindex="-1"></td>
                            <td><button class="btn btn-danger btn-sm deleteItemFuture" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @endif
            @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="15" class="text-center">Total </td>
                    <td>{{ Form::number('future_total_amount', old('future_total_amount', $bd_yearly_budget->future_total_amount ?? null), ['class' => 'form-control form-control-sm future_total_amount text-center', 'id' => 'future_total_amount', 'placeholder' => '0.00 ', 'readonly']) }}
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
                    <input type="hidden" name="progress_cost_center_id[]" id="progress_cost_center_id" class="form-control text-center form-control-sm progress_cost_center_id">
                </td>
                <td><input type="text" name="progress_particulers[]" class="form-control text-center form-control-sm progress_particulers" autocomplete="off" tabindex="-1"></td>
                <td><input type="text" name="progress_remarks[]"  class="form-control text-center form-control-sm progress_remarks" autocomplete="off" tabindex="-1"></td>
                <td><input type="text" name="progress_january[]" class="form-control text-center form-control-sm progress_january" autocomplete="off" ></td>
                <td><input type="text" name="progress_february[]" class="form-control text-center form-control-sm progress_february" autocomplete="off" ></td>
                <td><input type="text" name="progress_march[]"  class="form-control text-center form-control-sm progress_march" autocomplete="off" ></td>
                <td><input type="text" name="progress_april[]"  class="form-control text-center form-control-sm progress_april" autocomplete="off" ></td>
                <td><input type="text" name="progress_may[]" class="form-control text-center form-control-sm progress_may" autocomplete="off" ></td>
                <td><input type="text" name="progress_june[]"  class="form-control text-center form-control-sm progress_june" autocomplete="off" ></td>
                <td><input type="text" name="progress_july[]"  class="form-control text-center form-control-sm progress_july" autocomplete="off" ></td>
                <td><input type="text" name="progress_august[]"  class="form-control text-center form-control-sm progress_august" autocomplete="off" ></td>
                <td><input type="text" name="progress_september[]" class="form-control text-center form-control-sm progress_september" autocomplete="off" ></td>
                <td><input type="text" name="progress_october[]" class="form-control text-center form-control-sm progress_october" autocomplete="off" ></td>
                <td><input type="text" name="progress_november[]" class="form-control text-center form-control-sm progress_november" autocomplete="off" ></td>
                <td><input type="text" name="progress_december[]"class="form-control text-center form-control-sm progress_december" autocomplete="off" ></td>
                <td><input type="number" name="progress_amount[]"  class="form-control text-center form-control-sm progress_amount" autocomplete="off" tabindex="-1" readonly></td>
                <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
            </tr>
            `;
            $('#itemTable tbody').append(row);
            calculateTotalProgressPrice(this);
            totalOperationProgress();
        }

        function addRowFuture(){
            let row = `
            <tr>
                <td>
                    <input type="text" name="future_project_name[]" id="future_project_name" class="form-control text-center form-control-sm future_project_name" autocomplete="off">
                    <input type="hidden" name="future_cost_center_id[]" id="future_cost_center_id" class="form-control text-center form-control-sm future_cost_center_id">
                </td>
                <td><input type="text" name="future_particulers[]" class="form-control text-center form-control-sm future_particulers" autocomplete="off" tabindex="-1"></td>
                <td><input type="text" name="future_remarks[]"  class="form-control text-center form-control-sm future_remarks" autocomplete="off" tabindex="-1"></td>
                <td><input type="text" name="future_january[]" class="form-control text-center form-control-sm future_january"     autocomplete="off" ></td>
                <td><input type="text" name="future_february[]"    class="form-control text-center form-control-sm future_february"    autocomplete="off" ></td>
                <td><input type="text" name="future_march[]"       class="form-control text-center form-control-sm future_march"       autocomplete="off" ></td>
                <td><input type="text" name="future_april[]"       class="form-control text-center form-control-sm future_april"       autocomplete="off" ></td>
                <td><input type="text" name="future_may[]"         class="form-control text-center form-control-sm future_may"         autocomplete="off" ></td>
                <td><input type="text" name="future_june[]"        class="form-control text-center form-control-sm future_june"        autocomplete="off" ></td>
                <td><input type="text" name="future_july[]"        class="form-control text-center form-control-sm future_july"        autocomplete="off" ></td>
                <td><input type="text" name="future_august[]"      class="form-control text-center form-control-sm future_august"      autocomplete="off" ></td>
                <td><input type="text" name="future_september[]"   class="form-control text-center form-control-sm future_september"   autocomplete="off" ></td>
                <td><input type="text" name="future_october[]"     class="form-control text-center form-control-sm future_october"     autocomplete="off" ></td>
                <td><input type="text" name="future_november[]"    class="form-control text-center form-control-sm future_november"    autocomplete="off" ></td>
                <td><input type="text" name="future_december[]"    class="form-control text-center form-control-sm future_december"    autocomplete="off" ></td>
                <td><input type="number" name="future_amount[]"  class="form-control text-center form-control-sm future_amount" autocomplete="off" tabindex="-1" readonly></td>
                <td><button class="btn btn-danger btn-sm deleteItemFuture" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
            </tr>
            `;
            $('#itemTableFuture tbody').append(row);
            calculateTotalFuturesPrice(this);
            totalOperationFuture();
        }

        // Function for calculating total Progress price
        function calculateTotalProgressPrice(thisVal) {
            let progress_january = $(thisVal).closest('tr').find('.progress_january').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.progress_january').val()) : 0;
            let progress_february = $(thisVal).closest('tr').find('.progress_february').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.progress_february').val()) : 0;
            let progress_march = $(thisVal).closest('tr').find('.progress_march').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.progress_march').val()) : 0;
            let progress_april = $(thisVal).closest('tr').find('.progress_april').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.progress_april').val()) : 0;
            let progress_may = $(thisVal).closest('tr').find('.progress_may').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.progress_may').val()) : 0;
            let progress_june = $(thisVal).closest('tr').find('.progress_june').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.progress_june').val()) : 0;
            let progress_july = $(thisVal).closest('tr').find('.progress_july').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.progress_july').val()) : 0;
            let progress_august = $(thisVal).closest('tr').find('.progress_august').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.progress_august').val()) : 0;
            let progress_september = $(thisVal).closest('tr').find('.progress_september').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.progress_september').val()) : 0;
            let progress_october = $(thisVal).closest('tr').find('.progress_october').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.progress_october').val()) : 0;
            let progress_november = $(thisVal).closest('tr').find('.progress_november').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.progress_november').val()) : 0;
            let progress_december = $(thisVal).closest('tr').find('.progress_december').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.progress_december').val()) : 0;
            let total = (progress_january+progress_february+progress_march+progress_april+progress_may+progress_june+progress_july+progress_august+progress_september+progress_october+progress_november+progress_december).toFixed(2);
            $(thisVal).closest('tr').find('.progress_amount').val(total);
            totalOperationProgress();
        }

        // Function for calculating total Future price
        function calculateTotalFuturesPrice(thisVal) {
            let future_january = $(thisVal).closest('tr').find('.future_january').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.future_january').val()) : 0;
            let future_february = $(thisVal).closest('tr').find('.future_february').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.future_february').val()) : 0;
            let future_march = $(thisVal).closest('tr').find('.future_march').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.future_march').val()) : 0;
            let future_april = $(thisVal).closest('tr').find('.future_april').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.future_april').val()) : 0;
            let future_may = $(thisVal).closest('tr').find('.future_may').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.future_may').val()) : 0;
            let future_june = $(thisVal).closest('tr').find('.future_june').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.future_june').val()) : 0;
            let future_july = $(thisVal).closest('tr').find('.future_july').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.future_july').val()) : 0;
            let future_august = $(thisVal).closest('tr').find('.future_august').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.future_august').val()) : 0;
            let future_september = $(thisVal).closest('tr').find('.future_september').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.future_september').val()) : 0;
            let future_october = $(thisVal).closest('tr').find('.future_october').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.future_october').val()) : 0;
            let future_november = $(thisVal).closest('tr').find('.future_november').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.future_november').val()) : 0;
            let future_december = $(thisVal).closest('tr').find('.future_december').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.future_december').val()) : 0;
            let total = (future_january+future_february+future_march+future_april+future_may+future_june+future_july+future_august+future_september+future_october+future_november+future_december).toFixed(2);
            $(thisVal).closest('tr').find('.future_amount').val(total);
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

            $(document).on('keyup change', '.progress_january, .progress_february, .progress_march, .progress_april, .progress_may, .progress_june, .progress_july, .progress_august, .progress_september, .progress_october, .progress_november, .progress_december', function() {
                calculateTotalProgressPrice(this);
            });

            $(document).on('keyup change', '.future_january, .future_february, .future_march, .future_april, .future_may, .future_june, .future_july, .future_august, .future_september, .future_october, .future_november, .future_december', function() {
                calculateTotalFuturesPrice(this);
            });
        });

    </script>
@endsection
