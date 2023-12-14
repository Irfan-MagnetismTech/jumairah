@extends('layouts.backend-layout')
@section('title', 'Project Duration')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Project Duration
    @else
        Create Project Duration
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('construction/monthly_progress_report') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    @if($formType == 'edit')
        {!! Form::open(array('url' => "construction/monthly_progress_report/$monthly_progress_report->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "construction/monthly_progress_report",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
                <tr>
                    <th>Project Name<span class="text-danger">*</span></th>
                    <th >Date of <br> Inception</th>
                    <th >Estimated Date <br>of Completion</th>
                    <th >
                        <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody>

            @if(old('cost_center_id'))
                @foreach(old('cost_center_id') as $key => $materialOldData)
                    <tr>
                        <td>
                            <input type="text" name="project_name[]"   value="{{old('project_name')[$key]}}" id="project_name" class="form-control text-center project_name" autocomplete="off">
                            <input type="hidden" name="cost_center_id[]"   value="{{old('cost_center_id')[$key]}}" id="cost_center_id" class="form-control text-center  cost_center_id">
                        </td>
                        <td><input type="text" name="date_of_inception[]" value="{{old('date_of_inception')[$key]}}"  class="form-control text-center form-control-sm date_of_inception" id="date_of_inception" autocomplete="off" ></td>
                        <td><input type="text" name="date_of_completion[]" value="{{old('date_of_completion')[$key]}}"  class="form-control text-center form-control-sm date_of_completion" id="date_of_completion" autocomplete="off" ></td>
                      </tr>
                @endforeach
            @else
                @if(!empty($monthly_progress_report))
                    @foreach($monthly_progress_report->ProjectProgressReportDetails as $ProjectProgressReportDetail)

                        <tr>
                            <td>
                                <input type="text" name="project_name[]" value="{{ !empty($ProjectProgressReportDetail->cost_center_id) ? $ProjectProgressReportDetail->costCenter->name : "" }}" id="project_name" autocomplete="off" class="form-control text-center form-control-sm project_name">
                                <input type="hidden" name="cost_center_id[]" value="{{ !empty($ProjectProgressReportDetail->cost_center_id) ? $ProjectProgressReportDetail->cost_center_id : "" }}" id="cost_center_id" class="form-control form-control-sm text-center cost_center_id" >
                            </td>
                            <td><input type="text" name="date_of_inception[]" value="{{ $ProjectProgressReportDetail->date_of_inception }}"  class="form-control text-center form-control-sm date_of_inception" id="date_of_inception" autocomplete="off" ></td>
                            <td><input type="text" name="date_of_completion[]" value="{{ $ProjectProgressReportDetail->date_of_completion }}"  class="form-control text-center form-control-sm date_of_completion" id="date_of_completion" autocomplete="off" ></td>
                            <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @endif
            @endif

            </tbody>
        </table>
    </div> <!-- end table responsive -->

    <br><br>
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
                    <input type="text" name="project_name[]" id="project_name" class="form-control text-center  project_name" autocomplete="off">
                    <input type="hidden" name="cost_center_id[]" id="cost_center_id" class="form-control text-center  cost_center_id">
                </td>
                <td><input type="text" name="date_of_inception[]" class="form-control text-center form-control-sm date_of_inception" id="date_of_inception" autocomplete="off" ></td>
                <td><input type="text" name="date_of_completion[]" class="form-control text-center form-control-sm date_of_completion" id="date_of_completion" autocomplete="off" ></td>
                <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
            </tr>
            `;
            $('#itemTable tbody').append(row);
        }

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            @if($formType == 'create' && !old('cost_center_id'))
                addRow();
            @endif

            $("#itemTable").on('click', ".addItem", function(){
                addRow();
            }).on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
            });



            $('#applied_date').datepicker({format: "yyyy-mm-dd",autoclose: true,todayHighlight: true,showOtherMonths: true});

            $(document).on('mouseenter', '.date_of_inception, .date_of_completion', function(){
                $(this).datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
            });

            // Function for autocompletion of progress projects

            $(document).on('keyup', ".project_name", function() {
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
                        $(this).closest('tr').find('.cost_center_id').val(ui.item.value);
                        $(this).closest('tr').find('.project_name').val(ui.item.label);
                        return false;
                    }
                });
            });
        });

    </script>
@endsection
