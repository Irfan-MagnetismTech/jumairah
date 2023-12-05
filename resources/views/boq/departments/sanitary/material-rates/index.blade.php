@extends('boq.departments.sanitary.layout.app')
@section('title', 'BOQ - Material Rates')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Material Rates
@endsection

@section('project-name')
    {{$project->name}}
@endsection

@section('breadcrumb-button')
    @can('project-create')
        <a href="{{ route('boq.project.departments.sanitary.material-rates.create',['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
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
                        {{Form::select('parent_id', $leyer1NestedMaterial, old('parent_id[0]') ? old('parent_id[0]') : (!empty($nestedmaterial->parent_id) ? $layer1 : null),['class' => 'form-control form-control-sm material','id' => 'parent_id', 'placeholder'=>"Select 1st layer material Name", 'autocomplete'=>"off"])}}
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
                <th>Sl</th>
                <th >Material Name</th>
                <th >Unit</th>
                <th >Rate Per Unit</th>
                @can('boq-sanitary')
                <th>Action</th>
                @endcan
            </tr>
            </thead>
            <tbody>
            @foreach($materials as $key => $material)
                <tr style="background-color: #c9e8dd">
                    <td><b>{{$firstSl = $loop->iteration}}</b></td>
                    <td class="text-left"><b>{{$material->name}}</b></td>
                    <td class=""></td>
                    <td class="text-right"></td>
                    @can('boq-sanitary')
                    <td>
                        {{-- @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.project.departments.sanitary.material-rates', 'route_key' => ['project' => $project,'material_rate' => $material->id]]) --}}
                    </td>
                    @endcan
                </tr>
                @php($sl = 1)
                @foreach($material->sanitaryMaterials as $sanitaryMaterials)
                    @if($sanitaryMaterials->isNotEmpty())
                        @foreach($sanitaryMaterials as $sanitaryMaterial)
                            <tr>
                                <td >{{$firstSl}}.{{$sl++}}</td>
                                <td class="text-left" style="padding-left: 20px!important;">{{$sanitaryMaterial->material->name}}</td>
                                <td class="">{{$sanitaryMaterial->material->unit->name}}</td>
                                <td class="text-right">{{$sanitaryMaterial->material_rate}}</td>
                                @can('boq-sanitary')
                                <td>
                                    @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.project.departments.sanitary.material-rates', 'route_key' => ['project' => $project, 'material_rate' => $sanitaryMaterial->id]])
                                </td>
                                @endcan
                            </tr>
                        @endforeach
                    @endif
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
                bPaginate: true,
                ordering : false,
            });
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
        })
    </script>
@endsection
