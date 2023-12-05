@extends('layouts.backend-layout')
@section('title', 'Work Orders')

@section('breadcrumb-title')
    Payment Schedule
@endsection

@section('breadcrumb-button')
<a href="{{ url("workorders/$workorder->id/edit") }}" data-toggle="tooltip" title="Work Order" class="btn btn-out-dashed btn-sm btn-info"><i class="fas fa-long-arrow-alt-left"></i></a>
<a href="{{route("workorder-terms", $workorder->id) }}" data-toggle="tooltip" title="Terms and Condition" class="btn btn-out-dashed btn-sm btn-info"><i class="fas fa-long-arrow-alt-right"></i></a>
    <a href="{{ url('workorders') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('style')
<style>
    #paymentScheduleTable th:nth-child(3){
        width: 100px; 
    }

</style>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    {!! Form::open(['url' => route('workorder-payments.store', $workorder->id), 'method' => 'POST', 'class' => 'custom-form']) !!}

    <div class="row">
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="workorder_no"> Work Order No. <span class="text-danger">*</span></label>
                {{ Form::text('workorder_no', $workorder->workorder_no, ['class' => 'form-control workorder_no', 'id' => 'workorder_no', 'required', 'readonly']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="cs_no"> CS Ref No. <span class="text-danger">*</span></label>
                {{ Form::text('cs_no', $workorder->workCS->reference_no, ['class' => 'form-control cs_no', 'id' => 'cs_no', 'required', 'readonly']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="supplier_id">Supplier Name<span class="text-danger">*</span></label>
                {{ Form::text('supplier_id', $workorder->supplier->name, ['class' => 'form-control', 'id' => 'supplier_id', 'placeholder' => 'Select Supplier', 'autocomplete' => 'off', 'required', 'readonly']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="cs_type">CS Type <span class="text-danger">*</span></label>
                {{ Form::text('cs_type', $workorder->workCS->cs_type, ['class' => 'form-control', 'id' => 'cs_type', 'readonly', 'required']) }}
            </div>
        </div>
    </div>


    <hr class="bg-success">
    <div class="card">
        <div class="tableHeading">
            <h5> <span>&#10070;</span> Mode Of Payment <span>&#10070;</span> </h5>
        </div>
        <div class="card-body p-1">
            <div class="table-responsive">
                <table id="paymentScheduleTable" class="table text-center table-striped table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>RS-Title</th>
                            <th>Work Status<span class="text-danger">*</span></th>
                            <th>Payable <br> Amount (%)</th>
                            <th> Action </th>
                            <th> <i class="btn btn-success btn-sm fa fa-plus addWork"></i> </th>
                        </tr>
                    </thead>
                    <tbody>    
                        @if($workorder->workOrderSchedules->count())
                            @foreach ($workorder->workOrderSchedules as $parentKey=> $schedule)
                                @foreach ($schedule->workOrderScheduleLines as $key => $line)
                                    <tr class="work_group work_group_{{$parentKey}}">
                                        @if($loop->first)
                                        <td class="rs_title_td" rowspan="{{$schedule->workOrderScheduleLines->count()}}">                             
                                            <input type="text" name="workgroup[work_group_{{$parentKey}}][rs_title]" value="{{$schedule->rs_title}}" class="form-control form-control-sm rs_title" autocomplete="off">
                                        </td>
                                        @endif 
                                        <td>
                                            <textarea name="workgroup[work_group_{{$parentKey}}][work_status][{{$loop->iteration}}]" rows="1" required class="form-control form-control-sm work_status">{{$line->work_status}}</textarea>
                                        </td>
                                        <td>
                                            <input type="text" name="workgroup[work_group_{{$parentKey}}][payment_ratio][{{$loop->iteration}}]" value="{{$line->payment_ratio}}" class="form-control form-control-sm payment_ratio" autocomplete="off" required>
                                        </td>    
                                        <td>
                                            @if($loop->first)
                                            <i class="btn btn-primary btn-sm fa fa-plus addChildRow"></i>
                                            @else
                                            <i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i> 
                                            @endif 
                                        </td>   
                                        @if($loop->first)
                                        <td class="delete_schedule" rowspan="{{$schedule->workOrderScheduleLines->count()}}">
                                            <i class="btn btn-danger btn-sm fa fa-minus deleteGroup"></i>
                                        </td> 
                                        @endif                              
                                    </tr>
                                @endforeach
                            @endforeach
                        @endif    
                 

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr class="bg-success">    
                  
    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@section('script')
    <script>
            $("#paymentScheduleTable")
            .on('click', '.addWork', function() {
                addParentRow($(this));
            })
            .on('click', ".addChildRow", function(){
                addChildRow($(this)); 
            })
            .on('click', '.deleteItem', function() {                
                removeChild($(this)); 
            })
            .on('click', '.deleteGroup', function() {                
                removeGroup($(this)); 
            });

            function addParentRow(parentRow){
                if($(".work_group").length == 0){
                    var totalParent = $(".work_group").length+1; 
                }else{
                    let last_parent = $(".work_group").last().attr('class').split(' ')[1].split('_')[2];
                    var totalParent = (parseInt(last_parent)+1);
                }
                $("#paymentScheduleTable tbody").append(
                    `<tr class="work_group work_group_${totalParent}">
                        <td class="rs_title_td">                             
                            <input type="text" name="workgroup[work_group_${totalParent}][rs_title]" value="" class="form-control form-control-sm rs_title" autocomplete="off">
                        </td>
                        <td>
                            <textarea name="workgroup[work_group_${totalParent}][work_status][1]" rows="1" required class="form-control form-control-sm work_status"></textarea>
                        </td>
                        <td>
                            <input type="text" name="workgroup[work_group_${totalParent}][payment_ratio][1]" value="" class="form-control form-control-sm payment_ratio" autocomplete="off" required>
                        </td>    
                        <td>
                            <i class="btn btn-primary btn-sm fa fa-plus addChildRow"></i>
                        </td>    
                        <td class="delete_schedule">
                            <i class="btn btn-danger btn-sm fa fa-minus deleteGroup"></i>
                        </td>                              
                    </tr>`
                )
            }

            function addChildRow(childRow){
                let totalParent = $(".work_group").length+1; 
                let work_group = $(childRow).closest('tr').attr('class').split(' ')[1];
                let totalChild = $("."+work_group).length + 1;
                $("."+work_group).first().find('.rs_title_td, .delete_schedule').attr('rowspan',totalChild);                
                $("."+work_group).last().after(
                    `
                    <tr class="child_row ${work_group}">                        
                        <td>
                            <textarea name="workgroup[${work_group}][work_status][${totalChild}]" rows="1" required class="form-control form-control-sm work_status"></textarea>
                        </td>
                        <td>
                            <input type="text" name="workgroup[${work_group}][payment_ratio][${totalChild}]" value="" class="form-control form-control-sm payment_ratio" autocomplete="off" required>
                        </td>    
                        <td>
                            <i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i>
                        </td>
                    </tr>
                    `
                )
            }

            function removeChild(childRow){
                $(childRow).closest('tr').remove();
                let work_group = $(childRow).closest('tr').attr('class').split(' ')[1];
                let totalChild = $("."+work_group).length;
                let firstChild = $("."+work_group).first().find('.rs_title_td, .delete_schedule').attr('rowspan',totalChild); 
                // console.log($(".work_group_1").length);                 
            }

            function removeGroup(childRow){
                let work_group = $(childRow).closest('tr').attr('class').split(' ')[1];
                let firstChild = $("."+work_group).remove();
            }

    </script>
@endsection
