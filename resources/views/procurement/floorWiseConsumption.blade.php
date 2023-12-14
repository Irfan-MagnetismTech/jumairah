@extends('layouts.backend-layout')
@section('title', 'Existing Budget')

@section('breadcrumb-title')
    {{-- Floor wise Summary for {{ $projectName->name }} --}}
@endsection

@section('breadcrumb-button')
    {{-- <a href="{{ url("material_summery/$budgetFor/$project_id") }}" data-toggle="tooltip" title="Material Summary"
        class="btn btn-out-dashed btn-sm btn-primary"><i class="ti-list"></i></a>
    <a href="{{ url("supreme-budget-edit/$budgetFor/$project_id") }}" data-toggle="tooltip" title="Edit"
        class="btn btn-sm btn-outline-primary"><i class="fas fa-pen"></i></a>
    <a href="{{ url("supreme-budget-list/$budgetFor") }}" data-toggle="tooltip" title="Projects"
        class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a> --}}
    {{-- {!! Form::open(array('url' => "boqSupremeBudgets/$project_id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
    {!! Form::close() !!} --}}
@endsection


@section('content-grid')

@section('content')
    <form action="" method="get">
        <div class="row px-2">
            <div class="col-md-1 px-1 my-1 my-md-0" data-toggle="tooltip" title="Output">
                <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                    <option value="list" selected> List </option>
                    <option value="pdf"> PDF </option>
                </select>
            </div>
            <div class="col-md-3 px-1 my-1 my-md-0">
                <input type="text" id="project_name" name="project_name" class="form-control form-control-sm"
                    value="" placeholder="Enter Project Name" autocomplete="off">
                <input type="hidden" id="project_id" name="project_id" class="form-control form-control-sm" value="">
            </div>
            <div class="col-md-3 px-1 my-1 my-md-0" data-toggle="tooltip" title="Project Status">
                {{ Form::select('floor_id', $floors, old('floor_id') ? old('floor_id') : (!empty(request()) ? request('floor_id') : null), ['class' => 'form-control form-control-sm ', 'placeholder' => 'Select Floor', 'id' => 'floor_id']) }}
            </div>
            <div class="col-md-1 px-1 my-1 my-md-0">
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
                    <th rowspan="2">Floor Name </th>
                    <th rowspan="2">SL</th>
                    <th rowspan="2">Material Name</th>
                    <th rowspan="2">Unit</th>
                    <th colspan="3">Budget</th>
                    <th colspan="3">Consumption</th>
                    <th rowspan="2">Balance <br> Quantity</th>
                </tr>
                <tr>
                    <th>Quantity</th>
                    <th>Unit Rate</th>
                    <th>Total</th>
                    <th>Quantity</th>
                    <th>Unit Rate</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php($j = $sl)
                @foreach ($boq_supreme_budget_data as $key => $boq_supreme_budget)
                    @foreach ($boq_supreme_budget as $value)
                        <?php
                        // dd($value->material_id, $value->floor_id, $project_id);
                        
                        $boqRate = \App\Boq\Departments\Civil\BoqCivilBudget::where('project_id', $project_id)
                            ->whereRelation('boqFloor', 'boq_floor_id', $value->floor_id)
                            ->where('nested_material_id', $value->material_id)
                            ->first();
                        ?>
                        <tr>
                            @if ($loop->first)
                                <td rowspan="{{ count($boq_supreme_budget) }}"> {{ $value->boqFloorProject->floor->name }}
                                </td>
                            @endif
                            <td>{{ $j++ }} {{ $boqRate }}</td>
                            <td class="text-left"> {{ $value->nestedMaterial->name }} </td>
                            <td> {{ $value->nestedMaterial->unit->name }} </td>
                            <td class="text-right"> {{ $value->quantity }} </td>
                            <td class="text-right">{{ $rate = $boqRate->rate ?? 0 }}</td>
                            <td class="text-right">{{ $value->quantity * $rate }}</td>
                            <td class="text-right"> {{ $value->issued_quantity }} </td>
                            <td class="text-right">0</td>
                            <td class="text-right">0</td>
                            <td class="text-right"> {{ $value->quantity - $value->issued_quantity }} </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        {{-- {{ !empty($boq_supreme_budget_data) ? $boq_supreme_budget_data->withQueryString()->links() : '' }} --}}
    </div>
@endsection

@section('script')
    <script>
        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {
            $("#project_name").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('projectAutoSuggest') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#project_name').val(ui.item.label);
                    $('#project_id').val(ui.item.value);
                    getFloor()

                    return false;
                }
            });
        }); //document.ready

        function getFloor() {
            let project = $('#project_id').val();
            const url = '{{ url('getFloor') }}/' + project;
            let oldSelectedItem = "{{ old('floor_id)' ?? '') }}";
            let dropdown = $('#floor_id');
            dropdown.empty();
            dropdown.append('<option selected="true" disabled> Select Floor </option>');
            dropdown.prop('selectedIndex', 0);

            $.getJSON(url, function(items) {
                $.each(items, function(key, data) {
                    let select = (oldSelectedItem == key) ? "selected" : null;
                    let options =
                        `<option value="${data.boq_floor_project_id}">${data.floor.name}</option>`;
                    dropdown.append(options);
                })
            });
        }
    </script>
@endsection
