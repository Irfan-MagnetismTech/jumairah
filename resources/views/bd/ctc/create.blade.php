@extends('layouts.backend-layout')
@section('title', 'CTC')

@section('breadcrumb-title')
    {{ empty($BdLeadGeneration_id) ? 'PER MONTH COST TO THE COMPANY CALCULATION' : 'PER MONTH COST TO THE COMPANY CALCULATION' }}
@endsection

@section('breadcrumb-button')
    <a href="{{ url("ctc") }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

        @if($formType == 'edit')
            {!! Form::open(array('url' => "ctc/$ctc->id",'method' => 'PUT','class'=>'custom-form')) !!}
        @else
            {!! Form::open(array('url' => "ctc",'method' => 'POST','class'=>'custom-form')) !!}
        @endif

        <div class="row">
            <div class="col-md-6 col-xl-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="location_id">Location<span class="text-danger">*</span></label>
                    {{Form::select('location_id', $locations, old('location_id') ? old('location_id') : (!empty($ctc->location_id) ? $ctc->location_id : null),['class' => 'form-control','id' => 'location_id', 'placeholder'=>"Select Location", 'autocomplete'=>"off"])}}
                </div>
            </div>
        </div><!-- end row -->

    <div class="table-responsive">
        <table id="purchaseTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Department<span class="text-danger">*</span></th>
                    <th>Designation<span class="text-danger">*</span></th>
                    <th>Employment <br>Nature</th>
                    <th>Percent <br>of Sharing</th>
                    <th>Number</th>
                    <th>Gross Salary</th>
                    <th>Mobile Bill <br>Allowence</th>
                    <th>Providend Fund(%)</th>
                    <th>Providend Fund</th>
                    <th>Bonus (%)</th>
                    <th>Bonus</th>
                    <th>Long Term<br> Service Benefit</th>
                    <th>Canteen <br>Contribution Expense</th>
                    <th>Earned Leave<br> Encashment</th>
                    <th>Others</th>
                    <th>Total Payable</th>
                    <th>Total Effect</th>
                    <th>Percent on<br> Gross Salary</th>

                    <th><i class="btn btn-primary btn-sm fa fa-plus" id="addItem" onclick="addItemDtl()"> </i></th>
                </tr>
            </thead>
            <tbody>
                @if ($formType == 'create' && !(old('designation_id')))
                    @foreach ($rate_data as $key => $value)
                        <tr>
                            <td>
                                {{Form::select('department_id[]',$departments,$value->department_id,  ['class' => 'form-control form-control-sm department_id','required' ])}}
                            </td>
                            <td>
                                {{Form::select('designation_id[]',$designations,$value->designation_id,  ['class' => 'form-control form-control-sm designation_id','required' ])}}
                            </td>
                            <td>
                                {{Form::select('employment_nature[]',$employment_nature,$value->employment_nature,  ['class' => 'form-control form-control-sm employment_nature','required',])}}
                            </td>
                            <td>
                                <input type="text" name="percent_sharing[]" placeholder="0.00" class="form-control percent_sharing text-center" autocomplete="off" >
                            </td>
                            <td>
                                <input type="text" name="number[]" placeholder="0.00" class="form-control number text-center" autocomplete="off" >
                            </td>
                            <td>
                                <input type="text" name="gross_salary[]" placeholder="0.00" class="form-control gross_salary text-center" id="gross_salary" autocomplete="off" >
                            </td>
                            <td>
                                <input type="text" name="mobile_bill[]" value="{{ $value->mobile_bill }}" class="form-control mobile_bill text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="providend_fund_cent[]" value="{{ $value->providend_fund_cent }}" class="form-control providend_fund_cent text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="providend_fund[]" value="{{ $value->providend_fund }}" class="form-control providend_fund text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="bonus_cent[]" value="{{ $value->bonus_cent }}" class="form-control bonus_cent text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="bonus[]" value="{{ $value->bonus }}" class="form-control bonus text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="Long_term_benefit[]" value="{{ $value->Long_term_benefit }}" class="form-control Long_term_benefit text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="canteen_expense[]" value="{{ $value->canteen_expense }}" class="form-control canteen_expense text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="earned_encashment[]" value="{{ $value->earned_encashment }}" class="form-control earned_encashment text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="others[]" value="{{ $value->others }}" class="form-control others text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="total_payable[]" placeholder="0.00" class="form-control total_payable text-center" autocomplete="off" tabindex="-1" readonly>
                            </td>
                            <td>
                                <input type="text" name="total_effect[]" placeholder="0.00" class="form-control total_effect text-center" autocomplete="off" tabindex="-1" readonly>
                            </td>
                            <td>
                                <input type="text" name="percent_on_slry[]" placeholder="0.00" class="form-control gross_salary_percent text-center" autocomplete="off" tabindex="-1" readonly>
                            </td>


                            <td class="text-center">
                                <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button" tabindex="-1">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
                @if(old('designation_id'))
                    @foreach(old('designation_id') as $key => $OldData)
                        <tr>
                            <td>
                                <select class ="form-control form-control-sm" name="department_id[]">
                                    @foreach ($departments as $k1 => $department)
                                        <option value="{{$k1}}" {{ $k1 == old('department_id')[$key] ? 'selected' : null }}>{{$department}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class ="form-control form-control-sm" name="designation_id[]">
                                    @foreach ($designations as $k2 => $designation)
                                        <option value="{{$k2}}" {{ $k2 == old('designation_id')[$key] ? 'selected' : null }}>{{$designation}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class ="form-control form-control-sm" name="designation_id[]">
                                    @foreach ($employment_nature as $k3 => $nature)
                                        <option value="{{$k3}}" {{ $k3 == old('employment_nature')[$key] ? 'selected' : null }}>{{$nature}}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input type="text" name="percent_sharing[]" value="{{old('percent_sharing')[$key]}}" class="form-control percent_sharing text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="number[]" value="{{old('number')[$key]}}" class="form-control number text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="gross_salary[]" value="{{old('gross_salary')[$key]}}" class="form-control gross_salary text-center" id="gross_salary" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="mobile_bill[]" value="{{old('mobile_bill')[$key]}}" class="form-control mobile_bill text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="providend_fund_cent[]" value="{{old('providend_fund_cent')[$key]}}" class="form-control providend_fund_cent text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="providend_fund[]" value="{{old('providend_fund')[$key]}}" class="form-control providend_fund text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="bonus_cent[]" value="{{old('bonus_cent')[$key]}}" class="form-control bonus_cent text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="bonus[]" value="{{old('bonus')[$key]}}" class="form-control bonus text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="Long_term_benefit[]" value="{{old('Long_term_benefit')[$key]}}" class="form-control Long_term_benefit text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="canteen_expense[]" value="{{old('canteen_expense')[$key]}}" class="form-control canteen_expense text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="earned_encashment[]" value="{{old('earned_encashment')[$key]}}" class="form-control earned_encashment text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="others[]" value="{{old('others')[$key]}}" class="form-control others text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="text" name="total_payable[]" value="{{old('total_payable')[$key]}}" class="form-control total_payable text-center" autocomplete="off" tabindex="-1" readonly>
                            </td>
                            <td>
                                <input type="text" name="total_effect[]" value="{{old('total_effect')[$key]}}" class="form-control total_effect text-center" autocomplete="off" tabindex="-1" readonly>
                            </td>
                            <td>
                                <input type="text" name="percent_on_slry[]" value="{{old('percent_on_slry')[$key]}}" class="form-control gross_salary_percent text-center" autocomplete="off" tabindex="-1" readonly>
                            </td>

                            <td class="text-center">
                                <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button" tabindex="-1">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    @if(!empty($ctc))
                        @foreach($ctc->BdFeasiCtcDetail as $data)
                            <tr>
                                <td>
                                    {{Form::select('department_id[]',$departments,$data->department_id,  ['class' => 'form-control form-control-sm department_id','required' ])}}
                                </td>
                                <td>
                                    {{Form::select('designation_id[]',$designations,$data->designation_id,  ['class' => 'form-control form-control-sm designation_id','required' ])}}
                                </td>
                                <td>
                                    {{Form::select('employment_nature[]',$employment_nature,$data->employment_nature,  ['class' => 'form-control form-control-sm employment_nature','required',])}}
                                </td>
                                <td>
                                    <input type="text" name="percent_sharing[]" value="{{ $data->percent_sharing }}" class="form-control percent_sharing text-center" autocomplete="off" required>
                                </td>
                                <td>
                                    <input type="text" name="number[]" value="{{ $data->number }}" class="form-control number text-center" autocomplete="off" required>
                                </td>
                                <td>
                                    <input type="text" name="gross_salary[]" value="{{ $data->gross_salary }}" class="form-control gross_salary text-center" id="gross_salary" autocomplete="off" required>
                                </td>
                                <td>
                                    <input type="text" name="mobile_bill[]" value="{{ $data->mobile_bill }}" class="form-control mobile_bill text-center" autocomplete="off" required>
                                </td>
                                <td>
                                    <input type="text" name="providend_fund_cent[]" value="{{ $data->providend_fund_cent }}" class="form-control providend_fund_cent text-center" autocomplete="off" required>
                                </td>
                                <td>
                                    <input type="text" name="providend_fund[]" value="{{ $data->providend_fund }}" class="form-control providend_fund text-center" autocomplete="off" required>
                                </td>
                                <td>
                                    <input type="text" name="bonus_cent[]" value="{{ $data->bonus_cent }}" class="form-control bonus_cent text-center" autocomplete="off" required>
                                </td>
                                <td>
                                    <input type="text" name="bonus[]" value="{{ $data->bonus }}" class="form-control bonus text-center" autocomplete="off" required>
                                </td>
                                <td>
                                    <input type="text" name="Long_term_benefit[]" value="{{ $data->Long_term_benefit }}" class="form-control Long_term_benefit text-center" autocomplete="off" required>
                                </td>
                                <td>
                                    <input type="text" name="canteen_expense[]" value="{{ $data->canteen_expense }}" class="form-control canteen_expense text-center" autocomplete="off" required>
                                </td>
                                <td>
                                    <input type="text" name="earned_encashment[]" value="{{ $data->earned_encashment }}" class="form-control earned_encashment text-center" autocomplete="off" required>
                                </td>
                                <td>
                                    <input type="text" name="others[]" value="{{ $data->others }}" class="form-control others text-center" autocomplete="off" required>
                                </td>
                                <td>
                                    <input type="text" name="total_payable[]" value="{{ $data->total_payable }}" class="form-control total_payable text-center" autocomplete="off" tabindex="-1" readonly>
                                </td>
                                <td>
                                    <input type="text" name="total_effect[]" value="{{ $data->total_effect }}" class="form-control total_effect text-center" autocomplete="off" tabindex="-1" readonly>
                                </td>
                                <td>
                                    <input type="text" name="percent_on_slry[]" value="{{ $data->percent_on_slry }}" class="form-control gross_salary_percent text-center" autocomplete="off" tabindex="-1" readonly>
                                </td>


                                <td class="text-center">
                                    <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button" tabindex="-1">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endif

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="15"></td>
                    <td>{{ Form::text('grand_total_payable', old('grand_total_payable') ? old('grand_total_payable') : (!empty($ctc->grand_total_payable) ? $ctc->grand_total_payable : null), ['class' => 'form-control', 'id' => 'grand_total_payable', 'autocomplete' => 'off', 'required','readonly','placeholder' => '0.00']) }}</td>
                    <td>{{ Form::text('grand_total_effect', old('grand_total_effect') ? old('grand_total_effect') : (!empty($ctc->grand_total_effect) ? $ctc->grand_total_effect : null), ['class' => 'form-control', 'id' => 'grand_total_effect', 'autocomplete' => 'off', 'required','readonly','placeholder' => '0.00']) }}</td>
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
        const CSRF_TOKEN = "{{ csrf_token() }}";


        // Function for adding new material row
        function addItemDtl() {
            var Row = `
            <tr>
                <td>
                    {{Form::select('department_id[]', $departments,null, ['class' => 'form-control form-control-sm department_id',  'placeholder' => 'Select Department','required'] )}}
                </td>
                <td>
                    {{Form::select('designation_id[]', $designations,null, ['class' => 'form-control form-control-sm designation_id',  'placeholder' => 'Select Designation','required'] )}}
                </td>
                <td>
                    <select name="employment_nature[]" id="employment_nature" class="form-control form-control-sm employment_nature" required>
                        @foreach ($employment_nature as $data)
                            <option value="{{ $data }}">{{ $data }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" name="percent_sharing[]" value="" class="form-control percent_sharing text-center" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="number[]" value="" class="form-control number text-center" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="gross_salary[]" value="" class="form-control gross_salary text-center" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="mobile_bill[]" value="" class="form-control mobile_bill text-center" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="providend_fund_cent[]" value="" class="form-control providend_fund_cent text-center" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="providend_fund[]" value="" class="form-control providend_fund text-center" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="bonus_cent[]" value="" class="form-control bonus_cent text-center" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="bonus[]" value="" class="form-control bonus text-center" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="Long_term_benefit[]" value="" class="form-control Long_term_benefit text-center" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="canteen_expense[]" value="" class="form-control canteen_expense text-center" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="earned_encashment[]" value="" class="form-control earned_encashment text-center" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="others[]" value="" class="form-control others text-center" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="total_payable[]" value="" class="form-control total_payable text-center" id="total_payable" autocomplete="off" tabindex="-1" readonly>
                </td>
                <td>
                    <input type="text" name="total_effect[]" value="" class="form-control total_effect text-center" autocomplete="off" tabindex="-1" readonly>
                </td>
                <td>
                    <input type="text" name="percent_on_slry[]" value="" class="form-control gross_salary_percent text-center" autocomplete="off" tabindex="-1" readonly>
                </td>

                <td class="text-center">
                    <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button" tabindex="-1">
                        <i class="fa fa-minus"></i>
                    </button>
                </td>
            </tr>
            `;
            var tableItem = $('#purchaseTable').append(Row);
            calculateTotalGroundCoverage(this);
        }

        $(document).on('change keyup',".percent_sharing, .gross_salary, .mobile_bill, .providend_fund,.providend_fund_cent, .bonus,.bonus_cent, .Long_term_benefit, .canteen_expense, .earned_encashment, .others, .number", function(){
                calculateTotalGroundCoverage(this);
            });

        function calculateTotalGroundCoverage(thisVal){

            let number        = $(thisVal).closest('tr').find(".number").val() > 0 ? parseFloat($(thisVal).closest('tr').find(".number").val()): 0;


            let gross_salary        = $(thisVal).closest('tr').find(".gross_salary").val() > 0 ? parseFloat($(thisVal).closest('tr').find(".gross_salary").val()): 0;
            var providend_fund = 0;
            var bonus = 0;
            if(gross_salary>0){

                let providend_fund_cent     = $(thisVal).closest('tr').find(".providend_fund_cent").val() > 0 ? parseFloat($(thisVal).closest('tr').find(".providend_fund_cent").val()): 0;
                let bonus_cent               = $(thisVal).closest('tr').find(".bonus_cent").val() > 0 ? parseFloat($(thisVal).closest('tr').find(".bonus_cent").val()): 0;
                    providend_fund     = (providend_fund_cent>0) ? ((Number(gross_salary)/2) * Number(providend_fund_cent) / 100) : 0;
                    $(thisVal).closest('tr').find('.providend_fund').val(providend_fund);
                    bonus     = (bonus_cent>0) ? ((Number(gross_salary) * Number(bonus_cent) / 100 * 2) / 12) : 0;
                    $(thisVal).closest('tr').find('.bonus').val(bonus);
               
            }else{
                $(thisVal).closest('tr').find('.providend_fund').val(providend_fund);
                $(thisVal).closest('tr').find('.bonus').val(bonus);
            }
            let mobile_bill         = $(thisVal).closest('tr').find(".mobile_bill").val() > 0 ? parseFloat($(thisVal).closest('tr').find(".mobile_bill").val()): 0;

            let Long_term_benefit   = $(thisVal).closest('tr').find(".Long_term_benefit").val() > 0 ? parseFloat($(thisVal).closest('tr').find(".Long_term_benefit").val()): 0;
            let canteen_expense     = $(thisVal).closest('tr').find(".canteen_expense").val() > 0 ? parseFloat($(thisVal).closest('tr').find(".canteen_expense").val()): 0;
            let earned_encashment   = $(thisVal).closest('tr').find(".earned_encashment").val() > 0 ? parseFloat($(thisVal).closest('tr').find(".earned_encashment").val()): 0;
            let others              = $(thisVal).closest('tr').find(".others").val() > 0 ? parseFloat($(thisVal).closest('tr').find(".others").val()): 0;

            let total_payable = gross_salary + mobile_bill + providend_fund + bonus + Long_term_benefit + canteen_expense + earned_encashment + others;
            let total_effect = number * total_payable;
            let gross_calculation = (total_effect / gross_salary / number) * 100;
            let gross_salary_percent = (gross_calculation).toFixed(2);
            $(thisVal).closest('tr').find('.total_payable').val(total_payable);
            $(thisVal).closest('tr').find('.total_effect').val(total_effect);
            $(thisVal).closest('tr').find('.gross_salary_percent').val(gross_salary_percent);
            totalPayable();
            totalEffect();
        }

        // Function for deleting a row
        function removQRow(qval) {
            var rowIndex = qval.parentNode.parentNode.rowIndex;
            document.getElementById("purchaseTable").deleteRow(rowIndex);
            totalPayable();
            totalEffect();
        }

        function totalPayable(){
            var totalPayable = 0;
            $('.total_payable').each(function(row){
                let amount = $(this).val() ?? 0;
                totalPayable += Number(amount);
            });
            $('#grand_total_payable').val(totalPayable);
        }

        function totalEffect(){
            var totalEffect = 0;
            $('.total_effect').each(function(row){
                let amount = $(this).val() ?? 0;
                totalEffect += Number(amount);
            });
            $('#grand_total_effect').val(totalEffect);
        }
        @if($formType == 'create' && !old('designation_id'))

        @endif

    </script>

@endsection
