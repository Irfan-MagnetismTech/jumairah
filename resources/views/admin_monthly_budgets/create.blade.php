@extends('layouts.backend-layout')
@section('title', 'Admin Monthly Budget')

@section('breadcrumb-title')
    @if (!empty($adminMonthlyBudget))
        Edit Admin Monthly Budget
    @else
        Create Admin Monthly Budget
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ route('admin-monthly-budgets.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if (!empty($adminMonthlyBudget))
        {!! Form::open(array('url' => "admin-monthly-budgets/$adminMonthlyBudget->id",'encType' =>"multipart/form-data", 'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(['url' => 'admin-monthly-budgets', 'method' => 'POST', 'class' => 'custom-form']) !!}
    @endif

{{--    <input type="text" name="id" value="{{!empty($adminMonthlyBudget) ? $adminMonthlyBudget->id : null}}">--}}
    <div class="row">
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_name">Date<span class="text-danger">*</span></label>
                {{ Form::text('date', old('date') ? old('date') : (!empty($adminMonthlyBudget) ? $adminMonthlyBudget->first()->date : now()->format('d-m-Y')), ['class' => 'form-control', 'id' => 'date', 'autocomplete' => 'off', 'required', 'placeholder' => 'Date' ]) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="month">Budget For<span class="text-danger">*</span></label>
                {{ Form::month('month', old('month') ? old('year') : (!empty($adminMonthlyBudget) ? $adminMonthlyBudget->first()->month : now()->format('m')), ['month' => 'form-control', 'id' => 'yeamonthr', 'autocomplete' => 'off', 'required', 'placeholder' => 'Month', ]) }}
            </div>
        </div>
    </div><!-- end row -->

    <hr class="bg-success">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
                <tr>
                    <th>Particular<span class="text-danger">*</span></th>
                    <th>Week One<span class="text-danger"></span></th>
                    <th>Week Two<span class="text-danger"></span></th>
                    <th>Week Three<span class="text-danger"></span></th>
                    <th>Week Four<span class="text-danger"></span></th>
                    <th>Week Five<span class="text-danger"></span></th>
                    <th>Remarks<span class="text-danger"></span></th>
                    <th>Total<span class="text-danger">*</span></th>
                    <th>
                        <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody>

                @if (old('week_one'))
                    @foreach (old('week_one') as $key => $materialOldData)
                        <tr>
                            <td>
                                    <!-- <input type="text" name="month[]" value="{{ old('month')[$key] }}" class="form-control text-center form-control-sm month" required autocomplete="off" readonly> -->
                                    <select name="budget_head_id[]" class="form-control" onautocomplete="off">
                                        @foreach($budget_heads as $head)
                                        <option value="{{$head->id}}">{{$head->name}}</option>
                                        @endforeach
                                    </select>
                            </td>
                            <td>
                                    <input type="number" name="week_one[]" number value="{{ old('week_one')[$key] }}" class="form-control text-center form-control-sm sales_value" required autocomplete="off" readonly>
                            </td>
                            <td>
                                    <input type="number" name="week_two[]" number value="{{ old('week_two')[$key] }}" class="form-control text-center form-control-sm sales_value" required autocomplete="off" readonly>
                            </td>
                            <td>
                                    <input type="number" name="week_three[]" number value="{{ old('week_three')[$key] }}" class="form-control text-center form-control-sm sales_value" required autocomplete="off" readonly>
                            </td>
                            <td>
                                    <input type="number" name="week_four[]" number value="{{ old('week_four')[$key] }}" class="form-control text-center form-control-sm sales_value" required autocomplete="off" readonly>
                            </td>
                            <td>
                                    <input type="number" name="week_five[]" number value="{{ old('week_five')[$key] }}" class="form-control text-center form-control-sm sales_value" required autocomplete="off" readonly>
                            </td>
                            <td>
                                <input type="number" name="remarks[]" value="{{ old('remarks')[$key] }}" number
                                    required class="form-control text-center form-control-sm sales_value"
                                    autocomplete="off">
                            </td>
                            <td>
                                <input type="number" name="amount[]" value="{{ old('amount')[$key] }}" min='0'
                                    required class="form-control text-center form-control-sm labor_cost" autocomplete="off">
                            </td>
                            <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                        class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @else
                    @if (!empty($adminMonthlyBudget))
                        @foreach ($adminMonthlyBudget->adminMonthlyBudgetDetails  as $details)
                            <tr>
                                <td>
                                    <!-- <input type="month" name="month[]"
                                           value="{{ $details->budgetHead->name}}" min='0' required
                                           class="form-control text-center form-control-sm sales_value" autocomplete="off"> -->
                                    <select name="budget_head_id[]" class="form-control" onautocomplete="off">
                                        @foreach($budget_heads as $head)
                                        <option value="{{$head->id}}">{{$head->name}}</option>
                                        @endforeach
                                    </select>

                                </td>
                                <td>
                                    <input type="number" name="week_one[]"
                                           value="{{ $details->week_one}}" min='0' required
                                           class="form-control text-center form-control-sm sales_value" autocomplete="off">
                                </td>
                                <td>
                                    <input type="number" name="week_two[]"
                                           value="{{ $details->week_two}}" min='0' required
                                           class="form-control text-center form-control-sm sales_value" autocomplete="off">
                                </td>
                                <td>
                                    <input type="number" name="week_three[]"
                                           value="{{ $details->week_three}}" min='0' required
                                           class="form-control text-center form-control-sm sales_value" autocomplete="off">
                                </td>
                                <td>
                                    <input type="number" name="week_four[]"
                                           value="{{ $details->week_four}}" min='0' required
                                           class="form-control text-center form-control-sm sales_value" autocomplete="off">
                                </td>
                                <td>
                                    <input type="number" name="week_five[]"
                                           value="{{ $details->week_five}}" min='0' required
                                           class="form-control text-center form-control-sm sales_value" autocomplete="off">
                                </td>
                                <td>
                                    <input type="text" name="remarks[]"
                                        value="{{ $details->remarks }}" min='0' required
                                        class="form-control text-center form-control-sm sales_value" autocomplete="off">
                                </td>
                                <td>
                                    <input type="number" name="amount[]"
                                        value="{{ $details->amount }}" min='0' required
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
                    <select name="budget_head_id[]" class="form-control" onautocomplete="off">
                        @foreach($budget_heads as $head)
                            <option value="{{$head->id}}">{{$head->name}}</option>
                        @endforeach
                    </select>
                </td>
               <td>
                    <input type="number" name="week_one[]" class="form-control text-center form-control-sm month" required autocomplete="off">
                </td>
                <td>
                    <input type="number" name="week_two[]" class="form-control text-center form-control-sm month" required autocomplete="off">
                </td>
                <td>
                    <input type="number" name="week_three[]" class="form-control text-center form-control-sm month" required autocomplete="off">
                </td>
                <td>
                    <input type="number" name="week_four[]" class="form-control text-center form-control-sm month" required autocomplete="off">
                </td>
                <td>
                    <input type="number" name="week_five[]" class="form-control text-center form-control-sm month" required autocomplete="off">
                </td>
                <td>
                    <input type="text" name="remarks[]" class="form-control text-center form-control-sm" min='0' required autocomplete="off" >
                </td>
                <td>
                    <input type="text" name="amount[]" class="form-control text-center form-control-sm booking_money" min='0' required autocomplete="off" >
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
            @if (empty($adminMonthlyBudget) && !old('project_id'))
                addRow();
            @endif

            $("#itemTable").on('click', ".addItem", function() {
                addRow();
            }).on('click', '.deleteItem', function() {
                $(this).closest('tr').remove();
            });

            $('#year').datepicker({format: "yyyy",autoclose: true,todayHighlight: false,showOtherMonths: false,minViewMode: 2});

            
            $(document).on('keyup','.sales_value',function (){
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
