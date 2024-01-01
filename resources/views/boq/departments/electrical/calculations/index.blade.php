@extends('boq.departments.electrical.layout.app')
@section('title', 'BOQ - Calculation List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Calculation
@endsection

@section('breadcrumb-button')
{{--    @can('project-create')--}}
        <a href="{{ route('boq.project.departments.electrical.calculations.create',['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
        <a href="{{ route('boq.project.departments.electrical.calculation.pdf',['project' => $project]) }}" data-toggle="tooltip" title="PDF" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a>
{{--    @endcan--}}
@endsection

@section('sub-title')
@endsection

    @section('content')
            <!-- search form here.. -->
            <form action="" method="get">
                <div class="row px-2">
                    <div class="col-md-3 px-1 my-1">
                        <select class="form-control budget_head_id" id="budget_head_id" name="budget_head_id" required>
                            <option value="">Select Head</option>
                            @foreach ($EmeBudgetHeads as $EmeBudgetHead)
                                <option value="{{ $EmeBudgetHead->id }}" {{ request('budget_head_id') == $EmeBudgetHead->id ? 'selected' : '' }}>
                                    {{ $EmeBudgetHead->name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 px-1 my-1">
                        <select class="form-control item_id" id="item_id" name="item_id">
                            <option value="">Select Item</option>
                            @foreach ($boqEmeRates as $boqEmeRate)
                                <option value="{{ $boqEmeRate->parent_id_second }}" {{ request('item_id') == $boqEmeRate->parent_id_second ? 'selected' : '' }}>
                                    {{ $boqEmeRate->NestedMaterialSecondLayer->name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1 px-1 my-2">
                        <div class="input-group input-group-sm">
                            <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div><!-- end row -->
            </form>
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th style="width: 250px;word-wrap:break-word">Grp</th>
                <th style="width: 250px;word-wrap:break-word">Unit</th>
                <th style="width: 250px;word-wrap:break-word">Quantity</th>
                <th style="width: 250px;word-wrap:break-word">Material Rate</th>
                {{-- <th style="width: 250px;word-wrap:break-word">Labour Rate</th> --}}
                <th style="width: 250px;word-wrap:break-word">Material Amount</th>
                {{-- <th style="width: 250px;word-wrap:break-word">Labor Amount</th> --}}
                {{-- <th style="width: 250px;word-wrap:break-word">Total Amount</th> --}}
                <th style="width: 250px;word-wrap:break-word">Remarks</th>
                <th style="width: 250px;word-wrap:break-word">Total</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th style="width: 250px;word-wrap:break-word">Grp</th>
                <th style="width: 250px;word-wrap:break-word">Unit</th>
                <th style="width: 250px;word-wrap:break-word">Quantity</th>
                <th style="width: 250px;word-wrap:break-word">Material Rate</th>
                {{-- <th style="width: 250px;word-wrap:break-word">Labour Rate</th> --}}
                <th style="width: 250px;word-wrap:break-word">Material Amount</th>
                {{-- <th style="width: 250px;word-wrap:break-word">Labor Amount</th> --}}
                {{-- <th style="width: 250px;word-wrap:break-word">Total Amount</th> --}}
                <th style="width: 250px;word-wrap:break-word">Remarks</th>
                <th style="width: 250px;word-wrap:break-word">Total</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>

                @foreach($BoqEmeCalculations as $BoqEmeCalculationsGbfloor)
                    <tr style="background-color: #b7ebb7" class="balanceLineStyle">
                        <td class="text-left" style="padding-left: 15px!important; first_line" >{{ $floop = $loop->iteration}}</td>
                        <td class="text-left first_layer" id="{{'budget_head_'.$BoqEmeCalculationsGbfloor->first()->first()->first()->first()->budget_head_id}}">
                            {{ $BoqEmeCalculationsGbfloor->first()->first()->first()->first()->EmeBudgetHead->name }}
                        </td>
                        <td colspan="7"></td>
                    </tr>
                    @foreach($BoqEmeCalculationsGbfloor as $BoqEmeCalculationsGbitem)
                        <tr style="background-color: #d0ebe3" class="balanceLineStyle hide_material second_line_{{$BoqEmeCalculationsGbitem->first()->first()->first()->floor_id}}">
                            <td class="text-left " style="padding-left: 15px!important;">{{$sloop = $floop .'.'.  $loop->iteration}}</td>
                            <td class="text-left second_layer" id="{{'floor_name_'.$BoqEmeCalculationsGbitem->first()->first()->first->floor_id ?? 0}}" style="padding-left: 30px!important;">
                                {{ $BoqEmeCalculationsGbitem->first()->first()->first()->BoqFloorProject->floor->name ?? '- - - -' }}
                            </td>
                            <td colspan="7"></td>
                        </tr>
                        @php
                          $rowSpan = 1;
                            $total = $BoqEmeCalculationsGbitem->flatten()->sum('total_material_amount');
                            $rowSpan += count($BoqEmeCalculationsGbitem);
                        @endphp
                        @foreach($BoqEmeCalculationsGbitem as $BoqEmeCalculationsGbmaterial)
                        @php
                            $rowSpan += count($BoqEmeCalculationsGbmaterial);
                        @endphp
                            <tr style="background-color: #c5eed5fb" class="balanceLineStyle hide_material third_line_{{$BoqEmeCalculationsGbmaterial->first()->first()->item_id}} hide_parent_account_{{$BoqEmeCalculationsGbmaterial->first()->first()->item_id}}">
                                <td class="text-left " style="padding-left: 15px!important;">{{ $ssloop = $sloop .'.'.$loop->iteration }}</td>
                                <td class="text-left third_layer" id="{{'second_layer_materials_'.$BoqEmeCalculationsGbmaterial->first()->first()->material_id}}" style="padding-left: 60px!important; " >
                                    {{ $BoqEmeCalculationsGbmaterial->first()->first()->NestedMaterialSecondLayer->name }}
                                </td>
                                <td colspan="5"></td>
                                @if ($loop->first)
                                <td rowspan ={{ $rowSpan }}>{{ $total }}</td>
                                @endif
                                <td></td>
                            </tr>
                            @foreach($BoqEmeCalculationsGbmaterial as $datas)
                            <tr style="background-color: #dbecdb" class="balanceLineStyle hide_material fourth_line_{{$datas->first()->material_id}} hide_parent_account_{{$datas->first()->material_id}}">
                                <td class="text-left " style="padding-left: 15px!important;">{{ $accloop = $ssloop .'.'.$loop->iteration }}</td>
                                <td class="text-left fourth_layer" id="{{'material_id_'.$datas->first()->material_id}}" style="padding-left: 100px!important; ">
                                    {{ $datas->first()->NestedMaterial->name }}
                                </td>
                                <td>{{ $datas->first()->NestedMaterial->unit->name }}</td>
                                <td>{{ $datas->first()->quantity }}</td>
                                <td>{{ $datas->first()->material_rate }}</td>
                                {{-- <td>{{ $datas->first()->labour_rate }}</td> --}}
                                <td>{{ $datas->first()->total_material_amount }}</td>
                                {{-- <td>{{ $datas->first()->total_labour_amount }}</td> --}}
                                {{-- <td>{{ $datas->first()->total_amount }}</td> --}}
                                <td>{{ $datas->first()->remarks }}</td>

                                <td>
                                    {{-- @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.project.departments.electrical.calculations', 'route_key' => ['project' => $project,'calculation' => $datas->first()]]) --}}
                                    <div class="icon-btn">
                                        <nobr>
                                            @php
                                                $data = $datas->first();
                                                $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($data){
                                                    $q->where([['name','BOQ EME ITEM CALCULATION'],['department_id',$data->appliedBy->department_id]]);
                                                })->whereDoesntHave('approvals',function ($q) use($data){
                                                    $q->where('approvable_id',$data->id)->where('approvable_type',\App\Boq\Departments\Eme\BoqEmeCalculation::class);
                                                })->orderBy('order_by','asc')->first();
                                            @endphp
                                            @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
                                            <a href="{{ url("boq/project/$project->id/departments/electrical/calculations/approved/$data->id/1") }}" data-toggle="tooltip" title="Approve" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                                {{-- <a href="{{ url("iou/approved/$iou->id/0") }}" data-toggle="tooltip" title="Reject Requisition" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a> --}}
                                                {{-- @include('components.buttons.action-button', ['actions' => ['approve'], 'url' => "boq/project/$project->id/departments/electrical/budgets/approved/$data->id/1"]) --}}
                                            @endif
                                            @if($data->approval()->doesntExist() || auth()->user()->hasAnyRole(['admin','super-admin']))
                                                {{-- @include('components.buttons.action-button', ['actions' => ['edit'], 'route' => 'boq.project.departments.electrical.budgets', 'route_key' => ['project' => $project,'budget' => $data]]) --}}
                                                <a href="{{ route('boq.project.departments.electrical.calculations.edit', ['project' => $project,'calculation' => $data]) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                @if($data->approval()->doesntExist())
                                                <form action="{{ route('boq.project.departments.electrical.calculations.destroy', ['project' => $project,'calculation' => $data]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                                {{-- @include('components.buttons.action-button', ['actions' => ['delete'], 'route' => 'boq.project.departments.electrical.budgets', 'route_key' => ['project' => $project,'budget' => $data]]) --}}
                                                @endif
                                            @endif()
                                        </nobr>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <div class="float-right">
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(window).scroll(function () {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function () {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function () {
            $('#dataTable').DataTable({
                stateSave: true,
                bPaginate: false
            });
        });

        // $(function() {
        //     $(document).on('click', '.first_layer', function(){
        //         let header = $(this).attr('id');
        //         $(".second_line_"+header).toggle();
        //         $(".hide_parent_account_"+header).hide();
        //     });

        //     $(document).on('click', '.second_layer', function(){
        //         let currentLine = $(this).attr('id');
        //         $(".third_line_"+currentLine).toggle();
        //         $(".hide_parent_account_"+currentLine).hide();
        //     });
        //     $(document).on('click', '.third_layer', function(){
        //         let parentAccount = $(this).attr('id');
        //         $(".fourth_line_"+parentAccount).toggle();
        //         $(".hide_parent_account_"+parentAccount).hide();
        //     });


        // });//document.ready
    </script>
@endsection
