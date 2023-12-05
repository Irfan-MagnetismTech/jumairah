@extends('layouts.backend-layout')
@section('title', 'Work Plan')

@section('breadcrumb-title')
        Make Work Plan
@endsection

@section('breadcrumb-button')
    {{-- <a href="{{ url(route("construction/work_plan/show")) }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a> --}}
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null) 

@section('content')
    @if($formType == 'edit')
        {!! Form::open(array('url' => "construction/work_plan/$workPlan->id",'method' => 'PUT', 'class'=>'custom-form','id' => 'tagForm')) !!}
    @else
        {!! Form::open(array('url' => 'construction/work_plan','method' => 'POST', 'class'=>'custom-form','id' => 'tagForm')) !!}
    @endif
    @if ($formType == 'edit' && $workPlan->is_saved == 0)
        <input type="hidden" name="draft_id" value="{{ $workPlan->id }}" id="draft_id" />
    @endif
        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Project Name<span class="text-danger">*</span></label>
                    {{Form::select('project_id', $projects, old('project_id') ? old('project_id') : (!empty($workPlan->project_id) ? $workPlan->project_id : null),['class' => 'form-control','id' => 'project_id', 'placeholder'=>"Select Project Name", 'autocomplete'=>"off",'required'])}}
                </div>
            </div>
        </div><!-- end row -->

    <hr class="bg-success">
{{-- <div class="row">
<div class="col-md-12">
    <div class="tableHeading">
        <h5> <span>&#10070;</span> Details <span>&#10070;</span> </h5>
    </div> --}}
    <div class="table-responsive">
        <table id="Table" class="table table-striped text-center table-bordered" >
            <thead>
                <tr>
                    <th width="250">Scope<br> Work Name<span class="text-danger">*</span></th>
                    <th >Sub Work<br>(if required)</th>
                    <th width="300"> Description<br>of work<span class="text-danger">*</span></th>
                    <th> Target<span class="text-danger">*</span></th>
                    <th> Target<br> accomplishment<br> status</th>
                    <th> Required Materials<br>(if required)</th>
                    <th> Architect Dept.<br> Engineer Name<br>(if required)</th>
                    <th> Supply Chain Dept.<br> Engineer Name<br>(if required)</th>
                    <th> Start Date<span class="text-danger">*</span> </th>
                    <th> Finish Date<span class="text-danger">*</span> </th>
                    <th> Delay<br> Reason</th>
                    <th><i class="btn btn-primary btn-sm fa fa-plus" id="addItem" onclick="addItemDtl()"> </i></th>
                </tr>
            </thead>
            <tbody>
                @if(old('work_id'))
                        @foreach(old('work_id') as $key=>$oldMaterialName)
                            <tr>
                                <td>
                                    <input type="text" name="work_name[]" value="{{old('work_name')[$key]}}" id="work_name" class="form-control form-control-sm work_name" autocomplete="off" required>
                                    <input type="hidden" name="work_id[]" value="{{old('work_id')[$key]}}" class="work_id" id="work_id">
                                </td>
                                <td><input type="text" name="sub_work[]" value="{{old('sub_work')[$key]}}" class="form-control form-control-sm sub_work" tabindex="-1" autocomplete="off"></td>
                                <td><input type="text" name="description[]" value="{{old('description')[$key]}}" class="form-control form-control-sm description" tabindex="-1" autocomplete="off" required></td>
                                <td><input type="number" name="target[]" value="{{old('target')[$key]}}" class="form-control form-control-sm  text-center target" autocomplete="off" required></td>
                                <td><input type="number" name="target_accomplishment[]" value="{{old('target_accomplishment')[$key]}}" class="form-control form-control-sm  text-center target_accomplishment" autocomplete="off" ></td>
                                <td>
                                    <input type="text" name="material_name[]"  value="{{old('material_name')[$key]}}" class="form-control form-control-sm material_name" id="material_name" autocomplete="off">
                                    <input type="hidden" name="material_id[]" value="{{old('material_id')[$key]}}" class="material_id" id="material_id">
                                </td>
                                <td><input type="text" name="architect_eng_name[]" value="{{old('architect_eng_name')[$key]}}" class="form-control form-control-sm  text-center architect_eng_name" autocomplete="off"></td>
                                <td><input type="text" name="sc_eng_name[]" value="{{old('sc_eng_name')[$key]}}" class="form-control form-control-sm  text-center sc_eng_name" autocomplete="off"></td>
                                <td><input type="text" name="start_date[]" value="{{old('start_date')[$key]}}" class="form-control form-control-sm  text-center start_date" autocomplete="off" required readonly></td>
                                <td><input type="text" name="finish_date[]" value="{{old('finish_date')[$key]}}" class="form-control form-control-sm  text-center finish_date" autocomplete="off" readonly></td>
                                <td><input type="text" name="delay[]" value="{{old('delay')[$key]}}" class="form-control form-control-sm  text-center delay" autocomplete="off"></td>
                                <td class="text-center">
                                    <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                    @if (!empty($workPlan))
                        @foreach ($workPlan->workPlanDetails as $workPlanDetail)
                        <tr>
                            <td>
                                <input type="text" name="work_name[]" value="{{$workPlanDetail->boqWorks->name ?? null}}" id="work_name" class="form-control form-control-sm work_name" autocomplete="off" required>
                                <input type="hidden" name="work_id[]" value="{{$workPlanDetail->boqWorks->id ?? null}}" class="work_id" id="work_id">
                            </td>
                            <td><input type="text" name="sub_work[]" value="{{$workPlanDetail->sub_work ?? null}}" class="form-control form-control-sm sub_work" tabindex="-1" autocomplete="off"></td>
                            <td><input type="text" name="description[]" value="{{$workPlanDetail->description ?? null}}" class="form-control form-control-sm description" tabindex="-1" autocomplete="off" required></td>
                            <td><input type="number" name="target[]" value="{{$workPlanDetail->target ?? null}}" class="form-control form-control-sm  text-center target" autocomplete="off" required></td>
                            <td><input type="number" name="target_accomplishment[]" value="{{$workPlanDetail->target_accomplishment ?? null}}" class="form-control form-control-sm  text-center target_accomplishment" autocomplete="off" ></td>
                            <td>
                                <input type="text" name="material_name[]"  value="{{$workPlanDetail->material_name ?? null}}" class="form-control form-control-sm material_name" id="material_name" autocomplete="off">
                                <input type="hidden" name="material_id[]" value="{{$workPlanDetail->material_id ?? null}}" class="material_id" id="material_id">
                            </td>
                            <td><input type="text" name="architect_eng_name[]" value="{{$workPlanDetail->architect_eng_name ?? null}}" class="form-control form-control-sm  text-center architect_eng_name" autocomplete="off"></td>
                            <td><input type="text" name="sc_eng_name[]" value="{{$workPlanDetail->sc_eng_name ?? null}}" class="form-control form-control-sm  text-center sc_eng_name" autocomplete="off"></td>
                            <td><input type="text" name="start_date[]" value="{{$workPlanDetail->start_date ?? null}}" class="form-control form-control-sm  text-center start_date" autocomplete="off" required readonly></td>
                            <td><input type="text" name="finish_date[]" value="{{$workPlanDetail->finish_date ?? null}}" class="form-control form-control-sm  text-center finish_date" autocomplete="off" readonly></td>
                            <td><input type="text" name="delay[]" value="{{$workPlanDetail->delay ?? null}}" class="form-control form-control-sm  text-center delay" autocomplete="off"></td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                @endif
            </tbody>
        </table>
    </div>
{{-- </div>
</div> --}}
@if (($formType == 'edit' && $workPlan->is_saved == 0) || $formType == 'create')
    <div class="row">
        <div class="mt-2 offset-md-2 col-md-4">
            <div class="input-group input-group-sm ">
                <button class="py-2 btn btn-success btn-round btn-block py-2">Save</button>
            </div>
        </div>
        <div class="mt-2 col-md-4">
            <div class="input-group input-group-sm">
                <button class="py-2 btn btn-success btn-round btn-block py-2" id='draft_button'>Save as draft</button>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="mt-2 offset-md-4 col-md-4">
            <div class="input-group input-group-sm ">
                <button class="py-2 btn btn-success btn-round btn-block py-2">Save</button>
            </div>
        </div>
    </div>
@endif
        
{!! Form::close() !!}



@endsection

@section('script')

    <script>

        function addItemDtl() {
            var Row = `
            <tr>
                <td>
                    <input type="text" name="work_name[]"  class="form-control form-control-sm work_name" id="work_name" autocomplete="off" required>
                    <input type="hidden" name="work_id[]"  class="work_id" id="work_id">
                </td>
                <td><input type="text" name="sub_work[]"  class="form-control form-control-sm sub_work" tabindex="-1" autocomplete="off"></td>
                <td><input type="text" name="description[]"  class="form-control form-control-sm description" tabindex="-1" autocomplete="off" required></td>
                <td><input type="number" name="target[]"  class="form-control form-control-sm  text-center target"  autocomplete="off" required></td>
                <td><input type="number" name="target_accomplishment[]"  class="form-control form-control-sm  text-center target_accomplishment"  autocomplete="off"></td>
                <td>
                    <input type="text" name="material_name[]"  class="form-control form-control-sm material_name" id="material_name" autocomplete="off">
                    <input type="hidden" name="material_id[]"  class="material_id" id="material_id">
                </td>
                <td><input type="text" name="architect_eng_name[]"  class="form-control form-control-sm  text-center architect_eng_name" autocomplete="off"></td>
                <td><input type="text" name="sc_eng_name[]"  class="form-control form-control-sm  text-center sc_eng_name" autocomplete="off"></td>
                <td><input type="text" name="start_date[]"  class="form-control form-control-sm  text-center start_date" autocomplete="off" required readonly></td>
                <td><input type="text" name="finish_date[]"  class="form-control form-control-sm  text-center finish_date" autocomplete="off" readonly></td>
                <td><input type="text" name="delay[]"  class="form-control form-control-sm  text-center delay" autocomplete="off"></td>
                <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" id="" type="button"><i class="fa fa-minus"></i></button></td>
            </tr>
            `;
            var tableItem = $('#Table').append(Row);
        }



        // Function for deleting a row
        function removQRow(qval) {
            var rowIndex = qval.parentNode.parentNode.rowIndex;
            document.getElementById("Table").deleteRow(rowIndex);
        }


        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {

            @if ($formType == 'create' && !old('work_id'))

            addItemDtl();
            @endif
           
            $(document).on('keyup', ".work_name", function(){
                $(this).autocomplete({
                    source: function(request, response) {
                    $.ajax({
                        url: "{{ route('construction.LoadboqWorkHead') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                            console.log(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $(this).closest('tr').find('#work_id').val(ui.item.value);
                    $(this).closest('tr').find('#work_name').val(ui.item.label);
                    return false;
                    }
                });
            });

            $(document).on('keyup', ".material_name", function(){
                $(this).autocomplete({
                    source: function(request, response) {
                    $.ajax({
                        url: "{{ route('construction.LoadmaterialName') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                            console.log(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $(this).closest('tr').find('#material_id').val(ui.item.value);
                    $(this).closest('tr').find('#material_name').val(ui.item.label);
                    return false;
                    }
                });
            });

            $(document).on('mouseenter', '.start_date, .finish_date', function() {
                $(this).datepicker({
                    format: "yyyy-mm-dd",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                });
            });
        });
        @if (($formType == 'edit' && $workPlan->is_saved == 0) || $formType == 'create')
            var CSRF_TOKEN = "{{ csrf_token() }}";
            $(document).ready(function() {
                    $('#draft_button').on('click', function (e) {
                        e.preventDefault();
                        var tagForm = document.getElementById('tagForm');
                        tagForm.action = "{{ route('construction.workPlan.DraftSave') }}";
                        tagForm.method = 'POST';
                        $('input[name=_method]').remove();
                        tagForm.submit();
                    })
            })
        @endif
    </script>
@endsection
