@extends('boq.departments.sanitary.layout.app')
@section('title', 'BOQ - Sanitary')

@section('breadcrumb-title')
    @if ($formType == 'create')
        Create
    @else
        Edit
    @endif
    Budget Summary
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

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
@section('style')

<style>

    .radio_container {
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      font-size: 15px;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;

    }

    /* Hide the browser's default radio button */
    .radio_container input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      box-sizing: border-box
    }
    .checkmark {
      position: absolute;
      top: 5%;
      left: 0;
      height: 20px;
      width: 20px;
      margin-left: 5px;
      background-color: #227447;
      border-radius: 50%;
    }
    .radio_container:hover input ~ .checkmark {
      background-color: #ccc;
    }
    .radio_container input:checked ~ .checkmark {
      background-color: #227447;
    }
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }
    .radio_container input:checked ~ .checkmark:after {
      display: block;
    }
    .radio_container .checkmark:after {
         top: 6px;
        left: 6px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }
</style>
@endsection
    <div class="row">
        <div class="col-md-12">
            @php($project = session()->get('project_id'))
            @if(!empty($sanitaryBudgetSummary))
                {!! Form::open(array('url' => "boq/project/$project/departments/sanitary/sanitary-budget-summaries/$sanitaryBudgetSummary->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
                <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($sanitaryBudgetSummary->id) ? $sanitaryBudgetSummary->id : null)}}">
            @else
                {!! Form::open(array('url' => "boq/project/$project/departments/sanitary/sanitary-budget-summaries",'method' => 'POST', 'class'=>'custom-form')) !!}
            @endif
                <div class="row">
                    <div class="col-md-6 offset-md-3 pr-md-1 mb-2 pt-2 d-flex justify-content-around" style="border:1px solid rgb(210, 223, 221);float:left">
                        <label class="radio_container">Main Budget
                          <input type="radio" id="main" class="main" value="0" name="type" {{ (((!empty(old('type')) && (old('type') == '0')) || (isset($sanitaryBudgetSummary) && ($sanitaryBudgetSummary->type == 0))) ? 'checked': "checked") }}>
                          <span class="checkmark"></span>
                        </label>
                        <label class="radio_container">Incremental Budget
                          <input type="radio" id="incremental" class="incremental" value="1" name="type" {{ (((!empty(old('type')) && (old('type') == '1')) || (isset($sanitaryBudgetSummary) && ($sanitaryBudgetSummary->type == 1)))  ? 'checked' : "") }}>
                          <span class="checkmark"></span>
                        </label>
                  </div>
                  <input type="hidden" name="project_id" value="{{old('project_id') ? old('project_id') : (!empty($sanitaryBudgetSummary->project_id) ? $sanitaryBudgetSummary->project_id : $project)}}">
                    <div class="col-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="buildup_area">Buildup Area <span class="text-danger">*</span></label>
                            {{Form::text('buildup_area', old('buildup_area') ? old('buildup_area') : (!empty($projectData) ? $projectData->boqFloorProjects()->sum('area') : null),['class' => 'form-control','id' => 'buildup_area', 'autocomplete'=>"off",'readonly'])}}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="type">Rate per Unit<span class="text-danger">*</span></label>
                            {{Form::text('rate_per_unit', old('rate_per_unit') ? old('rate_per_unit') : (!empty($sanitaryBudgetSummary->rate_per_unit) ? $sanitaryBudgetSummary->rate_per_unit : null),['class' => 'form-control','id' => 'rate_per_unit', 'autocomplete'=>"off"])}}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="type">Total Amount<span class="text-danger">*</span></label>
                            {{Form::text('total_amount', old('total_amount') ? old('total_amount') : (!empty($sanitaryBudgetSummary->total_amount) ? $sanitaryBudgetSummary->total_amount : null),['class' => 'form-control','id' => 'total_amount', 'autocomplete'=>"off",'required','readonly'])}}
                        </div>
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
        $("#rate_per_unit").on('keyup change', function (){
            let rate = $("#rate_per_unit").val();
            let area = $("#buildup_area").val();
            let total = rate * area;
            $("#total_amount").val(total);
        })

        $("#incremental").on('click',function (){
            $("#total_amount").attr("readonly", false);
        })
        $("#main").on('click',function (){
            $("#total_amount").attr("readonly", true);
        })
    </script>
@endsection
