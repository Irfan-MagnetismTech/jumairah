@extends('layouts.backend-layout')
@section('title', 'Memo')

@section('breadcrumb-title')
        Make Memo
@endsection

@section('breadcrumb-button')
    <a href="{{ url(route("memo.index")) }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')


@section('content')
    @if($formType == 'edit')
        {!! Form::open(array('url' => "memo/$memo->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => 'memo','method' => 'POST', 'class'=>'custom-form')) !!}
    @endif

        
        <div class="row">
            <div class="col-xl-6 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="letter_date">Date<span class="text-danger">*</span></label>
                    {{Form::text('letter_date', old('letter_date') ? old('letter_date') : (!empty($memo->letter_date) ? $memo->letter_date : null),['class' => 'form-control letter_date','id' => 'letter_date','autocomplete'=>"off","required",])}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_name">Project Name<span class="text-danger">*</span></label>
                    {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($memo->id) ? $memo->costCenter->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off",'required'])}}
                    {{Form::hidden('cost_center_id', old('cost_center_id') ? old('cost_center_id') : (!empty($memo->id) ? $memo->costCenter->id : null),['class' => 'form-control','id' => 'cost_center_id', 'autocomplete'=>"off",'required'])}}
                </div>
            </div>
        </div><br><br><br>
        <div class="row">
            <div class="col-xl-1 col-md-1"></div>
            <div class="col-xl-6 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <h6>To</h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-2 col-md-2"></div>
            <div class="col-xl-2 col-md-2">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::text('address_word_one', old('address_word_one') ? old('address_word_one') : (!empty($memo->address_word_one) ? $memo->address_word_one : null),['class' => 'form-control address_word_one','id' => 'address_word_one','autocomplete'=>"off","required", 'placeholder'=>"Mr/Mrs",])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <input type="hidden" name="employee_id" class="employee_id">
                    {{Form::select('employee_id', $employees, old('employee_id') ? old('employee_id') : (!empty($memo->employee_id) ? $memo->employee_id : null),['class' => 'form-control','id' => 'employee_id', 'autocomplete'=>"off", 'placeholder'=>"Select Employee",])}}
                </div>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-xl-1 col-md-1"></div>
            <div class="col-xl-1 col-md-1">
                <div class="input-group input-group-sm input-group-primary">
                    <h6 class="form-control " style="border: none">Subject: </h6>
                </div>
            </div>
            <div class="col-xl-10 col-md-10">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::text('letter_subject', old('letter_subject') ? old('letter_subject') : (!empty($memo->letter_subject) ? $memo->letter_subject : null),['class' => 'form-control letter_subject','id' => 'letter_subject','autocomplete'=>"off","required",])}}
                </div>
            </div>
        </div><br><br><br>

        <div class="row">
            <div class="col-xl-1 col-md-1"></div>
            <div class="col-xl-1 col-md-1">
                <div class="input-group input-group-sm input-group-primary">
                    <h6 class="form-control" style="border: none">Dear</h6>
                </div>
            </div>
            <div class="col-xl-2 col-md-2">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::text('address_word_two', 'Sir/Madam',['class' => 'form-control address_word_two','id' => 'address_word_two','autocomplete'=>"off","required", 'placeholder'=>"Sir/Madam",'readonly'])}}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-2 col-md-2"></div>
            <div class="col-xl-10 col-md-10">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::textarea('letter_body', old('letter_body') ? old('letter_body') : (!empty($memo->id) ? $memo->letter_body : null),['class' => 'form-control letter_body','id' => 'editor1','autocomplete'=>"off","required",])}}
                </div>
            </div>
        </div><br><br><br><br>
        <div class="row">
            <div class="col-xl-2 col-md-2"></div>
            <div class="col-xl-4 col-md-4">
                <table>
                    <tr>
                        <td>
                            <span>---------------------------------</span><br>
                            <span>Manager</span><br>
                            <span>Logistics Department</span><br>
                            <span>Rancon FC Propertise Limited</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div><br><br><br>

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
    <script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('js/ckeditor/ckeditor-custom.js')}}"></script>

    <script>


        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {

            // function for auto suggest projects
            $( "#project_name").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('scj.costCenterAutoSuggest')}}",
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
                    $('#project_name').val(ui.item.label);
                    $('#cost_center_id').val(ui.item.value);
                    return false;
                }
            });



            $(document).on('mouseenter', '.letter_date', function() {
                $(this).datepicker({
                    format: "yyyy-mm-dd",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                });
            });
        });
    </script>
@endsection
