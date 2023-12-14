@extends('layouts.backend-layout')
@section('title', 'Allocations')

@section('breadcrumb-title')
    @if(!empty($salary))
        Edit Financial Allocation
    @else
         Financial Allocation
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
        {!! Form::open(array('url' => "accounts/financial-allocations/$salary->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "accounts/financial-allocations",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="col-md-12 p-1" id="" >
            <div class="row py-2">
                <div class="col-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="from_month"> From Month <span class="text-danger">*</span></label>
                        {{Form::month('from_month', old('from_month') ? old('from_month') : (!empty($salary) ?  date('Y-m',strtotime($salary->from_month)) : now()->format('Y-m')),['class' => 'form-control','id' => 'from_month', 'autocomplete'=>"off", 'required'])}}
                    </div>
                </div>
                <div class="col-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="to_month"> To Month <span class="text-danger">*</span></label>
                        {{Form::month('to_month', old('to_month') ? old('to_month') : (!empty($salary) ?  date('Y-m',strtotime($salary->to_month)) : now()->format('Y-m')),['class' => 'form-control','id' => 'to_month', 'autocomplete'=>"off", 'required'])}}
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                    <table class="table table-bordered text-right" id="">
                        <thead class="text-center">
                        <tr style="background-color: #26a68c; color: white">
                            <td colspan="2"><b>Loan Interest Allocations</b></td>
                        </tr>
                        <tr class="bg-dark">
                            <th>Particulars  </th>
                            <th>Amount</th>
                        </tr>
                        <tr>
                            <td class="text-left"><span class="form-control" readonly> SOD Loan Interest</span> </td>
                            <td>{{Form::text('sod_amount', old('sod_amount') ? old('sod_amount') : (!empty($salary) ?  $salary->sod_amount : 0.00),['class' => 'form-control text-right','id' => 'sod_amount', 'autocomplete'=>"off"])}}</td>
                        </tr>
                        <tr>
                            <td class="text-left"><span class="form-control" readonly> HBL Loan Interest</span> </td>
                            <td>{{Form::text('hbl_amount', old('hbl_amount') ? old('hbl_amount') : (!empty($salary) ?  $salary->hbl_amount : 0.00),['class' => 'form-control text-right','id' => 'hbl_amount', 'autocomplete'=>"off"])}}</td>
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
            <table class="table table-bordered text-right " id="allocationTable">
                <thead class="text-center">
                    <tr class="bg-dark">
                        <th>Project Name</th>
                        <th>Inflow</th>
                        <th>Outflow</th>
                        <th>Nagetive Flow</th>
                        <th>SOD</th>
                        <th>HBL </th>
                        <th>Total </th>
                    </tr>
                </thead>
                <tbody class="text-left">

                </tbody>
                <tfoot>
                    <tr>
                        <td>Total </td>
                        <td><span class="form-control" id="totalRevenue" readonly=""></span></td>
                        <td><span class="form-control" id="totalOutflow" readonly=""></span></td>
                        <td><span class="form-control" id="grandTotalNagetiveFlow" readonly=""></span></td>
                        <td><input class="form-control text-right" id="total_sod_allocate" readonly></td>
                        <td><span class="form-control text-right" id="total_hbl_allocate" readonly></span></td>
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
            $("#from_month").on('change', function (){
                addRow();
            })
            $("#sod_amount, #hbl_amount").on('keyup, change', function (){
                addRow()
            })
            function addRow(){
                let from_month = $("#from_month").val();
                let to_month = $("#to_month").val();

                $('#allocationTable tbody').empty();
                const url = '{{url("allocation-loan-interest")}}/' + from_month + '/' + to_month;
                let totalRevenue =0; let totaloutflow=0; let grandTotalNagetiveFlow =0; let totalSodAmount=0;
                let totalDivisionFee =0; let totalDerpreciationFee=0;  let totalArchitectureFee =0; let grandtotalSalary = 0;
                fetch(url)
                    .then((resp) => resp.json())
                    .then(function(loopdata) {
                        $.each(loopdata[0], function (key, dataTotal) {
                            totalRevenue += dataTotal.revenue;
                            totaloutflow += dataTotal.outflow;
                            totalNagetiveFlow  = (dataTotal.revenue - dataTotal.outflow) < 0 ? (dataTotal.revenue - dataTotal.outflow) : 0;
                            grandTotalNagetiveFlow += totalNagetiveFlow ;
                        });

                        $("#hbl_amount").val(loopdata[1]);
                        $("#sod_amount").val(loopdata[2]);
                        $.each(loopdata[0], function (key, data){
                            let totalNagetiveFlow = (data.revenue - data.outflow) < 0 ? (data.revenue - data.outflow) : 0;
                            let sodAmount = $("#sod_amount").val().replace(/,/g, '') > 0 ?  ($("#sod_amount").val().replace(/,/g, '') / grandTotalNagetiveFlow ) * totalNagetiveFlow : 0;
                            totalSodAmount += sodAmount;
                            let divisionFeeAmount = $("#hbl_amount").val().replace(/,/g, '') > 0 ?  ($("#hbl_amount").val().replace(/,/g, '') / grandTotalNagetiveFlow ) * totalNagetiveFlow : 0;
                            totalDivisionFee += divisionFeeAmount;
                           
                            let totalSalary = sodAmount + divisionFeeAmount;
                            grandtotalSalary += totalSalary;
                            let row = `
                                <tr> 
                                    <td class="text-left"> <span class="form-control" readonly> ${data.costCenter[0]['name']}</span>
                                        <input class="form-control text-right" type="hidden" name="cost_center_id[]" value="${data.costCenter[0]['id']}" readonly>
                                    </td>
                                    
                                    <td class="text-right"> <span class="form-control" readonly> ${data.revenue} </span></td>
                                    <td class="text-right"> <span class="form-control" readonly> ${data.outflow} </span></td>
                                    <td class="text-right"> <span class="form-control" readonly> ${totalNagetiveFlow} </span></td>
                                    <td class="text-right"> <input class="form-control text-right sod_allocate" type="text" name="sod_allocate[]" value="${sodAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })}" readonly></td>
                                    <td class="text-right"> <input class="form-control text-right hbl_allocate" type="text" name="hbl_allocate[]" value="${divisionFeeAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })}"></td>
                                    <td class="text-right">
                                        <input class="form-control text-right total_allocation" type="text" name="total_allocation[]" value="${totalSalary.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })}" readonly>
                                        <input class="form-control text-right total_allocation_hidden" type="hidden" name="total_allocation_hidden[]" value="${totalSalary.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })}" readonly>
                                    </td>
                                </tr>
                            `;
                            $('#allocationTable tbody').append(row);
                        });

                        $("#totalRevenue").text(totalRevenue.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#totalOutflow").text(totaloutflow.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#grandTotalNagetiveFlow").text(grandTotalNagetiveFlow.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#total_sod_allocate").val(totalSodAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#total_hbl_allocate").text(totalDivisionFee.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
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

            $(document).on('keyup','#management_fee, #hbl_amount, .construction_project',function (){
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

