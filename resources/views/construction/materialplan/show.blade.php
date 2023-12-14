@extends('layouts.backend-layout')
@section('title', 'Work Plan')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection




@section('breadcrumb-button')
@endsection

@section('sub-title')
    @endsection


    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th colspan="9">Jumairah Holdings Ltd.</th>
                </tr>
                <tr>
                    <th colspan="4">Project Name: {{ $currentYearPlans[0]->materialPlan->projects->name }}</th>
                    <th colspan="6">Duration: {{ date_format(date_create($currentYearPlans[0]->materialPlan->from_date),"d.m.Y")  }} To {{  date_format(date_create($currentYearPlans[0]->materialPlan->to_date),"d.m.Y") }}</th>
                </tr>
                <tr>
                    <th >SL No</th>
                    <th >Name of Materials</th>
                    <th >Unit</th>
                    <th >Week-1</th>
                    <th >Week-2</th>
                    <th >Week-3</th>
                    <th >Week-4</th>
                    <th >Remarks</th>
                    <th >Total<br>Quantity</th>
                    <th >Remarks</th>
                </tr>

            </thead>
            <tfoot>
                <tr>
                    <th colspan="10">Monthly Material Budget</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($currentYearPlans as $currentYearPlan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $currentYearPlan->nestedMaterials->name }}</td>
                        <td>{{ $currentYearPlan->nestedMaterials->unit->name }}</td>
                        <td>{{ $currentYearPlan->week_one }}</td>
                        <td>{{ $currentYearPlan->week_two }}</td>
                        <td>{{ $currentYearPlan->week_three }}</td>
                        <td>{{ $currentYearPlan->week_four }}</td>
                        <td>{{ $currentYearPlan->remarks }}</td>
                        <td>{{ $currentYearPlan->total_quantity }}</td>
                        <td></td>
                    </tr>
               @endforeach
            </tbody>
        </table>
    </div>
@endsection
