@extends('boq.departments.sanitary.layout.app')
@section('title', 'BOQ - Sanitary')

@section('breadcrumb-title')
    Update Material Rate
@endsection

@section('project-name')
    {{$project->name}}
@endsection

@section('breadcrumb-button')
@include('components.buttons.breadcrumb-button', ['route' => route('boq.project.departments.sanitary.material-rates.index',['project' => $project->id]), 'type' => 'index'])
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @php($project = session()->get('project_id'))
            @if(!empty($sanitaryMaterialRate))
                {!! Form::open(array('url' => "boq/project/$project/departments/sanitary/material-rates/$sanitaryMaterialRate->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
                <input type="hidden" name="id" value="{{old('id') ? old('id') : (isset($sanitaryMaterialRate) ? $sanitaryMaterialRate->id : null)}}">
            @endif
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="calculation_table">
                            <thead>
                                <tr class="electrical_calc_head">
                                    <th> Item <span class="text-danger">*</span></th>
                                    <th class=""> Unit<span class="text-danger">*</span></th>
                                    <th class="material_rate_th"> Material Unit Rate <span class="text-danger">*</span></th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <input type="hidden" name="material_name" class="form-control text-center form-control-sm material_name" readonly tabindex="-1" value="{{ $sanitaryMaterialRate->material_id }}">
                                    {{ $sanitaryMaterialRate->material->name }}
                                </td>
                                <td> <input type="text" class="form-control form-control-sm unit text-center" readonly value="{{ $sanitaryMaterialRate->material->unit->name }}"></td>
                                <td> <input type="number" name="material_rate" class="form-control form-control-sm material_rate" required value="{{ $sanitaryMaterialRate->material_rate }}"></td>
                            </tr>
                        </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="offset-md-4 col-md-4 mt-2">
                        <div class="input-group input-group-sm ">
                            <button class="btn btn-success btn-round btn-block py-2">Update Rate</button>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>


@endsection
