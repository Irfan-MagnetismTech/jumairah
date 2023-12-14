@extends('boq.departments.sanitary.layout.app')
@section('title', 'BOQ - Material Rates')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Formulas
@endsection

@section('project-name')
    {{session()->get('project_name')}}
@endsection
@section('breadcrumb-button')
    @can('project-create')
        <a href="{{ route('boq.project.departments.sanitary.sanitary-formulas.create',['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
@endsection

    @section('content')
            <!-- put search form here.. -->
            <form action="" method="get">
                <div class="row px-2">
                    <div class="col-md-1 px-1 my-1" data-toggle="tooltip" title="Output">
                        <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                            <option value="list" selected> List </option>
                            <option value="pdf"> PDF </option>
                        </select>
                    </div>
                    <div class="col-md-3 px-1 my-1">
                        {{Form::select('parent_id', $leyer1NestedMaterial=[], old('parent_id[0]') ? old('parent_id[0]') : (!empty($nestedmaterial->parent_id) ? $layer1 : null),['class' => 'form-control form-control-sm material','id' => 'parent_id', 'placeholder'=>"Select 1st layer material Name", 'autocomplete'=>"off"])}}
                    </div>
                    <div class="col-md-3 px-1 my-1">
                        {{Form::select('parent_id_second', !empty($nestedmaterial->parent_id) ? $leyer2NestedMaterial : [],old('parent_id_second') ? old('parent_id_second') : (!empty($nestedmaterial->parent_id) ? $layer2 : null),['class' => 'form-control form-control-sm material','id' => 'parent_id_second', 'placeholder'=>"Select 2nd layer material Name", 'autocomplete'=>"off"])}}
                    </div>

                    <div class="col-md-1 px-1 my-1">
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
                <th >Material Name</th>
                <th >Multiply Term</th>
                @can('boq-sanitary')
                <th>Action</th>
                @endcan
            </tr>
            </thead>
            <tbody>
                @php
                    $locationFor = ['Commercial','Residential']
                @endphp
            @foreach($SanitaryFormulaDatas as $key => $SanitaryFormulaData)
                <tr style="background-color: #c9e8dd">
                    <td>{{$psl = $loop->iteration}}</td>
                    <td class="text-left"><b>{{$SanitaryFormulaData->location_type}}</b>
                    </td>
                    <td class="">{{ $locationFor[$SanitaryFormulaData->location_for] }}</td>
                    @can('boq-sanitary')
                    <td>
                        @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.project.departments.sanitary.sanitary-formulas', 'route_key' => ['project' => $project,'sanitary_formula'=>$SanitaryFormulaData->id,'calculation' => 4]])
                    </td>
                    @endcan
                </tr>
                @foreach($SanitaryFormulaData->sanitaryFormulaDetails as  $sanitaryFormulaDetail)
                    <tr>
                        <td>{{$psl}}.{{$loop->iteration}}</td>
                        <td class="text-left" style="padding-left: 20px">{{$sanitaryFormulaDetail->material->name}}</td>
                        <td class="text-center">{{$sanitaryFormulaDetail->multiply_qnt}}</td>
                        @can('boq-sanitary')
                        <td>
                            @include('components.buttons.action-button', [
                                'actions' => ['custom','delete'],
                                'route' => 'boq.project.departments.sanitary.DeleteIndividualSanitaryFormulaDetails',
                                  'route_key' => ['project' => $project,'id'=>$sanitaryFormulaDetail->id,'calculation' => 4],
                                  'function' => "onClick='popup_modal_edit($sanitaryFormulaDetail->id)'",
                                  'class' => 'edit_popup'])
                        </td>
                        @endcan
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
        <div class="float-right">

        </div>
    </div>






{{--  modal start--}}

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document" style="min-width: 900px!important;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel"> Edit Formula</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
        {!! Form::open(['url' => 'boq/project/$project->id/departments/sanitary/UpdateIndividualSanitaryFormulaDetails', 'method' => 'POST', 'class' => 'custom-form']) !!}
        <div class="modal-body table-responsive" id="edit-modal-body">


            @if ($errors->any())
            <div class="alert alert-danger icons-alert mb-2 p-2" id="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="icofont icofont-close-line-circled"></i>
                </button>
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

           <hr />
           <div class="table-responsive">
                <table class="table table-bordered nowrap table-styling table-hover">
                    <thead>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-round py-2" data-dismiss="modal">Close</button>
            <button class="btn btn-success btn-round py-2">Save</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
</div>
{{--  modal end--}}

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
                bPaginate: true,
                ordering : false
            });
            $(function(){
                $('.edit_popup').on('click',function(){
                    // alert();
                })
            })
        });

        const CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {
            $('#parent_id').on('change',function(){
                var material_id = $(this).val();
                var selected_data = $("#parent_id_second");
                $.ajax({
                    url:"{{ url('scj/getChildMaterial') }}",
                    type: 'GET',
                    data: {'material_id': material_id},
                    success: function(data){
                        $(selected_data).parent('div').find('.material').html();
                        $(selected_data).parent('div').find('.material').html(data);
                    }
                });
            })

            $(document).on('change keyup','#material_rate,#quantity',function(){
                let material_rate = $('#material_rate').val() ?? 0;
                let quantity = $('#quantity').val() ?? 0;
                $('#total_rate').val(material_rate*quantity);
            })


        })



    function popup_modal_edit(id){
                // $('#editModal').modal('show');
    const url = '{{ url("boq/project/$project->id/departments/sanitary/getSanitaryFormulaDetailsInfo") }}/' + id;

    fetch(url)
    .then((resp) => resp.json())
    .then(function(data) {
        $('#edit-modal-body').empty();
        console.log(data);
       var modalelement = `
       <input type="hidden" name="id" value="${data[0].id}"  class="id" >
       <input type="hidden" name="project_id" value="{{ $project->id }}"  class="id" >
            <div class="table-responsive">
                <table class="table table-bordered nowrap table-styling table-hover">
                    <thead>
                        <tr class="electrical_calc_head">
                                        <th> Item <span class="text-danger">*</span></th>
                                        <th class="material_rate_th"> Unit <span class="text-danger">*</span></th>
                                        <th class="material_rate_th"> Multiply Qnt <span class="text-danger">*</span></th>
                                        <th class="material_rate_th"> Addition Qnt <span class="text-danger">*</span></th>
                                        <th class="material_rate_th"> Formula <span class="text-danger">*</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="hidden" name="material_id" value="${data[0].material_id}"  class="material_id" >
                                <input type="text" name="material_name" value='${data[0].material.name}' class="form-control form-control-sm material_name" readonly tabindex="-1">
                            </td>
                            <td>
                                <input type="text" name="unit" value='${data[0].material.unit.name}' class="form-control form-control-sm text-center unit" readonly tabindex="-1"> </td>
                            <td>
                                <input type="number" name="multiply_qnt" value='${data[0].multiply_qnt }' class="form-control form-control-sm text-center multiply_qnt" required placeholder="0.00" id="multiply_qnt"> </td>
                            <td>
                                <input type="number" name="additional_qnt" value='${data[0].additional_qnt }' class="form-control form-control-sm text-center additional_qnt" required placeholder="0.00" id="additional_qnt"> </td>
                            <td>
                                <input type="text" name="formula" value='${data[0].formula }' class="form-control form-control-sm text-center formula" required readonly id="formula">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>`
            $('#edit-modal-body').append(modalelement);
            $('#editModal').modal('show');
            })
        }
        $(document).on('keyup','#multiply_qnt, #additional_qnt', function (){
            changeFormula($(this));
        })
        function changeFormula (thisVal){
            let multiplyVal = $('#multiply_qnt').val();
            let additionalVal = $('#additional_qnt').val();
            let formula = "1 * "+ multiplyVal + " + " + additionalVal
            $('#formula').val(formula);
        }
    </script>
@endsection
