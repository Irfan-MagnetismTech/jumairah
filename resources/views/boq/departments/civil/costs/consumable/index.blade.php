@extends('boq.departments.civil.layout.app')

@section('project-name', $project->name)

@section('breadcrumb-title')
    Consumable Cost
@endsection

@section('breadcrumb-button')
    <a href="{{ route('boq.project.departments.civil.costs.consumables.create', ['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('content')
    <!-- Responsive Table -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Particulars</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Rate/Unit</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($consumables as $consumable)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $consumable->nestedMaterial->name }}</td>
                        <td>{{ $consumable->nestedMaterial->unit->name ?? '---' }}</td>
                        <td class="text-right">@money($consumable->quantity)</td>
                        <td class="text-right">@money($consumable->rate)</td>
                        <td class="text-right">@money($consumable->total_amount)</td>
                        <td>
                            <div class="icon-btn">
                                <a href="{{ route('boq.project.departments.civil.costs.consumables.edit', ['project' => $project, 'consumable' => $consumable]) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('boq.project.departments.civil.costs.consumables.destroy', ['project' => $project, 'consumable' => $consumable]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @if ($loop->last)
                        <tr>
                            <th colspan="5" class="text-right"><b>Total Amount</b></th>
                            <th class="text-right"><b>@money($consumables->sum('total_amount'))</b></th>
                            <th></th>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No data available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
