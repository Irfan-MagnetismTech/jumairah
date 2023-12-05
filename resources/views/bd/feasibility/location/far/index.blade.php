@extends('bd.feasibility.layout.app')
@section('title', 'FAR')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    FAR of {{ $bd_lead_location_name[0]->land_location }}
@endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th colspan="5">{{ $bd_lead_location_name[0]->category }}</th>
                </tr>
                <tr>
                    <th rowspan="2">Land Size<br>(Katha)</th>
                    <th colspan="2">Road</th>
                    <th rowspan="2">FAR</th>
                    <th rowspan="2">Max Ground<br> Coverage (%)</th>
                </tr>
                <tr>
                    <th>Feet</th>
                    <th>Meter</th>
                </tr>
            </thead>
            <tbody>
            @foreach($Bd_far as $data)
                <tr>
                    <td>{{ $data->land_size_katha }}</td>
                    <td>{{ $data->road_feet }}</td>
                    <td>{{ $data->road_meter }}</td>
                    <td>{{ $data->far }}</td>
                    <td>{{ $data->max_ground_coverage }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>
    
@endsection
