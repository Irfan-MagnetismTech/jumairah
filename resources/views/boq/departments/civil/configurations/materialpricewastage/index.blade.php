@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Material Price & Wastage')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Material Price
@endsection

@section('breadcrumb-button')
@can('boq-civil')
<a href="{{ route('boq.project.departments.civil.configurations.material-price-wastage.create', ['project' => $project]) }}"
   class="btn btn-out-dashed btn-sm btn-success">
    <i class="fas fa-plus"></i>
</a>
@endcan
@endsection

@section('sub-title')
    Total: {{ count($material_price_wastages) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th style="width: 250px;word-wrap:break-word">Material Name</th>
                <th style="width: 250px;word-wrap:break-word">Price</th>
                <th style="width: 250px;word-wrap:break-word">Consumable Cost Head</th>
                @can('boq-civil')
                <th>Action</th>
                @endcan
            </tr>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
            @foreach ($material_price_wastages as $key => $formula)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td> {{ $formula?->material?->name ?? '---' }}</td>
                    <td> {{ $formula?->price ?? '' }}</td>
                    <td> {{ $formula?->other_material_head ?? '---' }}</td>
                    @can('boq-civil')
                    <td>
                        @include('components.buttons.action-button', [
                            'actions' => ['edit', 'delete'],
                            'route' => 'boq.project.departments.civil.configurations.material-price-wastage',
                            'route_key' => ['project' => $project, 'materialPriceWastage' => $formula->id],
                        ])
                    </td>
                    @endcan
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="float-right">
            {{-- {{ $material_price_wastages->links() }} --}}
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
                bPaginate: false
            });
        });
    </script>
@endsection
