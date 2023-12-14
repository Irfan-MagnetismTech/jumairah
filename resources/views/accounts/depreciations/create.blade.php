@extends('layouts.backend-layout')
@section('title', 'Depreciation')

@section('breadcrumb-title')
    @if(!empty($depreciation))
        Depreciation List
    @else
         Add Depreciation
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ route('depreciations.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')

    @if(!empty($depreciation))
        {!! Form::open(array('url' => route('depreciations.update', $depreciation->id),'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => route('depreciations.store'), 'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($depreciation->id) ? $depreciation->id : null)}}">
            <div class="col-xl-6 col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="loanable_type"> Month <span class="text-danger">*</span></label>
                    {{Form::month('month', old('month') ? old('month') : (!empty($depreciation) ? date('Y-m', strtotime($depreciation->month)) : now()->format('Y-m')),['class' => 'form-control','id' => 'month'])}}
                </div>
            </div>
            <div class="col-xl-6 col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="loanable_type">  Date<span class="text-danger">*</span></label>
                    {{Form::text('date', old('date') ? old('date') : (!empty($depreciation) ? $depreciation->date : now()->format('d-m-Y')),['class' => 'form-control','id' => 'date', 'placeholder'=>"",''])}}
                </div>
            </div>
        </div><!-- end row -->
        <br>
        <hr>
    @php
        $assets = old('fixed_asset', !empty($depreciation) ?  $depreciation->depreciationDetails->pluck('asset.tag') : []);
        $assetId = old('fixed_asset_id', !empty($depreciation) ?  $depreciation->depreciationDetails->pluck('fixed_asset_id') : []);
        $useLife = old('useful_life', !empty($depreciation) ?  $depreciation->depreciationDetails->pluck('asset.life_time') : []);
        $rate = old('rate', !empty($depreciation) ?  $depreciation->depreciationDetails->pluck('asset.percentage') : []);
        $cost = old('cost', !empty($depreciation) ?  $depreciation->depreciationDetails->pluck('asset.fixedAssetCosts') : []);
        $amount = old('amount', !empty($depreciation) ?  $depreciation->depreciationDetails->pluck('amount') : []);
    @endphp
        <table class="table table-bordered text-right" id="depreciationTable">
            <thead class="text-center">
            <tr class="bg-dark">
                <th>Asset Name</th>
                <th>Useful Life</th>
                <th>Rate</th>
                <th>Cost</th>
                <th>Amount</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-left">
                @foreach($assets as $key => $asset)
                    <tr>
                        <td>{{Form::text('fixed_asset[]', $assets[$key],['class' => 'form-control', 'readonly'])}}
                            {{Form::hidden('fixed_asset_id[]', $assetId[$key],['class' => 'form-control', 'readonly'])}}
                        </td>
                        <td>{{Form::text('useful_life[]', $useLife[$key],['class' => 'form-control text-center', 'readonly'])}}</td>
                        <td>{{Form::text('rate[]', $rate[$key],['class' => 'form-control text-center', 'readonly'])}}</td>
                        <td>{{Form::text('cost[]', empty(old('cost')[$key]) ? $cost[$key]->flatten()->sum('amount') : '',['class' => 'form-control text-right', 'readonly'])}}</td>
                        <td>{{Form::text('amount[]', $amount[$key],['class' => 'form-control text-right','autocomplete'=>"off"])}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

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
        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            $('#date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

            $("#month").on('change', function (){
                addRow();
            })
            @if(empty($depreciation))
                addRow();
            @endif

            function addRow(){
                let month = $("#month").val();
                $('#depreciationTable tbody').empty();
                const url = '{{url("get-depreciation-assets")}}/' + month;

                fetch(url)
                    .then((resp) => resp.json())
                    .then(function(loopdata) {
                        $.each(loopdata, function (key, data) {
                            let depAmount = (((data.fixed_asset_costs_sum_amount * data.percentage)/12)/100).toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
                            let assetCost = (data.fixed_asset_costs_sum_amount).toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
                            let row = `
                                <tr>
                                    <td class="text-left"><input type="text" name="fixed_asset" class="form-control text-left" value="${data.tag}" readonly>
                                        <input class="form-control text-right" type="hidden" name="fixed_asset_id[]" value="${data.id}" readonly>
                                    </td>
                                    <td class="text-center"><input type="text" name="useful_life" class="form-control text-center" value="${data.life_time}" readonly></td>
                                    <td class="text-center"><input type="text" name="rate" class="form-control text-center" value="${data.percentage}" readonly></td>
                                    <td class="text-right"><input type="text" name="cost" class="form-control text-right" value="${assetCost}" readonly></td>
                                    <td class="text-right">
                                        <input class="form-control text-right" type="text" name="amount[]" value="${depAmount}">
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button>
                                    </td>
                                </tr>
                            `;
                            $('#depreciationTable tbody').append(row);
                        })
                    });
            }

            $(document).on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
            });

        });//document.ready()



        /*function getAssetInfo() {
            const asset_id = $("#fixed_asset_id").val();
            if (asset_id != '') {

                const url = '{{ url('loadAssetInfo') }}/' + asset_id;
                {{--let oldSelectedItem = "{{ old('supplier_id', $workorder->supplier_id ?? '') }}";--}}
                $.getJSON(url, function(items) {
                    let costAmount =0;
                    $(items.fixed_asset_costs).each(function (i , cost){
                        costAmount += parseFloat(cost.amount);
                    })
                    $("#received_date").val(items.received_date)  ;
                    $("#useful_life").val(items.life_time)  ;
                    $("#asset_cost").val(costAmount);
                    $("#percentage").val(items.percentage);
                    $("#amount").val((((costAmount*items.percentage)/12)/100).toFixed(2))  ;
                });
            }
        }*/
    </script>
@endsection
