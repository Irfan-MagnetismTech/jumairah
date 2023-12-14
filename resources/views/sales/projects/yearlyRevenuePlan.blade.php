@extends('layouts.backend-layout')
@section('title', 'Yearly Sales Plan ')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Yearly Revenue Plan Report
@endsection

@section('breadcrumb-button')
    {{--    <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}}
@endsection

@section('sub-title')
    {{-- Total: {{ count($projects) }} --}}
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
            {{--            @dd($year); --}}
            {{-- <div class="col-md-3 px-1 my-1 my-md-0"> --}}
            {{-- <input type="text" id="project_name" name="project_name" class="form-control form-control-sm" value="{{!empty($request) ? $request->project_name : null}}" placeholder="Enter Project Name" autocomplete="off"> --}}
            {{-- <input type="hidden" id="project_id" name="project_id" class="form-control form-control-sm" value="{{!empty($request) ? $request->project_id : null}}"> --}}
            {{-- </div> --}}
            <div class="col-md-3 px-1 my-1 my-md-0">
                <input type="text" id="year" name="year" class="form-control form-control-sm"
                    value="{{ $request->year ? $request->year : now()->format('Y') }}" placeholder="Select Year"
                    autocomplete="off">
            </div>
            <div class="col-md-1 px-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    <div class="tableHeading">
        <h5> <span>&#10070;</span> Yearly Revenue Plan - {{ $year }} <span>&#10070;</span> </h5>
    </div>
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Particular</th>
                    {{-- <th>Hand <br> Over</th>
                    <th>Unsold</th>
                    <th>Closing <br> Inventory</th> --}}
                    @foreach ($months as $month)
                        <th>{{ date('M', strtotime("$year-$month")) }}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
            </thead>
            <tbody class="text-right">
                <?php
                $grandTotalBM = 0;
                $grandTotalAC = 0;
                $grandTotalEC = 0;
                ?>
                @foreach ($projects as $key => $project)
                    <?php
                    $totalBM = 0;
                    $totalAC = 0;
                    $totalEC = 0;
                    ?>
                    <tr>
                        <td rowspan="4" class="text-left">{{ $project['project'] }}</td>
                        <td class="text-center">Approximate Booking Money</td>
                        @foreach ($months as $month)
                            <?php
                            $bm = array_key_exists("$year-$month", $project['bookingMoney']) ? $project['bookingMoney']["$year-$month"] : 0;
                            $totalBM += $bm;
                            $grandTotalBM += $bm;
                            ?>
                            <td>{{ number_format($bm) }}</td>
                        @endforeach
                        <td><strong>{{ number_format($totalBM) }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-center">Approximate Revenue </td>

                        @foreach ($months as $month)
                            <?php
                            $approximateCollection = array_key_exists("$year-$month", $project['approximateCollection']) ? $project['approximateCollection']["$year-$month"] : 0.0;
                            $totalAC += $approximateCollection;
                            $grandTotalAC += $approximateCollection;
                            ?>
                            <td>{{ number_format($approximateCollection) }}</td>
                        @endforeach
                        <td><strong> {{ number_format($totalAC) }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-center">Existing Revenue</td>
                        @foreach ($months as $month)
                            <?php
                            $exitingCollection = array_key_exists("$year-$month", $project['exitingCollection']) ? $project['exitingCollection']["$year-$month"] : 0.0;
                            $totalEC += $exitingCollection;
                            $grandTotalEC += $exitingCollection;
                            ?>
                            <td>{{ number_format($exitingCollection) }} </td>
                        @endforeach
                        <td><strong>{{ number_format($totalEC) }}</strong></td>
                    </tr>
                    <tr style="background-color: #2ed8b626">
                        <td class="text-center"><strong>Total</strong></td>
                        <?php $projectWiseYearTotal = 0; ?>
                        @foreach ($months as $month)
                            <?php
                            $projectWiseBM = array_key_exists("$year-$month", $project['bookingMoney']) ? $project['bookingMoney']["$year-$month"] : 0.0;
                            $projectWiseAC = array_key_exists("$year-$month", $project['approximateCollection']) ? $project['approximateCollection']["$year-$month"] : 0.0;
                            $projectWiseEC = array_key_exists("$year-$month", $project['exitingCollection']) ? $project['exitingCollection']["$year-$month"] : 0.0;
                            $projectWiseTotal = $projectWiseBM + $projectWiseAC + $projectWiseEC;
                            $projectWiseYearTotal += $projectWiseTotal;
                            ?>
                            <td><strong>{{ number_format($projectWiseTotal) }}</strong> </td>
                        @endforeach
                        <td><strong>{{ number_format($projectWiseYearTotal) }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-center"><strong> Approximate Booking Money </strong></td>
                    @foreach ($months as $month)
                        <td class="text-right"> <strong>{{ number_format($totalBookingMoney["$year-$month"]) ?? 0 }}
                            </strong></td>
                    @endforeach
                    <td class="text-right"><strong>{{ number_format($grandTotalBM) }}</strong></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center"><strong> Approximate Revenue </strong></td>
                    @foreach ($months as $month)
                        <td class="text-right">
                            <strong>{{ number_format($totalApproximateCollection["$year-$month"]) ?? 0 }} </strong>
                        </td>
                    @endforeach
                    <td class="text-right"><strong>{{ number_format($grandTotalAC) }}</strong></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center"><strong> Existing Revenue </strong></td>
                    @foreach ($months as $month)
                        <td class="text-right"> <strong>{{ number_format($totalCollection["$year-$month"]) ?? 0 }}
                            </strong></td>
                    @endforeach
                    <td class="text-right"><strong>{{ number_format($grandTotalEC) }}</strong></td>
                </tr>
                <tr style="background-color: #2e91d842">
                    <td colspan="2" class="text-center"><strong>Total Approximate Revenue </strong></td>
                    <?php $yearlyTotalRevenue = 0 ; ?>
                    @foreach ($months as $month)
                        <?php
                        $monthWiseTotal = $totalCollection["$year-$month"] + $totalApproximateCollection["$year-$month"] + $totalBookingMoney["$year-$month"];
                        $yearlyTotalRevenue += $monthWiseTotal;
                        ?>
                        <td class="text-right"> <strong>{{ number_format($monthWiseTotal) ?? 0 }}</strong></td>
                    @endforeach
                    <td class="text-right"><strong>{{ number_format($yearlyTotalRevenue) }}</strong></td>
                </tr>

                <tr>
                    <td colspan="2" class="text-center"><strong> Booking Money Collection </strong></td>
                    <?php $yearlyTotalBMCollection = 0 ; ?>
                    @foreach ($months as $month)
                        <td class="text-right"> <strong>{{ number_format($totalBmCollection["$year-$month"]) ?? 0 }}
                            </strong></td>

                        <?php  $yearlyTotalBMCollection += $totalBmCollection["$year-$month"]; ?>
                    @endforeach
                    <td class="text-right"><strong>{{number_format($yearlyTotalBMCollection)}}</strong></td>
                </tr>

                <tr>
                    <td colspan="2" class="text-center"><strong> New Project Collection </strong></td>
                    <?php $yearlyNewCollectionTotal = 0 ; ?>
                    @foreach ($months as $month)
                        <?php $yearlyNewCollectionTotal += $totalNewProjcetCollection["$year-$month"] ; ?>
                        <td class="text-right">
                            <strong>{{ number_format($totalNewProjcetCollection["$year-$month"]) ?? 0 }} </strong></td>
                    @endforeach
                    <td class="text-right"><strong>{{number_format($yearlyNewCollectionTotal)}}</strong></td>
                </tr>

                <tr>
                    <td colspan="2" class="text-center"><strong> Existing Project Collection </strong></td>
                    <?php $yearlyECTotal = 0; ?>
                    @foreach ($months as $month)
                        <?php $yearlyECTotal += $totalExistingProjcetCollection["$year-$month"]?>
                        <td class="text-right">
                            <strong>{{ number_format($totalExistingProjcetCollection["$year-$month"]) ?? 0 }} </strong>
                        </td>
                    @endforeach
                    <td class="text-right"><strong>{{number_format($yearlyECTotal)}}</strong></td>
                </tr>

                <tr style="background-color: #484ecf3b">
                    <td colspan="2" class="text-center"><strong>Total Actual Collection </strong></td>
                    <?php  $YearlyTotalCollection = 0; ?>
                    @foreach ($months as $month)
                        <?php
                            $monthlyTotalCollection = $totalExistingProjcetCollection["$year-$month"] +
                                                    $totalNewProjcetCollection["$year-$month"] + $totalBmCollection["$year-$month"];
                            $YearlyTotalCollection += $monthlyTotalCollection;
                        ?>
                        <td class="text-right"> <strong>{{number_format($monthlyTotalCollection)}}</strong></td>
                    @endforeach
                    <td class="text-right"><strong>{{number_format($YearlyTotalCollection)}}</strong></td>
                </tr>

            </tfoot>
        </table>
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
                    return false;
                }
            });

            $("#year").datepicker({
                format: "yyyy",
                startView: "years",
                minViewMode: "years",
                todayHighlight: true,
                autoclose: true
            });
        }); //document.ready
    </script>
@endsection
