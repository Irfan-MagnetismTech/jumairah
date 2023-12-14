@extends('boq.departments.civil.layout.app')

@section('project-name', $project->name)

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
    <style>
        .dataTables_info {
            display: none !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <style>
                    tbody tr,
                    td {
                        text-align: left;
                    }

                    tbody td {
                        margin-left: 5px;
                    }
                </style>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th colspan="3">
                            <h4>Project name - {{ $project->name }}</h4>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="3" style="text-align: center;display: flex;justify-content: space-between;align-items: center">
                            <h5>MS Rod Sheet</h5>
                            <a target="_blank" href="{{ route('boq.project.departments.civil.cost_analysis.download.ms.rod.pdf', ['project' => $project]) }}" data-toggle="tooltip" title="" class="btn btn-outline-danger" data-original-title="Download PDF">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table id="" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SL.</th>
                            <th>Location</th>
                            <th>8 mm</th>
                            <th>10 mm</th>
                            <th>12 mm</th>
                            <th>16 mm</th>
                            <th>20 mm</th>
                            <th>22 mm</th>
                            <th>25 mm</th>
                            <th>32 mm</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $grand_total = 0;
                    @endphp
                    @if(isset($reinforcement_sheet) && count($reinforcement_sheet) > 0)
                    @foreach ($reinforcement_sheet as $ms_sheet)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $ms_sheet['floor_name'] ?? '---' }}</strong></td>
                            @foreach($ms_sheet['dia_totals'] as $dia_total)
                                <td>{{ $dia_total['total_quantity'] }}</td>
                            @endforeach
                            <td><strong>{{ $ms_sheet['floorwise_dia_totals'] }}</strong></td>
                        </tr>
                        @php
                            $grand_total += $ms_sheet['floorwise_dia_totals'];
                        @endphp
                    @endforeach
                    <tr>
                        <th>SL.</th>
                        <th>Location</th>
                        @foreach($diaWiseTotal as $dia_total)
                            <th>{{ $dia_total?->total_quantity ?? $dia_total['total_quantity'] }}</th>
                        @endforeach
                        <th>@money($grand_total)</th>
                    </tr>
                        @else
                        <tr>
                            <td colspan="11" class="text-center">No Data Found</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
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
            $('#work-table').DataTable({
                stateSave: true,
                bPaginate: false,
                bSort: false,
            });

        });
    </script>
@endsection
