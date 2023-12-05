@extends('layouts.backend-layout')
@section('title', 'Existing Budget')

@section('breadcrumb-title')
    Floor wise Summary for {{ $projectName->name }}
@endsection

@section('breadcrumb-button')
    <a href="{{ url("material_summery/$budgetFor/$project_id") }}" data-toggle="tooltip" title="Material Summary"
        class="btn btn-out-dashed btn-sm btn-primary"><i class="ti-list"></i></a>
    @can('boqSupremeBudgets-edit')
        <a href="{{ url("supreme-budget-edit/$budgetFor/$project_id") }}" data-toggle="tooltip" title="Edit"
        class="btn btn-sm btn-outline-primary"><i class="fas fa-pen"></i></a>
    @endcan
    <a href="{{ url("supreme-budget-list/$budgetFor") }}" data-toggle="tooltip" title="Projects"
        class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
    {{-- {!! Form::open(array('url' => "boqSupremeBudgets/$project_id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
    {!! Form::close() !!} --}}
@endsection


@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    <form action="" method="get">
        <div class="row px-2">
            <div class="col-md-2 px-1 my-1 my-md-0" data-toggle="tooltip" title="Output">
                <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                    <option value="list" selected> List </option>
                    <option value="pdf"> PDF </option>
                </select>
            </div>
            <div class="col-md-3 px-1 my-1 my-md-0" data-toggle="tooltip" title="Project Status">
                {{ Form::select('floor_id', $floors, old('floor_id') ? old('floor_id') : (!empty(request()) ? request('floor_id') : null), ['class' => 'form-control form-control-sm ', 'placeholder' => 'Select Floor', 'autocomplete' => 'off']) }}
            </div>
            <div class="col-md-2 px-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-center">
                        <tr style="background-color: #0C4A77;color: white">
                            {{--                            <td> <strong>{{ $boq_supreme_budget_data['projectData']->name }}</strong></td> --}}
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Floor Name </th>
                    <th>SL</th>
                    <th>Material Name</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @php($j = $sl)
                @foreach ($boq_supreme_budget_data as $key => $boq_supreme_budget)
                    @foreach ($boq_supreme_budget as $value)
                        <tr>
                            @if ($loop->first)
                                <td rowspan="{{ count($boq_supreme_budget) }}"> {{ $value->boqFloorProject->floor->name }}
                                </td>
                            @endif
                            <td>{{ $j++ }}</td>
                            <td class="text-left"> {{ $value->nestedMaterial->name }} </td>
                            <td> {{ $value->nestedMaterial->unit->name }} </td>
                            <td> {{ $value->quantity }} </td>
                            <td> {{ $value->remarks }} </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        {{ !empty($boq_supreme_budget_data) ? $boq_supreme_budget_data->withQueryString()->links() : '' }}
    </div>
@endsection
