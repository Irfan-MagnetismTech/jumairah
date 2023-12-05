@extends('layouts.backend-layout')
@section('title', 'MPR')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Cost Memo
    @else
        Add Cost Memo
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('requisitions') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if($formType == 'edit')
        {!! Form::open(array('url' => "costMemo/$costMemo->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "costMemo",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Project Name<span class="text-danger">*</span></label>
                    {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($costMemo) ? $costMemo->costCenter->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off","required", 'placeholder' => 'Project Name'])}}
                    {{Form::hidden('cost_center_id', old('cost_center_id') ? old('cost_center_id') : (!empty($costMemo) ? $costMemo->cost_center_id: null),['class' => 'form-control','id' => 'cost_center_id', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="applied_date">Applied Date<span class="text-danger">*</span></label>
                    {{Form::text('applied_date', old('applied_date') ? old('applied_date') : (!empty($costMemo) ? $costMemo->applied_date : null),['class' => 'form-control','id' => 'applied_date','autocomplete'=>"off","required", 'placeholder' => 'Applied Date', 'readonly'])}}
                </div>
            </div>
        </div><!-- end row -->

    <hr class="bg-success">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
            <tr>
                <th>Particulers<span class="text-danger">*</span></th>
                <th>Amount</th>
                <th>
                    <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                </th>
            </tr>
            </thead>
            <tbody>

            @if(old('material_id'))
               @foreach(old('material_id') as $key => $materialOldData)
                   <tr>
                       <td><input type="text" name="particulers[]" value="{{old('particulers')[$key]}}" class="form-control form-control-sm text-center particulers" required autocomplete="off"></td>
                       <td><input type="text" name="amount[]" value="{{old('amount')[$key]}}" class="form-control form-control-sm amount" autocomplete="off"></td>
                       <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                   </tr>
               @endforeach
            @else
                @if(!empty($costMemo))
                    @foreach($costMemo->costMemoDetails as $costMemoDetail)
                        <tr>
                            <td><input type="text" name="particulers[]" value="{{ $costMemoDetail->particulers }}" class="form-control form-control-sm text-center particulers" required autocomplete="off"></td>
                            <td><input type="text" name="amount[]" value="{{ $costMemoDetail->amount }}" class="form-control form-control-sm amount" autocomplete="off"></td>
                            <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @endif
            @endif
            </tbody>
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
    <script>
        function addRow(){
            let row = `
                <tr>
                    <td><input type="text" name="particulers[]" class="form-control form-control-sm text-center particulers" required autocomplete="off"></td>
                    <td><input type="text" name="amount[]" class="form-control form-control-sm amount" autocomplete="off"></td>
                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            $('#itemTable tbody').append(row);
        }

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){

            @if($formType == 'create' && !old('particulers'))
                addRow();
            @endif

            $("#itemTable").on('click', ".addItem", function(){
                addRow();

            }).on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
            });

            $('#applied_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});


            // Function for autocompletion of projects

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
                    $("#itemTable").find("tbody").children("tr").remove();
                    addRow();
                    return false;
                }
            })
        });
    </script>
@endsection
