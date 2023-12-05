@extends('boq.departments.electrical.layout.app')
@section('title', 'Boq - Eme - Utilities Bill Details')

@section('breadcrumb-title')
   Utilities Bill Details
@endsection

@section('breadcrumb-button')
@include('components.buttons.breadcrumb-button', ['route' => route('boq.project.departments.electrical.utility_bill.index'), 'type' => 'index'])
@endsection


@section('content-grid',null)

@section('content')
@php
    $expld_data = explode("-",$utility_bill->period);
    $dateObj   = DateTime::createFromFormat('!m', $expld_data[0])->format('F');
    $dperiod = $dateObj .", ". $expld_data[1];
@endphp
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                    <tr style="background-color: #0C4A77;color: white"><td> <strong>Project Name</strong> </td> <td> <strong>{{$utility_bill->project->name}}</strong></td></tr>
                    <tr><td> <strong>Client Name</strong> </td> <td> <strong>{{$utility_bill->client->name}}</strong></td></tr>
                    <tr><td> <strong>Apartment Name</strong> </td> <td> <strong>{{$utility_bill->apartment->name}}</strong></td></tr>
                    <tr><td> <strong>Period</strong> </td> <td>{{$dperiod}}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th >Previous Reading<span class="text-danger"></span></th>
                <th >Present Reading</th>
                <th >Consumed unit</th>
                <th >Unit Rate</th>
                <th >Amount</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$utility_bill->previous_reading}}</td>
                    <td>{{$utility_bill->present_reading}}</td>
                    <td>
                        {{number_format(($utility_bill->present_reading) - ($utility_bill->previous_reading), 5, '.', '')}}
                    </td>
                    <td>{{$utility_bill->electricity_rate}}</td>
                    <td>
                        @php
                            $total_electric = ($utility_bill->present_reading - $utility_bill->previous_reading) * $utility_bill->electricity_rate;
                        @endphp
                        {{number_format($total_electric, 5, '.', '')}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right">
                        Vat & Tax ({{$utility_bill->vat_tax_percent}}%)
                    </td>
                    <td>
                        {{number_format($total_electric * $utility_bill->vat_tax_percent / 100, 5, '.', '')}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right">
                        Demand Charge ({{$utility_bill->demand_charge_percent}}%)
                    </td>
                    <td>
                        {{number_format($total_electric * $utility_bill->demand_charge_percent / 100, 5, '.', '')}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right">
                        PFC Charge ({{$utility_bill->pfc_charge_percent}}%)
                    </td>
                    <td>
                        {{number_format($total_electric * $utility_bill->pfc_charge_percent / 100, 5, '.', '')}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right">
                        Delay Charge ({{$utility_bill->delay_charge_percent}}%)
                    </td>
                    <td>
                        {{number_format($total_electric * $utility_bill->delay_charge_percent / 100, 5, '.', '')}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right">
                        Individual PDB Charge
                    </td>
                    <td>
                        {{number_format($total_electric * (1 - (($utility_bill->delay_charge_percent + $utility_bill->pfc_charge_percent + $utility_bill->demand_charge_percent + $utility_bill->vat_tax_percent ) / 100)), 5, '.', '')}}
                    </td>
                </tr>
                
                
                <tr>
                    <td colspan="4" class="text-right">
                        Common Electric
                    </td>
                    <td>
                        {{$utility_bill->common_electric_amount}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right">
                        Total Electric Bill After Vat, Tax & Other Charge
                    </td>
                    <td>
                        {{$utility_bill->total_electric_amount_aftervat}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4"><b>Other Cost Name</b></td>
                </tr>
                @foreach($utility_bill->eme_utility_bill_detail as $key => $value)
                <tr>
                    <td colspan="4">{{ $value->other_cost_name }}</td>
                    <td>{{ $value->other_cost_amount }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="text-right">
                        Due Amount
                    </td>
                    <td>
                        {{$utility_bill->due_amount}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right">
                        Total Bill
                    </td>
                    <td>
                        {{$utility_bill->total_bill}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection

