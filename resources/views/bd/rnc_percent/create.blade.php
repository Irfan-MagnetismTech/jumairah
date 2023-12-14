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
    <a href="{{ url('rnc_percent') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => "rnc_percent/$rncPercent->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "rnc_percent",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif

        <div class="row">
            <div class="col-md-6 col-xl-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="location_id">Location<span class="text-danger">*</span></label>
                    {{Form::select('location_id', $locations, old('location_id') ? old('location_id') : (!empty($rncPercent->bd_lead_generation_id) ? $rncPercent->bd_lead_generation_id : null),['class' => 'form-control','id' => 'location_id', 'placeholder'=>"Select Location", 'autocomplete'=>"off"])}}
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
                        <th rowspan="2">Construction Duration (Year)</th>
                        <th colspan="10">Percent</th>
                        <th rowspan="2">
                            Total
                        </th>
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
                        @if(!empty($rncPercent))
                       
                           @foreach ($rncPercent->BdFeasCPercents as $key => $value )
                            @php
                                $total = $value->cent_1st + $value->cent_2nd + $value->cent_3rd + $value->cent_4th + $value->cent_5th + $value->cent_6th + $value->cent_7th + $value->cent_8th + $value->cent_9th + $value->cent_10th;
                            @endphp
                           <tr>
                                <td><input type="text" readonly name="cons_year[]" class="form-control form-control text-center form-control-sm cons_year" value='{{ $value->project_year }}'></td>
                                <td><input type="text" name="cons_1stper[]" class="form-control form-control text-center form-control-sm 1stper" value='{{ $value->cent_1st }}'></td>
                                <td><input type="text" name="cons_2ndper[]" class="form-control form-control text-center form-control-sm 2ndper" value='{{ $value->cent_2nd }}'></td>
                                <td><input type="text" name="cons_3rdper[]" class="form-control form-control text-center form-control-sm 3rdper" value='{{ $value->cent_3rd }}'></td>
                                <td><input type="text" name="cons_4thper[]" class="form-control form-control text-center form-control-sm 4thper" value='{{ $value->cent_4th }}'></td>
                                <td><input type="text" name="cons_5thper[]" class="form-control form-control text-center form-control-sm 5thper" value='{{ $value->cent_5th }}'></td>
                                <td><input type="text" name="cons_6thper[]" class="form-control form-control text-center form-control-sm 6thper" value='{{ $value->cent_6th }}'></td>
                                <td><input type="text" name="cons_7thper[]" class="form-control form-control text-center form-control-sm 7thper" value='{{ $value->cent_7th }}'></td>
                                <td><input type="text" name="cons_8thper[]" class="form-control form-control text-center form-control-sm 8thper" value='{{ $value->cent_8th }}'></td>
                                <td><input type="text" name="cons_9thper[]" class="form-control form-control text-center form-control-sm 9thper" value='{{ $value->cent_9th }}'></td>
                                <td><input type="text" name="cons_10thper[]" class="form-control form-control text-center form-control-sm 10thper" value='{{ $value->cent_10th }}'></td>
                                <td><input type="text" readonly max=100 min=100 name="cons_total[]" class="form-control form-control text-center form-control-sm total" value='{{ $total }}'></td>
                            </tr>
                           @endforeach
                        @endif

                        @if(old('cons_year'))
                        @foreach (old('cons_year') as $key => $value )
                        
                        <tr>
                            <td><input type="text" readonly name="cons_year[]" class="form-control form-control text-center form-control-sm cons_year" value='{{ old('cons_year')[$key] }}'></td>
                            <td><input type="text" name="cons_1stper[]" class="form-control form-control text-center form-control-sm 1stper" value='{{ old('cons_1stper')[$key] }}'></td>
                            <td><input type="text" name="cons_2ndper[]" class="form-control form-control text-center form-control-sm 2ndper" value='{{ old('cons_2ndper')[$key] }}'></td>
                            <td><input type="text" name="cons_3rdper[]" class="form-control form-control text-center form-control-sm 3rdper" value='{{ old('cons_3rdper')[$key] }}'></td>
                            <td><input type="text" name="cons_4thper[]" class="form-control form-control text-center form-control-sm 4thper" value='{{ old('cons_4thper')[$key] }}'></td>
                            <td><input type="text" name="cons_5thper[]" class="form-control form-control text-center form-control-sm 5thper" value='{{ old('cons_5thper')[$key] }}'></td>
                            <td><input type="text" name="cons_6thper[]" class="form-control form-control text-center form-control-sm 6thper" value='{{ old('cons_6thper')[$key] }}'></td>
                            <td><input type="text" name="cons_7thper[]" class="form-control form-control text-center form-control-sm 7thper" value='{{ old('cons_7thper')[$key] }}'></td>
                            <td><input type="text" name="cons_8thper[]" class="form-control form-control text-center form-control-sm 8thper" value='{{ old('cons_8thper')[$key] }}'></td>
                            <td><input type="text" name="cons_9thper[]" class="form-control form-control text-center form-control-sm 9thper" value='{{ old('cons_9thper')[$key] }}'></td>
                            <td><input type="text" name="cons_10thper[]" class="form-control form-control text-center form-control-sm 10thper" value='{{ old('cons_10thper')[$key] }}'></td>
                            <td><input type="text" readonly max=100 min=100 name="cons_total[]" class="form-control form-control text-center form-control-sm total" value='{{ old('cons_total')[$key] }}'></td>
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
                            <th rowspan="2">Sales Duration (Year)</th>
                            <th colspan="10">Percent</th>
                            <th rowspan="2">
                                Total
                            </th>
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
                        @if(!empty($rncPercent))
                        @foreach ($rncPercent->BdFeasRPercents as $key => $value )
                        @php
                            $total = $value->cent_1st + $value->cent_2nd + $value->cent_3rd + $value->cent_4th + $value->cent_5th + $value->cent_6th + $value->cent_7th + $value->cent_8th + $value->cent_9th + $value->cent_10th;
                        @endphp
                        <tr>
                            <td><input type="text" readonly name="sales_year[]" class="form-control form-control text-center form-control-sm sales_year" value='{{ $value->project_year }}'></td>
                            <td><input type="text" name="sales_1stper[]" class="form-control form-control text-center form-contro 1stper" value='{{ $value->cent_1st }}'></td>
                            <td><input type="text" name="sales_2ndper[]" class="form-control form-control text-center form-contro 2ndper" value='{{ $value->cent_2nd }}'></td>
                            <td><input type="text" name="sales_3rdper[]" class="form-control form-control text-center form-contro 3rdper" value='{{ $value->cent_3rd }}'></td>
                            <td><input type="text" name="sales_4thper[]" class="form-control form-control text-center form-contro 4thper" value='{{ $value->cent_4th }}'></td>
                            <td><input type="text" name="sales_5thper[]" class="form-control form-control text-center form-contro 5thper" value='{{ $value->cent_5th }}'></td>
                            <td><input type="text" name="sales_6thper[]" class="form-control form-control text-center form-contro 6thper" value='{{ $value->cent_6th }}'></td>
                            <td><input type="text" name="sales_7thper[]" class="form-control form-control text-center form-contro 7thper" value='{{ $value->cent_7th }}'></td>
                            <td><input type="text" name="sales_8thper[]" class="form-control form-control text-center form-contro 8thper" value='{{ $value->cent_8th }}'></td>
                            <td><input type="text" name="sales_9thper[]" class="form-control form-control text-center form-contro 9thper" value='{{ $value->cent_9th }}'></td>
                            <td><input type="text" name="sales_10thper[]" class="form-control form-control text-center form-contro 10thper" value='{{ $value->cent_10th }}'></td>
                            <td><input type="text" readonly max=100 min=100 name="sales_total[]" class="form-control form-control text-center form-control-sm total" value='{{ $total }}'></td>
                        </tr>
                        @endforeach
                        @endif

                        @if(old('sales_year'))
                        @foreach (old('sales_year') as $key => $value )
                        
                        <tr>
                            <td><input type="text" readonly name="sales_year[]" class="form-control form-control text-center form-control-sm sales_year" value='{{ old('sales_year')[$key] }}'></td>
                            <td><input type="text" name="sales_1stper[]" class="form-control form-control text-center form-control-sm 1stper" value='{{ old('sales_1stper')[$key] }}'></td>
                            <td><input type="text" name="sales_2ndper[]" class="form-control form-control text-center form-control-sm 2ndper" value='{{ old('sales_2ndper')[$key] }}'></td>
                            <td><input type="text" name="sales_3rdper[]" class="form-control form-control text-center form-control-sm 3rdper" value='{{ old('sales_3rdper')[$key] }}'></td>
                            <td><input type="text" name="sales_4thper[]" class="form-control form-control text-center form-control-sm 4thper" value='{{ old('sales_4thper')[$key] }}'></td>
                            <td><input type="text" name="sales_5thper[]" class="form-control form-control text-center form-control-sm 5thper" value='{{ old('sales_5thper')[$key] }}'></td>
                            <td><input type="text" name="sales_6thper[]" class="form-control form-control text-center form-control-sm 6thper" value='{{ old('sales_6thper')[$key] }}'></td>
                            <td><input type="text" name="sales_7thper[]" class="form-control form-control text-center form-control-sm 7thper" value='{{ old('sales_7thper')[$key] }}'></td>
                            <td><input type="text" name="sales_8thper[]" class="form-control form-control text-center form-control-sm 8thper" value='{{ old('sales_8thper')[$key] }}'></td>
                            <td><input type="text" name="sales_9thper[]" class="form-control form-control text-center form-control-sm 9thper" value='{{ old('sales_9thper')[$key] }}'></td>
                            <td><input type="text" name="sales_10thper[]" class="form-control form-control text-center form-control-sm 10thper" value='{{ old('sales_10thper')[$key] }}'></td>
                            <td><input type="text" readonly max=100 min=100 name="sales_total[]" class="form-control form-control text-center form-control-sm total" value='{{ old('sales_total')[$key] }}'></td>
                        </tr>
                        @endforeach
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
        let yr = [2,2.5,3,3.5,4,4.5,5,5.5,6,6.5,7,7.5,8];
        @if($formType == 'create' && !(old('sales_year')) && !(old('cons_year')))
        yr.forEach((item, index)=>{
            addRow(item);
            addReferenceRow(item);
        })
        @endif
        function addRow(item = null){
            let row = `
                <tr>
                    <td><input type="text" readonly name="cons_year[]" class="form-control form-control text-center form-control-sm cons_year" value=${item}></td>
                    <td><input type="text" name="cons_1stper[]" class="form-control form-control text-center form-control-sm 1stper"></td>
                    <td><input type="text" name="cons_2ndper[]" class="form-control form-control text-center form-control-sm 2ndper"></td>
                    <td><input type="text" name="cons_3rdper[]" class="form-control form-control text-center form-control-sm 3rdper"></td>
                    <td><input type="text" name="cons_4thper[]" class="form-control form-control text-center form-control-sm 4thper"></td>
                    <td><input type="text" name="cons_5thper[]" class="form-control form-control text-center form-control-sm 5thper"></td>
                    <td><input type="text" name="cons_6thper[]" class="form-control form-control text-center form-control-sm 6thper"></td>
                    <td><input type="text" name="cons_7thper[]" class="form-control form-control text-center form-control-sm 7thper"></td>
                    <td><input type="text" name="cons_8thper[]" class="form-control form-control text-center form-control-sm 8thper"></td>
                    <td><input type="text" name="cons_9thper[]" class="form-control form-control text-center form-control-sm 9thper"></td>
                    <td><input type="text" name="cons_10thper[]" class="form-control form-control text-center form-control-sm 10thper"></td>
                    <td><input type="text" readonly max=100 min=100 name="cons_total[]" class="form-control form-control text-center form-control-sm total"></td>
                </tr>
            `;
            $('#itemTable tbody').append(row);
            calculateTotalValue(this);
        }

        

        function addReferenceRow(item = null){
            let row = `
                <tr>
                    <td><input type="text" readonly name="sales_year[]" class="form-control form-control text-center form-control-sm cons_year" value=${item}></td>
                    <td><input type="text" name="sales_1stper[]" class="form-control form-control text-center form-control-sm 1stper"></td>
                    <td><input type="text" name="sales_2ndper[]" class="form-control form-control text-center form-control-sm 2ndper"></td>
                    <td><input type="text" name="sales_3rdper[]" class="form-control form-control text-center form-control-sm 3rdper"></td>
                    <td><input type="text" name="sales_4thper[]" class="form-control form-control text-center form-control-sm 4thper"></td>
                    <td><input type="text" name="sales_5thper[]" class="form-control form-control text-center form-control-sm 5thper"></td>
                    <td><input type="text" name="sales_6thper[]" class="form-control form-control text-center form-control-sm 6thper"></td>
                    <td><input type="text" name="sales_7thper[]" class="form-control form-control text-center form-control-sm 7thper"></td>
                    <td><input type="text" name="sales_8thper[]" class="form-control form-control text-center form-control-sm 8thper"></td>
                    <td><input type="text" name="sales_9thper[]" class="form-control form-control text-center form-control-sm 9thper"></td>
                    <td><input type="text" name="sales_10thper[]" class="form-control form-control text-center form-control-sm 10thper"></td>
                    <td><input type="text" readonly max=100 min=100 name="sales_total[]" class="form-control form-control text-center form-control-sm total"></td>
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
            document.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                }
            });
            
        }) // Document.Ready
    </script>
    
@endsection


