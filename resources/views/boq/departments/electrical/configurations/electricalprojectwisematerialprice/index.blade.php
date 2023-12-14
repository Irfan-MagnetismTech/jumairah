@extends('boq.departments.electrical.layout.app')
@section('title', 'BOQ - Electrical - Material Price')

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
    List of Electrical Material Price
@endsection

@section('breadcrumb-button')
@endsection

@section('sub-title')
    Total: {{ count($material_price) }}
@endsection

@section('content')
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="width: 450px;">SL</th>
                    <th style="word-wrap:break-word">Material Name</th>
                    <th style="width: 650px;word-wrap:break-word">Price</th>
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
                @foreach ($material_price as $key => $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td> {{ $data?->NestedMaterial?->name }}</td>
                        <td> {{ $data?->labour_rate ?? '' }}</td>
                        {{-- <td>
                            @include('components.buttons.action-button', [
                                'actions' => ['edit'],
                                'route' =>
                                    'boq.project.departments.sanitary.configurations.sanitary-projectwise-material-price',
                                'route_key' => [
                                    'project' => $project,
                                    'sanitaryProjectWiseMaterialPrice' => $data->id,
                                ],
                            ])
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>

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
