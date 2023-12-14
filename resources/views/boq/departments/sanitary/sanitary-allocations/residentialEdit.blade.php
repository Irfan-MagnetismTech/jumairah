@extends('boq.departments.sanitary.layout.app')
@section('title', 'BOQ - Sanitary')

@section('breadcrumb-title')
    Material Allocations Plan
@endsection

@section('project-name')
    {{ $project->name }}
@endsection

@section('breadcrumb-button')
    {{-- @include('components.buttons.breadcrumb-button', ['route' => route('boq.project.departments.electrical.configurations.rates.index',['project' => Session::get('project_id')]), 'type' => 'index']) --}}
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10')

@section('content')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open([
                'url' => "boq/project/$project->id/departments/sanitary/sanitary-allocations/update",
                'method' => 'POST',
                'class' => 'custom-form',
            ]) !!}
            <input type="hidden" name="project_id"
                value="{{ old('id') ? old('id') : (!empty($project->id) ? $project->id : null) }}">

            <input type="hidden" name="type" value="{{ old('type') ? old('type') : $type }}">
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-bordered" id="calculation_table">
                        <thead>
                            <tr style="background-color: #2ed8b6!important;">
                                <td class="text-center" colspan="13">
                                    <h5 style="color: white" class="text-center">Residential Part</h5>
                                </td>
                            </tr>
                            <tr>
                                <th rowspan="2">Apartment Type</th>
                                <th rowspan="2">No</th>
                                <th class="material_rate_th" colspan="2">
                                    <input type="text" class="form-control text-center" name="master"
                                        value="Master Bath" style="background-color: #227447; color: white">
                                </th>
                                <th class="material_rate_th" colspan="2">
                                    <input type="text" class="form-control text-center" name="child" value="Child Bath"
                                        style="background-color: #227447; color: white">
                                </th>
                                <th class="material_rate_th" colspan="2">
                                    <input type="text" class="form-control text-center" name="common"
                                        value="Common Bath" style="background-color: #227447; color: white">
                                </th>
                                <th class="material_rate_th" colspan="2">
                                    <input type="text" class="form-control text-center" name="smalltoilet"
                                        value="S. Toilet Bath" style="background-color: #227447; color: white">
                                </th>
                                <th class="material_rate_th" colspan="2">
                                    <input type="text" class="form-control text-center" name="kitchen" value="Kitchen"
                                        style="background-color: #227447; color: white">
                                </th>
                            </tr>
                            <tr>
                                <th>FC</th>
                                <th>LW</th>
                                <th>FC</th>
                                <th>LW</th>
                                <th>FC</th>
                                <th>LW</th>
                                <th>FC</th>
                                <th>LW</th>
                                <th>FC</th>
                                <th>LW</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $rows = $allocations->count();
                            @endphp
                            @foreach ($allocations as $akey => $allocation)
                                @php
                                    $projecttype = \App\ProjectType::where('composite_key', $akey)->first();
                                @endphp
                                <tr style="background-color: #c9e8dd">
                                    <td>{{ $projecttype->type_name ?? '' }}
                                        <input type="hidden" name="apartment_type[]"
                                            value="{{ $projecttype->composite_key }}">
                                    </td>
                                    <td>{{ $projecttype ? $projecttype->typeApartments->count() : 0 }}</td>
                                    @foreach ($allocation as $key => $data)
                                        @foreach ($data as $d)
                                            @if ($key == 'Master Bath')
                                                <td>
                                                    <input type="text" name="master_FC[]"
                                                        class="form-control text-right master_FC"
                                                        value="{{ $d->fc_quantity }}" />
                                                </td>
                                                <td>
                                                    <input type="text" name="master_LW[]"
                                                        class="form-control text-right master_LW"
                                                        value="{{ $d->owner_quantity }}" />
                                                </td>
                                            @elseif($key == 'Child Bath')
                                                <td>
                                                    <input type="text" name="child_FC[]"
                                                        class="form-control text-right child_FC"
                                                        value="{{ $d->fc_quantity }}" />
                                                </td>
                                                <td>
                                                    <input type="text" name="child_LW[]"
                                                        class="form-control text-right child_LW"
                                                        value="{{ $d->owner_quantity }}" />
                                                </td>
                                            @elseif($key == 'Common Bath')
                                                <td>
                                                    <input type="text" name="common_FC[]"
                                                        class="form-control text-right common_FC"
                                                        value="{{ $d->fc_quantity }}" />
                                                </td>
                                                <td>
                                                    <input type="text" name="common_LW[]"
                                                        class="form-control text-right common_LW"
                                                        value="{{ $d->owner_quantity }}" />
                                                </td>
                                            @elseif($key == 'S. Toilet Bath')
                                                <td>
                                                    <input type="text" name="smalltoilet_FC[]"
                                                        class="form-control text-right smalltoilet_FC"
                                                        value="{{ $d->fc_quantity }}" />
                                                </td>
                                                <td>
                                                    <input type="text" name="smalltoilet_LW[]"
                                                        class="form-control text-right smalltoilet_LW"
                                                        value="{{ $d->owner_quantity }}" />
                                                </td>
                                            @elseif($key == 'Kitchen')
                                                <td>
                                                    <input type="text" name="kitchen_FC[]"
                                                        class="form-control text-right kitchen_FC"
                                                        value="{{ $d->fc_quantity }}" />
                                                </td>
                                                <td>
                                                    <input type="text" name="kitchen_LW[]"
                                                        class="form-control text-right kitchen_LW"
                                                        value="{{ $d->owner_quantity }}" />
                                                </td>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-right"><b>Total</b> </td>
                                @php
                                    $total_master_fc = 0;
                                    $total_master_lw = 0;
                                    $total_child_fc = 0;
                                    $total_child_lw = 0;
                                    $total_common_fc = 0;
                                    $total_common_lw = 0;
                                    $total_s_toilet_fc = 0;
                                    $total_s_toilet_lw = 0;
                                    $total_kitchen_fc = 0;
                                    $total_kitchen_lw = 0;
                                @endphp
                                @foreach ($allocations as $akey => $allocation)
                                    @foreach ($allocation as $key => $data)
                                        @foreach ($data as $d)
                                            @if ($key == 'Master Bath')
                                                @php
                                                    $total_master_fc = $total_master_fc + $d->fc_quantity;
                                                    $total_master_lw = $total_master_lw + $d->owner_quantity;
                                                @endphp
                                            @elseif($key == 'Child Bath')
                                                @php
                                                    $total_child_fc += $d->fc_quantity;
                                                    $total_child_lw += $d->owner_quantity;
                                                @endphp
                                            @elseif($key == 'Common Bath')
                                                @php
                                                    $total_common_fc += $d->fc_quantity;
                                                    $total_common_lw += $d->owner_quantity;
                                                @endphp
                                            @elseif($key == 'S. Toilet Bath')
                                                @php
                                                    
                                                    $total_s_toilet_fc += $d->fc_quantity;
                                                    $total_s_toilet_lw += $d->owner_quantity;
                                                @endphp
                                            @elseif($key == 'Kitchen')
                                                @php
                                                    $total_kitchen_fc += $d->fc_quantity;
                                                    $total_kitchen_lw += $d->owner_quantity;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endforeach
                                <td>
                                    <input type="text" name="total_master_fc"
                                        class="form-control text-right total_master_fc" value="{{ $total_master_fc }}"
                                        readonly />
                                </td>

                                <td>
                                    <input type="text" name="total_master_lw"
                                        class="form-control text-right total_master_lw" value="{{ $total_master_lw }}"
                                        readonly />
                                </td>
                                <td>
                                    <input type="text" name="total_child_fc"
                                        class="form-control text-right total_child_fc" value="{{ $total_child_fc }}"
                                        readonly />
                                </td>
                                <td>
                                    <input type="text" name="total_child_lw"
                                        class="form-control text-right total_child_lw" value="{{ $total_child_lw }}"
                                        readonly />
                                </td>
                                <td>
                                    <input type="text" name="total_common_fc"
                                        class="form-control text-right total_common_fc" value="{{ $total_common_fc }}"
                                        readonly />
                                </td>
                                <td>
                                    <input type="text" name="total_common_lw"
                                        class="form-control text-right total_common_lw" value="{{ $total_common_lw }}"
                                        readonly />
                                </td>
                                <td>
                                    <input type="text" name="total_s_toilet_fc"
                                        class="form-control text-right total_toilet_fc" value="{{ $total_s_toilet_fc }}"
                                        readonly />
                                </td>
                                <td>
                                    <input type="text" name="total_s_toilet_lw"
                                        class="form-control text-right total_toilet_lw" value="{{ $total_s_toilet_lw }}"
                                        readonly />
                                </td>
                                <td>
                                    <input type="text" name="total_kitchen_fc"
                                        class="form-control text-right total_kitchen_fc" value="{{ $total_kitchen_fc }}"
                                        readonly />
                                </td>
                                <td>
                                    <input type="text" name="total_kitchen_lw"
                                        class="form-control text-right total_kitchen_lw" value="{{ $total_kitchen_lw }}"
                                        readonly />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <br>
                    <hr>
                    {{-- //allocate area --}}
                    <table class="table table-bordered" id="">
                        <thead>
                            <tr class="">
                                <th rowspan="2">Item </th>
                                <th rowspan="2">Unit </th>
                                <th colspan="2">Master Bath</th>
                                <th colspan="2">Child / Attached Bath</th>
                                <th colspan="2">Common Bath</th>
                                <th colspan="2">S. Toilet Bath</th>
                                <th colspan="2">Kitchen</th>
                                <th rowspan="2">Common <br> Area</th>
                                <th rowspan="2">Total</th>
                            </tr>
                            <tr>
                                <th>FC</th>
                                <th>LW</th>
                                <th>FC</th>
                                <th>LW</th>
                                <th>FC</th>
                                <th>LW</th>
                                <th>FC</th>
                                <th>LW</th>
                                <th>FC</th>
                                <th>LW</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                                $master_fc = 0;
                                $master_lw = 0;
                                $child_fc = 0;
                                $child_lw = 0;
                                $common_fc = 0;
                                $common_lw = 0;
                                $s_toilet_fc = 0;
                                $s_toilet_lw = 0;
                                $kitchen_fc = 0;
                                $kitchen_lw = 0;
                                $common_area = 0;
                            @endphp
                            @foreach ($formulas as $mkey => $formulaData)
                                <tr>
                                    {{-- @foreach ($sanitaryAllocations as $key => $sanitaryAllocation) --}}
                                    @php
                                        
                                        $materialName = $formulaData
                                            ->flatten()
                                            ->pluck('material')
                                            ->flatten();
                                    @endphp
                                    <td class="text-left">{{ $materialName[0]->name }}
                                        {{ Form::hidden('material_id[]', old('material_id') ? old('material_id') : (!empty($nestedmaterial->material_id) ? $layer1 : $materialName[0]->id), ['class' => 'material_id']) }}
                                    </td>
                                    <td class="">{{ $materialName[0]->unit->name }}</td>
                                    @foreach ($types as $key => $type)
                                        @php
                                            $items = \App\SanitaryFormulaDetail::whereHas('sanitaryFormula', function ($q) use ($type) {
                                                $q->where('location_type', $type->name)->where('location_for', 1);
                                            })
                                                ->where('material_id', $materialName[0]->id)
                                                ->first();
                                            $materialAllocation = !empty($items->material)
                                                ? $items->material
                                                    ->materialAllocation()
                                                    ->where('type', 'Residential')
                                                    ->first()
                                                : null;
                                            
                                        @endphp
                                        @if ($key == '0')
                                            @php
                                                $master_fc = !empty($materialAllocation) ? $materialAllocation->master_fc : 0;
                                                $master_lw = !empty($materialAllocation) ? $materialAllocation->master_lw : 0;
                                            @endphp
                                            <td>
                                                {{ Form::hidden("hidden_multi_$type->value[]", old('hidden_master_multi_fc') ? old('hidden_master_multi_fc') : (!empty($nestedmaterial->hidden_master_multi_fc) ? $layer1 : $items->multiply_qnt ?? 0), ['class' => "hidden_multi_fc_$type->value"]) }}
                                                {{ Form::hidden("hidden_add_$type->value[]", old('hidden_master_add_fc') ? old('hidden_master_add_fc') : (!empty($nestedmaterial->hidden_master_add_fc) ? $layer1 : $items->additional_qnt ?? 0), ['class' => "hidden_add_fc_$type->value"]) }}
                                                <input type="text" name="allocate_fc_{{ $type->value }}[]"
                                                    class="form-control text-right allocate_fc_{{ $type->value }}"
                                                    value="{{ number_format($master_fc, 0) }}" />
                                            </td>
                                            <td>
                                                {{ Form::hidden("hidden_multi_lw_$type->value[]", old('hidden_master_multi_lw') ? old('hidden_master_multi_lw') : (!empty($nestedmaterial->hidden_master_multi_lw) ? $layer1 : $items->multiply_qnt ?? 0), ['class' => "hidden_multi_lw_$type->value"]) }}
                                                {{ Form::hidden("hidden_add_lw_$type->value[]", old('hidden_master_add_lw') ? old('hidden_master_add_lw') : (!empty($nestedmaterial->hidden_master_add_lw) ? $layer1 : $items->additional_qnt ?? 0), ['class' => "hidden_add_lw_$type->value"]) }}
                                                <input type="text" name="allocate_lw_{{ $type->value }}[]"
                                                    class="form-control text-right allocate_lw_{{ $type->value }}"
                                                    value="{{ number_format($master_lw, 0) }}" />
                                            </td>
                                        @elseif($key == '1')
                                            @php
                                                $child_fc = !empty($materialAllocation) ? $materialAllocation->child_fc : 0;
                                                $child_lw = !empty($materialAllocation) ? $materialAllocation->child_lw : 0;
                                            @endphp
                                            <td>
                                                {{ Form::hidden("hidden_multi_$type->value[]", old('hidden_master_multi_fc') ? old('hidden_master_multi_fc') : (!empty($nestedmaterial->hidden_master_multi_fc) ? $layer1 : $items->multiply_qnt ?? 0), ['class' => "hidden_multi_fc_$type->value"]) }}
                                                {{ Form::hidden("hidden_add_$type->value[]", old('hidden_master_add_fc') ? old('hidden_master_add_fc') : (!empty($nestedmaterial->hidden_master_add_fc) ? $layer1 : $items->additional_qnt ?? 0), ['class' => "hidden_add_fc_$type->value"]) }}
                                                <input type="text" name="allocate_fc_{{ $type->value }}[]"
                                                    class="form-control text-right allocate_fc_{{ $type->value }}"
                                                    value="{{ number_format($child_fc, 0) }}" />
                                            </td>
                                            <td>
                                                {{ Form::hidden("hidden_multi_lw_$type->value[]", old('hidden_master_multi_lw') ? old('hidden_master_multi_lw') : (!empty($nestedmaterial->hidden_master_multi_lw) ? $layer1 : $items->multiply_qnt ?? 0), ['class' => "hidden_multi_lw_$type->value"]) }}
                                                {{ Form::hidden("hidden_add_lw_$type->value[]", old('hidden_master_add_lw') ? old('hidden_master_add_lw') : (!empty($nestedmaterial->hidden_master_add_lw) ? $layer1 : $items->additional_qnt ?? 0), ['class' => "hidden_add_lw_$type->value"]) }}
                                                <input type="text" name="allocate_lw_{{ $type->value }}[]"
                                                    class="form-control text-right allocate_lw_{{ $type->value }}"
                                                    value="{{ number_format($child_lw, 0) }}" />
                                            </td>
                                        @elseif($key == '2')
                                            @php
                                                $common_fc = !empty($materialAllocation) ? $materialAllocation->common_fc : 0;
                                                $common_lw = !empty($materialAllocation) ? $materialAllocation->common_lw : 0;
                                            @endphp
                                            <td>
                                                {{ Form::hidden("hidden_multi_$type->value[]", old('hidden_master_multi_fc') ? old('hidden_master_multi_fc') : (!empty($nestedmaterial->hidden_master_multi_fc) ? $layer1 : $items->multiply_qnt ?? 0), ['class' => "hidden_multi_fc_$type->value"]) }}
                                                {{ Form::hidden("hidden_add_$type->value[]", old('hidden_master_add_fc') ? old('hidden_master_add_fc') : (!empty($nestedmaterial->hidden_master_add_fc) ? $layer1 : $items->additional_qnt ?? 0), ['class' => "hidden_add_fc_$type->value"]) }}
                                                <input type="text" name="allocate_fc_{{ $type->value }}[]"
                                                    class="form-control text-right allocate_fc_{{ $type->value }}"
                                                    value="{{ number_format($common_fc, 0) }}" />
                                            </td>
                                            <td>
                                                {{ Form::hidden("hidden_multi_lw_$type->value[]", old('hidden_master_multi_lw') ? old('hidden_master_multi_lw') : (!empty($nestedmaterial->hidden_master_multi_lw) ? $layer1 : $items->multiply_qnt ?? 0), ['class' => "hidden_multi_lw_$type->value"]) }}
                                                {{ Form::hidden("hidden_add_lw_$type->value[]", old('hidden_master_add_lw') ? old('hidden_master_add_lw') : (!empty($nestedmaterial->hidden_master_add_lw) ? $layer1 : $items->additional_qnt ?? 0), ['class' => "hidden_add_lw_$type->value"]) }}
                                                <input type="text" name="allocate_lw_{{ $type->value }}[]"
                                                    class="form-control text-right allocate_lw_{{ $type->value }}"
                                                    value="{{ number_format($common_lw, 0) }}" />
                                            </td>
                                        @elseif($key == '3')
                                            @php
                                                $s_toilet_fc = !empty($materialAllocation) ? $materialAllocation->small_toilet_fc : 0;
                                                $s_toilet_lw = !empty($materialAllocation) ? $materialAllocation->small_toilet_lw : 0;
                                            @endphp
                                            <td>
                                                {{ Form::hidden("hidden_multi_$type->value[]", old('hidden_master_multi_fc') ? old('hidden_master_multi_fc') : (!empty($nestedmaterial->hidden_master_multi_fc) ? $layer1 : $items->multiply_qnt ?? 0), ['class' => "hidden_multi_fc_$type->value"]) }}
                                                {{ Form::hidden("hidden_add_$type->value[]", old('hidden_master_add_fc') ? old('hidden_master_add_fc') : (!empty($nestedmaterial->hidden_master_add_fc) ? $layer1 : $items->additional_qnt ?? 0), ['class' => "hidden_add_fc_$type->value"]) }}
                                                <input type="text" name="allocate_fc_{{ $type->value }}[]"
                                                    class="form-control text-right allocate_fc_{{ $type->value }}"
                                                    value="{{ number_format($s_toilet_fc, 0) }}" />
                                            </td>
                                            <td>
                                                {{ Form::hidden("hidden_multi_lw_$type->value[]", old('hidden_master_multi_lw') ? old('hidden_master_multi_lw') : (!empty($nestedmaterial->hidden_master_multi_lw) ? $layer1 : $items->multiply_qnt ?? 0), ['class' => "hidden_multi_lw_$type->value"]) }}
                                                {{ Form::hidden("hidden_add_lw_$type->value[]", old('hidden_master_add_lw') ? old('hidden_master_add_lw') : (!empty($nestedmaterial->hidden_master_add_lw) ? $layer1 : $items->additional_qnt ?? 0), ['class' => "hidden_add_lw_$type->value"]) }}
                                                <input type="text" name="allocate_lw_{{ $type->value }}[]"
                                                    class="form-control text-right allocate_lw_{{ $type->value }}"
                                                    value="{{ number_format($s_toilet_lw, 0) }}" />
                                            </td>
                                        @elseif($key == '4')
                                            @php
                                                $kitchen_fc = !empty($materialAllocation) ? $materialAllocation->kitchen_fc : 0;
                                                $kitchen_lw = !empty($materialAllocation) ? $materialAllocation->kitchen_lw : 0;
                                                
                                            @endphp

                                            <td>
                                                {{ Form::hidden("hidden_multi_$type->value[]", old('hidden_master_multi_fc') ? old('hidden_master_multi_fc') : (!empty($nestedmaterial->hidden_master_multi_fc) ? $layer1 : $items->multiply_qnt ?? 0), ['class' => "hidden_multi_fc_$type->value"]) }}
                                                {{ Form::hidden("hidden_add_$type->value[]", old('hidden_master_add_fc') ? old('hidden_master_add_fc') : (!empty($nestedmaterial->hidden_master_add_fc) ? $layer1 : $items->additional_qnt ?? 0), ['class' => "hidden_add_fc_$type->value"]) }}
                                                <input type="text" name="allocate_fc_{{ $type->value }}[]"
                                                    class="form-control text-right allocate_fc_{{ $type->value }}"
                                                    value="{{ number_format($kitchen_fc, 0) }}" />
                                            </td>
                                            <td>
                                                {{ Form::hidden("hidden_multi_lw_$type->value[]", old('hidden_master_multi_lw') ? old('hidden_master_multi_lw') : (!empty($nestedmaterial->hidden_master_multi_lw) ? $layer1 : $items->multiply_qnt ?? 0), ['class' => "hidden_multi_lw_$type->value"]) }}
                                                {{ Form::hidden("hidden_add_lw_$type->value[]", old('hidden_master_add_lw') ? old('hidden_master_add_lw') : (!empty($nestedmaterial->hidden_master_add_lw) ? $layer1 : $items->additional_qnt ?? 0), ['class' => "hidden_add_lw_$type->value"]) }}
                                                <input type="text" name="allocate_lw_{{ $type->value }}[]"
                                                    class="form-control text-right allocate_lw_{{ $type->value }}"
                                                    value="{{ number_format($kitchen_lw, 0) }}" />
                                            </td>
                                        @endif
                                        @php
                                            
                                        $total = $master_fc + $master_lw + $child_fc + $child_lw + $common_fc + $common_lw + $s_toilet_fc + $s_toilet_lw + $kitchen_fc + $kitchen_lw; @endphp
                                    @endforeach
                                    <td>
                                        @php
                                            $commonMaterial = \App\Boq\Departments\Sanitary\SanitaryMaterialAllocation::where('material_id', $materialName[0]->id)->first();
                                            // $common_area = !empty($materialAllocation) ? $materialAllocation->commonArea : 0;
                                        @endphp
                                        {{-- {{ dump($formulaData[$mkey]) }} --}}
                                        {{-- {{ Form::hidden("hidden_multi_$type->value[]", old('hidden_master_multi_fc') ? old('hidden_master_multi_fc') : (!empty($nestedmaterial->hidden_master_multi_fc) ? $layer1 : $items->multiply_qnt ?? 0), ['class' => "hidden_multi_fc_$type->value"]) }} --}}
                                        {{-- {{ Form::hidden("hidden_add_$type->value[]", old('hidden_master_add_fc') ? old('hidden_master_add_fc') : (!empty($nestedmaterial->hidden_master_add_fc) ? $layer1 : $items->additional_qnt ?? 0), ['class' => "hidden_add_fc_$type->value"]) }} --}}
                                        <input type="text" name="common_area[]"
                                            class="form-control text-right common_area"
                                            value="{{ number_format($commonMaterial->commonArea, 0) ?? 0 }} " />
                                    </td>
                                    <td>
                                        {{ Form::hidden("hidden_multi_lw_$type->value[]", old('hidden_master_multi_lw') ? old('hidden_master_multi_lw') : (!empty($nestedmaterial->hidden_master_multi_lw) ? $layer1 : $items->multiply_qnt ?? 0), ['class' => "hidden_multi_lw_$type->value"]) }}
                                        {{ Form::hidden("hidden_add_lw_$type->value[]", old('hidden_master_add_lw') ? old('hidden_master_add_lw') : (!empty($nestedmaterial->hidden_master_add_lw) ? $layer1 : $items->additional_qnt ?? 0), ['class' => "hidden_add_lw_$type->value"]) }}
                                        <input type="text" name="total[]" class="form-control text-right total"
                                            value="{{ $total + number_format($commonMaterial->commonArea, 0) }}" />
                                    </td>


                                    {{-- @endforeach --}}
                                </tr>
                            @endforeach
                            {{-- @dd(); --}}
                        </tbody>
                    </table>
                </div>
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
        const CSRF_TOKEN = "{{ csrf_token() }}";

        $(document).on('keyup', '.master_FC', function() {
            changeTotalMasterFc();
        })
        $(document).on('keyup', '.master_LW', function() {
            changeTotalMasterLw();
        })
        $(document).on('keyup', '.child_FC', function() {
            changeTotalChildFc();
        })
        $(document).on('keyup', '.child_LW', function() {
            changeTotalChildLw();
        })
        $(document).on('keyup', '.common_FC', function() {
            changeTotalCommonFc();
        })
        $(document).on('keyup', '.common_LW', function() {
            changeTotalCommonLw();
        })
        $(document).on('keyup', '.smalltoilet_FC', function() {
            changeTotalSToiletFc();
        })
        $(document).on('keyup', '.smalltoilet_LW', function() {
            changeTotalSToiletLw();
        })
        $(document).on('keyup', '.kitchen_FC', function() {
            changeTotalKitchenFc();
        })
        $(document).on('keyup', '.kitchen_LW', function() {
            changeTotalKitchenLw();
        })
        $(document).on('keyup', '.common_area', function() {
            changeTotal($(this));
        })

        function changeTotalMasterFc() {
            let total = 0;
            if ($(".master_FC").length > 0) {
                $(".master_FC").each(function(i, row) {
                    let totalQnt = Number($(row).val());
                    total += parseFloat(totalQnt);
                })
            }
            $(".total_master_fc").val(total);
            changeAllocateMasterFc();
        }

        function changeTotalMasterLw() {
            let total = 0;
            if ($(".master_LW").length > 0) {
                $(".master_LW").each(function(i, row) {
                    let totalQnt = Number($(row).val());
                    total += parseFloat(totalQnt);
                })
            }
            $(".total_master_lw").val(total);
            changeAllocateMasterLw();
        }

        function changeTotalChildFc() {
            let total = 0;
            if ($(".child_FC").length > 0) {
                $(".child_FC").each(function(i, row) {
                    let totalQnt = Number($(row).val());
                    total += parseFloat(totalQnt);
                })
            }
            $(".total_child_fc").val(total);
            changeAllocateChildFc();
        }

        function changeTotalChildLw() {
            let total = 0;
            if ($(".child_LW").length > 0) {
                $(".child_LW").each(function(i, row) {
                    let totalQnt = Number($(row).val());
                    total += parseFloat(totalQnt);
                })
            }
            $(".total_child_lw").val(total);
            changeAllocateChildLw();
        }

        function changeTotalCommonFc() {
            let total = 0;
            if ($(".common_FC").length > 0) {
                $(".common_FC").each(function(i, row) {
                    let totalQnt = Number($(row).val());
                    total += parseFloat(totalQnt);
                })
            }
            $(".total_common_fc").val(total);
            changeAllocateCommonFc();
        }

        function changeTotalCommonLw() {
            let total = 0;
            if ($(".common_LW").length > 0) {
                $(".common_LW").each(function(i, row) {
                    let totalQnt = Number($(row).val());
                    total += parseFloat(totalQnt);
                })
            }
            $(".total_common_lw").val(total);
            changeAllocateCommonLw();
        }

        function changeTotalSToiletFc() {
            let total = 0;
            if ($(".smalltoilet_FC").length > 0) {
                $(".smalltoilet_FC").each(function(i, row) {
                    let totalQnt = Number($(row).val());
                    total += parseFloat(totalQnt);
                })
            }
            $(".total_toilet_fc").val(total);
            changeAllocateSToiletFc();
        }

        function changeTotalSToiletLw() {
            let total = 0;
            if ($(".smalltoilet_LW").length > 0) {
                $(".smalltoilet_LW").each(function(i, row) {
                    let totalQnt = Number($(row).val());
                    total += parseFloat(totalQnt);
                })
            }
            $(".total_toilet_lw").val(total);
            changeAllocateSToiletLw();
        }

        function changeTotalKitchenFc() {
            let total = 0;
            if ($(".kitchen_FC").length > 0) {
                $(".kitchen_FC").each(function(i, row) {
                    let totalQnt = Number($(row).val());
                    total += parseFloat(totalQnt);
                })
            }
            $(".total_kitchen_fc").val(total);
            changeAllocateKitchenFc();
        }

        function changeTotalKitchenLw() {
            let total = 0;
            if ($(".kitchen_LW").length > 0) {
                $(".kitchen_LW").each(function(i, row) {
                    let totalQnt = Number($(row).val());
                    total += parseFloat(totalQnt);
                })
            }
            $(".total_kitchen_lw").val(total);
            changeAllocateKitchenLw();
        }

        function changeTotal(thisVal) {
            let allocateQntmfc = thisVal.closest('tr').find('.allocate_fc_master').val() > 0 ? parseFloat(thisVal.closest(
                'tr').find('.allocate_fc_master').val()) : 0;
            let allocateQntmlw = thisVal.closest('tr').find('.allocate_lw_master').val() > 0 ? parseFloat(thisVal.closest(
                'tr').find('.allocate_lw_master').val()) : 0;
            let allocateQntcfc = thisVal.closest('tr').find('.allocate_fc_child').val() > 0 ? parseFloat(thisVal.closest(
                'tr').find('.allocate_fc_child').val()) : 0;
            let allocateQntclw = thisVal.closest('tr').find('.allocate_lw_child').val() > 0 ? parseFloat(thisVal.closest(
                'tr').find('.allocate_lw_child').val()) : 0;
            let allocateQntcbfc = thisVal.closest('tr').find('.allocate_fc_commonBath').val() > 0 ? parseFloat(thisVal
                .closest('tr').find('.allocate_fc_commonBath').val()) : 0;
            let allocateQntcblw = thisVal.closest('tr').find('.allocate_lw_commonBath').val() > 0 ? parseFloat(thisVal
                .closest('tr').find('.allocate_lw_commonBath').val()) : 0;
            let allocateQntstfc = thisVal.closest('tr').find('.allocate_fc_smallToilet').val() > 0 ? parseFloat(thisVal
                .closest('tr').find('.allocate_fc_smallToilet').val()) : 0;
            let allocateQntstlw = thisVal.closest('tr').find('.allocate_lw_smallToilet').val() > 0 ? parseFloat(thisVal
                .closest('tr').find('.allocate_lw_smallToilet').val()) : 0;
            let allocateQntkfc = thisVal.closest('tr').find('.allocate_fc_kitchen').val() > 0 ? parseFloat(thisVal.closest(
                'tr').find('.allocate_fc_kitchen').val()) : 0;
            let allocateQntklw = thisVal.closest('tr').find('.allocate_lw_kitchen').val() > 0 ? parseFloat(thisVal.closest(
                'tr').find('.allocate_lw_kitchen').val()) : 0;
            let commonAreaQnt = thisVal.closest('tr').find('.common_area').val() > 0 ? parseFloat(thisVal.closest('tr')
                .find('.common_area').val()) : 0;
            thisVal.closest('tr').find('.total').val(allocateQntmfc + allocateQntmlw + allocateQntcfc + allocateQntclw +
                allocateQntcbfc + allocateQntcblw + allocateQntstfc +
                allocateQntstlw + allocateQntkfc + allocateQntklw + commonAreaQnt);
        }

        function changeAllocateMasterFc() {
            $(".hidden_multi_fc_master").each(function(i, row) {
                let allocateMasterMultiFc = Number($(row).val());
                let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_fc_master').val());
                let totalMasterFc = $(".total_master_fc").val();
                console.log(allocateMasterMultiFc, allocateMasterAddFc, totalMasterFc)
                $(row).closest('tr').find('.allocate_fc_master').val(allocateMasterMultiFc * totalMasterFc +
                    allocateMasterAddFc)
                changeTotal($(row));
            })
        }

        function changeAllocateMasterLw() {
            $(".hidden_multi_lw_master").each(function(i, row) {
                let allocateMasterMultiFc = Number($(row).val());
                let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_lw_master').val());
                let totalMasterFc = $(".total_master_lw").val();
                $(row).closest('tr').find('.allocate_lw_master').val(allocateMasterMultiFc * totalMasterFc +
                    allocateMasterAddFc)
                changeTotal($(row));
            })
        }

        function changeAllocateChildFc() {
            $(".hidden_multi_fc_child").each(function(i, row) {
                let allocateMasterMultiFc = Number($(row).val());
                let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_fc_child').val());
                let totalMasterFc = $(".total_child_fc").val();
                $(row).closest('tr').find('.allocate_fc_child').val(allocateMasterMultiFc * totalMasterFc +
                    allocateMasterAddFc)
                changeTotal($(row));
            })
        }

        function changeAllocateChildLw() {
            $(".hidden_multi_lw_child").each(function(i, row) {
                let allocateMasterMultiFc = Number($(row).val());
                let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_lw_child').val());
                let totalMasterFc = $(".total_child_lw").val();
                $(row).closest('tr').find('.allocate_lw_child').val(allocateMasterMultiFc * totalMasterFc +
                    allocateMasterAddFc)
                changeTotal($(row));
            })
        }

        function changeAllocateCommonFc() {
            $(".hidden_multi_fc_commonBath").each(function(i, row) {
                let allocateMasterMultiFc = Number($(row).val());
                let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_fc_commonBath').val());
                let totalMasterFc = $(".total_common_fc").val();
                $(row).closest('tr').find('.allocate_fc_commonBath').val(allocateMasterMultiFc * totalMasterFc +
                    allocateMasterAddFc)
                changeTotal($(row));
            })
        }

        function changeAllocateCommonLw() {
            $(".hidden_multi_lw_commonBath").each(function(i, row) {
                let allocateMasterMultiFc = Number($(row).val());
                let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_lw_commonBath').val());
                let totalMasterFc = $(".total_common_lw").val();
                $(row).closest('tr').find('.allocate_lw_commonBath').val(allocateMasterMultiFc * totalMasterFc +
                    allocateMasterAddFc)
                changeTotal($(row));
            })
        }

        function changeAllocateSToiletFc() {
            $(".hidden_multi_fc_smallToilet").each(function(i, row) {
                let allocateMasterMultiFc = Number($(row).val());
                let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_fc_smallToilet').val());
                let totalMasterFc = $(".total_toilet_fc").val();
                $(row).closest('tr').find('.allocate_fc_smallToilet').val(allocateMasterMultiFc * totalMasterFc +
                    allocateMasterAddFc)
                changeTotal($(row));
            })
        }

        function changeAllocateSToiletLw() {
            $(".hidden_multi_lw_smallToilet").each(function(i, row) {
                let allocateMasterMultiFc = Number($(row).val());
                let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_lw_smallToilet').val());
                let totalMasterFc = $(".total_toilet_lw").val();
                $(row).closest('tr').find('.allocate_lw_smallToilet').val(allocateMasterMultiFc * totalMasterFc +
                    allocateMasterAddFc)
                changeTotal($(row));
            })
        }

        function changeAllocateKitchenFc() {
            $(".hidden_multi_fc_kitchen").each(function(i, row) {
                let allocateMasterMultiFc = Number($(row).val());
                let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_fc_kitchen').val());
                let totalMasterFc = $(".total_kitchen_fc").val();
                $(row).closest('tr').find('.allocate_fc_kitchen').val(allocateMasterMultiFc * totalMasterFc +
                    allocateMasterAddFc)
                changeTotal($(row));
            })
        }

        function changeAllocateKitchenLw() {
            $(".hidden_multi_lw_kitchen").each(function(i, row) {
                let allocateMasterMultiFc = Number($(row).val());
                let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_lw_kitchen').val());
                let totalMasterFc = $(".total_kitchen_lw").val();
                $(row).closest('tr').find('.allocate_lw_kitchen').val(allocateMasterMultiFc * totalMasterFc +
                    allocateMasterAddFc)
                changeTotal($(row));
            })
        }
    </script>
@endsection
