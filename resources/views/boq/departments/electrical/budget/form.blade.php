
@csrf

<div class="table-responsive">
    <table id="purchaseTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="700px">Head Name</th>
                <th width="200px" >Specification</th>
                <th width="200px" >Brand/Origin</th>
                <th width="200px" >Rate</th>
                <th width="200px" >Quantity</th>
                <th width="200px" >Amount</th>
                {{-- @if($formType == 'create')
                <th></th>
                @endif --}}

            </tr>
        </thead>

        <tbody>
            @if($formType == 'create')


            <?php
            $EmeBudgetHeadNames = old('name', !empty($laborCostData) ?  $laborCostData->name : $EmeBudgetHeadData->pluck('name','id'));
            ?>
            @foreach ($EmeBudgetHeadNames as $key => $EmeBudgetHeadName)

            <tr>
                <td>
                    {{Form::text('name[]', $EmeBudgetHeadName,['class' => 'form-control name text-left wrap-text','id' => 'name', 'autocomplete'=>"off", 'readonly', 'tabindex' => '-1'])}}
                    {{Form::hidden('budget_head_id[]', $key,['class' => 'form-control budget_head_id text-left wrap-text','id' => 'budget_head_id', 'autocomplete'=>"off", 'readonly'])}}
                </td>
                <td>
                    <input type="text" name="specification[]" value="" class="form-control specification text-center" autocomplete="off" >
                </td>
                <td>
                    <input type="text" name="brand[]" value="" class="form-control brand text-center" autocomplete="off" >
                </td>
                <td>
                    <input type="text" name="rate[]" value="" class="form-control rate text-center" id="rate" autocomplete="off" placeholder="0.00">
                </td>
                <td>
                    <input type="text" name="quantity[]" value="" class="form-control quantity text-center" id="quantity" autocomplete="off" placeholder="0.00">
                </td>
                <td>
                    <input type="text" name="amount[]" value="" class="form-control amount text-center" id="amount" autocomplete="off" placeholder="0.00" readonly tabindex="-1">
                </td>
                {{-- @if($formType == 'create')
                    <td class="text-center">
                        <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button" tabindex="-1">
                            <i class="fa fa-minus"></i>
                        </button>
                    </td>
                @endif --}}
            </tr>
            @endforeach
            @else
            {{-- <input type="hidden" name="id" value="{{$BoqEmeBudget->id}}" class="form-control specification text-center" autocomplete="off" > --}}
            {{-- @dd($BoqEmeBudget) --}}
            {{-- @if (!empty($BoqEmeBudget))
                @foreach ($BoqEmeBudget as $key => $BoqEmeBudget1)
                <tr>
                    <td>
                        {{Form::text('name[]', $BoqEmeBudget1->EmeBudgetHead->name,['class' => 'form-control name text-left wrap-text','id' => 'name', 'autocomplete'=>"off", 'readonly', 'tabindex' => '-1'])}}
                        {{Form::hidden('budget_head_id[]',$BoqEmeBudget1->budget_head_id,['class' => 'form-control budget_head_id text-left wrap-text','id' => 'budget_head_id', 'autocomplete'=>"off", 'readonly'])}}
                    </td>
                    <td>
                        <input type="text" name="specification[]" value="{{ $BoqEmeBudget1->specification }}" class="form-control specification text-center" autocomplete="off" >
                    </td>
                    <td>
                        <input type="text" name="brand[]" value="{{ $BoqEmeBudget1->brand }}" class="form-control brand text-center" autocomplete="off" >
                    </td>
                    <td>
                        <input type="text" name="rate[]" value="{{ $BoqEmeBudget1->rate }}" class="form-control rate text-center" id="rate" autocomplete="off" placeholder="0.00">
                    </td>
                    <td>
                        <input type="text" name="quantity[]" value="{{ $BoqEmeBudget1->quantity }}" class="form-control quantity text-center" id="quantity" autocomplete="off" placeholder="0.00">
                    </td>
                    <td>
                        <input type="text" name="amount[]" value="{{ $BoqEmeBudget1->amount }}" class="form-control amount text-center" id="amount" placeholder="0.00" autocomplete="off" placeholder="0.00" readonly tabindex="-1">
                    </td>
                </tr> --}}
                {{-- @endforeach
            @endif  --}}

            @if (!empty($BoqEmeBudget))
                @php
                    $EmeBudgetHeads = App\Boq\Departments\Eme\EmeBudgetHead::orderBy('id')->pluck('name', 'id');
                @endphp
            @foreach ($EmeBudgetHeads as $key => $value)
                @php
                    $BoqEmeBudget1 = null;
                @endphp

            @foreach ($BoqEmeBudget as $budgetItem)
                @if ($key == $budgetItem->budget_head_id)
                    @php
                        $BoqEmeBudget1 = $budgetItem;
                    @endphp
                @endif
            @endforeach

            <tr>
                <td>
                    @if ($BoqEmeBudget1)
                        {{ Form::text('name[]', $BoqEmeBudget1->EmeBudgetHead->name, ['class' => 'form-control name text-left wrap-text', 'id' => 'name', 'autocomplete' => 'off', 'readonly', 'tabindex' => '-1']) }}
                        {{ Form::hidden('budget_head_id[]', $BoqEmeBudget1->budget_head_id, ['class' => 'form-control budget_head_id text-left wrap-text', 'id' => 'budget_head_id', 'autocomplete' => 'off', 'readonly']) }}
                    @else
                        {{ Form::text('name[]', $value, ['class' => 'form-control name text-left wrap-text', 'id' => 'name', 'autocomplete' => 'off', 'readonly', 'tabindex' => '-1']) }}
                        {{ Form::hidden('budget_head_id[]', $key, ['class' => 'form-control budget_head_id text-left wrap-text', 'id' => 'budget_head_id', 'autocomplete' => 'off', 'readonly']) }}
                    @endif
                </td>
                <td>
                    <input type="text" name="specification[]" value="{{ $BoqEmeBudget1 ? $BoqEmeBudget1->specification : '' }}" class="form-control specification text-center" autocomplete="off">
                </td>
                <td>
                    <input type="text" name="brand[]" value="{{ $BoqEmeBudget1 ? $BoqEmeBudget1->brand : '' }}" class="form-control brand text-center" autocomplete="off">
                </td>
                <td>
                    <input type="text" name="rate[]" value="{{ $BoqEmeBudget1 ? $BoqEmeBudget1->rate : "" }}" class="form-control rate text-center" id="rate" autocomplete="off" placeholder="0.00">
                </td>
                <td>
                    <input type="text" name="quantity[]" value="{{ $BoqEmeBudget1 ? $BoqEmeBudget1->quantity : "" }}" class="form-control quantity text-center" id="quantity" autocomplete="off" placeholder="0.00">
                </td>
                <td>
                    <input type="text" name="amount[]" value="{{ $BoqEmeBudget1 ? $BoqEmeBudget1->amount : '' }}" class="form-control amount text-center" id="amount" placeholder="0.00" autocomplete="off" readonly tabindex="-1">
                </td>
            </tr>
        @endforeach
    @endif
@endif
        </tbody>
        <tfoot>
            {{-- @if($formType == 'create') --}}
            <tr>
                <td colspan="5" class="text-right">Total </td>
                <td>{{ Form::number('total', old('total', $purchaseOrder->total ?? null), ['class' => 'form-control form-control-sm total text-center', 'id' => 'total', 'placeholder' => '0.00 ', 'readonly', 'tabindex' => '-1']) }}
                </td>
            </tr>
            {{-- @endif --}}
        </tfoot>
    </table>
</div>

@section('script')
    <script>

        // Function for deleting a row
        // function removQRow(qval) {
        //     var rowIndex = qval.parentNode.parentNode.rowIndex;
        //     document.getElementById("purchaseTable").deleteRow(rowIndex);
        //     totalOperation();
        // }

        // Function for calculating total price
        function calculateTotalPrice(thisVal) {
            let rate = $(thisVal).closest('tr').find('.rate').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.rate').val()) : 0;
            let quantity = $(thisVal).closest('tr').find('.quantity').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.quantity').val()) : 0;
            let total = (rate * quantity).toFixed(2);
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
            $(document).on('keyup change', '.quantity, .rate', function() {
                calculateTotalPrice(this);
            });
        });


    </script>
@endsection
