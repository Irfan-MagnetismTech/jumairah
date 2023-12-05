@extends('layouts.backend-layout')
@section('title', 'Tentative Budget')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit Tentative Budget
    @else
        Create Tentative Budget
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('construction/tentative-budget-year-List') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if ($formType == 'edit')
        {!! Form::open(['url' => "construction/tentative_budget_update", 'method' => 'POST', 'class' => 'custom-form']) !!}
    @else
        {!! Form::open(['url' => 'construction/tentative_budget', 'method' => 'POST', 'class' => 'custom-form']) !!}
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_name">Project Name<span class="text-danger">*</span></label>
                {{ Form::text('project_name', old('project_name') ? old('project_name') : (!empty($tentative_budget) ? $tentative_budget->first()->costCenter->name : null), ['class' => 'form-control project_name', 'id' => 'project_name', 'autocomplete' => 'off', 'required', 'placeholder' => 'Project Name']) }}
                {{ Form::hidden('cost_center_id', old('cost_center_id') ? old('cost_center_id') : (!empty($tentative_budget) ? $tentative_budget->first()->cost_center_id : null), ['class' => 'form-control cost_center_id', 'id' => 'cost_center_id', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="applied_year">Budget For<span class="text-danger">*</span></label>
                {{ Form::text('applied_year', old('applied_year') ? old('applied_year') : (!empty($tentative_budget) ? $tentative_budget->first()->applied_year : now()->format('Y')), ['class' => 'form-control', 'id' => 'applied_date', 'autocomplete' => 'off', 'required', 'placeholder' => 'Date', 'readonly']) }}
            </div>
        </div>
    </div><!-- end row -->

    <hr class="bg-success">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
                <tr>
                    <th>Month<span class="text-danger">*</span></th>
                    <th>Material Cost<span class="text-danger">*</span></th>
                    <th>Labor Cost<span class="text-danger">*</span></th>
                    <th>
                        <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody>

                @if (old('tentative_month_name'))
                    @foreach (old('tentative_month_name') as $key => $materialOldData)
                        <tr>

                            <td>
                                    <input type="text" name="tentative_month_name[]" value="{{ old('tentative_month_name')[$key] }}" class="form-control text-center form-control-sm month" required autocomplete="off" readonly>
                                    <input type="hidden" name="tentative_month[]" value="{{ old('tentative_month')[$key] }}" class="form-control text-center form-control-sm month1" required autocomplete="off">
                            </td>
                            <td>
                                <input type="number" name="material_cost[]" value="{{ old('material_cost')[$key] }}" min='0'
                                    required class="form-control text-center form-control-sm material_cost"
                                    autocomplete="off">
                            </td>
                            <td>
                                <input type="number" name="labor_cost[]" value="{{ old('labor_cost')[$key] }}" min='0'
                                    required class="form-control text-center form-control-sm labor_cost" autocomplete="off">
                            </td>
                            <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                        class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @else
                    @if (!empty($tentative_budget))
                        @php
                            $month_name = ['January', 'February', 'March', 'April', 'May', 'June','July', 'August', 'September', 'October', 'November', 'December']
                        @endphp
                        @foreach ($tentative_budget as $tentativeBudgetDetail)
                            <tr>
                                <td>
                                    <input type="text" name="tentative_month_name[]"
                                        value="{{ $month_name[$tentativeBudgetDetail->tentative_month - 1]}}" min='0' required
                                        class="form-control text-center form-control-sm month" autocomplete="off" readonly>
                                    <input type="hidden" name="tentative_month[]"
                                        value="{{ $tentativeBudgetDetail->tentative_month }}" min='0' required
                                        class="form-control text-center form-control-sm month1" autocomplete="off">
                                </td>
                                <td>
                                    <input type="number" name="material_cost[]"
                                        value="{{ $tentativeBudgetDetail->material_cost }}" min='0' required
                                        class="form-control text-center form-control-sm material_cost" autocomplete="off">
                                </td>
                                <td>
                                    <input type="number" name="labor_cost[]"
                                        value="{{ $tentativeBudgetDetail->labor_cost }}" min='0' required
                                        class="form-control text-center form-control-sm labor_cost" autocomplete="off"></td>
                                <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                            class="fa fa-minus"></i></button></td>
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
          function date_picker(){
            $('.month').datepicker({
                    format: "MM",
                    autoclose: true,
                    todayHighlight: false,
                    showOtherMonths: false,
                    minViewMode: 1,
                    viewMode: 'month',
                    changeYear: false
                });
           }
        function addRow() {
            let row = `
            <tr>
               <td>
                    <input type="text" name="tentative_month_name[]" class="form-control text-center form-control-sm month" required autocomplete="off" readonly>
                    <input type="hidden" name="tentative_month[]" class="form-control text-center form-control-sm month1" required autocomplete="off">
                </td>
                <td>
                    <input type="number" name="material_cost[]" class="form-control text-center form-control-sm material_cost" min='0' required autocomplete="off" >
                </td>
                <td>
                    <input type="number" name="labor_cost[]" class="form-control text-center form-control-sm labor_cost" min='0' required autocomplete="off" >
                </td>
                <td>
                    <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button>
                </td>
            </tr>
            `;
            $('#itemTable tbody').append(row);
            date_picker();
        }







        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {
            @if ($formType == 'create' && !old('cost_center_id'))
                addRow();
            @endif
            @if ($formType == 'edit')
                date_picker();
            @endif

            $("#itemTable").on('click', ".addItem", function() {
                addRow();
            }).on('click', '.deleteItem', function() {
                $(this).closest('tr').remove();
            });



            $('#applied_date').datepicker({
                format: "yyyy",
                autoclose: true,
                todayHighlight: false,
                showOtherMonths: false,
                minViewMode: 2
            });
            // $('#applied_date').on('change', function(){
            //     $('.month').attr('min',$(this).val()+"-01");
            //     $('.month').attr('max',$(this).val()+"-12");
            //     $('.month').val($(this).val()+"-01");
            // })

            // $(document).on('mouseenter', '.month', function(){
            //     $(this).datepicker({format: "mm",autoclose: true,todayHighlight: false,showOtherMonths: false,minViewMode: 1});
            // });
            // $('#datepicker').datepicker();
            // $('#datepicker').on('changeDate', function() {
            //     $('#my_hidden_input').val(
            //         $('#datepicker').datepicker('getFormattedDate')
            //     );
            // });
          
          
           
           




            $(document).on('change', '.month', function() {
                let month_name = ['January', 'February', 'March', 'April', 'May', 'June','July', 'August', 'September', 'October', 'November', 'December']
                let indx = month_name.indexOf($(this).val());
               $(this).closest('tr').find('.month1').val(indx+1);
            });
  // Function for autocompletion of progress projects
            $("#project_name").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('scj.ConstructionTentativeBudgetProjectAutoSuggestWithBoq') }}",
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
                    $('#cost_center_id').val(ui.item.value);
                    $('#project_name').val(ui.item.label);
                    return false;
                }
            })


        });
    </script>
@endsection
