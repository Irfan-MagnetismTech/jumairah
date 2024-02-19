@extends('layouts.backend-layout')
@section('title', 'Projects')

@section('breadcrumb-title')
    @if($formType == 'edit')
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

    @if($formType == 'edit')
        {!! Form::open(array('url' => "projects/$project->id",'encType' =>"multipart/form-data", 'method' => 'PUT', 'class'=>'custom-form')) !!}
        <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($project->id) ? $project->id : null)}}">
    @else
        {!! Form::open(array('url' => "projects",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="name">Project Name<span class="text-danger">*</span></label>
                    {{Form::text('name', old('name') ? old('name') : (!empty($project->name) ? $project->name : null),['class' => 'form-control','id' => 'name', 'autocomplete'=>"off"],'required')}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="shortName">Project Short Name<span class="text-danger">*</span></label>
                    {{Form::text('shortName', old('shortName') ? old('shortName') : (!empty($project->shortName) ? $project->shortName : null),['class' => 'form-control','id' => 'shortName', 'autocomplete'=>"off"],'required')}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="category">Category<span class="text-danger">*</span></label>
                    {{Form::select('category', $category, old('category') ? old('category') : (!empty($project->category) ? $project->category : null), ['class' => 'form-control','id' => 'category', 'placeholder' => 'Select category','required'])}}

                </div>
            </div>
            <div class="col-xl-8 col-md-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="location">Location<span class="text-danger">*</span></label>
                    {{Form::textarea('location', old('location') ? old('location') : (!empty($project->location) ? $project->location : null),['class' => 'form-control','id' => 'location', 'autocomplete'=>"off",'required', 'rows'=>1])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="signing_date">Signing Date<span class="text-danger">*</span></label>
                    {{Form::text('signing_date', old('signing_date') ? old('signing_date') : (!empty($project->signing_date) ? $project->signing_date :  null),['class' => 'form-control','id' => 'signing_date', 'placeholder'=>'dd-mm-yyyy','autocomplete'=>"off", 'required'])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="storied">Storied<span class="text-danger">*</span></label>
                    {{Form::number('storied',  old('storied') ? old('storied') : (!empty($project->storied) ? $project->storied : null),['class' => 'form-control','id' => 'storied','autocomplete'=>"off",'min'=>0,'required'])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6" id="residentialStoriedArea" @if(!empty($project) && $project->category!='Residential cum Commercial') style="display: none" @endif>
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="res_storied_from"> Storied (Res)<span class="text-danger">*</span></label>
                    {{Form::number('res_storied_from',  old('res_storied_from') ? old('res_storied_from') : (!empty($project->res_storied_from) ? $project->res_storied_from : null),['class' => 'form-control','id' => 'res_storied_from','autocomplete'=>"off",'min'=>0])}}
                    <label class="input-group-addon text-center" for="res_storied_from"> To <span class="text-danger">*</span></label>
                    {{Form::number('res_storied_to',  old('res_storied_to') ? old('res_storied_to') : (!empty($project->res_storied_to) ? $project->res_storied_to : null),['class' => 'form-control','id' => 'res_storied_to','autocomplete'=>"off",'min'=>0])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6" id="CommercialStoriedArea" @if(!empty($project) && $project->category!='Residential cum Commercial') style="display: none" @endif>
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="com_storied_from">  Storied (Com)<span class="text-danger">*</span></label>
                    {{Form::number('com_storied_from',  old('com_storied_from') ? old('com_storied_from') : (!empty($project->com_storied_from) ? $project->com_storied_from : null),['class' => 'form-control','id' => 'com_storied_from','autocomplete'=>"off",'min'=>0])}}
                    <label class="input-group-addon" for="com_storied_from">  To <span class="text-danger">*</span></label>
                    {{Form::number('com_storied_to',  old('com_storied_to') ? old('com_storied_to') : (!empty($project->com_storied_to) ? $project->com_storied_to : null),['class' => 'form-control','id' => 'com_storied_to','autocomplete'=>"off",'min'=>0])}}
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="cda_approval_date">CDA Approv. Date<span class="text-danger">*</span></label>
                    {{Form::text('cda_approval_date', old('cda_approval_date') ? old('cda_approval_date') : (!empty($project->cda_approval_date) ? $project->cda_approval_date : null),['class' => 'form-control','id' => 'cda_approval_date', 'placeholder'=>'dd-mm-yyyy','autocomplete'=>"off",'required'])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="innogration_date">Inauguration Date</label>
                    {{Form::text('innogration_date', old('innogration_date') ? old('innogration_date') : (!empty($project->innogration_date) ? $project->innogration_date :null),['class' => 'form-control','id' => 'innogration_date','placeholder'=>'dd-mm-yyyy', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="handover_date">Handover Date</label>
                    {{Form::text('handover_date', old('handover_date') ? old('handover_date') : (!empty($project->handover_date) ? $project->handover_date :  null),['class' => 'form-control','id' => 'handover_date','placeholder'=>'dd-mm-yyyy', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="landsize">Land Size (Katha)<span class="text-danger">*</span></label>
                    {{Form::number('landsize', old('landsize') ? old('landsize') : (!empty($project->landsize) ? $project->landsize: null),['class' => 'form-control','id' => 'landsize', 'autocomplete'=>"off",'min'=>0,'step'=>0.01,'required'])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="buildup_area">Buildup Area(SFT)<span class="text-danger">*</span></label>
                    {{Form::number('buildup_area', old('buildup_area') ? old('buildup_area') : (!empty($project->buildup_area) ? $project->buildup_area : null),['class' => 'form-control','id' => 'buildup_area', 'autocomplete'=>"off" ,'required','min'=>0, 'step'=>0.01])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="sellable_area">Saleable Area(SFT)<span class="text-danger">*</span></label>
                    {{Form::number('sellable_area', old('sellable_area') ? old('sellable_area') : (!empty($project->sellable_area) ? $project->sellable_area : null),['class' => 'form-control','id' => 'sellable_area', 'autocomplete'=>"off", 'required','min'=>0,'step'=>0.01])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_cost">Project Cost<span class="text-danger">*</span></label>
                    {{Form::number('project_cost', old('project_cost') ? old('project_cost') : (!empty($project->project_cost) ? $project->project_cost : null),['class' => 'form-control','id' => 'project_cost', 'autocomplete'=>"off" ,'required','min'=>0,'step'=>0.01])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="units">Total Units<span class="text-danger">*</span></label>
                    {{Form::number('units', old('units') ? old('units') : (!empty($project->units) ? $project->units : null),['class' => 'form-control','id' => 'units',  'autocomplete'=>"off",'required','min'=>0])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="parking">Total Parking <span class="text-danger">*</span></label>
                    {{Form::number('parking', old('parking') ? old('parking') : (!empty($project->parking) ? $project->parking : null),['class' => 'form-control','id' => 'parking', 'autocomplete'=>"off",'required','min'=>0])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="lift">Lift </label>
                    {{Form::number('lift', old('lift') ? old('lift') : (!empty($project->lift) ? $project->lift : null),['class' => 'form-control','id' => 'lift', 'autocomplete'=>"off",'min'=>0])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="generator">Generator (KVA) </label>
                    {{Form::text('generator', old('generator') ? old('generator') : (!empty($project->generator) ? $project->generator : null),['class' => 'form-control','id' => 'generator', 'autocomplete'=>"off",])}}
                </div>
            </div>
            <div class="col-xl-8 col-md-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="features">Special Features </label>
                    {{Form::textarea('features', old('features') ? old('features') : (!empty($project->features) ? $project->features : null),['class' => 'form-control','id' => 'features', 'autocomplete'=>"off",'rows'=>'2'])}}
                </div>
            </div>
        </div><!-- end row -->
        <hr class="bg-success">
        <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="landowner_share">LO Share<span class="text-danger">*</span></label>
                    {{Form::number('landowner_share', old('landowner_share') ? old('landowner_share') : (!empty($project->landowner_share) ? $project->landowner_share : null),['class' => 'form-control','id' => 'landowner_share', 'autocomplete'=>"off", 'required','min'=>0, 'max'=>100,'step'=>0.01])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="developer_share">Developer Share<span class="text-danger">*</span></label>
                    {{Form::number('developer_share', old('developer_share') ? old('developer_share') : (!empty($project->developer_share) ? $project->developer_share : null),['class' => 'form-control','id' => 'developer_share', 'autocomplete'=>"off" , 'required','min'=>0,'max'=>100,'step'=>0.01])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="lO_sellable_area">LO saleable Area<span class="text-danger">*</span></label>
                    {{Form::number('lO_sellable_area', old('lO_sellable_area') ? old('lO_sellable_area') : (!empty($project->lO_sellable_area) ? $project->lO_sellable_area : null),['class' => 'form-control','id' => 'lO_sellable_area', 'autocomplete'=>"off", 'required','min'=>0,'step'=>0.01])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="developer_sellable_area">Dev.saleable Area<span class="text-danger">*</span></label>
                    {{Form::number('developer_sellable_area', old('developer_sellable_area') ? old('developer_sellable_area') : (!empty($project->developer_sellable_area) ? $project->developer_sellable_area : null),['class' => 'form-control','id' => 'developer_sellable_area', 'autocomplete'=>"off", 'required','min'=>0,'step'=>0.01])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="landowner_unit">LO Units<span class="text-danger">*</span></label>
                    {{Form::number('landowner_unit', old('landowner_unit') ? old('landowner_unit') : (!empty($project->landowner_unit) ? $project->landowner_unit : null),['class' => 'form-control','id' => 'landowner_unit', 'autocomplete'=>"off", 'required','min'=>0,'step'=>0.01])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="developer_unit">Developer Units<span class="text-danger">*</span></label>
                    {{Form::number('developer_unit', old('developer_unit') ? old('developer_unit') : (!empty($project->developer_unit) ? $project->developer_unit : null),['class' => 'form-control','id' => 'developer_unit', 'autocomplete'=>"off" , 'required','min'=>0,'step'=>0.01])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="landowner_parking">LO Parking<span class="text-danger">*</span></label>
                    {{Form::number('landowner_parking', old('landowner_parking') ? old('landowner_parking') : (!empty($project->landowner_parking) ? $project->landowner_parking : null),['class' => 'form-control','id' => 'landowner_parking', 'autocomplete'=>"off", 'required','min'=>0,'step'=>0.01])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="developer_parking">Developer Parking<span class="text-danger">*</span></label>
                    {{Form::number('developer_parking', old('developer_parking') ? old('developer_parking') : (!empty($project->developer_parking) ? $project->developer_parking : null),['class' => 'form-control','id' => 'developer_parking', 'autocomplete'=>"off" , 'required','min'=>0,'step'=>0.01])}}
                </div>
            </div>
            @role('super-admin')
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="landowner_cash_benefit">Cash Benefit</label>
                    {{Form::number('landowner_cash_benefit', old('landowner_cash_benefit') ? old('landowner_cash_benefit') : (!empty($project->landowner_cash_benefit) ? $project->landowner_cash_benefit : null),['class' => 'form-control','id' => 'landowner_cash_benefit', 'autocomplete'=>"off",'min'=>0,'step'=>0.01])}}
                </div>
            </div>
            @endrole
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="basement">Basement<span class="text-danger">*</span></label>
                    {{Form::number('basement', old('basement') ? old('basement') : (!empty($project->basement) ? $project->basement : 0),['class' => 'form-control','id' => 'basement',  'autocomplete'=>"off",'required','min'=>0])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                  <div class="input-group input-group-sm input-group-primary">
                       <label class="input-group-addon" for="types">Total Types<span class="text-danger">*</span></label>
                       {{Form::number('types', old('types') ? old('types') : (!empty($project->types) ? $project->types : null),['class' => 'form-control','id' => 'types', 'min'=>0, 'autocomplete'=>"off", 'required'])}}
                  </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="rebate_charge">Rebate Charge<span class="text-danger">*</span></label>
                    {{Form::number('rebate_charge', old('rebate_charge') ? old('rebate_charge') : (!empty($project->rebate_charge) ? $project->rebate_charge : 0),['class' => 'form-control','id' => 'rebate_charge', 'min'=>0, 'step'=>0.01, 'autocomplete'=>"off", 'required','data-toggle'=>"tooltip",'title'=>"Yearly Percentage(%)"])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="delay_charge">Delay Charge<span class="text-danger">*</span></label>
                    {{Form::number('delay_charge', old('delay_charge') ? old('delay_charge') : (!empty($project->delay_charge) ? $project->delay_charge : 0),['class' => 'form-control','id' => 'delay_charge', 'min'=>0, 'step'=>0.01, 'autocomplete'=>"off", 'required','data-toggle'=>"tooltip",'title'=>"Monthly Percentage(%)"])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="rental_compensation">Rental <br> Compensation<span class="text-danger">*</span></label>
                    {{Form::number('rental_compensation', old('rental_compensation') ? old('rental_compensation') : (!empty($project->rental_compensation) ? $project->rental_compensation : null),['class' => 'form-control','id' => 'rental_compensation', 'min'=>0, 'step'=>0.01, 'autocomplete'=>"off", 'required','data-toggle'=>"tooltip",'title'=>"Rental Compensation in Percentage(%)"])}}
                </div>
            </div>
        </div> <!-- end row -->



    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="picture">Supplimentary <br/> Agreement</label>
                {{Form::file('agreement',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('agreement').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($project) && $project->agreement)
                <p class="text-right mt-0 pt-0"><a href="{{ asset($project->agreement) }}" target="_blank">See Current Agreement</a></p>
            @endif
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="floor_plan"> Floor Plan</label>
                {{Form::file('floor_plan',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('floor_plan').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($project) && $project->floor_plan)
                <p class="text-right mt-0 pt-0"><a href="{{ asset($project->floor_plan) }}" target="_blank">See Current Foor Plan</a></p>
            @endif
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="others"> Others </label>
                {{Form::file('others',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('others').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($project) && $project->others)
                <p class="text-right mt-0 pt-0"><a href="{{ asset($project->others) }}" target="_blank">See Current Others Flie</a></p>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="photo"> Photo</label>
                {{Form::file('photo',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('photo').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($project) && $project->photo)
                <p class="text-right mt-0 pt-0"><a href="{{ asset($project->photo) }}" target="_blank">See Current Photo</a></p>
            @endif
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="nid"> NID </label>
                {{Form::file('nid',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('nid').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($project) && $project->nid)
                <p class="text-right mt-0 pt-0"><a href="{{ asset($project->nid) }}" target="_blank">See Current NID Flie</a></p>
            @endif
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="tin"> TIN</label>
                {{Form::file('tin',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('tin').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($project) && $project->tin)
                <p class="text-right mt-0 pt-0"><a href="{{ asset($project->tin) }}" target="_blank">See Current TIN</a></p>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="doa"> DOA</label>
                {{Form::file('doa',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('doa').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($project) && $project->doa)
                <p class="text-right mt-0 pt-0"><a href="{{ asset($project->doa) }}" target="_blank">See Current DOA</a></p>
            @endif
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="poa"> POA </label>
                {{Form::file('poa',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('poa').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($project) && $project->poa)
                <p class="text-right mt-0 pt-0"><a href="{{ asset($project->poa) }}" target="_blank">See Current POA</a></p>
            @endif
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="khajna_receipt"> Khajna Receipt</label>
                {{Form::file('khajna_receipt',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('khajna_receipt').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($project) && $project->khajna_receipt)
                <p class="text-right mt-0 pt-0"><a href="{{ asset($project->khajna_receipt) }}" target="_blank">See Current Khajna Receipt</a></p>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="khatiyan"> Khatiyan</label>
                {{Form::file('khatiyan',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('khatiyan').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($project) && $project->khatiyan)
                <p class="text-right mt-0 pt-0"><a href="{{ asset($project->khatiyan) }}" target="_blank">See Current Khatiyan</a></p>
            @endif
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="warishion_certificate"> Warishion Certificate </label>
                {{Form::file('warishion_certificate',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('warishion_certificate').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($project) && $project->warishion_certificate)
                <p class="text-right mt-0 pt-0"><a href="{{ asset($project->warishion_certificate) }}" target="_blank">See Current Warishion Certificate</a></p>
            @endif
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="luc"> LUC</label>
                {{Form::file('luc',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('luc').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($project) && $project->luc)
                <p class="text-right mt-0 pt-0"><a href="{{ asset($project->luc) }}" target="_blank">See Current LUC</a></p>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="cda"> CDA Approval <br/> Letter</label>
                {{Form::file('cda',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('cda').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($project) && $project->cda)
                <p class="text-right mt-0 pt-0"><a href="{{ asset($project->cda) }}" target="_blank">See Current CDA Plan</a></p>
            @endif
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="nec"> NEC </label>
                {{Form::file('nec',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('nec').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($project) && $project->nec)
                <p class="text-right mt-0 pt-0"><a href="{{ asset($project->nec) }}" target="_blank">See Current NEC</a></p>
            @endif
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="electricity_bill"> Electricity Bill</label>
                {{Form::file('electricity_bill',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('electricity_bill').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($project) && $project->electricity_bill)
                <p class="text-right mt-0 pt-0"><a href="{{ asset($project->electricity_bill) }}" target="_blank">See Current Electricity Bill</a></p>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="wasa_billl"> Wasa billl</label>
                {{Form::file('wasa_billl',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('wasa_billl').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($project) && $project->wasa_billl)
                <p class="text-right mt-0 pt-0"><a href="{{ asset($project->wasa_billl) }}" target="_blank">See Current Wasa billl</a></p>
            @endif
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="holding_tex"> Holding Tex </label>
                {{Form::file('holding_tex',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('holding_tex').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($project) && $project->holding_tex)
                <p class="text-right mt-0 pt-0"><a href="{{ asset($project->holding_tex) }}" target="_blank">See Current Holding Tex</a></p>
            @endif
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="gas_bill"> Gas Bill</label>
                {{Form::file('gas_bill',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('gas_bill').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($project) && $project->gas_bill)
                <p class="text-right mt-0 pt-0"><a href="{{ asset($project->gas_bill) }}" target="_blank">See Current Gas Bill</a></p>
            @endif
        </div>
    </div>

    <hr class="bg-success">

    <div class="table-responsive">
        <table id="typeTable" class="table table-striped table-bordered" >
            <thead>
            <tr>
                <th>Type Name </th>
                <th>Size (SFT)</th>
                @if(!empty($project))
                <th>Action</th>
                @endif
            </tr>
            </thead>
            <tbody>

            @if(old('type_name'))
                @foreach(old('type_name') as $key=>$oldType)
                    <tr>
                        <td>
                            <input type="text" name="type_name[]" value="{{old('type_name')[$key]}}" class="form-control form-control-sm text-right"  autocomplete="off" id="type_name">
                        </td>
                        <td>
                            <input type="number" name="size[]" value="{{old('size')[$key]}}" class="form-control form-control-sm text-right" id="size"  autocomplete="off" step="0.01" min="0" required>
                        </td>

                        <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button"><i class="fa fa-minus"></i></button></td>
                    </tr>
                @endforeach
            @else
                @if(!empty($project))
                    @foreach($project->projectType as $projectType)
                        <tr>
                            <td>{{Form::text('type_name[]', old('type_name') ? old('type_name') : (!empty($projectType->type_name) ? $projectType->type_name : null),['class' => 'form-control form-control-sm text-right', 'id'=>'type_name','autocomplete'=>"off",'required'] )}}</td>
                            <td>{{Form::number('size[]', old('size') ? old('size') : (!empty($projectType->size) ? $projectType->size : null),['class' => 'form-control form-control-sm text-right', 'id'=>'size','min'=>'0', 'step'=>'0.01','autocomplete'=>"off",'required'] )}}</td>
                            <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button"><i class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @endif
            @endif

            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="offset-md-4 col-md-4 mt-4">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div> <!-- end row -->
    {!! Form::close() !!}
@endsection
@section('script')

    <script>
        $("#types").on('change', function(){
            let i, row, types = $(this).val() > 0 ? parseInt($(this).val()) : 0;
            let tableItem = $('#typeTable tbody');
            tableItem.empty();

            for(i = 1; i <= types; i++){
                row += `
                <tr>
                    <td><input type="text" name="type_name[]" class="form-control  item_unit" id='type_name' placeholder = "Enter Type Name"  autocomplete="off" required></td>
                    <td><input type="number" name="size[]" class="form-control  text-right" min='0' id='size' step='0.01' autocomplete="off" required></td>
                    <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button"><i class="fa fa-minus"></i></button></td>
                </tr>
                `;
            }
            tableItem.append(row);
        });
        $("#category").on('change', function (){
            let catVal = $("#category").val();
            if(catVal == 'Residential cum Commercial'){
                $("#residentialStoriedArea").show(1000);
                $("#CommercialStoriedArea").show(1000);
                $("#res_storied_from").prop('required', true);
                $("#res_storied_to").prop('required', true);
                $("#com_storied_from").prop('required', true);
                $("#com_storied_to").prop('required', true);
            }else {
                $("#residentialStoriedArea").hide(1000);
                $("#CommercialStoriedArea").hide(1000);
                $("#residentialStoriedArea").val(null);
                $("#CommercialStoriedArea").val(null);
                $("#res_storied_from").prop('required', false);
                $("#res_storied_to").prop('required', false);
                $("#com_storied_from").prop('required', false);
                $("#com_storied_to").prop('required', false);
            }
        })

        $('#cda_approval_date,#innogration_date,#handover_date,#signing_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

        $("#landowner_share").on('change keyup', function(){
            calculateDeveloperShare();
        });
        function calculateDeveloperShare(){
            let landowner_share = $("#landowner_share").val() > 0 ? parseFloat($("#landowner_share").val()): 0;
            let developer_share = ( 100- landowner_share).toFixed(2);
            $("#developer_share").val(developer_share);

        }
        $("#developer_share").on('change keyup', function(){
            calculateLandOwnerShare();
        });
        function calculateLandOwnerShare(){
            let developer_share = $("#developer_share").val() > 0 ? parseFloat($("#developer_share").val()): 0;
            let landowner_share = ( 100- developer_share).toFixed(2);
            $("#landowner_share").val(landowner_share);

        }
        $("#units,#developer_share,#landowner_share").on('change keyup', function(){
            calculateUnitShare();
        });
        function calculateUnitShare(){
            let units = $("#units").val() > 0 ? parseFloat($("#units").val()): 0;
            let developer_share = $("#developer_share").val() > 0 ? parseFloat($("#developer_share").val()): 0;
            let landowner_share = $("#landowner_share").val() > 0 ? parseFloat($("#landowner_share").val()): 0;

            let landowner_unit = (units * (landowner_share / 100)).toFixed(2);
            let developer_unit = (units * (developer_share / 100)).toFixed(2);
            $("#landowner_unit").val(landowner_unit);
            $("#developer_unit").val(developer_unit);
        }

        $("#units,#developer_unit").on('change keyup', function(){
            calculateLandOwnerUnitShare();
        });
        function calculateLandOwnerUnitShare(){
            let units = $("#units").val() > 0 ? parseFloat($("#units").val()): 0;
            let developer_unit = $("#developer_unit").val() > 0 ? parseFloat($("#developer_unit").val()): 0;
            let landowner_unit = ( units- developer_unit).toFixed(2);
            $("#landowner_unit").val(landowner_unit);
        }

        $("#units,#landowner_unit").on('change keyup', function(){
            calculateDeveloperUnitShare();
        });
        function calculateDeveloperUnitShare(){
            let units = $("#units").val() > 0 ? parseFloat($("#units").val()): 0;
            let landowner_unit = $("#landowner_unit").val() > 0 ? parseFloat($("#landowner_unit").val()): 0;
            let developer_unit = ( units- landowner_unit).toFixed(2);
            $("#developer_unit").val(developer_unit);
        }



        $("#parking,#developer_share,#landowner_share").on('change keyup', function(){
            calculateParkingShare();
        });
        function calculateParkingShare(){
            let parking= $("#parking").val() > 0 ? parseFloat($("#parking").val()): 0;
            let developer_share = $("#developer_share").val() > 0 ? parseFloat($("#developer_share").val()): 0;
            let landowner_share = $("#landowner_share").val() > 0 ? parseFloat($("#landowner_share").val()): 0;

            let landowner_parking = (parking * (landowner_share/100)).toFixed(2);
            let developer_parking = ( parking * (developer_share/100)).toFixed(2);
            $("#landowner_parking").val(landowner_parking);
            $("#developer_parking").val(developer_parking);
        }

        $("#parking,#developer_parking").on('change keyup', function(){
            calculateLandOwnerParkingShare();
        });
        function calculateLandOwnerParkingShare(){
            let parking = $("#parking").val() > 0 ? parseFloat($("#parking").val()): 0;
            let developer_parking = $("#developer_parking").val() > 0 ? parseFloat($("#developer_parking").val()): 0;
            let landowner_parking = ( parking-developer_parking).toFixed(2);
            $("#landowner_parking").val(landowner_parking);
        }

        $("#parking,#landowner_parking").on('change keyup', function(){
            calculateDeveloperParkingShare();
        });
        function calculateDeveloperParkingShare(){
            let parking = $("#parking").val() > 0 ? parseFloat($("#parking").val()): 0;
            let landowner_parking = $("#landowner_parking").val() > 0 ? parseFloat($("#landowner_parking").val()): 0;
            let developer_parking = ( parking- landowner_parking).toFixed(2);
            $("#developer_parking").val(developer_parking);
        }

        $("#sellable_area,#developer_share,#landowner_share").on('change keyup', function(){
            calculateSellableAreaShare();
        });
        function calculateSellableAreaShare(){
            let sellable_area= $("#sellable_area").val() > 0 ? parseFloat($("#sellable_area").val()): 0;
            let developer_share = $("#developer_share").val() > 0 ? parseFloat($("#developer_share").val()): 0;
            let landowner_share = $("#landowner_share").val() > 0 ? parseFloat($("#landowner_share").val()): 0;

            let lO_sellable_area = (sellable_area * (landowner_share/100)).toFixed(2);
            let developer_sellable_area = ( sellable_area * (developer_share/100)).toFixed(2);
            $("#lO_sellable_area").val(lO_sellable_area);
            $("#developer_sellable_area").val(developer_sellable_area);
        }

        $("#sellable_area,#developer_sellable_area").on('change keyup', function(){
            calculateLandOwnerSellableArea();
        });
        function calculateLandOwnerSellableArea(){
            let sellable_area = $("#sellable_area").val() > 0 ? parseFloat($("#sellable_area").val()): 0;
            let developer_sellable_area = $("#developer_sellable_area").val() > 0 ? parseFloat($("#developer_sellable_area").val()): 0;
            let lO_sellable_area = ( sellable_area-developer_sellable_area).toFixed(2);
            $("#lO_sellable_area").val(lO_sellable_area);
        }

        $("#sellable_area,#lO_sellable_area").on('change keyup', function(){
            calculateDeveloperSellableArea();
        });
        function calculateDeveloperSellableArea() {
            let sellable_area = $("#sellable_area").val() > 0 ? parseFloat($("#sellable_area").val()) : 0;
            let lO_sellable_area = $("#lO_sellable_area").val() > 0 ? parseFloat($("#lO_sellable_area").val()) : 0;
            let developer_sellable_area = (sellable_area - lO_sellable_area).toFixed(2);
            $("#developer_sellable_area").val(developer_sellable_area);

        }


            $(function(){
            @if($formType == 'create')
                addItemDtl();
            @endif
        });

        function removQRow(qval){
            var rowIndex = qval.parentNode.parentNode.rowIndex;
            document.getElementById("typeTable").deleteRow(rowIndex);
            let types = $("#types").val() > 0 ? parseInt($("#types").val()): 0;
             types = (types -1);
            $("#types").val(types);


        }



    </script>
@endsection
