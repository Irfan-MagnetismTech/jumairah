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
                    <label class="input-group-addon" for="loanable_type"> Fixed Asset <span class="text-danger">*</span></label>
                    {{Form::select('fixed_asset_id', $fixedAssets, old('fixed_asset_id') ? old('fixed_asset_id') : (!empty($depreciation->fixed_asset_id) ? $depreciation->fixed_asset_id : null),['class' => 'form-control','id' => 'fixed_asset_id', 'placeholder'=>"Select Source",'onchange'=>'getAssetInfo()'])}}
                </div>
            </div>
            <div class="col-xl-6 col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="loanable_type"> Received Date<span class="text-danger">*</span></label>
                    {{Form::text('received_date', old('received_date') ? old('received_date') : (!empty($depreciation) ? $depreciation->asset->received_date : null),['class' => 'form-control','id' => 'received_date', 'placeholder'=>"",'readonly'])}}
                </div>
            </div>
            <div class="col-xl-6 col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="loanable_type"> Useful Life<span class="text-danger">*</span></label>
                    {{Form::text('useful_life', old('useful_life') ? old('useful_life') : (!empty($depreciation) ? $depreciation->asset->life_time : null),['class' => 'form-control','id' => 'useful_life', 'placeholder'=>"",'readonly'])}}
                </div>
            </div>
            <div class="col-xl-6 col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="loanable_type"> Asset Cost<span class="text-danger">*</span></label>
                    {{Form::text('asset_cost', old('asset_cost') ? old('asset_cost') : (!empty($depreciation) ? number_format($depreciation->asset->price,2) : null),['class' => 'form-control','id' => 'asset_cost', 'placeholder'=>"",'readonly'])}}
                </div>
            </div>
            <div class="col-xl-6 col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="loanable_type"> Depreciation Rate<span class="text-danger">*</span></label>
                    {{Form::text('percentage', old('percentage') ? old('percentage') : (!empty($depreciation) ? $depreciation->asset->percentage : null),['class' => 'form-control','id' => 'percentage', 'placeholder'=>"",'readonly'])}}
                </div>
            </div>
            <div class="col-xl-6 col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="loanable_type"> Amount <span class="text-danger">*</span></label>
                    {{Form::number('amount', old('amount') ? old('amount') : (!empty($depreciation->amount) ? $depreciation->amount : null),['class' => 'form-control','id' => 'amount', 'placeholder'=>"Select Source",'step'=>'0.01'])}}
                </div>
            </div>
        </div><!-- end row -->
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
            $('#date, #cheque_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
        });//document.ready()

        function getAssetInfo() {
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
        }
    </script>
@endsection
