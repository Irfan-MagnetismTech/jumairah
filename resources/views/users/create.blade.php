@extends('layouts.backend-layout')
@section('title', 'User')

@section('breadcrumb-title')
    @if($formType == 'edit')  Edit  @else  Create  @endif
    User Info
@endsection

@section('style')
    <style>
        .input-group-addon{
            min-width: 120px;
        }
        .input-group-info .input-group-addon{
            /*background-color: #04748a!important;*/
        }
        .select2container {
            max-width: 350px!important;
            white-space: inherit!important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice span {
            color: #000!important;
            font-size: 11px!important;
            font-weight: bold!important;
        }
    </style>
    <link rel="stylesheet" href={{ asset("js/image-viewer-smooth-animations/assets/css/master.css") }}>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('users.index')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    @if($formType == 'create')
        {!! Form::open(array('url' => "users",'method' => 'POST', 'class'=>'custom-form','encType' =>"multipart/form-data")) !!}
    @else
        {!! Form::open(array('url' => "users/$user->id",'method' => 'PUT', 'class'=>'custom-form','encType' =>"multipart/form-data")) !!}
    @endif
     <div class="row">
         <div class="col-12">
             <div class="input-group input-group-sm input-group-primary">
                 <label class="input-group-addon" for="name">Department</label>
                 {{Form::select('department_id',$departments, old('department_id') ? old('department_id') : (!empty($user) ? $user->department_id : null),['class' => 'form-control','id' => 'department_id', 'placeholder' => 'Select Department'] )}}
                 @error('department_id') <p class="text-danger">{{ $errors->first('department_id') }}</p> @enderror
             </div>
         </div>
         <div class="col-12">
             <div class="input-group input-group-sm input-group-primary">
                 <label class="input-group-addon" for="name">Employee</label>
                {{Form::select('employee_id',$employees, old('employee_id') ? old('employee_id') : (!empty($user) ? $user->employee_id : null),['class' => 'form-control','id' => 'employee_id', 'placeholder' => 'Select Name', "onchange"=>"getEmployeeInfo(this)"] )}}
             </div>
         </div>
         <div class="col-12">
             <div class="input-group input-group-sm input-group-primary">
                 <label class="input-group-addon" for="name">User Name <span class="text-danger">*</span></label>
                 {{Form::text('name', old('name') ? old('name') : (!empty($user->name) ? $user->name : null),['class' => 'form-control','id' => 'name', 'placeholder' => 'Enter User Name Here', 'required'] )}}
                 @error('name') <p class="text-danger">{{ $errors->first('name') }}</p> @enderror
             </div>
         </div>
         <div class="col-12">
             <div class="input-group input-group-sm input-group-primary">
                 <label class="input-group-addon" for="name">User Email<span class="text-danger">*</span></label>
                 {{Form::text('email', old('email') ? old('email') : (!empty($user->email) ? $user->email : null),['class' => 'form-control','id' => 'email', 'placeholder' => 'Enter User email Here','required'] )}}
                 @error('email') <p class="text-danger">{{ $errors->first('email') }}</p> @enderror
             </div>
         </div>
         <div class="col-12">
             <div class="input-group input-group-sm input-group-primary">
                 <label class="input-group-addon" for="name">Password<span class="text-danger">*</span></label>
                 {{Form::password('password', ['class' => 'form-control','id' => 'password', 'placeholder' => 'Enter User password Here', empty($user) ? 'required' : ''] )}}
                 @error('password') <p class="text-danger">{{ $errors->first('password') }}</p> @enderror
             </div>
         </div>
         <div class="col-12">
             <div class="input-group input-group-sm input-group-primary">
                 <label class="input-group-addon" for="name">Conf. Pass<span class="text-danger">*</span></label>
                 {{Form::password('confirm-password',['class' => 'form-control','id' => 'confirm-password', 'placeholder' => 'Enter User password Here',  empty($user) ? 'required' : '' ] )}}
                 @error('confirm-password') <p class="text-danger">{{ $errors->first('confirm-password') }}</p> @enderror
             </div>
         </div>

         <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="name">User Role<span class="text-danger">*</span></label>
                {{Form::select('role',$roles, old('role') ? old('role') : (!empty($user) ? $user->roles : null),['class' => 'form-control','id' => 'role', 'placeholder' => 'Select User Role', 'required'] )}}
                @error('role') <p class="text-danger">{{ $errors->first('role') }}</p> @enderror
            </div>
        </div>
        <div class="col-12 row">
            <div class="col-md-6 col-sm-11 col-xs-11">
                <div class="input-group input-group-sm input-group-primary input-container">
                    <label class="input-group-addon" for="signature"> Signature</label>
                    {{ Form::file('signature',['class' => 'form-control', 'accept' => '.png, .jpg, .jpeg,','id' => '',"onchange"=>"document.getElementById('signature_view').src = window.URL.createObjectURL(this.files[0])"]) }}
                </div>
            </div>
            <div class="col-md-2">
                <div class="images">
                    @if ($formType=='edit' && $user != null && !empty($user->signature))
                        <img src="{{ asset("{$user->signature}") }}" id="signature_view" width="40px" height="40px" alt="Signature">
                    @else
                        <img id="signature_view" width="40px" height="40px" alt="" />
                    @endif
                </div>
            </div>
        </div>
    </div><!-- end row -->
    <!-- div to show preview image -->
    <div class="row">
        <div class="col-md-2">
            <div class="input-group input-group-sm input-group-primary input-container">
                <label class="input-group-addon" for="signature"> Assign Project</label>
                <div class="checkbox-fade fade-in-primary" style="margin-top: 6px;margin-left: 5px;margin-right: 0px;">
                    <label>
                        <input type="checkbox" name="project_assigned" value="1"
                            class="form-control" id="project_assigned" data-toggle="tooltip" title="Assign Project" @if($formType=='edit' && $user != null && ($user->project_assigned == 1)) checked @endif>
                        <span class="cr" data-toggle="tooltip" title="Assign Project">
                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                        </span>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-2" id="project_list" style="display: none;">
            <div class="select2_container">
                    <select class="form-control serial_code select2" name='cost_center_id[]' multiple="multiple">
                        @if($formType == 'edit')
                            @forelse ($user->assignedProject as $key => $value )
                                <option value="{{$value->cost_center_id}}" selected>{{$value?->costCenter?->name ?? ''}}</option>
                            @empty

                            @endforelse
                            @forelse ($costCenter as $key => $value )
                                <option value="{{$key}}">{{$value}}</option>
                            @empty

                            @endforelse
                        @else
                            @forelse ($costCenter as $key => $value )
                                <option value="{{$key}}">{{$value}}</option>
                            @empty

                            @endforelse
                        @endif
                    </select>
            </div>
        </div>
    </div>
    <div>
    <div id="image-viewer" style="z-index: 9999">
        <span class="close">&times;</span>
        <img class="modal-content" id="full-image">
    </div>
<!-- div to show preview image -->
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
        $(document).ready(function(){
            $('#project_assigned').trigger('change');
        })
        function getEmployeeInfo(employeeid){
            let eid=$(employeeid).val();
            let url ='{{url("employeeAutoComplete")}}/'+eid;
            fetch (url)
                .then ((resp)=>resp.json())
                .then (function (einfo) {
                $("#name").val(einfo.emp_name);
                $("#email").val(einfo.email);
            })
            .catch(function () {
            });
        }

        function getDepartmentEmployee() {
            let dropdown = $('#employee_id');
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select Name</option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{url("getDepartmentEmployee")}}/' + $("#department_id").val();
            let selectedEmployeeId = '{{ isset($user) ? $user->employee_id : '' }}';
            // Populate dropdown with list of provinces
            $.getJSON(url, function (employee) {
                $.each(employee, function (key, entry) {
                    // dropdown.append($('<option></option>').attr('value', entry.id).text(entry.emp_name + ' - ' + entry.emp_code));
                    let option = $('<option></option>').attr('value', entry.id).text(entry.emp_name + ' ~ ' + entry.emp_code);
            if (entry.id == selectedEmployeeId) {
                option.attr('selected', 'selected');
            }
            dropdown.append(option);
                })
            });
        }

        $(function(){
            getDepartmentEmployee();
            intialize_photo_preview();
            $("#department_id").on('change', function(){
                getDepartmentEmployee();
            });
            $('.select2').select2({
                maximumSelectionLength: 5,
                width: '100%'
            }).on('select2:select', function(e) {
                if ($(this).val().length === 5) {
                    $(this).next().find('.select2-selection').addClass('narrow-selection');
                }
            });
        });//document.ready


        function intialize_photo_preview(){
            $(".images img").click(function(){
            $("#full-image").attr("src", null);
            $("#full-image").attr("src", $(this).attr("src"));
            $('#image-viewer').show();
            });

                $("#image-viewer .close").click(function(){
                $('#image-viewer').hide();
                });
        }
        $('#project_assigned').on('change',function(){
            let isChecked = $(this).is(':checked');
            if(isChecked){
                $('#project_list').show('fade');
            }else{
                $('#project_list').hide('fade');
                $('.select2').val('');
                $('.select2').select2({});
            }
        })

    </script>

@endsection
