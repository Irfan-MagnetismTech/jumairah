@extends('layouts.backend-layout')
@section('title', 'Sales Plan')

@section('breadcrumb-title')
    @if (!empty($salesYearlyBudget))
        Edit Sales Plan
    @else
        Create Sales Plan
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ route('sales-yearly-budgets.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 my-3')

@section('content')

    @if (!empty($salesYearlyBudget))
        {!! Form::open(array('url' => "sales-yearly-budgets/$salesYearlyBudget->id",'encType' =>"multipart/form-data", 'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(['url' => 'sales-yearly-budgets', 'method' => 'POST', 'class' => 'custom-form']) !!}
    @endif

{{--    <input type="text" name="id" value="{{!empty($salesYearlyBudget) ? $salesYearlyBudget->id : null}}">--}}
    <div class="row">
        <div class="col-md-8">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_name">Project Name<span class="text-danger">*</span></label>
                {{ Form::text('project_name', old('project_name') ? old('project_name') : (!empty($salesYearlyBudget) ? $salesYearlyBudget->project->name : null), ['class' => 'form-control project_name', 'id' => 'project_name', 'autocomplete' => 'off', 'required', 'placeholder' => 'Project Name']) }}
                {{ Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($salesYearlyBudget) ? $salesYearlyBudget->project_id : null), ['class' => 'form-control project_id', 'id' => 'project_id', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="year">Budget For<span class="text-danger">*</span></label>
                {{ Form::text('year', old('year') ? old('year') : (!empty($salesYearlyBudget) ? $salesYearlyBudget->first()->year : now()->format('Y')), ['class' => 'form-control', 'id' => 'year', 'autocomplete' => 'off', 'required', 'placeholder' => 'Date', 'readonly']) }}
            </div>
        </div>
    </div><!-- end row -->

    <hr class="bg-success">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
                <tr>
                    <th>Month<span class="text-danger">*</span></th>
                    <th>Sales Value <span class="text-danger">*</span></th>
                    <th>Booking Money <span class="text-danger">*</span></th>
                    <th>
                        <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody>

                @if (old('month'))
                    @foreach (old('month') as $key => $materialOldData)
                        <tr>
                            <td>
                                    <input type="text" name="month[]" value="{{ old('month')[$key] }}" class="form-control text-center form-control-sm month" required autocomplete="off" readonly>
                            </td>
                            <td>
                                <input type="number" name="sales_value[]" value="{{ old('sales_value')[$key] }}" min='0'
                                    required class="form-control text-center form-control-sm sales_value"
                                    autocomplete="off">
                            </td>
                            <td>
                                <input type="number" name="booking_money[]" value="{{ old('booking_money')[$key] }}" min='0'
                                    required class="form-control text-center form-control-sm labor_cost" autocomplete="off">
                            </td>
                            <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                        class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @else
                    @if (!empty($salesYearlyBudget))
                        @foreach ($salesYearlyBudget->salesYearlyBudgetDetails  as $details)
                            <tr>
                                <td>
                                    <input type="month" name="month[]"
                                           value="{{ $details->month}}" min='0' required
                                           class="form-control text-center form-control-sm sales_value" autocomplete="off">
                                </td>
                                <td>
                                    <input type="number" name="sales_value[]"
                                        value="{{ $details->sales_value }}" min='0' required
                                        class="form-control text-center form-control-sm sales_value" autocomplete="off">
                                </td>
                                <td>
                                    <input type="number" name="booking_money[]"
                                        value="{{ $details->booking_money }}" min='0' required
                                        class="form-control text-center form-control-sm labor_cost" autocomplete="off"></td>
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

        function addRow() {
            let row = `
            <tr>
               <td>
                    <input type="month" name="month[]" class="form-control text-center form-control-sm month" required autocomplete="off">
                </td>
                <td>
                    <input type="text" name="sales_value[]" class="form-control text-center form-control-sm sales_value" min='0' required autocomplete="off" >
                </td>
                <td>
                    <input type="text" name="booking_money[]" class="form-control text-center form-control-sm booking_money" min='0' required autocomplete="off" >
                </td>
                <td>
                    <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button>
                </td>
            </tr>
            `;
            $('#itemTable tbody').append(row);
        }

        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {
            @if (empty($salesYearlyBudget) && !old('project_id'))
                addRow();
            @endif

            $("#itemTable").on('click', ".addItem", function() {
                addRow();
            }).on('click', '.deleteItem', function() {
                $(this).closest('tr').remove();
            });

            $('#year').datepicker({format: "yyyy",autoclose: true,todayHighlight: false,showOtherMonths: false,minViewMode: 2});

            $( "#project_name").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('projectAutoSuggest')}}",
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
                    $('#project_id').val(ui.item.value);
                    return false;
                }
            });
            $(document).on('keyup','.sales_value, .booking_money ',function (){
                addComma(this)
            });

            function addComma (thisVal){
                $(thisVal).keyup(function(event) {
                    if(event.which >= 37 && event.which <= 40) return;
                    $(this).val(function(index, value) {
                        return value .replace(/[^0-9\.]/g, "") .replace(/\B(?=(\d{3})+(?!\d))/g, ",") ;
                    });
                });
            }
        });
    </script>
@endsection
