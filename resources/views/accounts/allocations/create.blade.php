@extends('layouts.backend-layout')
@section('title', 'Allocations')

@section('breadcrumb-title')
    @if(!empty($salary))
        Edit Allocation
    @else
         Allocation
    @endif
@endsection

@section('style')

@endsection

@section('breadcrumb-button')
    <a href="{{ url('accounts/allocations') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    @if(!empty($salary))
        {!! Form::open(array('url' => "accounts/allocations/$salary->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "accounts/allocations",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="col-md-12 p-1" id="" >
            <div class="row py-2">
                <div class="col-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="month"> Month <span class="text-danger">*</span></label>
                        {{Form::month('month', old('month') ? old('month') : (!empty($salary) ?  date('Y-m',strtotime($salary->month)) : now()->format('Y-m')),['class' => 'form-control','id' => 'month', 'autocomplete'=>"off", 'required'])}}
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                    <table class="table table-bordered text-right" id="">
                        <thead class="text-center">
                        <tr style="background-color: #26a68c; color: white">
                            <td colspan="2"><b>Allocations</b></td>
                        </tr>
                        <tr class="bg-dark">
                            <th>Particulars  </th>
                            <th>Amount</th>
                        </tr>
                        <tr>
                            <td class="text-left"><span class="form-control" readonly> Management Fee (1% of Revenue )</span> </td>
                            <td>{{Form::text('management_fee_amount', old('management_fee_amount') ? old('management_fee_amount') : (!empty($salary) ?  $salary->management_fee_amount : null),['class' => 'form-control text-right','id' => 'management_fee_amount', 'autocomplete'=>"off"])}}</td>
                        </tr>
                        <tr>
                            <td class="text-left"><span class="form-control" readonly> Division Fee</span> </td>
                            <td>{{Form::text('division_fee_amount', old('division_fee_amount') ? old('division_fee_amount') : (!empty($salary) ?  $salary->division_fee_amount : null),['class' => 'form-control text-right','id' => 'division_fee_amount', 'autocomplete'=>"off"])}}</td>
                        </tr>
                        <tr>
                            <td class="text-left"><span class="form-control" readonly> Construction Depreciation</span> </td>
                            <td>{{Form::text('depreciation_amount', old('depreciation_amount') ? old('depreciation_amount') : (!empty($salary) ?  $salary->depreciation_amount : null),['class' => 'form-control text-right','id' => 'depreciation_amount', 'autocomplete'=>"off"])}}</td>
                        </tr>
                        <tr>
                            <td class="text-left"><span class="form-control" readonly> Architecture Fee</span> </td>
                            <td>{{Form::text('architecture_fee_amount', old('architecture_fee_amount') ? old('architecture_fee_amount') : (!empty($salary) ?  $salary->architecture_fee_amount : null),['class' => 'form-control text-right','id' => 'architecture_fee_amount', 'autocomplete'=>"off"])}}</td>
                        </tr>
                        </thead>

                        <tbody>

                        </tbody>
                        <tfoot>
{{--                        <tr> <td>Total</td> </tr>--}}
                        </tfoot>
                    </table>

            </div>
            <hr>
            <table class="table table-bordered text-right table-responsive" id="allocationTable">
                <thead class="text-center">
                    <tr class="bg-dark">
                        <th>Project Name</th>
                        <th>Labor</th>
                        <th>Material</th>
                        <th>Total Cost</th>
                        <th>Revenue</th>
                        <th>Management Fee </th>
                        <th>Division Fee </th>
                        <th>Depreciation (Construction) </th>
                        <th>Architecture Fee </th>
                        <th>Total </th>
                    </tr>
                </thead>
                <tbody class="text-left">

                </tbody>
                <tfoot>
                    <tr>
                        <td>Total </td>
                        <td><span class="form-control" id="totalLabor" readonly=""></span></td>
                        <td><span class="form-control" id="totalMaterial" readonly=""></span></td>
                        <td><span class="form-control" id="grandTotalCost" readonly=""></span></td>
                        <td><span class="form-control" id="totalRevenue" readonly=""></span></td>
                        <td><input class="form-control text-right" id="total_management_fee" readonly></td>
                        <td><span class="form-control text-right" id="total_division_fee" readonly></span></td>
                        <td><span class="form-control text-right" id="total_depreciation_fee" readonly></span></td>
                        <td><span class="form-control text-right" id="total_architecture_fee" readonly></span></td>
                        <td><span class="form-control" id="grandtotalSalary" readonly=""></span></td>
                    </tr>
                </tfoot>
            </table>
            <div class="row">
                <div class="offset-md-4 col-md-4 mt-2">
                    <div class="input-group input-group-sm ">
                        <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                    </div>
                </div>
            </div> <!-- end row -->
        </div>

        <!-- end row -->
    {!! Form::close() !!}

@endsection
@section('script')
    <script>
        $(function(){
            addRow();
            $("#month").on('change', function (){
                addRow();
            })
            $("#management_fee_amount, #division_fee_amount, #depreciation_amount, #architecture_fee_amount").on('keyup, change', function (){
                addRow()
            })
            function addRow(){
                let month = $("#month").val();

                $('#allocationTable tbody').empty();
                const url = '{{url("get-allocation-cost")}}/' + month;
                let totalLabour =0; let totalMaterial =0; let totalRevenue =0; let grandTotalCost =0; let totalManagementFee=0;
                let totalDivisionFee =0; let totalDerpreciationFee=0;  let totalArchitectureFee =0; let grandtotalSalary = 0;
                fetch(url)
                    .then((resp) => resp.json())
                    .then(function(loopdata) {
                        $.each(loopdata, function (key, dataTotal) {
                            totalLabour += dataTotal.labors;
                            totalMaterial += dataTotal.material;
                            totalRevenue += dataTotal.revenue;
                            grandTotalCost += dataTotal.labors + dataTotal.material ;
                        });
                        let managementFeeAmountSet = (totalRevenue * 0.01).toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
                        $("#management_fee_amount").val(managementFeeAmountSet)

                        $.each(loopdata, function (key, data){
                            let totalCost = data.labors + data.material;
                            let managementFeeAmount = $("#management_fee_amount").val().replace(/,/g, '') > 0 ?  ($("#management_fee_amount").val().replace(/,/g, '') / totalRevenue ) * data.revenue : 0;
                            totalManagementFee += managementFeeAmount;
                            let divisionFeeAmount = $("#division_fee_amount").val().replace(/,/g, '') > 0 ?  ($("#division_fee_amount").val().replace(/,/g, '') / grandTotalCost ) * totalCost : 0;
                            totalDivisionFee += divisionFeeAmount;
                            let DepreciationAmount = $("#depreciation_amount").val().replace(/,/g, '') > 0 ?  ($("#depreciation_amount").val().replace(/,/g, '') / grandTotalCost ) * totalCost : 0;
                            totalDerpreciationFee += DepreciationAmount;
                            let architectureAmount = $("#architecture_fee_amount").val().replace(/,/g, '') > 0 ?  ($("#architecture_fee_amount").val().replace(/,/g, '') / grandTotalCost ) * totalCost : 0;
                            totalArchitectureFee += architectureAmount;
                            let totalSalary = managementFeeAmount + divisionFeeAmount + DepreciationAmount + architectureAmount;
                            grandtotalSalary += totalSalary;
                            let row = `
                                <tr>
                                    <td class="text-left"> <span class="form-control" readonly> ${data.costCenter[0]['name']}</span>
                                        <input class="form-control text-right" type="hidden" name="cost_center_id[]" value="${data.costCenter[0]['id']}" readonly>
                                    </td>
                                    <td class="text-right"> <span class="form-control labor s" readonly>${data.labors.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })} </span></td>
                                    <td class="text-right"> <span class="form-control" readonly>${data.material.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })} </span></td>
                                    <td class="text-right"> <span class="form-control" readonly> ${totalCost.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })} </span></td>
                                    <td class="text-right"> <span class="form-control" readonly> ${data.revenue.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })} </span></td>
                                    <td class="text-right"> <input class="form-control text-right management_fee" type="text" name="management_fee[]" value="${managementFeeAmount}" readonly></td>
                                    <td class="text-right"> <input class="form-control text-right division_fee" type="text" name="division_fee[]" value="${divisionFeeAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })}"></td>
                                    <td class="text-right"> <input class="form-control text-right construction_depreciation" type="text" name="construction_depreciation[]" value="${DepreciationAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })}"></td>
                                    <td class="text-right"> <input class="form-control text-right architecture_fee" type="text" name="architectureFee[]" value="${architectureAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })}"></td>
                                    <td class="text-right">
                                        <input class="form-control text-right total_allocation" type="text" name="total_allocation[]" value="${totalSalary.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })}" readonly>
                                        <input class="form-control text-right total_allocation_hidden" type="hidden" name="total_allocation_hidden[]" value="${totalSalary.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })}" readonly>
                                    </td>
                                </tr>
                            `;
                            $('#allocationTable tbody').append(row);
                        });

                        $("#totalLabor").text(totalLabour.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#totalMaterial").text(totalMaterial.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#grandTotalCost").text(grandTotalCost.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#totalRevenue").text(totalRevenue.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#total_management_fee").val(totalManagementFee.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#total_division_fee").text(totalDivisionFee.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#total_depreciation_fee").text(totalDerpreciationFee.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#total_architecture_fee").text(totalArchitectureFee.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#grandtotalSalary").text(grandtotalSalary.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                    })
            }

            function changeAllocationTotal (thisVal){
                let construction_project = parseFloat($(thisVal).closest('tr').find('.construction_project').val()) > 0 ? parseFloat($(thisVal).closest('tr').find('.construction_project').val().replace(/,/g, '')) : 0;
                let total_allocation_hidden = parseFloat($(thisVal).closest('tr').find('.total_allocation_hidden').val()) > 0 ? parseFloat($(thisVal).closest('tr').find('.total_allocation_hidden').val().replace(/,/g, '')) : 0;
                $(thisVal).closest('tr').find('.total_allocation').val((construction_project + total_allocation_hidden).toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }

            function totalConstructionProject(){
                var totalConstructionProject = 0;
                if($(".construction_project").length > 0){
                    $(".construction_project").each(function(i, row){
                        let amountTK = Number($(row).val().replace(/,/g, ''));
                        totalConstructionProject += parseFloat(amountTK);
                        console.log(totalConstructionProject)
                    })
                }
                $("#total_construction_project").val(totalConstructionProject.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }

            $(document).on('keyup', '.construction_project', function (){
                changeAllocationTotal(this);
                totalConstructionProject();
            })

            $(document).on('keyup','#management_fee, #division_fee_amount, #depreciation_amount, #architecture_fee_amount, .construction_project',function (){
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
        }); //document.ready

    </script>
@endsection

