@extends('layouts.backend-layout')
@section('title', 'Revenue & Cost')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Revenue & Cost
    @else
        New Revenue & Cost
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('rnc_calculation') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => "rnc_calculation/$rncCalculation->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "rnc_calculation",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif

        <div class="row">
            <div class="col-md-6 col-xl-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="location_id">Location<span class="text-danger">*</span></label>
                    {{Form::select('location_id', $locations, old('location_id') ? old('location_id') : (!empty($rncCalculation->bd_lead_generation_id) ? $rncCalculation->bd_lead_generation_id : null),['class' => 'form-control','id' => 'location_id', 'placeholder'=>"Select Location", 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-6 col-xl-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="year">Year<span class="text-danger">*</span></label>
                    {{Form::select('year', array_combine($years,$years), old('year') ? old('year') : (!empty($rncCalculation->project_year) ? $rncCalculation->project_year : null),['class' => 'form-control','id' => 'year', 'placeholder'=>"Select Year", 'autocomplete'=>"off"])}}
                </div>
            </div>
        </div><!-- end row -->
        <hr class="bg-success">
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span>Construction<span>&#10070;</span> </h5>
                </div>
                <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
                    <thead>
                    <tr>
                        <th colspan="10">Percent</th>
                        
                    </tr>
                    <tr>
                        <th>1st</th>
                        <th>2nd</th>
                        <th>3rd</th>
                        <th>4th</th>
                        <th>5th</th>
                        <th>6th</th>
                        <th>7th</th>
                        <th>8th</th>
                        <th>9th</th>
                        <th>10th</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($rncCalculation) && !old('cons_1stper'))
                                <tr>
                                    <td><input type="text" name="cons_1stper[]" readonly class="form-control form-control text-center form-control-sm cons" value='{{ $rncCalculation->BdFeasRncCalCost->row_1st ?? 0}}'></td>
                                    <td><input type="text" name="cons_2ndper[]" readonly class="form-control form-control text-center form-control-sm cons" value='{{ $rncCalculation->BdFeasRncCalCost->row_2nd ?? 0}}'></td>
                                    <td><input type="text" name="cons_3rdper[]" readonly class="form-control form-control text-center form-control-sm cons" value='{{ $rncCalculation->BdFeasRncCalCost->row_3rd ?? 0}}'></td>
                                    <td><input type="text" name="cons_4thper[]" readonly class="form-control form-control text-center form-control-sm cons" value='{{ $rncCalculation->BdFeasRncCalCost->row_4th ?? 0}}'></td>
                                    <td><input type="text" name="cons_5thper[]" readonly class="form-control form-control text-center form-control-sm cons" value='{{ $rncCalculation->BdFeasRncCalCost->row_5th ?? 0}}'></td>
                                    <td><input type="text" name="cons_6thper[]" readonly class="form-control form-control text-center form-control-sm cons" value='{{ $rncCalculation->BdFeasRncCalCost->row_6th ?? 0}}'></td>
                                    <td><input type="text" name="cons_7thper[]" readonly class="form-control form-control text-center form-control-sm cons" value='{{ $rncCalculation->BdFeasRncCalCost->row_7th ?? 0}}'></td>
                                    <td><input type="text" name="cons_8thper[]" readonly class="form-control form-control text-center form-control-sm cons" value='{{ $rncCalculation->BdFeasRncCalCost->row_8th ?? 0}}'></td>
                                    <td><input type="text" name="cons_9thper[]" readonly class="form-control form-control text-center form-control-sm cons" value='{{ $rncCalculation->BdFeasRncCalCost->row_9th ?? 0}}'></td>
                                    <td><input type="text" name="cons_10thper[]" readonly class="form-control form-control text-center form-control-sm cons" value='{{ $rncCalculation->BdFeasRncCalCost->row_10th ?? 0}}'></td>
                                </tr>
                    @endif


                        @if(old('cons_1stper'))
                            @foreach (old('cons_1stper') as $key => $value )
                                <tr>
                                    <td><input type="text" name="cons_1stper[]" readonly class="form-control form-control text-center form-control-sm cons" value="{{ old('cons_1stper')[$key] }}"></td>
                                    <td><input type="text" name="cons_2ndper[]" readonly class="form-control form-control text-center form-control-sm cons" value="{{ old('cons_2ndper')[$key] }}"></td>
                                    <td><input type="text" name="cons_3rdper[]" readonly class="form-control form-control text-center form-control-sm cons" value="{{ old('cons_3rdper')[$key] }}"></td>
                                    <td><input type="text" name="cons_4thper[]" readonly class="form-control form-control text-center form-control-sm cons" value="{{ old('cons_4thper')[$key] }}"></td>
                                    <td><input type="text" name="cons_5thper[]" readonly class="form-control form-control text-center form-control-sm cons" value="{{ old('cons_5thper')[$key] }}"></td>
                                    <td><input type="text" name="cons_6thper[]" readonly class="form-control form-control text-center form-control-sm cons" value="{{ old('cons_6thper')[$key] }}"></td>
                                    <td><input type="text" name="cons_7thper[]" readonly class="form-control form-control text-center form-control-sm cons" value="{{ old('cons_7thper')[$key] }}"></td>
                                    <td><input type="text" name="cons_8thper[]" readonly class="form-control form-control text-center form-control-sm cons" value="{{ old('cons_8thper')[$key] }}"></td>
                                    <td><input type="text" name="cons_9thper[]" readonly class="form-control form-control text-center form-control-sm cons" value="{{ old('cons_9thper')[$key] }}"></td>
                                    <td><input type="text" name="cons_10thper[]" readonly class="form-control form-control text-center form-control-sm cons" value="{{ old('cons_10thper')[$key] }}"></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <hr class="bg-success">

        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span>Sales<span>&#10070;</span> </h5>
                </div>
                <table class="table table-striped table-bordered table-sm text-center" id="referenceTable">
                    <thead>
                        <tr>
                            <th colspan="10">Percent</th>
                         
                        </tr>
                        <tr>
                            <th>1st</th>
                            <th>2nd</th>
                            <th>3rd</th>
                            <th>4th</th>
                            <th>5th</th>
                            <th>6th</th>
                            <th>7th</th>
                            <th>8th</th>
                            <th>9th</th>
                            <th>10th</th>
                        </tr>
                        </thead>
                    <tbody>
                    @if(!empty($rncCalculation) && !old('sales_1stper'))
                                <tr>
                                    <td><input type="text" name="sales_1stper[]" readonly class="form-control form-control text-center form-control-sm sales" value='{{ $rncCalculation->BdFeasRncCalSale->row_1st ?? 0}}'></td>
                                    <td><input type="text" name="sales_2ndper[]" readonly class="form-control form-control text-center form-control-sm sales" value='{{ $rncCalculation->BdFeasRncCalSale->row_2nd ?? 0}}'></td>
                                    <td><input type="text" name="sales_3rdper[]" readonly class="form-control form-control text-center form-control-sm sales" value='{{ $rncCalculation->BdFeasRncCalSale->row_3rd ?? 0}}'></td>
                                    <td><input type="text" name="sales_4thper[]" readonly class="form-control form-control text-center form-control-sm sales" value='{{ $rncCalculation->BdFeasRncCalSale->row_4th ?? 0}}'></td>
                                    <td><input type="text" name="sales_5thper[]" readonly class="form-control form-control text-center form-control-sm sales" value='{{ $rncCalculation->BdFeasRncCalSale->row_5th ?? 0}}'></td>
                                    <td><input type="text" name="sales_6thper[]" readonly class="form-control form-control text-center form-control-sm sales" value='{{ $rncCalculation->BdFeasRncCalSale->row_6th ?? 0}}'></td>
                                    <td><input type="text" name="sales_7thper[]" readonly class="form-control form-control text-center form-control-sm sales" value='{{ $rncCalculation->BdFeasRncCalSale->row_7th ?? 0}}'></td>
                                    <td><input type="text" name="sales_8thper[]" readonly class="form-control form-control text-center form-control-sm sales" value='{{ $rncCalculation->BdFeasRncCalSale->row_8th ?? 0}}'></td>
                                    <td><input type="text" name="sales_9thper[]" readonly class="form-control form-control text-center form-control-sm sales" value='{{ $rncCalculation->BdFeasRncCalSale->row_9th ?? 0}}'></td>
                                    <td><input type="text" name="sales_10thper[]" readonly class="form-control form-control text-center form-control-sm sales" value='{{ $rncCalculation->BdFeasRncCalSale->row_10th ?? 0}}'></td>
                                </tr>
                        @endif


                        @if(old('sales_1stper'))
                            @foreach (old('sales_1stper') as $key => $value )
                                <tr>
                                    <td><input type="text" name="sales_1stper[]" readonly class="form-control form-control text-center form-control-sm sales" value="{{ old('sales_1stper')[$key] }}"></td>
                                    <td><input type="text" name="sales_2ndper[]" readonly class="form-control form-control text-center form-control-sm sales" value="{{ old('sales_2ndper')[$key] }}"></td>
                                    <td><input type="text" name="sales_3rdper[]" readonly class="form-control form-control text-center form-control-sm sales" value="{{ old('sales_3rdper')[$key] }}"></td>
                                    <td><input type="text" name="sales_4thper[]" readonly class="form-control form-control text-center form-control-sm sales" value="{{ old('sales_4thper')[$key] }}"></td>
                                    <td><input type="text" name="sales_5thper[]" readonly class="form-control form-control text-center form-control-sm sales" value="{{ old('sales_5thper')[$key] }}"></td>
                                    <td><input type="text" name="sales_6thper[]" readonly class="form-control form-control text-center form-control-sm sales" value="{{ old('sales_6thper')[$key] }}"></td>
                                    <td><input type="text" name="sales_7thper[]" readonly class="form-control form-control text-center form-control-sm sales" value="{{ old('sales_7thper')[$key] }}"></td>
                                    <td><input type="text" name="sales_8thper[]" readonly class="form-control form-control text-center form-control-sm sales" value="{{ old('sales_8thper')[$key] }}"></td>
                                    <td><input type="text" name="sales_9thper[]" readonly class="form-control form-control text-center form-control-sm sales" value="{{ old('sales_9thper')[$key] }}"></td>
                                    <td><input type="text" name="sales_10thper[]" readonly class="form-control form-control text-center form-control-sm sales" value="{{ old('sales_10thper')[$key] }}"></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span>Collection<span>&#10070;</span> </h5>
                </div>
                <table class="table table-striped table-bordered table-sm text-center" id="cTable">
                    <tbody>
                        @if (($formType == 'edit') && !old('sales_1stper') && !old('cons_1stper') && !old('rate_1stper'))
                            @php
                                $yr = ceil($rncCalculation->project_year);
                                $devide_val = $yr + 1;
                                $array_data = [$rncCalculation->BdFeasRncCalSale->row_1st,$rncCalculation->BdFeasRncCalSale->row_2nd,$rncCalculation->BdFeasRncCalSale->row_3rd,$rncCalculation->BdFeasRncCalSale->row_4th,$rncCalculation->BdFeasRncCalSale->row_5th,$rncCalculation->BdFeasRncCalSale->row_6th,$rncCalculation->BdFeasRncCalSale->row_7th,$rncCalculation->BdFeasRncCalSale->row_8th,$rncCalculation->BdFeasRncCalSale->row_9th,$rncCalculation->BdFeasRncCalSale->row_10th];
                            @endphp
                            @foreach ($array_data as $key => $value)
                                <tr>
                                @for ($x = 0; $x < 10; $x++)
                                        @if ($value==0)
                                            <td>0</td>
                                        @else
                                            @if ($key <= $x && $x <= $yr)
                                            @php
                                                $rate = number_format(($value / $devide_val),2);
                                            @endphp
                                            <td>{{ $rate }}</td>
                                            @else
                                            <td>0</td>
                                            @endif    
                                        @endif
                                        
                                @endfor
                            @php
                                $devide_val--; 
                            @endphp
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                    @php
                        $rate_1 = old('rate_1stper') ? old('rate_1stper')[0] : (isset($rncCalculation->BdFeasRncCalRate->row_1st) ? $rncCalculation->BdFeasRncCalRate->row_1st : null);
                        $rate_2 = old('rate_2ndper') ? old('rate_2ndper')[0] : (isset($rncCalculation->BdFeasRncCalRate->row_2nd) ? $rncCalculation->BdFeasRncCalRate->row_2nd : null);
                        $rate_3 = old('rate_3rdper') ? old('rate_3rdper')[0] : (isset($rncCalculation->BdFeasRncCalRate->row_3rd) ? $rncCalculation->BdFeasRncCalRate->row_3rd : null);
                        $rate_4 = old('rate_4thper') ? old('rate_4thper')[0] : (isset($rncCalculation->BdFeasRncCalRate->row_4th) ? $rncCalculation->BdFeasRncCalRate->row_4th : null);
                        $rate_5 = old('rate_5thper') ? old('rate_5thper')[0] : (isset($rncCalculation->BdFeasRncCalRate->row_5th) ? $rncCalculation->BdFeasRncCalRate->row_5th : null);
                        $rate_6 = old('rate_6thper') ? old('rate_6thper')[0] : (isset($rncCalculation->BdFeasRncCalRate->row_6th) ? $rncCalculation->BdFeasRncCalRate->row_6th : null);
                        $rate_7 = old('rate_7thper') ? old('rate_7thper')[0] : (isset($rncCalculation->BdFeasRncCalRate->row_7th) ? $rncCalculation->BdFeasRncCalRate->row_7th : null);
                        $rate_8 = old('rate_8thper') ? old('rate_8thper')[0] : (isset($rncCalculation->BdFeasRncCalRate->row_8th) ? $rncCalculation->BdFeasRncCalRate->row_8th : null);
                        $rate_9 = old('rate_9thper') ? old('rate_9thper')[0] : (isset($rncCalculation->BdFeasRncCalRate->row_9th) ? $rncCalculation->BdFeasRncCalRate->row_9th : null);
                        $rate_10 = old('rate_10thper') ? old('rate_10thper')[0] : (isset($rncCalculation->BdFeasRncCalRate->row_10th) ? $rncCalculation->BdFeasRncCalRate->row_10th : null);
                    @endphp
                    <tfoot>
                        <tr>
                            <td><input type="text" name="rate_1stper[]" class="form-control form-control text-center form-control-sm 1stper row_1_total" value="{{$rate_1}}" readonly></td>
                            <td><input type="text" name="rate_2ndper[]" class="form-control form-control text-center form-control-sm 2ndper row_2_total" value="{{$rate_2}}" readonly></td>
                            <td><input type="text" name="rate_3rdper[]" class="form-control form-control text-center form-control-sm 3rdper row_3_total" value="{{$rate_3}}" readonly></td>
                            <td><input type="text" name="rate_4thper[]" class="form-control form-control text-center form-control-sm 4thper row_4_total" value="{{$rate_4}}" readonly></td>
                            <td><input type="text" name="rate_5thper[]" class="form-control form-control text-center form-control-sm 5thper row_5_total" value="{{$rate_5}}" readonly></td>
                            <td><input type="text" name="rate_6thper[]" class="form-control form-control text-center form-control-sm 6thper row_6_total" value="{{$rate_6}}" readonly></td>
                            <td><input type="text" name="rate_7thper[]" class="form-control form-control text-center form-control-sm 7thper row_7_total" value="{{$rate_7}}" readonly></td>
                            <td><input type="text" name="rate_8thper[]" class="form-control form-control text-center form-control-sm 8thper row_8_total" value="{{$rate_8}}" readonly></td>
                            <td><input type="text" name="rate_9thper[]" class="form-control form-control text-center form-control-sm 9thper row_9_total" value="{{$rate_9}}" readonly></td>
                            <td><input type="text" name="rate_10thper[]" class="form-control form-control text-center form-control-sm 10thper row_10_total" value="{{$rate_10}}" readonly></td>
                        </tr>
                    </tfoot>
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
        const CSRF_TOKEN = "{{ csrf_token() }}";
        @if($formType == 'create' && !(old('sales_year')) && !(old('cons_year')))

            addRow();
            addReferenceRow();

        @endif
        function addRow(){
            let row = `
                <tr>
                    <td><input type="text" name="cons_1stper[]" readonly class="form-control form-control text-center form-control-sm cons"></td>
                    <td><input type="text" name="cons_2ndper[]" readonly class="form-control form-control text-center form-control-sm cons"></td>
                    <td><input type="text" name="cons_3rdper[]" readonly class="form-control form-control text-center form-control-sm cons"></td>
                    <td><input type="text" name="cons_4thper[]" readonly class="form-control form-control text-center form-control-sm cons"></td>
                    <td><input type="text" name="cons_5thper[]" readonly class="form-control form-control text-center form-control-sm cons"></td>
                    <td><input type="text" name="cons_6thper[]" readonly class="form-control form-control text-center form-control-sm cons"></td>
                    <td><input type="text" name="cons_7thper[]" readonly class="form-control form-control text-center form-control-sm cons"></td>
                    <td><input type="text" name="cons_8thper[]" readonly class="form-control form-control text-center form-control-sm cons"></td>
                    <td><input type="text" name="cons_9thper[]" readonly class="form-control form-control text-center form-control-sm cons"></td>
                    <td><input type="text" name="cons_10thper[]" readonly class="form-control form-control text-center form-control-sm cons"></td>
                </tr>
            `;
            $('#itemTable tbody').append(row);
            calculateTotalValue(this);
        }



        function addReferenceRow(){
            let row = `
                <tr>
                    <td><input type="text" name="sales_1stper[]" readonly class="form-control form-control text-center form-control-sm sales"></td>
                    <td><input type="text" name="sales_2ndper[]" readonly class="form-control form-control text-center form-control-sm sales"></td>
                    <td><input type="text" name="sales_3rdper[]" readonly class="form-control form-control text-center form-control-sm sales"></td>
                    <td><input type="text" name="sales_4thper[]" readonly class="form-control form-control text-center form-control-sm sales"></td>
                    <td><input type="text" name="sales_5thper[]" readonly class="form-control form-control text-center form-control-sm sales"></td>
                    <td><input type="text" name="sales_6thper[]" readonly class="form-control form-control text-center form-control-sm sales"></td>
                    <td><input type="text" name="sales_7thper[]" readonly class="form-control form-control text-center form-control-sm sales"></td>
                    <td><input type="text" name="sales_8thper[]" readonly class="form-control form-control text-center form-control-sm sales"></td>
                    <td><input type="text" name="sales_9thper[]" readonly class="form-control form-control text-center form-control-sm sales"></td>
                    <td><input type="text" name="sales_10thper[]" readonly class="form-control form-control text-center form-control-sm sales"></td>
                </tr>
            `;
            $('#referenceTable tbody').append(row);
        }



            $(document).on('change keyup', ".1stper,.2ndper,.3rdper,.4thper,.5thper,.6thper,.7thper,.8thper,.9thper,.10thper", function(){
                let first = Number($(this).closest('tr').find('.1stper').val());
                let second = Number($(this).closest('tr').find('.2ndper').val());
                let third = Number($(this).closest('tr').find('.3rdper').val());
                let fourth = Number($(this).closest('tr').find('.4thper').val());
                let fifth = Number($(this).closest('tr').find('.5thper').val());
                let sixth = Number($(this).closest('tr').find('.6thper').val());
                let seventh = Number($(this).closest('tr').find('.7thper').val());
                let eighth = Number($(this).closest('tr').find('.8thper').val());
                let nighth = Number($(this).closest('tr').find('.9thper').val());
                let tenth = Number($(this).closest('tr').find('.10thper').val());
                $(this).closest('tr').find('.total').val( first + second + third + fourth + fifth + sixth + seventh + eighth + nighth + tenth );
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
            $(function() {
            $('#year').on('change',function(){

                let location = $('#location_id').val();
                if(!location){
                    alert('Please select location first');
                    return false;
                }
                let year = $(this).val();
                     $.ajax({
                         url: "{{ route('percentForYearAndLocation') }}",
                         type: 'get',
                         dataType: "json",
                         data: {
                             _token: CSRF_TOKEN,
                             year,location
                         },
                         success: function(data) {
                             if(data.construction.length > 0) {
                                let row = `
                                            <tr>
                                                <td><input type="text" readonly value="${data.construction[0].cent_1st}" name="cons_1stper[]" class="form-control form-control text-center form-control-sm cons"></td>
                                                <td><input type="text" readonly value="${data.construction[0].cent_2nd}" name="cons_2ndper[]" class="form-control form-control text-center form-control-sm cons"></td>
                                                <td><input type="text" readonly value="${data.construction[0].cent_3rd}" name="cons_3rdper[]" class="form-control form-control text-center form-control-sm cons"></td>
                                                <td><input type="text" readonly value="${data.construction[0].cent_4th}" name="cons_4thper[]" class="form-control form-control text-center form-control-sm cons"></td>
                                                <td><input type="text" readonly value="${data.construction[0].cent_5th}" name="cons_5thper[]" class="form-control form-control text-center form-control-sm cons"></td>
                                                <td><input type="text" readonly value="${data.construction[0].cent_6th}" name="cons_6thper[]" class="form-control form-control text-center form-control-sm cons"></td>
                                                <td><input type="text" readonly value="${data.construction[0].cent_7th}" name="cons_7thper[]" class="form-control form-control text-center form-control-sm cons"></td>
                                                <td><input type="text" readonly value="${data.construction[0].cent_8th}" name="cons_8thper[]" class="form-control form-control text-center form-control-sm cons"></td>
                                                <td><input type="text" readonly value="${data.construction[0].cent_9th}" name="cons_9thper[]" class="form-control form-control text-center form-control-sm cons"></td>
                                                <td><input type="text" readonly value="${data.construction[0].cent_10th}" name="cons_10thper[]" class="form-control form-control text-center form-control-sm cons"></td>
                                                
                                            </tr>
                                        `;
                                $('#itemTable tbody').empty();
                                $('#itemTable tbody').append(row);
                             }

                             if(data.sale.length > 0) {
                                let row2 = `
                                            <tr>
                                                <td><input type="text" readonly value="${data.sale[0].cent_1st}" name="sales_1stper[]" class="form-control form-control text-center form-control-sm sales"></td>
                                                <td><input type="text" readonly value="${data.sale[0].cent_2nd}" name="sales_2ndper[]" class="form-control form-control text-center form-control-sm sales"></td>
                                                <td><input type="text" readonly value="${data.sale[0].cent_3rd}" name="sales_3rdper[]" class="form-control form-control text-center form-control-sm sales"></td>
                                                <td><input type="text" readonly value="${data.sale[0].cent_4th}" name="sales_4thper[]" class="form-control form-control text-center form-control-sm sales"></td>
                                                <td><input type="text" readonly value="${data.sale[0].cent_5th}" name="sales_5thper[]" class="form-control form-control text-center form-control-sm sales"></td>
                                                <td><input type="text" readonly value="${data.sale[0].cent_6th}" name="sales_6thper[]" class="form-control form-control text-center form-control-sm sales"></td>
                                                <td><input type="text" readonly value="${data.sale[0].cent_7th}" name="sales_7thper[]" class="form-control form-control text-center form-control-sm sales"></td>
                                                <td><input type="text" readonly value="${data.sale[0].cent_8th}" name="sales_8thper[]" class="form-control form-control text-center form-control-sm sales"></td>
                                                <td><input type="text" readonly value="${data.sale[0].cent_9th}" name="sales_9thper[]" class="form-control form-control text-center form-control-sm sales"></td>
                                                <td><input type="text" readonly value="${data.sale[0].cent_10th}" name="sales_10thper[]" class="form-control form-control text-center form-control-sm sales"></td>
                                             
                                            </tr>
                                        `;
                                $('#referenceTable tbody').empty();
                                $('#referenceTable tbody').append(row2);
                             }
                            var year_r = Number(Math.ceil(year))
                            var loop_year = year_r + 1; 
                            var data ='';

                             $('.sales')
                             .map(function(inex,currentValue,arr){
                                        data += `<tr>`;
                                        var rate = (Number(currentValue.value) / (Number(loop_year))).toFixed(2);
                                        for (let i = 0; i < 10; i++) {
                                            var className = "row_" + (i+1).toString();
                                            if(inex <= i && i <= year_r){
                                                data += `<td class="${className}">${rate}</td>`;
                                            }else{
                                                data += `<td class="${className}">0</td>`;
                                            }

                                        }
                                        data += `</tr>`;
                                        loop_year--;
                                   })
                                $('#cTable tbody').empty();
                                $('#cTable tbody').append(data);
                            var ClassArray = ['row_1','row_2','row_3','row_4','row_5','row_6','row_7','row_8','row_9','row_10'];
                            ClassArray.map(function(value, index, array){
                                    var n = "."+value;
                                    var total_class = "."+value + "_total"
                                    var total = 0;
                                    $(n).each(function(i, row){
                                      total += Number($(row).html());
                                    })
                                    $(total_class).val(total.toFixed(2));
                            });
                         }
                 });
            })
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


