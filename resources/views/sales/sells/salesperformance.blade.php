@extends('layouts.backend-layout')
@section('title', 'Sales Performance')

@section('breadcrumb-title')
    Sales Performance
@endsection

@section('breadcrumb-button')
    {{--<a href="{{ url('sells') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>--}}
@endsection

@section('sub-title')
    {{--<span class="text-danger">*</span> Marked are required.--}}
@endsection

@section('content-grid',null)

@section('content')
<div class="row" id="contentArea">
    <div id="chart_div" style="width: 100%; min-height: 300px;"></div>


</div> <!-- end row -->
@endsection

@section('script')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        var pieDiv = null;
        @foreach($teams as $teamKey => $team)
            google.charts.setOnLoadCallback(drawChart{!! $teamKey !!});
            function drawChart{!! $teamKey !!}() {
                var data = google.visualization.arrayToDataTable([
                    ['Member Name', 'Sells'],
                    @foreach($team->members as $member)
                        ['{{$member->user->name.", uid:".$member->user->id, "Sold: ".$member->user->sells->count()}} ', {{$member->user->sells->count()}}],
                    @endforeach
                ]);

                var options = {
                    title: '{{"Team-$team->name Performance."}}',
                    is3D: true,
                    titleTextStyle: { 'color': 'green','fontSize': '25'},
                };

                pieDiv=`<div class="col-lg-6 col-12"><div id="{!! $teamKey !!}" style="width: 100%; height: 300px;"></div></div>`;
                $("#contentArea").append(pieDiv);
                let chart = new google.visualization.PieChart(document.getElementById('{!! $teamKey !!}'));
                chart.draw(data, options);
            }
        @endforeach


        google.charts.setOnLoadCallback(drawVisualization);
        function drawVisualization() {
            // Some raw data (not necessarily accurate)
            var data = google.visualization.arrayToDataTable([
                [   'Month',
                    @foreach($teamNames as $key => $as)
                            '{{$key}}',
                    @endforeach
                ],
                @foreach($allTeamSales as $key => $allTeamSale)
                ['{{$key}}', {{$allTeamSale}}],
                @endforeach
            ]);

            var options = {
                title : 'Overall Sales Performance',
                vAxis: {title: 'Sales'},
                hAxis: {title: 'Month'},
                seriesType: 'bars',
                series: {5: {type: 'line'}}
            };

            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
@endsection