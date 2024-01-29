@extends('boq.departments.sanitary.layout.app')
@section('title', 'BOQ - Material Rates')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Material Rates
@endsection

@section('project-name')
    {{ session()->get('project_name') }}
@endsection

{{-- @section('breadcrumb-button')
@can('project-create')
<a href="{{ route('boq.project.departments.sanitary.material-rates.create',['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endcan
@endsection --}}

@section('sub-title')
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr style="background-color: #2ed8b6!important;">
                    <td class="text-center" colspan="13">
                        <h5 style="color: white" class="text-center">Residential Part</h5>
                    </td>
                </tr>
                <tr>
                    <th rowspan="2">Apartment Type</th>
                    <th rowspan="2">No</th>
                    <th colspan="2">Master Bath</th>
                    <th colspan="2">Child Bath</th>
                    <th colspan="2">Common Bath</th>
                    <th colspan="2">S.Toilet</th>
                    <th colspan="2">Kitchen</th>
                    @can('boq-sanitary')
                    <th rowspan="2">Action</th>
                    @endcan
                </tr>
                <tr>
                    <th>JHL</th>
                    <th>LO</th>
                    <th>JHL</th>
                    <th>LO</th>
                    <th>JHL</th>
                    <th>LO</th>
                    <th>JHL</th>
                    <th>LO</th>
                    <th>JHL</th>
                    <th>LO</th>
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
                        <td>{{ $projecttype->type_name ?? '' }}</td>
                        <td>{{ $projecttype ? $projecttype->typeApartments->count() : 0 }}</td>
                        @foreach ($allocation as $key => $data)
                            @foreach ($data as $d)
                                <td>{{ $d->fc_quantity }}</td>
                                <td>{{ $d->owner_quantity }}</td>
                            @endforeach
                        @endforeach
                        @can('boq-sanitary')
                        @if ($loop->first)
                            <td rowspan="{{ $rows }}">
                                <div class="icon-btn">
                                    <nobr>
                                        <a href="{{ url("boq/project/$project->id/departments/sanitary/sanitary-allocations-view", 'Residential') }}"
                                            data-toggle="tooltip" title="View" class="btn btn-outline-info"><i
                                                class="fas fa-eye"></i></a>
                                        <a href="{{ url("boq/project/$project->id/departments/sanitary/sanitary-allocations-edit", 'Residential') }}"
                                            data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                                class="fas fa-pen"></i></a>
                                        {!! Form::open([
                                            'url' => 'sanitary-allocations/1',
                                            'method' => 'delete',
                                            'class' => 'd-inline',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Delete',
                                        ]) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                        {!! Form::close() !!}
                                    </nobr>
                                </div>
                            </td>
                        @endif
                        @endcan
                    </tr>
                @endforeach
                <tr style="background-color: #2ed8b6!important;">
                    <td class="text-center" colspan="13">
                        <h5 style="color: white" class="text-center">Commercial Part</h5>
                    </td>
                </tr>
                <tr>
                    <th>Floor Details</th>
                    <th>No of Floor</th>
                    <th colspan="2">Toilet</th>
                    <th colspan="2">Wash Basin</th>
                    <th colspan="2">Urinal</th>
                    <th colspan="2">Pantry </th>
                    <th colspan="2">Common Toilet </th>
                    @can('boq-sanitary')
                    <th>Action</th>
                    @endcan
                </tr>

                @foreach ($allocationsCommercial as $key => $comdata)
                    <tr style="background-color: #c9e8dd">
                        <td> {{ $comdata['floor'] }}</td>
                        <td> {{ $comdata['floor_no'] }}</td>
                        @foreach ($comdata['typeWiseQuantity'] as $d)
                            <td colspan="2">{{ $d['fc_quantity'] }}</td>
                        @endforeach
                        @if ($loop->first)
                            <td rowspan="{{ $rows }}">
                                <div class="icon-btn">
                                    <nobr>
                                        <a href="{{ url("boq/project/$project->id/departments/sanitary/sanitary-allocations-view", 'Commercial') }}"
                                            data-toggle="tooltip" title="View" class="btn btn-outline-info"><i
                                                class="fas fa-eye"></i></a>
                                        <a href="{{ url("boq/project/$project->id/departments/sanitary/sanitary-allocations-edit", 'Commercial') }}"
                                            data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                                class="fas fa-pen"></i></a>
                                        {!! Form::open([
                                            'url' => 'sanitary-allocations/1',
                                            'method' => 'delete',
                                            'class' => 'd-inline',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Delete',
                                        ]) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                        {!! Form::close() !!}
                                    </nobr>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach

            </tbody>
        </table>
        <div class="float-right"></div>

    </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function() {
            $('#dataTable').DataTable({
                stateSave: true,
                bPaginate: false,
                ordering: false
            });
        });

        const CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {
            $('#parent_id').on('change', function() {
                var material_id = $(this).val();
                var selected_data = $("#parent_id_second");
                $.ajax({
                    url: "{{ url('scj/getChildMaterial') }}",
                    type: 'GET',
                    data: {
                        'material_id': material_id
                    },
                    success: function(data) {
                        $(selected_data).parent('div').find('.material').html();
                        $(selected_data).parent('div').find('.material').html(data);
                    }
                });
            })
        })
    </script>
@endsection
