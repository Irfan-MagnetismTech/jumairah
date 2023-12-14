@extends('layouts.backend-layout')
@section('title', 'Store Issue')

@section('breadcrumb-title')
    @if(!empty($storeissue))
        Edit Store Issue Note
    @else
        Add Store Issue Note
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('storeissues') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    {!! Form::open(array('url' => "StoreIssueApprovedStore",'method' => 'POST', 'class'=>'custom-form')) !!}
    <input type="hidden" name="storeIssue_id" value="{{(!empty($storeissue->id) ? $storeissue->id : null)}}">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Project Name<span class="text-danger">*</span></label>
                    {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($storeissue) ? $storeissue->costCenter->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off","required", 'readonly'])}}
                    {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($storeissue) ? $storeissue->costCenter->project_id: null),['class' => 'form-control','id' => 'project_id', 'autocomplete'=>"off"])}}
                    {{Form::hidden('cost_center_id', old('cost_center_id') ? old('cost_center_id') : (!empty($storeissue) ? $storeissue->cost_center_id : null),['class' => 'form-control','id' => 'cost_center_id', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="sin_no">SIN No.<span class="text-danger">*</span></label>
                    {{Form::number('sin_no', old('sin_no') ? old('sin_no') : (!empty($storeissue->sin_no) ? $storeissue->sin_no : null),['class' => 'form-control','id' => 'sin_no','autocomplete'=>"off","readonly"])}}
                </div>
            </div>

            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="srf_no">SRF No.<span class="text-danger">*</span></label>
                    {{Form::text('srf_no', old('srf_no') ? old('srf_no') : (!empty($storeissue->srf_no) ? $storeissue->srf_no : null),['class' => 'form-control','id' => 'srf_no','autocomplete'=>"off","readonly"])}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="date">Date<span class="text-danger">*</span></label>
                    {{Form::text('date', old('date') ? old('date') : (!empty($storeissue->date) ? $storeissue->date : null),['class' => 'form-control','id' => 'date','autocomplete'=>"off","readonly"])}}
                </div>
            </div>

        </div><!-- end row -->

        {{-- <div id="material_and_quantity">
        </div> --}}

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
            <tr>
{{--                <th width="200px">Floor Name</th>--}}
                <th>Material Name <span class="text-danger">*</span></th>
                <th>Unit</th>
                <th>Accounts Head<span class="text-danger">*</span></th>
                <th>MRR<br>Quantity</th>
                {{--                <th>Ledger Folio No.<span class="text-danger">*</span></th>--}}
                <th>Issued <br> Quantity<span class="text-danger">*</span></th>
                {{--                <th>Purpose of Works<span class="text-danger">*</span></th>--}}
                <th>Notes</th>
            </tr>
            </thead>
            <tbody>

            @if(!empty($storeissue))
                @foreach($storeissue->storeissuedetails as $storeissuedetail)
                    <tr>
                        <td>
                            <input type="text" name="material_name[]"   value="{{$storeissuedetail->nestedMaterials->name}}" class="form-control text-center form-control-sm material_name" readonly>
                            <input type="hidden" name="material_id[]" value="{{$storeissuedetail->nestedMaterials->id}}" class="form-control form-control-sm text-center material_id" >
                        </td>
                        <td><input type="text" name="unit[]"  value="{{$storeissuedetail->nestedMaterials->unit->name}}" class="form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                        <td>{{Form::select('account_id[]', $accounts, old('account_id') ? old('account_id') : (!empty($account) ? $account->account_id : null),['class' => 'form-control','autocomplete'=>"off", 'placeholder'=>"Select Account"])}}</td>
                        <td><input type="text" name="mrr_quantity[]"  value="{{$storeissuedetail->quantity}}" class="form-control text-center form-control-sm mrr_quantity" readonly tabindex="-1"></td>
                        {{--                            <td><input type="text" name="ledger_folio_no[]" value="{{$storeissuedetail->ledger_folio_no}}" class="form-control text-center form-control-sm ledger_folio_no" autocomplete="off" ></td>--}}
                        <td><input type="number" name="issued_quantity[]" value="{{$storeissuedetail->issued_quantity}}" class="form-control text-center form-control-sm issued_quantity" readonly  autocomplete="off"></td>
                        {{--                            <td> <textarea name="purpose[]" class ='form-control text-center' id ='purpose' rows=1>{{$storeissuedetail->purpose}}</textarea></td>--}}
                        <td> <textarea name="notes[]" class ='form-control text-center' readonly id ='notes' rows=1>{{$storeissuedetail->notes}}</textarea></td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
        <div class="row">
            <div class="offset-md-4 col-md-4 mt-2">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                </div>
            </div>
        </div> <!-- end row -->
    {!! Form::close() !!}
@endsection


@section('script')
    <script>




    </script>
@endsection
