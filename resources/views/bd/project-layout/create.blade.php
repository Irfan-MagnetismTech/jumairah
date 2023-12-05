@extends('layouts.backend-layout')
@section('title', 'Project Layout')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit Project
    @else
        Add New Project
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('projects') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    {!! Form::open([
        'url' => "project-layout-store/$bd_lead_location_id",
        'method' => 'POST',
        'class' => 'custom-form',
    ]) !!}
    @if (isset($projectLayout) && count($projectLayout) > 0)
        <input type="hidden" name="id"
            value="{{ old('id') ? old('id') : (!empty($projectLayout->id) ? $projectLayout->id : null) }}">
    @else
    @endif
    @php
        if (count($previous_data)) {
            $applicable_land = $bd_lead_generation->land_size * 720 - $previous_data->first()->grand_road_sft;
            $proposed_land = $applicable_land / 720;
        }
    @endphp
    <div class="row">
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="location">Location<span class="text-danger ">*</span></label>
                {{ Form::text('location', old('location') ? old('location') : (!empty($bd_lead_generation->land_location) ? $bd_lead_generation->land_location : null), ['class' => 'form-control text-center', 'id' => 'location', 'autocomplete' => 'off', 'required', 'readonly']) }}
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="land_category">Land Category<span class="text-danger">*</span></label>
                {{ Form::text('land_category', old('land_category') ? old('land_category') : (!empty($bd_lead_generation->lead_stage) ? $bd_lead_generation->lead_stage : null), ['class' => 'form-control text-center', 'id' => 'land_category', 'autocomplete' => 'off', 'required', 'readonly']) }}
            </div>
        </div>
        {{--        {{dd('ll')}} --}}
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="land_owner">Land Owner <span class="text-danger">*</span></label>
                {{ Form::text('land_owner', old('land_owner') ? old('land_owner') : (!empty($loName) ? $loName : null), ['class' => 'form-control text-center', 'id' => 'land_owner', 'readonly']) }}
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_category">Project Category<span
                        class="text-danger">*</span></label>
                {{ Form::text('project_category', old('project_category') ? old('project_category') : (!empty($bd_lead_generation->category) ? $bd_lead_generation->category : null), ['class' => 'form-control text-center', 'id' => 'project_category', 'autocomplete' => 'off', 'required', 'readonly']) }}
            </div>
        </div>
    </div><!-- end row -->
    <hr class="bg-success">
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>Surrendered land for road widening<span>&#10070;</span> </h5>
            </div>
            <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
                <thead>
                    <tr>
                        <th>Road Type</th>
                        <th>Proposed Road(Feet)</th>
                        <th>Existing Road(Feet)</th>
                        <th>Surrender <br/> Road Width(Feet)</th>
                        <th>Land Width(Feet)</th>
                        <th>Bonus FAR</th>
                        <th>Surrendered land for <br /> road widening</th>
                        <th>Additional FAR</th>
                        <th>
                            <button class="btn btn-success btn-sm addItem" type="button"><i
                                    class="fa fa-plus"></i></button>
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @if (old('material_id'))
                        @foreach (old('material_id') as $key => $materialOldData)
                            <tr>
                                <td>
                                    @if($loop->first)
                                    Front Road
                                    @else
                                    Side Road
                                    @endif
                                </td>
                                <td><input type="text" name="proposed_road[]" @if($loop->first) id='proposed_road_width' @endif value="{{ old('proposed_road')[$key] }}" class="form-control form-control text-center form-control-sm proposed_road" autocomplete="off"></td>
                                <td><input type="text" name="existing_road[]" value="{{ old('existing_road')[$key] }}" class="form-control form-control text-center form-control-sm existing_road" autocomplete="off"></td>
                                <td><input type="text" name="road_width[]" value="{{ old('road_width')[$key] }}"
                                        class="form-control text-center form-control-sm road_width" autocomplete="off"></td>
                                <td><input type="text" name="land_width[]" value="{{ old('land_width')[$key] }}"
                                        class="form-control text-center form-control-sm land_width" autocomplete="off"></td>
                                <td><input type="text" name="additional_far[]" value="{{ old('additional_far')[$key] }}"
                                        class="form-control text-center form-control-sm additional_far" autocomplete="off">
                                </td>
                                <td><input type="text" name="total_road_sft[]" value="{{ old('total_road_sft')[$key] }}"
                                        class="form-control text-center form-control-sm total_road_sft" tabindex="-1"
                                        readonly></td>
                                <td><input type="text" name="total_far_sft[]" value="{{ old('total_far_sft')[$key] }}"
                                        class="form-control text-center form-control-sm total_far_sft" tabindex="-1"
                                        readonly></td>
                                <td>
                                    @if(!$loop->first)
                                    <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                            class="fa fa-minus"></i></button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @elseif(count($previous_data))
                            @foreach ($previous_data->first()->road_details as $key => $OldData)
                                <tr>
                                    <td>
                                        @if($loop->first)
                                        Front Road
                                        @else
                                        Side Road
                                        @endif
                                    </td>
                                    <td><input type="text" @if($loop->first) id='proposed_road_width' @endif name="proposed_road[]" value="{{ $OldData?->proposed_road ?? 0 }}" class="form-control form-control text-center form-control-sm proposed_road" autocomplete="off"></td>
                                    <td><input type="text" name="existing_road[]" value="{{ $OldData?->existing_road ?? 0 }}" class="form-control form-control text-center form-control-sm existing_road" autocomplete="off"></td>
                                    <td><input type="text" name="road_width[]" value="{{ $OldData?->road_width ?? 0 }}"
                                            class="form-control text-center form-control-sm text-center road_width"
                                            tabindex="-1" autocomplete="off"></td>
                                    <td><input type="text" name="land_width[]" value="{{ $OldData->land_width ?? 0 }}"
                                            class="form-control text-center form-control-sm land_width" autocomplete="off">
                                    </td>
                                    <td><input type="text" name="additional_far[]"
                                            value="{{ $OldData->additional_far ?? 0 }}"
                                            class="form-control text-center form-control-sm additional_far"
                                            autocomplete="off"></td>
                                    <td><input type="text" name="total_road_sft[]"
                                            value="{{ $OldData?->road_width * $OldData->land_width ?? 0 }}"
                                            class="form-control text-center form-control-sm total_road_sft" tabindex="-1"
                                            readonly></td>
                                    <td><input type="text" name="total_far_sft[]"
                                            value="{{ $OldData?->road_width * $OldData->additional_far ?? 0 }}"
                                            class="form-control text-center form-control-sm total_far_sft" tabindex="-1"
                                            readonly></td>
                                    <td>
                                        @if(!$loop->first)
                                        <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                                class="fa fa-minus"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                    @else
                        <tr>
                            <td>Front Road</td>
                            <td><input type="text"  name="proposed_road[]" id='proposed_road_width' class="form-control form-control text-center form-control-sm proposed_road" autocomplete="off" ></td>
                            <td><input type="text" name="existing_road[]" value="{{ (!empty($bd_lead_generation->front_road_size) ? $bd_lead_generation->front_road_size : null) }}" class="form-control form-control text-center form-control-sm existing_road" autocomplete="off"></td>
                            <td><input type="text" name="road_width[]" class="form-control form-control text-center form-control-sm road_width" autocomplete="off"></td>
                            <td><input type="text" name="land_width[]" class="form-control text-center form-control-sm land_width" autocomplete="off"></td>
                            <td><input type="text" name="additional_far[]" class="form-control text-center form-control-sm additional_far" value=".05" autocomplete="off"></td>
                            <td><input type="text" name="total_road_sft[]" class="form-control text-center form-control-sm total_road_sft" tabindex="-1" readonly></td>
                            <td><input type="text" name="total_far_sft[]" class="form-control text-center form-control-sm total_far_sft" tabindex="-1" readonly></td>
                            <td></td>
                        </tr>
                        @if (count($bd_lead_generation->BdLeadGenerationSideRoads))
                            @foreach($bd_lead_generation->BdLeadGenerationSideRoads as $key => $value)
                                <tr>
                                    <td>Side Road</td>
                                    <td><input type="text" name="proposed_road[]" class="form-control form-control text-center form-control-sm proposed_road" autocomplete="off"></td>
                                    <td><input type="text" name="existing_road[]" value="{{$value->feet}}" class="form-control form-control text-center form-control-sm existing_road" autocomplete="off"></td>
                                    <td><input type="text" name="road_width[]" class="form-control form-control text-center form-control-sm road_width" autocomplete="off"></td>
                                    <td><input type="text" name="land_width[]" class="form-control text-center form-control-sm land_width" autocomplete="off"></td>
                                    <td><input type="text" name="additional_far[]" class="form-control text-center form-control-sm additional_far" value=".05" autocomplete="off"></td>
                                    <td><input type="text" name="total_road_sft[]" class="form-control text-center form-control-sm total_road_sft" tabindex="-1" readonly></td>
                                    <td><input type="text" name="total_far_sft[]" class="form-control text-center form-control-sm total_far_sft" tabindex="-1" readonly></td>
                                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                                </tr>
                            @endforeach
                        @endif
                        @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="text-right"> Grand Total </td>
                        <td>{{ Form::number('grand_road_sft', old('grand_road_sft') ? old('grand_road_sft') : (count($previous_data) ? $previous_data->first()->grand_road_sft : null), ['class' => 'form-control form-control-sm grand_road_sft text-center', 'id' => 'grand_road_sft', 'placeholder' => '0.00 ', 'readonly', 'tabindex' => '-1']) }}
                        <td>{{ Form::number('grand_far_sft', old('grand_far_sft') ? old('grand_far_sft') : (count($previous_data) ? $previous_data->first()->grand_far_sft : null), ['class' => 'form-control form-control-sm grand_far_sft text-center', 'id' => 'grand_far_sft', 'placeholder' => '0.00 ', 'readonly', 'tabindex' => '-1']) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        {{-- <div class="col-xl-3 col-md-3"></div> --}}
        <div class="col-xl-12 col-md-12">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-3">
                </div>
                <div class="col-md-3">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="project_id">Far For<span
                                class="text-danger"></span></label>
                        <input type="radio" id="katha" name="far_for"
                            style="height:20px; width:20px; margin-left: 30px; margin-top: 8px" value="katha"
                            {{ !empty($salaryHead) && $salaryHead->is_allocate == 1 ? 'checked' : '' }}>
                        <label style="margin-left: 5px; margin-top: 12px" for="katha">Katha</label><br>

                        <input type="radio" id="road" name="far_for"
                            style="height:20px; width:20px; margin-left: 30px; margin-top: 8px" value="road"
                            {{ !empty($salaryHead) && $salaryHead->is_allocate == 0 ? 'checked' : '' }}>
                        <label style="margin-left: 5px; margin-top: 12px" for="road">Road</label><br>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">

        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>Land Area</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="document">Document(Katha)<span class="text-danger">*</span></label>
                {{ Form::number('document', old('document') ? old('document') : (!empty($bd_lead_generation->land_size) ? $bd_lead_generation->land_size : null), ['class' => 'form-control text-center', 'id' => 'document', 'autocomplete' => 'off', 'required', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="total_sft">Total SFT<span class="text-danger">*</span></label>
                {{ Form::number('total_sft', old('total_sft') ? old('total_sft') : (!empty($projectLayout->first()->total_sft) ? $projectLayout->first()->total_sft : null), ['class' => 'form-control', 'id' => 'total_sft', 'autocomplete' => 'off', 'required', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>

        {{-- <div class="col-xl-3 col-md-3"></div>
        <div class="col-xl-6 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <p>Existing Road (Front)</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="front_road_width">width<span class="text-danger">*</span></label>
                {{ Form::number('front_road_width', old('front_road_width') ? old('front_road_width') : (!empty($bd_lead_generation->front_road_size) ? $bd_lead_generation->front_road_size : null), ['class' => 'form-control text-center', 'id' => 'front_road_width', 'autocomplete' => 'off', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div> --}}

        {{-- <div class="col-xl-3 col-md-3"></div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>Proposed Road (Front)</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="proposed_road_width">width<span
                        class="text-danger">*</span></label>
                {{ Form::number('proposed_road_width', old('proposed_road_width') ? old('proposed_road_width') : (!empty($projectLayout->first()->proposed_road_width) ? $projectLayout->first()->proposed_road_width : null), ['class' => 'form-control proposed_road_width', 'autocomplete' => 'off', 'required', 'min' => 0, 'max' => 100, 'step' => 0.01]) }}
            </div>
        </div> 
        <div class="col-xl-3 col-md-3"></div>--}}

        <div class="col-xl-3 col-md-3"></div>
        <div class="col-xl-6 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <p>Applicable Land Area</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                {{ Form::number('applicable_land_area', old('applicable_land_area') ? old('applicable_land_area') : (count($previous_data) ? $applicable_land : null), ['class' => 'form-control form-control-sm applicable_land_area text-center', 'id' => 'applicable_land_area', 'placeholder' => '0.00 ', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>

        <div class="col-xl-3 col-md-3"></div>
        <div class="col-xl-6 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <p>Proposed Land Area (Katha)</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                {{ Form::number('proposed_land_area', old('proposed_land_area') ? old('proposed_land_area') : (count($previous_data) ? $proposed_land : null), ['class' => 'form-control form-control-sm proposed_land_area text-center', 'id' => 'proposed_land_area', 'placeholder' => '0.00', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>

        <div class="col-xl-3 col-md-3"></div>
        <div class="col-xl-6 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <p>Basic FAR</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                {{ Form::number('basic_far', old('basic_far', $purchaseOrder->basic_far ?? null), ['class' => 'form-control form-control-sm basic_far text-center', 'id' => 'basic_far', 'placeholder' => '0.00 ', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>

        <div class="col-xl-3 col-md-3"></div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>Total FAR</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="modified_far">Modified FAR<span
                        class="text-danger">*</span></label>
                {{ Form::number('modified_far', old('modified_far') ? old('modified_far') : (count($previous_data) ? $previous_data->first()->modified_far : null), ['class' => 'form-control form-control-sm modified_far text-center', 'id' => 'modified_far', 'step=0.01', 'placeholder' => '0.00']) }}
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                {{ Form::number('total_far', old('total_far') ? old('total_far') : null, ['class' => 'form-control form-control-sm total_far text-center', 'id' => 'total_far', 'placeholder' => '0.00 ', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>

        <div class="col-xl-3 col-md-3"></div>
        <div class="col-xl-6 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <p>Total Area(within FAR)</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                {{ Form::number('total_area_with_far', old('total_area_with_far', $purchaseOrder->total_area_with_far ?? null), ['class' => 'form-control form-control-sm total_area_with_far text-center', 'id' => 'total_area_with_far', 'placeholder' => '0.00 ', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>

        <div class="col-xl-3 col-md-3"></div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>Land Area with MGC</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="proposed_road_width">MGC<span class="text-danger">*</span></label>
                {{ Form::number('actual_mgc', old('actual_mgc', $purchaseOrder->actual_mgc ?? null), ['class' => 'form-control form-control-sm actual_mgc text-center', 'id' => 'actual_mgc', 'placeholder' => '0.00 ', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                {{ Form::number('total_area_with_mgc', old('total_area_with_mgc', $purchaseOrder->total_area_with_mgc ?? null), ['class' => 'form-control form-control-sm total_area_with_mgc text-center', 'id' => 'total_area_with_mgc', 'placeholder' => '0.00 ', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>

        <div class="col-xl-3 col-md-3"></div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>Proposed Land Area with MGC</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="proposed_road_width">MGC<span class="text-danger">*</span></label>
                {{ Form::number('proposed_mgc', old('proposed_total_area') ? old('proposed_total_area') : (count($previous_data) ? $previous_data->first()->proposed_mgc : null), ['class' => 'form-control form-control-sm proposed_mgc text-center', 'id' => 'proposed_mgc', 'placeholder' => '0.00 ']) }}
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                {{ Form::number('proposed_total_area', old('proposed_total_area') ? old('proposed_total_area') : null, ['class' => 'form-control form-control-sm proposed_total_area text-center', 'id' => 'proposed_total_area', 'placeholder' => '0.00 ', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>


        <div class="col-xl-3 col-md-3"></div>
        <div class="col-xl-6 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <p>Story based on actual MGC</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                {{ Form::text('actual_story', old('actual_story') ? old('actual_story') : (count($previous_data) ? $previous_data->first()->actual_story : null), ['class' => 'form-control form-control-sm actual_story text-center', 'id' => 'actual_story', 'placeholder' => '0.00 ', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>

        <div class="col-xl-3 col-md-3"></div>
        <div class="col-xl-6 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <p>Proposed No. of Story</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                {{ Form::text('proposed_story', old('proposed_story', $purchaseOrder->proposed_story ?? null), ['class' => 'form-control form-control-sm proposed_story text-center', 'id' => 'proposed_story', 'placeholder' => '0.00 ', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>



        <div class="col-xl-3 col-md-3"></div>
        <div class="col-xl-6 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <p>Ground Floor Area(75% of Land Area)</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                {{ Form::text('ground_floor_area', old('ground_floor_area', $purchaseOrder->ground_floor_area ?? null), ['class' => 'form-control form-control-sm ground_floor_area text-center', 'id' => 'ground_floor_area', 'placeholder' => '0.00 ', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>

        <div class="col-xl-3 col-md-3"></div>
        <div class="col-xl-2 col-md-2">
            <div class="input-group input-group-sm input-group-primary">
                <p>Basement/Semi Basement FLoor Area</p>
            </div>
        </div>
        <div class="col-xl-2 col-md-2">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="total_basement_floor">Floor<span
                        class="text-danger">*</span></label>
                {{ Form::number('total_basement_floor', old('total_basement_floor') ? old('total_basement_floor') : (count($previous_data) ? $previous_data->first()->total_basement_floor : (!empty($bd_lead_generation->basement) ? $bd_lead_generation->basement : null)), ['class' => 'form-control form-control-sm total_basement_floor text-center', 'id' => 'total_basement_floor']) }}
            </div>
        </div>
        <div class="col-xl-2 col-md-2">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="percentage">Percent ( % )<span class="text-danger">*</span></label>
                {{ Form::number('percentage', old('percentage') ? old('percentage') : (count($previous_data) ? $previous_data->first()->percentage : 75), ['class' => 'form-control form-control-sm percentage text-center', 'id' => 'percentage', 'placeholder' => '75', 'tabindex' => '-1']) }}
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                {{ Form::number('total_basement_floor_area', old('total_basement_floor_area', $purchaseOrder->total_basement_floor_area ?? null), ['class' => 'form-control form-control-sm total_basement_floor_area text-center', 'id' => 'total_basement_floor_area', 'placeholder' => '0.00 ', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>
        <div class="col-xl-3 col-md-3"></div>
        <div class="col-xl-4 col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <p>Side Verenda</p>
            </div>
        </div>
        <div class="col-xl-2 col-md-2">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="side_ver_spc_per">Feet ( % )<span class="text-danger">*</span></label>
                {{ Form::number('side_ver_spc_per', old('side_ver_spc_per') ? old('side_ver_spc_per') : (count($previous_data) ? $previous_data->first()->side_ver_spc_per : 2.5), ['class' => 'form-control form-control-sm side_ver_spc_per text-center', 'id' => 'side_ver_spc_per', 'placeholder' => '2.5', 'tabindex' => '-1']) }}
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                {{ Form::number('total_side_verenda', old('total_side_verenda', $purchaseOrder->total_side_verenda ?? null), ['class' => 'form-control form-control-sm total_side_verenda text-center', 'id' => 'total_side_verenda', 'placeholder' => '0.00 ', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>Front Verenda</p>
            </div>
        </div>
        <div class="col-xl-2 col-md-2">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="front_verenda_feet">Feet<span class="text-danger">*</span></label>
                {{ Form::number('front_verenda_feet', old('front_verenda_feet') ? old('front_verenda_feet') : (count($previous_data) ? $previous_data->first()->front_verenda_feet : null), ['class' => 'form-control form-control-sm front_verenda_feet text-center', 'id' => 'front_verenda_feet', 'placeholder' => '0.00 ']) }}
            </div>
        </div>
        <div class="col-xl-2 col-md-2">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="front_verenda_percent">Percent ( % )<span
                        class="text-danger">*</span></label>
                {{ Form::number('front_verenda_percent', old('front_verenda_percent') ? old('front_verenda_percent') : (count($previous_data) ? $previous_data->first()->front_verenda_percent : 30), ['class' => 'form-control form-control-sm front_verenda_percent text-center', 'id' => 'front_verenda_percent', 'placeholder' => '30', 'tabindex' => '-1']) }}
            </div>
        </div>
        <div class="col-xl-2 col-md-2">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="front_ver_spc_per">Per Feet<span class="text-danger">*</span></label>
                {{ Form::number('front_ver_spc_per', old('front_ver_spc_per') ? old('front_ver_spc_per') : (count($previous_data) ? $previous_data->first()->front_ver_spc_per : 3.25), ['class' => 'form-control form-control-sm front_ver_spc_per text-center', 'id' => 'front_ver_spc_per', 'placeholder' => '3.25', 'tabindex' => '-1']) }}
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                {{ Form::number('total_front_verenda', old('total_front_verenda', $purchaseOrder->total_front_verenda ?? null), ['class' => 'form-control form-control-sm total_front_verenda text-center', 'id' => 'total_front_verenda', 'placeholder' => '0.00 ', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>

        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>Total Buildup Area (without FAR)</p>
            </div>
        </div>
        <div class="col-xl-6 col-md-6"></div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                {{ Form::number('total_buildup_area', old('total_buildup_area', $purchaseOrder->total_buildup_area ?? null), ['class' => 'form-control form-control-sm total_buildup_area text-center', 'id' => 'total_buildup_area', 'placeholder' => '0.00 ', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>


    </div>

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
        $(function() {
            calculateTotalGroundCoverage();
            calculateFar();
            calculateTotalFar()
            totalOperation()
            gerFarValue()
        })

        function calculateTotalGroundCoverage() {
            let document = $("#document").val() > 0 ? parseFloat($("#document").val()) : 0;
            let per_sft = 720;
            let total_sft = document * per_sft;
            $("#total_sft").val((total_sft).toFixed(2));
        }

        $(document).on('change','input[type=radio][name=far_for], #proposed_road_width',function() {
            gerFarValue();
            // calculateFar();
            calculateTotalFar()
        });

        function calculateFar() {
            @if (count($previous_data))
            $.ajax({
                url: "{{ route('scj.getFARvalue') }}",
                type: 'get',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    proposed_land_area: $("#proposed_land_area").val(),
                    project_category: $("#project_category").val(),
                    front_road_width: $("#proposed_road_width").val(),
                    far_for: $('input[name="far_for"]:checked').val(),
                },
                success: function(data) {
                    $('#basic_far').val(data.far);
                    $('#actual_mgc').val(data.max_ground_coverage);
                    $('#total_far').val(Number(data.far) + {{ $previous_data->first()->modified_far }});
                    $('#total_area_with_far').val((Number(data.far) +
                        {{ $previous_data->first()->modified_far }}) * {{ $applicable_land }});
                    $('#total_area_with_mgc').val(Number(data.max_ground_coverage) *
                        {{ $applicable_land }} / 100);
                    $("#proposed_total_area").val({{ $previous_data->first()->proposed_mgc }} *
                        {{ $applicable_land }} / 100);
                    let proposed_story = ((Number(data.far) +
                        {{ $previous_data->first()->modified_far }}) * {{ $applicable_land }}) / (
                        {{ $previous_data->first()->proposed_mgc }} * {{ $applicable_land }} / 100);
                    $("#proposed_story").val("G + " + proposed_story.toFixed(2));
                    $("#ground_floor_area").val({{ $applicable_land }} * 0.75);
                    $("#total_basement_floor_area").val({{ $applicable_land }} * 0.75 *
                        {{ $previous_data->first()->total_basement_floor }});
                    let total_side_varenda = ({{ $previous_data->first()->proposed_mgc }} *
                        {{ $applicable_land }} / 100) * 0.025
                    $("#total_side_verenda").val(total_side_varenda.toFixed(2));
                    $('#total_front_verenda').val({!! $previous_data->first()->front_verenda_feet ?? 0 !!} * 0.30 * 3.25);
                    $('#total_buildup_area').val(((Number(data.far) +
                        {{ $previous_data->first()->modified_far }}) * {{ $applicable_land }}) + (
                        {{ $applicable_land }} * 0.75) + ({{ $applicable_land }} * 0.75 *
                        {{ $previous_data->first()->total_basement_floor }}) + (
                        {!! $previous_data->first()->front_verenda_feet ?? 0 !!} * 0.30 * 3.25) + ((
                        {{ $previous_data->first()->proposed_mgc }} * {{ $applicable_land }} /
                        100) * 0.025));
                    return false;
                }
            });
            @endif
        }

        // Function for calculating modified Value

        @if ($formType == 'create' && !$previous_data)
        addRow();
        @endif

        function addRow() {
            let row = `
                <tr>
                    <td>Side Road</td>
                    <td><input type="text" name="proposed_road[]" class="form-control form-control text-center form-control-sm proposed_road" autocomplete="off"></td>
                    <td><input type="text" name="existing_road[]" class="form-control form-control text-center form-control-sm existing_road" autocomplete="off"></td>
                    <td><input type="text" name="road_width[]" class="form-control form-control text-center form-control-sm road_width" autocomplete="off"></td>
                    <td><input type="text" name="land_width[]" class="form-control text-center form-control-sm land_width" autocomplete="off"></td>
                    <td><input type="text" name="additional_far[]" class="form-control text-center form-control-sm additional_far" value=".05" autocomplete="off"></td>
                    <td><input type="text" name="total_road_sft[]" class="form-control text-center form-control-sm total_road_sft" tabindex="-1" readonly></td>
                    <td><input type="text" name="total_far_sft[]" class="form-control text-center form-control-sm total_far_sft" tabindex="-1" readonly></td>
                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            $('#itemTable tbody').append(row);
            calculateTotalRoadSFT(this);
            calculateTotalFarSFT(this);
            totalOperation();
            calculateTotalFar();
        }

        $("#itemTable").on('click', ".addItem", function() {
            addRow();

        }).on('click', '.deleteItem', function() {
            $(this).closest('tr').remove();
            calculateTotalRoadSFT(this);
            calculateTotalFarSFT(this);
            totalOperation();
            calculateTotalFar();
        });

        $("#itemBasementTable").on('click', ".addItem", function() {
            addBasementRow();
        }).on('click', '.deleteItem', function() {
            $(this).closest('tr').remove();
        });

        // Function for deleting a row
        function removQRow(qval) {
            var rowIndex = qval.parentNode.parentNode.rowIndex;
            document.getElementById("purchaseTable").deleteRow(rowIndex);
            totalOperation();
        }
        
        // Function for calculating total Road SFT
        function calculateTotalRoadSFT(thisVal) {
            let road_width = $(thisVal).closest('tr').find('.road_width').val() > 0 ? parseFloat($(thisVal).closest('tr')
                .find('.road_width').val()) : 0;
            let land_width = $(thisVal).closest('tr').find('.land_width').val() > 0 ? parseFloat($(thisVal).closest('tr')
                .find('.land_width').val()) : 0;
            let total_road_sft = (road_width * land_width).toFixed(2);
            $(thisVal).closest('tr').find('.total_road_sft').val(total_road_sft);
            totalOperation();
        }

        // Function for calculating total FAR SFT
        function calculateTotalFarSFT(thisVal) {
            let road_width = $(thisVal).closest('tr').find('.road_width').val() > 0 ? parseFloat($(thisVal).closest('tr')
                .find('.road_width').val()) : 0;
            let additional_far = $(thisVal).closest('tr').find('.additional_far').val() > 0 ? parseFloat($(thisVal).closest(
                'tr').find('.additional_far').val()) : 0;
            let total_far_sft = (road_width * additional_far).toFixed(2);
            $(thisVal).closest('tr').find('.total_far_sft').val(total_far_sft);
            totalOperation();
        }

        // Function for calculating total FAR SFT total_area_with_far
        function calculateTotalFar() {
            let basic_far = $("#basic_far").val() > 0 ? parseFloat($("#basic_far").val()) : 0;
            let modified_far = $("#modified_far").val() > 0 ? parseFloat($("#modified_far").val()) : 0;
            let applicable_land_area = $("#applicable_land_area").val() > 0 ? parseFloat($("#applicable_land_area").val()) :
                0;
            let actual_mgc = $("#actual_mgc").val() > 0 ? parseFloat($("#actual_mgc").val()) : 0;
            let proposed_mgc = $("#proposed_mgc").val() > 0 ? parseFloat($("#proposed_mgc").val()) : 0;
            let total_basement_floor = $("#total_basement_floor").val() > 0 ? parseFloat($("#total_basement_floor").val()) :
                0;
            let front_verenda_feet = $("#front_verenda_feet").val() > 0 ? parseFloat($("#front_verenda_feet").val()) : 0;
            let basement_percent = $("#percentage").val() > 0 ? parseFloat($("#percentage").val()) : 0;
            let side_ver_spc_per = $("#side_ver_spc_per").val() > 0 ? parseFloat($("#side_ver_spc_per").val()) : 0;
            let front_ver_spc_per = $("#front_ver_spc_per").val() > 0 ? parseFloat($("#front_ver_spc_per").val()) : 0;
            let front_verenda_percent = $("#front_verenda_percent").val() > 0 ? parseFloat($("#front_verenda_percent").val()) : 0;
            let total_far = (modified_far + basic_far);
            let total_area_with_far = (total_far * applicable_land_area);
            let total_area_with_mgc = (actual_mgc * applicable_land_area / 100).toFixed(2);
            let proposed_total_area = (proposed_mgc * applicable_land_area / 100).toFixed(2);
            let actual_story = (total_area_with_far / total_area_with_mgc).toFixed(2);
            let proposed_story = (total_area_with_far / proposed_total_area).toFixed(2);
            let ground_floor_area = (applicable_land_area * 0.75);
            let total_basement_floor_area = (applicable_land_area *  Number(basement_percent) / 100 * total_basement_floor);
            let total_front_verenda = (front_verenda_feet * Number(front_verenda_percent) / 100 * Number(front_ver_spc_per));
            let total_side_verenda = (proposed_total_area * Number(side_ver_spc_per) / 100);

            let total_buildup_area = (total_area_with_far + ground_floor_area + total_basement_floor_area +
                total_front_verenda + total_side_verenda);
            console.log(total_far);
            $("#total_far").val(total_far);
            $("#total_area_with_far").val(total_area_with_far);
            $("#total_area_with_mgc").val(total_area_with_mgc);
            $("#proposed_total_area").val(proposed_total_area);
            $("#proposed_story").val("G + " + proposed_story);
            $("#actual_story").val("G + " + actual_story);
            $("#ground_floor_area").val(ground_floor_area.toFixed(2));
            $("#total_basement_floor_area").val(total_basement_floor_area);
            $("#total_front_verenda").val(total_front_verenda);
            $("#total_side_verenda").val(total_side_verenda.toFixed(2));
            $("#total_buildup_area").val(total_buildup_area.toFixed(2));
        }

        // Function for calculating total Operation
        function totalOperation() {
            var road_total = 0;
            var far_total = 0;
            var modifiedfar_total = 0;
            if ($(".total_road_sft").length > 0) {
                $(".total_road_sft").each(function(i, row) {
                    var total_road_sft = Number($(row).val());
                    road_total += parseFloat(total_road_sft);
                })
            }
            if ($(".total_far_sft").length > 0) {
                $(".total_far_sft").each(function(i, row) {
                    var total_far_sft = Number($(row).val());
                    far_total += parseFloat(total_far_sft);
                    modifiedfar_total += total_far_sft < .2 ? total_far_sft : .2;
                })
            }
            $("#grand_road_sft").val(road_total.toFixed(2));
            let modification_far = far_total < .2 ? far_total : .2;
            $("#grand_far_sft").val(far_total.toFixed(2));
            $("#modified_far").val(modifiedfar_total.toFixed(2))
            var applicable_land_area = $("#total_sft").val() - road_total;
            $("#applicable_land_area").val(applicable_land_area.toFixed(2));
            var proposed_land_area = applicable_land_area / 720;
            $("#proposed_land_area").val(proposed_land_area.toFixed(2)).trigger('change');
        }

        var CSRF_TOKEN = "{{ csrf_token() }}";

        // $("#proposed_land_area").on('change', function() {
        //     gerFarValue()
        // });

        function gerFarValue() {
            $.ajax({
                url: "{{ route('scj.getFARvalue') }}",
                type: 'get',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    proposed_land_area: $("#proposed_land_area").val(),
                    project_category: $("#project_category").val(),
                    front_road_width: $("#proposed_road_width").val(),
                    far_for: $('input[name="far_for"]:checked').val(),
                },
                success: function(data) {
                    $('#basic_far').val(data.far);
                    $('#actual_mgc').val(data.max_ground_coverage);
                    calculateTotalFar();
                    return false;
                }
            });
        }

        // modified_far

        $(document).on('keyup change', '.road_width,.land_width', function() {
            calculateTotalRoadSFT(this);
            calculateFar()
            calculateTotalFar()
            // calculateTotalFarSFT()
        });
        $(document).on('keyup change', '.additional_far, .land_width, .road_width', function() {
            calculateTotalFarSFT(this);
            calculateTotalFar()
        });

        $(document).on('keyup change', '.modified_far, .proposed_mgc, .front_verenda_feet, .total_basement_floor ,#percentage,#side_ver_spc_per,#front_verenda_percent,#front_ver_spc_per',
            function() {
                calculateTotalFar();
            });
        $(document).on('keyup change', '.proposed_road, .existing_road',function() {
           let proposed_road = $(this).closest('tr').find('.proposed_road').val() > 0 ? $(this).closest('tr').find('.proposed_road').val() : 0;
           let existing_road = $(this).closest('tr').find('.existing_road').val() > 0 ? $(this).closest('tr').find('.existing_road').val() : 0;
           $(this).closest('tr').find('.road_width').val(0);
           if(Number(proposed_road)>Number(existing_road)){
                $(this).closest('tr').find('.road_width').val((proposed_road-existing_road)/2);
           }
           calculateTotalFarSFT(this);
           calculateTotalFar()
        });

     
        $(function() { 
            document.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                }
            });
            
        }) // Document.Ready
    </script>
    
@endsection

