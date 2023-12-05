@extends('boq.departments.sanitary.layout.app')
@section('title', 'BOQ - Sanitary')

@section('breadcrumb-title')
    Create Project Wise Labor Cost
@endsection

@section('project-name')
    {{session()->get('project_name')}}
@endsection

@section('breadcrumb-button')
{{--    @include('components.buttons.breadcrumb-button', ['route' => route('boq.project.departments.electrical.configurations.rates.index',['project' => Session::get('project_id')]), 'type' => 'index'])--}}
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    <div class="row">
        <div class="col-md-12">
            @php($project = session()->get('project_id'))
            @if(!empty($SanitaryLaborCostData))
                {!! Form::open(array('url' => "boq/project/$project/departments/sanitary/project-wise-labor-cost/$SanitaryLaborCostData->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
            @else
                {!! Form::open(array('url' => "boq/project/$project/departments/sanitary/project-wise-labor-cost",'method' => 'POST', 'class'=>'custom-form')) !!}
            @endif


                
            <div class="table-responsive">

                <table id="purchaseTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="700px">Item Name<span class="text-danger">*</span></th>
                            <th width="200px" >Unit</th>
                            <th width="200px" >Rate Per Unit</th>
                            <th width="200px" >Quantity<span class="text-danger">*</span></th>
                            <th width="200px" >Amount</th>
                            <th></th>
                        </tr>
                    </thead>

                    <?php 
                        $laborCostNames = old('name', !empty($laborCostData) ?  $laborCostData->name : $laborCostDetails->pluck('name','id')); 
                        $laborCostUnit = old('unit', !empty($laborCostData) ?  $laborCostData->name : $laborCostDetails->pluck('unit.name', 'id'));
                        $laborCostRate = old('rate_per_unit', !empty($laborCostData) ?  $laborCostData->rate_per_unit : $laborCostDetails->pluck('rate_per_unit','id'));
                        $laborCostQuantity = old('quantity', !empty($laborCostData) ?  $laborCostData->quantity : []);
                        $laborCostAmount = old('amount', !empty($laborCostData) ?  $laborCostData->amount : []);
                    ?>
                    

                    <tbody>
                        @foreach ($laborCostNames as $key => $laborCostName)
                        <tr>
                            <td>
                                {{Form::text('name[]', $laborCostName,['class' => 'form-control name text-left wrap-text','id' => 'name', 'autocomplete'=>"off", 'readonly', 'tabindex' => '-1'])}}
                                {{Form::hidden('labor_cost_id[]', $key,['class' => 'form-control labor_cost_id text-left wrap-text','id' => 'labor_cost_id', 'autocomplete'=>"off", 'readonly'])}}
                            </td>
                            <td>
                                {{Form::text('unit[]', $laborCostUnit[$key],['class' => 'form-control unit text-center','id' => 'unit', 'readonly', 'tabindex' => '-1'])}}
                            </td>
                            <td>
                                {{Form::text('rate_per_unit[]', $laborCostRate[$key],['class' => 'form-control rate_per_unit text-center','id' => 'rate_per_unit', 'tabindex' => '-1'])}}
                            </td>
                            <td>
                                <input type="text" name="quantity[]" value="" class="form-control quantity text-center" autocomplete="off" placeholder="0.00" required>
                            </td>
                            <td>
                                <input type="text" name="amount[]" value="" class="form-control amount text-center" autocomplete="off" placeholder="0.00" readonly tabindex="-1">
                            </td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button" tabindex="-1">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right">Total </td>
                            <td>{{ Form::number('total', old('total', $purchaseOrder->total ?? null), ['class' => 'form-control form-control-sm total text-center', 'id' => 'total', 'placeholder' => '0.00 ', 'readonly']) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
                <div class="row">
                    <div class="offset-md-4 col-md-4 mt-2">
                        <div class="input-group input-group-sm ">
                            <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('script')
    <script>

        // Function for deleting a row
        function removQRow(qval) {
            var rowIndex = qval.parentNode.parentNode.rowIndex;
            document.getElementById("purchaseTable").deleteRow(rowIndex); 
            totalOperation();
        }

        // Function for calculating total price
        function calculateTotalPrice(thisVal) {
            let rate_per_unit = $(thisVal).closest('tr').find('.rate_per_unit').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.rate_per_unit').val()) : 0;
            let quantity = $(thisVal).closest('tr').find('.quantity').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.quantity').val()) : 0;
            let total = (rate_per_unit * quantity).toFixed(2);
            $(thisVal).closest('tr').find('.amount').val(total);
            totalOperation();
        }

        // Function for calculating total price
        function totalOperation() {
            var total = 0;
            if ($(".amount").length > 0) {
                $(".amount").each(function(i, row) {
                    var amount = Number($(row).val());
                    total += parseFloat(amount);
                })
            }
            $("#total").val(total.toFixed(2));
        }

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {
            $(document).on('keyup change', '.quantity, .rate_per_unit', function() {
                calculateTotalPrice(this);
            });
        });
        

    </script>
@endsection
