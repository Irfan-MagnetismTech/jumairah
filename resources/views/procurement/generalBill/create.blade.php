@extends('layouts.backend-layout')
@section('title', 'General Bill')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit General Bill
    @else
        Add General Bill
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('generalBill') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if ($formType == 'edit')
        {!! Form::open([
            'url' => "generalBill/$generalBill->id",
            'enctype' => 'multipart/form-data',
            'method' => 'PUT',
            'class' => 'custom-form',
        ]) !!}
    @else
        {!! Form::open([
            'url' => 'generalBill',
            'method' => 'POST',
            'enctype' => 'multipart/form-data',
            'class' => 'custom-form',
        ]) !!}
    @endif
    <input type="hidden" name="general_bill_id" value="{{ !empty($generalBill->id) ? $generalBill->id : null }}">
    <div class="row">
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="date">Date<span class="text-danger">*</span> </label>
                {{ Form::text('date', old('date') ? old('date') : (!empty($generalBill->date) ? $generalBill->date : null), ['class' => 'form-control', 'id' => 'date', 'autocomplete' => 'off', 'required', 'readonly']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_id">Project Name<span class="text-danger">*</span></label>
                {{ Form::text('project_name', old('project_name') ? old('project_name') : (!empty($generalBill) ? $generalBill->project->name : null), ['class' => 'form-control', 'id' => 'project_name', 'placeholder' => 'Select a Project', 'autocomplete' => 'off', 'required', 'tabindex' => -1]) }}
                {{ Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($generalBill->project->id) ? $generalBill->project->id : null), ['class' => 'form-control', 'id' => 'project_id', 'autocomplete' => 'off', 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="mpr_no">MPR No</label>
                {{Form::text('mpr_no', old('mpr_no') ? old('mpr_no') : (!empty($generalBill->mpr_id) ? $generalBill->mpr->mpr_no : null),['class' => 'form-control','id' => 'mpr_no','placeholder'=>"Search MPR No" ,'autocomplete'=>"off"])}}
                {{Form::hidden('mpr_id', old('mpr_id') ? old('mpr_id') : (!empty($generalBill->mpr_id) ? $generalBill->mpr_id : null),['class' => 'form-control','id' => 'mpr_id','autocomplete'=>"off"])}}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="mrr_no">MRR No</label>
                {{Form::text('mrr_no', old('mrr_no') ? old('mrr_no') : (!empty($generalBill->mrr_id) ? $generalBill->mrr->mrr_no : null),['class' => 'form-control','id' => 'mrr_no','placeholder'=>"Search MRR No" ,'autocomplete'=>"off"])}}
                {{Form::hidden('mrr_id', old('mrr_id') ? old('mrr_id') : (!empty($generalBill->mrr_id) ? $generalBill->mrr_id : null),['class' => 'form-control','id' => 'mrr_id','autocomplete'=>"off"])}}
            </div>
        </div>
    </div><!-- end row -->
    <hr class="bg-success">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
                <tr>
                    <th>Purpose (Account Head)<span class="text-danger">*</span></th>
                    <th width="300px">Description</th>
                    <th>Remarks</th>
                    <th>Attachments</th>
                    <th>Amount<span class="text-danger">*</span></th>
                    <th>
                        <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody>
                @if (old('account_id'))
                    @foreach (old('account_id') as $key => $generalBillOldData)
                        <tr>
                            <td>
                                <input type="text" name="account_head_name[]"
                                    value="{{ old('account_head_name')[$key] }}"
                                    class="form-control form-control-sm account_head_name" placeholder="Search here">
                                <input type="hidden" name="account_id[]" value="{{ old('account_id')[$key] }}"
                                    class="form-control form-control-sm account_id">
                            </td>
                            <td>
                                <textarea class="ckeditor form-control form-control-sm description" cols="80" name="description[]">{{ old('description')[$key] }}</textarea>
                            </td>
                            <td><input type="text" name="remarks[]" value="{{ old('remarks')[$key] }}"
                                    class="form-control form-control-sm remarks"></td>
                            <td><input type="file" class="dropify" accept='.png, .jpg, .jpeg, .pdf' data-height="300"
                                    name="image[]" /></td>
                            <td><input type="text" name="amount[]" autocomplete="off" class="form-control form-control-sm amount text-right"></td>
                            <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                        class="fa fa-minus"></i></button></td>

                        </tr>
                    @endforeach
                @else
                    @if (!empty($generalBill))
                        @foreach ($generalBill->generalBilldetails as $generalBilldetail)
                            <tr>
                                <td>
                                    <input type="text" name="account_head_name[]"
                                        value="{{ $generalBilldetail->account->account_name }}"
                                        class="form-control form-control-sm account_head_name" placeholder="Search here">
                                    <input type="hidden" name="account_id[]"
                                        value="{{ $generalBilldetail->account_id }}}}"
                                        class="form-control form-control-sm account_id">
                                </td>
                                <td>
                                    <textarea class="ckeditor form-control form-control-sm description" cols="80" name="description[]">{{ $generalBilldetail->description }}</textarea>
                                </td>
                                <td><input type="text" name="remarks[]" value="{{ $generalBilldetail->remarks }}"
                                        class="form-control form-control-sm remarks"></td>
                                <td><input type="file" class="dropify mb-1"
                                     accept='.png, .jpg, .jpeg, .pdf' data-height="300"
                                        name="image[]"><br>
                                        @if (!is_null($generalBilldetail->attachment))
                                        <a href='{{route("generalBilldetail.ShowFile",\Illuminate\Support\Facades\Crypt::encryptString($generalBilldetail->id))}}' target="_blank">Show Attachment</a>
                                        @endif</td>
                                <td><input type="text" name="amount[]" value="{{ $generalBilldetail->amount }}" autocomplete="off" class="form-control form-control-sm amount text-right"></td>
                                <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                            class="fa fa-minus"></i></button></td>
                            </tr>
                        @endforeach
                    @endif
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right">Total Amount</td>
                    <td>{{ Form::number('total_amount', old('total_amount') ? old('total_amount') : (!empty($generalBill->total_amount) ? $generalBill->total_amount : null), ['class' => 'form-control total_amount text-right', 'id' => 'total_amount', 'placeholder' => '0.00 ', 'readonly']) }}
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
    <script defer>
        function addRow() {
            let row = `
            <tr>
                <td>
                    <input type="text" name="account_head_name[]" class="form-control form-control-sm account_head_name" placeholder="Search here">
                    <input type="hidden" name="account_id[]" class="form-control form-control-sm account_id">
                </td>
                <td><textarea class="ckeditor" cols="80" name="description[]"></textarea></td>
                <td><input type="text" name="remarks[]" class="form-control form-control-sm remarks"></td>
                <td><input type="file" class="dropify" accept='.png, .jpg, .jpeg, .pdf' data-height="300" name="image[]"/></td>
                <td><input type="text" name="amount[]" autocomplete="off" class="form-control form-control-sm amount text-right"></td>
                <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
            </tr>
        `;
            $('#itemTable tbody').append(row);
        }

        function total_amount() {
            let total = 0;
            if ($(".amount").length > 0) {
                $(".amount").each(function() {
                    var amount = $(this).val();
                    total += parseFloat(amount);
                })
            }
            $("#total_amount").val(total);
        }

        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {
            @if ($formType == 'create' && !old('account_id'))
                addRow();
            @endif

            $(document).on('keyup mousewheel', ".amount", function() {
                total_amount();
            });

            $("#itemTable").on('click', ".addItem", function() {
                addRow();

            }).on('click', '.deleteItem', function() {
                $(this).closest('tr').remove();
                total_amount();
            });

            $('#date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });

            $(document).on('mouseenter', '.bill_date', function() {
                $(this).datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                });
            });

            $("#project_name").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('scj.projectAutoSuggest') }}",
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
                    $('#project_name').val(ui.item.label);
                    $('#project_id').val(ui.item.value);
                    return false;
                }
            });


            $(document).on('keyup', ".account_head_name", function() {
                $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('scj.SearchAccountHead') }}",
                            type: 'get',
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
                        $(this).closest('td').find('.account_id').val(ui.item.value);
                        return false;
                    }
                });
            })

            $(document).on('keyup', "#mrr_no", function(){
            let cost_center_id = $("#project_id").val();
            $(this).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('scj.getMrrByCostCenter')}}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            cost_center_id : cost_center_id,
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                  $(this).val(ui.item.label);
                  $('#mrr_id').val(ui.item.value);
                    return false;
                }
            });
        });

        $(document).on('keyup', "#mpr_no", function(){
            let cost_center_id = $("#project_id").val();
            $(this).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('scj.getMprByCostCenter')}}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            cost_center_id : cost_center_id,
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                  $(this).val(ui.item.label);
                  $('#mpr_id').val(ui.item.value);
                    return false;
                }
            });
        });

        }); // end document ready
    </script>

@endsection
