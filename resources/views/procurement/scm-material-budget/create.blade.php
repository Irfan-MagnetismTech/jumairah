@extends('layouts.backend-layout')
@section('title', 'Material Budget')

@section('breadcrumb-title')
         Material Budget Rate for {{ DateTime::createFromFormat('!m', $materialPlan->month)->format('F') . ', ' . $materialPlan->year }}
@endsection

@section('breadcrumb-button')
    <a href="{{ url('scm-material-budget-pdf')}}/{{$year}}/{{$month}}/{{$project_id}}/{{$material_plan_id}}" title="PDF" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null) 

@section('content')
    @if($formType == 'edit')
        {!! Form::open(array('url' => "ScmMaterialBudgets/$materialPlan->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => 'ScmMaterialBudgets','method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
    
        <div class="row">
            <div class="col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Project Name<span class="text-danger">*</span></label>
                    {{ Form::text('project_name', $materialPlan->projects->name, ['class' => 'form-control project_name', 'id' => 'project_name', 'required', 'readonly']) }}
                    {{ Form::hidden('project_id', $materialPlan->project_id, ['class' => 'form-control project_id', 'id' => 'project_id', 'required', 'readonly']) }}
                    {{ Form::hidden('year', $materialPlan->year, ['class' => 'form-control year', 'id' => 'year', 'required', 'readonly']) }}
                    {{ Form::hidden('month', $materialPlan->month, ['class' => 'form-control month', 'id' => 'month', 'required', 'readonly']) }}
                    {{ Form::hidden('material_plan_id', $materialPlan->id, ['class' => 'form-control material_plan_id', 'id' => 'material_plan_id', 'required', 'readonly']) }}
                </div>
            </div>
        </div>

    <hr class="bg-success">
<div class="row">
<div class="col-sm-12 col-md-12 col-xl-12">
    <div class="tableHeading">
        <h5> <span>&#10070;</span> Details <span>&#10070;</span> </h5>
    </div>
    <div class="table-responsive">
        <table id="Table" class="table text-center table-striped table-sm table-bordered">
            <thead>
                <tr>
                    <th rowspan="2" width="400">Material Name</th>
                    <th rowspan="2">Unit</th>
                    <th colspan="3">Week-1</th>
                    <th colspan="3">Week-2</th>
                    <th colspan="3">Week-3</th>
                    <th colspan="3">Week-4</th>
                    <th rowspan="2">Remarks</th>
                    <th rowspan="2">Grand Total<br>Amount(BDT.)</th>
                </tr> 
                <tr>
                    <th >Quantity</th>
                    <th width="150">Rate</th>
                    <th >Value (BDT.)</th>
                    <th >Quantity</th>
                    <th width="150">Rate</th>
                    <th >Value (BDT.)</th>
                    <th >Quantity</th>
                    <th width="150">Rate</th>
                    <th >Value (BDT.)</th>
                    <th >Quantity</th>
                    <th width="150">Rate</th>
                    <th >Value (BDT.)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($materialPlan->materialPlanDetails as $data)
                    <input type="hidden" name="id[]" value="{{ $data->id }}" id="material_name" class="text-center form-control form-control-sm id" autocomplete="off" readonly required>
                    <tr >
                        <td>
                            <input type="text" name="material_name[]" value="{{ $data->nestedMaterials->name }}" id="material_name" class="text-center form-control form-control-sm material_name" autocomplete="off" readonly required>
                            <input type="hidden" name="material_id[]" value="{{ $data->nestedMaterials->id }}" class="text-center material_id" id="material_id">
                        </td>
                        <td>
                            <input type="text" name="unit[]" value="{{ $data->nestedMaterials->unit->name }}" class="text-center form-control form-control-sm unit" autocomplete="off" readonly>
                            <input type="hidden" name="unit_id[]" value="{{ $data->nestedMaterials->unit->id }}" class="text-center form-control form-control-sm unit_id">
                        </td>
                        <td><input type="number" name="week_one[]" value="{{ $data->week_one }}" class="text-center form-control form-control-sm qty" autocomplete="off" readonly></td>
                        <td><input type="number" name="week_one_rate[]" value="{{ $data->week_one_rate ?? 0 }}" class="text-center form-control form-control-sm rate" autocomplete="off"></td>
                        <td><input type="number" name="week_one_value[]" value="" class="text-center form-control form-control-sm value week1" autocomplete="off" readonly></td>
                        <td><input type="number" name="week_two[]" value="{{ $data->week_two }}" class="text-center form-control form-control-sm qty" autocomplete="off" readonly></td>
                        <td><input type="number" name="week_two_rate[]" value="{{ $data->week_two_rate ?? 0 }}" class="text-center form-control form-control-sm rate" autocomplete="off"></td>
                        <td><input type="number" name="week_two_value[]" value="" class="text-center form-control form-control-sm value week2" autocomplete="off" readonly></td>
                        <td><input type="number" name="week_three[]" value="{{ $data->week_three }}" class="text-center form-control form-control-sm qty" autocomplete="off" readonly></td>
                        <td><input type="number" name="week_three_rate[]" value="{{ $data->week_three_rate ?? 0 }}" class="text-center form-control form-control-sm rate" autocomplete="off"></td>
                        <td><input type="number" name="week_three_value[]" value="" class="text-center form-control form-control-sm value week3" autocomplete="off" readonly></td>
                        <td><input type="number" name="week_four[]" value="{{ $data->week_four }}" class="text-center form-control form-control-sm qty" autocomplete="off" readonly></td>
                        <td><input type="number" name="week_four_rate[]" value="{{ $data->week_four_rate ?? 0 }}" class="text-center form-control form-control-sm rate" autocomplete="off"></td>
                        <td><input type="number" name="week_four_value[]" value="" class="text-center form-control form-control-sm value week4" autocomplete="off" readonly></td>
                        <td><input type="text" name="remarks[]" value="{{ $data->remarks }}" class="text-center form-control form-control-sm remarks" autocomplete="off" readonly></td>
                        <td class="align-middle"><p class="total_quantity"></p></td>
                    </tr>
                @endforeach
                <tr >
                    <td class="align-middle">
                        <p>Total</p>
                    </td>
                    <td>
                    </td>
                    <td></td>
                    <td></td>
                    <td class="align-middle"><p class="total_week1"></p></td>
                    <td></td>
                    <td></td>
                    <td class="align-middle"><p class="total_week2"></p></td>
                    <td></td>
                    <td></td>
                    <td class="align-middle"><p class="total_week3"></p></td>
                    <td></td>
                    <td></td>
                    <td class="align-middle"><p class="total_week4"></p></td>
                    <td></td>
                    <td class="align-middle"><p class="grand"></p></td>
                
                </tr>
            </tbody>
        </table>
    </div>
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

   <script type="text/javascript">
   $(document).ready(function() {
        var a = 0;
        $('.value').each(function() {
            let qty = $(this).parent('td').prev().find('.rate').val();
            let rate = $(this).parent('td').prev().prev().find('.qty').val();
            $(this).val(qty * rate);
        });
        $('.rate').on('change keyup', function() {   
            let qty = $(this).parent('td').prev().find('.qty').val();
            let rate = $(this).val();
            $(this).parent('td').next().find('.value').val(qty*rate);
            Get_total();
        })
        function Get_total(){
            let week1 = 0;
            let week2 = 0;
            let week3 = 0;
            let week4 = 0;
            $('.week1').each(function() {
                week1 += Number($(this).val());
            });
            $('.week2').each(function() {
                week2 += Number($(this).val());
            });
            $('.week3').each(function() {
                week3 += Number($(this).val());
            });
            $('.week4').each(function() {
                week4 += Number($(this).val());
            });
            $('.total_week1').text(week1);
            $('.total_week2').text(week2);
            $('.total_week3').text(week3);
            $('.total_week4').text(week4);
            $('.grand').text(week1 + week2 + week3 + week4);
            $('.total_quantity').each(function() {
                let row_week1= Number($(this).closest('tr').find('.week1').val());
                let row_week2= Number($(this).closest('tr').find('.week2').val());
                let row_week3= Number($(this).closest('tr').find('.week3').val());
                let row_week4= Number($(this).closest('tr').find('.week4').val());
                $(this).text(row_week1 + row_week2 + row_week3 + row_week4);
            });
        }
        Get_total();
    })
   </script>
@endsection
