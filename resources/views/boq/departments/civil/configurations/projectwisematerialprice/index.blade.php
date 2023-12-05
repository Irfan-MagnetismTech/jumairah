@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Civil - Material Price & Wastage')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
    <style>
        .dataTables_info {
            display: none !important;
        }

        .select2-selection.select2-selection--single {
            height: 36px !important;
            display: flex !important;
            align-items: center !important;
        }

        .pricesearchbox {
            position: absolute;
            z-index: 1;
            width: auto;
        }

        .pricesearchbox form {
            display: flex;
            justify-content: space-between;
        }
    </style>
@endsection

@section('breadcrumb-title')
    List of Civil Material Price
@endsection

@section('breadcrumb-button')
    {{--    <a href="{{ route('boq.project.departments.civil.configurations.material-price-wastage.create', ['project' => $project]) }}" --}}
    {{--        class="btn btn-out-dashed btn-sm btn-success"> --}}
    {{--        <i class="fas fa-plus"></i> --}}
    {{--    </a> --}}
@endsection

@section('sub-title')
    Total: {{ count($material_price_wastages) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="pricesearchbox">
        <form
            action="{{ route('boq.project.departments.civil.configurations.projectwise-material-price.index', ['project' => $project]) }}"
            method="GET" class="custom-form">
            <div>
                <select class="form-control nested_material_id" name="type" style="width: 250px">
                    <option value="" selected disabled>Select Option</option>
                    <option value="all" @if (request()->input('type') == 'all') selected @endif>All</option>
                    <option value="material" @if (request()->input('type') == 'material') selected @endif>Material</option>
                    <option value="material-labour" @if (request()->input('type') == 'material-labour') selected @endif>Material & Labour
                    </option>
                    {{--                    <option value="labour" @if (request()->input('type') == 'labour') selected @endif>Labour</option> --}}
                    <option value="other" @if (request()->input('type') == 'other') selected @endif>Other</option>
                </select>
            </div>
            <div>
                <button type="submit" class="py-2 btn btn-success btn-round ml-2"
                    id="">{{ $label ?? 'Submit' }}</button>
            </div>
        </form>
    </div>
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
                        <td> {{ $formula?->boqMaterialPriceWastage?->nestedMaterial?->name ?? '---' }}</td>
                        <td> {{ $formula?->rate ?? '' }}</td>
                        <td> {{ $formula?->boqMaterialPriceWastage?->other_material_head ?? '---' }}</td>
                        @can('boq-civil')
                        <td>
                            {{--                            @include('components.buttons.action-button', [ --}}
                            {{--                                'actions' => ['edit', 'delete'], --}}
                            {{--                                'route' => 'boq.project.departments.civil.configurations.material-price-wastage', --}}
                            {{--                                'route_key' => ['project' => $project, 'materialPriceWastage' => $formula->id], --}}
                            {{--                            ]) --}}
                            @include('components.buttons.action-button', [
                                'actions' => ['edit'],
                                'route' =>
                                    'boq.project.departments.civil.configurations.projectwise-material-price',
                                'route_key' => ['project' => $project, 'projectWiseMaterialPrice' => $formula->id],
                            ])
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{--        <div class="float-right"> --}}
        {{--            {{ $material_price_wastages->links() }} --}}
        {{--        </div> --}}
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
            });

        });
    </script>
@endsection
