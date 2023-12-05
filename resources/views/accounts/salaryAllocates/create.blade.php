@extends('layouts.backend-layout')
@section('title', 'Allocations')

@section('breadcrumb-title')
    @if(!empty($salary))
        Edit Salary Allocation
    @else
        Salary Allocation
    @endif
@endsection

@section('style')

@endsection

@section('breadcrumb-button')
    <a href="{{ url('accounts/salary-allocates') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    @if(!empty($salary))
        {!! Form::open(array('url' => "accounts/salary-allocates/$salary->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "accounts/salary-allocates",'method' => 'POST', 'class'=>'custom-form')) !!}
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
                <table class="table table-bordered text-right" id="salaryTable">
                        <thead class="text-center">
                        <tr style="background-color: #26a68c; color: white">
                            <td colspan="2"><b>Common Salary</b></td>
                        </tr>
                        <tr class="bg-dark">
                            <th>Department to be Allocated </th>
                            <th>Gross Salary</th>
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
                        <th>Construction (HO)</th>
                        <th>ICMD</th>
                        <th>Architecture & Design</th>
                        <th>Supply Chain </th>
                        <th>Construction (Project) </th>
                        <th>Contract Salary  </th>
                        <th>Total </th>
                    </tr>
                </thead>
                <tbody class="text-left">
                    {{--@foreach($projects as $project)
                        <tr>
                            <td>{{$project->costCenter->name}}</td>
                            <td>{{Form::text('construction', old('construction') ? old('construction') : (!empty($salary) ?  date('Y-m',strtotime($salary->month)) : null),['class' => 'form-control', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('icmd', old('icmd') ? old('icmd') : (!empty($salary) ?  date('Y-m',strtotime($salary->icmd)) : null),['class' => 'form-control', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('architecture', old('architecture') ? old('architecture') : (!empty($salary) ?  date('Y-m',strtotime($salary->architecture)) : null),['class' => 'form-control', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('supply_chain', old('supply_chain') ? old('supply_chain') : (!empty($salary) ?  date('Y-m',strtotime($salary->supply_chain)) : null),['class' => 'form-control', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('total', old('total') ? old('total') : (!empty($salary) ?  date('Y-m',strtotime($salary->total)) : null),['class' => 'form-control', 'autocomplete'=>"off"])}}</td>
                        </tr>
                    @endforeach--}}
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total </td>
                        <td><span class="form-control" id="totalLabor" readonly=""></span></td>
                        <td><span class="form-control" id="totalMaterial" readonly=""></span></td>
                        <td><span class="form-control" id="grandTotalCost" readonly=""></span></td>
                        <td><span class="form-control" id="totalConstruction" readonly=""></span></td>
                        <td><span class="form-control" id="totalIcmd" readonly=""></span></td>
                        <td><span class="form-control" id="totalarchitecture" readonly=""></span></td>
                        <td><span class="form-control" id="totalsupplyChain" readonly=""></span></td>
                        <td><input class="form-control text-right" id="total_construction_project" readonly></td>
                        <td><input class="form-control text-right" id="total_contractual_salary" readonly></td>
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
            function addRow(){
                let month = $("#month").val();

                const salaryurl = '{{url("get-allocation-salary")}}/' + month;
                $('#salaryTable tbody').empty();
                fetch(salaryurl)
                    .then((resp) => resp.json())
                    .then(function(salaryloop) {
                        $.each(salaryloop, function (key, salarydata){
                            let grossSalary = ((salarydata.gross_salary));
                            let salaryrow = `
                                <tr>
                                    <td class="text-left"> <span class="form-control" readonly>${salarydata.salary_heads.name}</span></td>
                                    <td class="text-right "> <span class="form-control" readonly> ${grossSalary.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })}</span></td>
                                </tr>
                            `;
                            $('#salaryTable tbody').append(salaryrow);
                        })
                    })

                $('#allocationTable tbody').empty();
                const url = '{{url("get-salary-allocation-cost")}}/' + month;
                let totalLabour =0; let totalMaterial =0; let grandTotalCost =0; let totalConstruction =0; let totalIcmd =0;
                let totalarchitecture =0; let totalsupplyChain =0; let grandtotalSalary = 0;
                fetch(url)
                    .then((resp) => resp.json())
                    .then(function(loopdata) {
                        $.each(loopdata, function (key, dataTotal) {
                            totalLabour += dataTotal.labors;
                            totalMaterial += dataTotal.material;
                            grandTotalCost += dataTotal.labors + dataTotal.material;
                        });
                        $.each(loopdata, function (key, data){
                            let totalCost = data.labors + data.material;
                            let constructionAmount = data.construction > 0 ?  (data.construction / grandTotalCost ) * totalCost : 0;
                            totalConstruction += constructionAmount;
                            let icmdAmount = data.icmd > 0 ?  (data.icmd / grandTotalCost ) * totalCost : 0;
                            totalIcmd += icmdAmount;
                            let architectureAmount =  data.architecture > 0 ?  (data.architecture / grandTotalCost ) * totalCost : 0;
                            totalarchitecture += architectureAmount;
                            let supplyChainAmount = data.supplyChain > 0 ?  (data.supplyChain / grandTotalCost ) * totalCost : 0;
                            totalsupplyChain += supplyChainAmount;
                            let totalSalary = constructionAmount + icmdAmount + architectureAmount + supplyChainAmount;
                            grandtotalSalary += totalSalary;
                            let row = `
                                <tr>
                                    <td class="text-left"> <span class="form-control" readonly> ${data.costCenter[0]['name']}</span>
                                        <input class="form-control text-right" type="hidden" name="cost_center_id[]" value="${data.costCenter[0]['id']}" readonly>
                                    </td>
                                    <td class="text-right"> <span class="form-control labors" readonly>${data.labors.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })} </span></td>
                                    <td class="text-right"> <span class="form-control" readonly>${data.material.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })} </span></td>
                                    <td class="text-right"> <span class="form-control" readonly> ${totalCost.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })} </span></td>
                                    <td class="text-right"> <input class="form-control text-right" type="text" name="construction_head_office[]" value="${constructionAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })}" readonly></td>
                                    <td class="text-right"> <input class="form-control text-right" type="text" name="icmd[]" value="${icmdAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })}" readonly></td>
                                    <td class="text-right"> <input class="form-control text-right" type="text" name="architecture[]" value="${architectureAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })}" readonly></td>
                                    <td class="text-right"> <input class="form-control text-right" type="text" name="supply_chain[]" value="${supplyChainAmount.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })}" readonly></td>
                                    <td class="text-right"> <input class="form-control text-right construction_project" type="text" name="construction_project[]" value=""></td>
                                    <td class="text-right"> <input class="form-control text-right contractual_salary" type="text" name="contractual_salary[]" value=""></td>
                                    <td class="text-right">
                                        <input class="form-control text-right total_salary" type="text" name="total_salary[]" value="${totalSalary.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })}" readonly>
                                        <input class="form-control text-right total_salary_hidden" type="hidden" name="total_salary_hidden[]" value="${totalSalary.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 })}" readonly>
                                    </td>
                                </tr>
                            `;
                            $('#allocationTable tbody').append(row);
                        })
                        $("#totalLabor").text(totalLabour.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#totalMaterial").text(totalMaterial.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#grandTotalCost").text(grandTotalCost.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#totalConstruction").text(totalConstruction.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#totalIcmd").text(totalIcmd.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#totalarchitecture").text(totalarchitecture.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#totalsupplyChain").text(totalsupplyChain.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                        $("#grandtotalSalary").text(grandtotalSalary.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
                    })
            }

            function changeSalaryTotal (thisVal){
                let construction_project = parseFloat($(thisVal).closest('tr').find('.construction_project').val()) > 0 ? parseFloat($(thisVal).closest('tr').find('.construction_project').val().replace(/,/g, '')) : 0;
                let contractual_salary = parseFloat($(thisVal).closest('tr').find('.contractual_salary').val()) > 0 ? parseFloat($(thisVal).closest('tr').find('.contractual_salary').val().replace(/,/g, '')) : 0;
                let total_salary_hidden = parseFloat($(thisVal).closest('tr').find('.total_salary_hidden').val()) > 0 ? parseFloat($(thisVal).closest('tr').find('.total_salary_hidden').val().replace(/,/g, '')) : 0;
                console.log(contractual_salary);
                $(thisVal).closest('tr').find('.total_salary').val((construction_project + total_salary_hidden + contractual_salary).toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }

            function totalConstructionProject(){
                var totalConstructionProject = 0;
                if($(".construction_project").length > 0){
                    $(".construction_project").each(function(i, row){
                        let amountTK = Number($(row).val().replace(/,/g, ''));
                        totalConstructionProject += parseFloat(amountTK);
                        // console.log(totalConstructionProject)
                    })
                }
                $("#total_construction_project").val(totalConstructionProject.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }

            $(document).on('keyup', '.construction_project', function (){
                changeSalaryTotal(this);
                totalConstructionProject();
            })

            function totalContractualSalary(){
                var totalContractualSalary = 0;
                if($(".contractual_salary").length > 0){
                    $(".contractual_salary").each(function(i, row){
                        let amountTK = Number($(row).val().replace(/,/g, ''));
                        totalContractualSalary += parseFloat(amountTK);
                        // console.log(totalContractualSalary)
                    })
                }
                $("#total_contractual_salary").val(totalContractualSalary.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }

            $(document).on('keyup', '.contractual_salary', function (){
                changeSalaryTotal(this);
                totalContractualSalary();
            })

            $(document).on('keyup','.construction_project, .contractual_salary',function (){
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

