@extends('layouts.backend-layout')
@section('title', 'Final Costing')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Final Costing
@endsection

@section('sub-title')
    <span>Project Name: </span> {{ $project->projects->name }}
    <span style="padding-left:170px;">Owner Name: {{ $client->sellClientsInfo[0]->client->name }}</span>
    <span style="float: right">Apartment No: {{ $project->apartments->name }}</span>
@endsection


@section('breadcrumb-button')

    @php
        $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) {
            $q->where('name', 'Final Costing');
        })
            ->whereDoesntHave('approvals', function ($q) use ($costing_id) {
                $q->where('approvable_id', $costing_id)->where('approvable_type', \App\CSD\CSDFinalCosting::class);
            })
            ->orderBy('order_by', 'asc')
            ->first();
    @endphp
    @if (!empty($approval) && $approval->designation_id == auth()->user()->designation?->id)
        <a href="{{ url("csd/csd_approval/$costing_id/1") }}" data-toggle="tooltip" title="Approval"
            class="btn btn-sm btn-outline-success">Approval</a>
        {{-- <a href="{{ url("csd/csd_approval/$costing_id/1") }}" data-toggle="tooltip" title="Approve Requisition" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a> --}}
    @endif
    @if ($project->approval()->doesntExist())
        <a href="{{ url("csd/costing/$costing_id/edit") }}" title="Edit" class="btn btn-out-dashed btn-sm btn-primary"><i
                class="fas fa-pen"></i></a>
    @endif()
    <a href="{{ url('csd/csd-final-costing-pdf') }}/{{ $costing_id }}" data-toggle="tooltip" title="Create Pdf"
        class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-file-pdf"></i></a>
    <a href="{{ url("finalCostingLog/$costing_id/log") }}" data-toggle="tooltip" title="Logs" class="btn btn-dark"><i
            class="fas fa-history"></i></a>

@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="row">
        <div class="col-md-6">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th colspan="6">Additional/Demand Work</th>

                        </tr>
                        <tr>
                            <th>SL</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Qty</th>
                            <th>Rate</th>
                            <th>Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($csd_final_costing_demand as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->csdMaterials->name }}</td>
                                <td>{{ $data->csdMaterials->unit->name }}</td>
                                <td>{{ $data->quantity }}</td>
                                <td>{{ $data->demand_rate }}</td>
                                <td>{{ $data->amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th>{{ number_format($csd_final_costing_demand->sum('amount'), 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="col-md-6">
            <div class="table-responsive">
                <table id="dataTable2" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th colspan="6">Refund Work</th>

                        </tr>
                        <tr>
                            <th>SL</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Qty</th>
                            <th>Rate</th>
                            <th>Amount</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($csd_final_costing_refund as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->csdMaterials->name }}</td>
                                <td>{{ $data->csdMaterials->unit->name }}</td>
                                <td>{{ $data->quantity_refund }}</td>
                                <td>{{ $data->refund_rate }}</td>
                                <td>{{ $data->amount_refund }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    @php
                        $amount_refund = $csd_final_costing_refund->sum('amount_refund');
                    @endphp
                    <tfoot>
                        @php
                            $sum = 0;
                            $total_modification_cost = 0;
                        @endphp
                        @foreach ($payment_received->sellCollections as $key => $sellCollection)
                            @foreach ($sellCollection->salesCollectionDetails as $salesCollectionDetail)
                                @if ($salesCollectionDetail->particular == 'Modification Cost')
                                    <tr>
                                        <th colspan="4">Payment received as an Advanced (
                                            @if ($sellCollection->payment_mode == 'Cheque')
                                                Cheque number: {{ $payment_received->sellCollections[0]->transaction_no }},
                                                Date: {{ $payment_received->sellCollections[0]->received_date }})
                                        </th>
                                        <th>
                                            {{ number_format($sellCollection->received_amount) }}
                                            @php
                                                $total_modification_cost += $sellCollection->received_amount;
                                            @endphp
                                        </th>
                                    @elseif ($sellCollection->payment_mode == 'Cash')
                                        Cash,
                                        Date: {{ $payment_received->sellCollections[0]->received_date }})
                                        </th>
                                        <th>
                                            {{ number_format($sellCollection->received_amount) }}
                                            @php
                                                $total_modification_cost += $sellCollection->received_amount;
                                            @endphp
                                        </th>
                                    @else
                                        </th>
                                        <th></th>
                                @endif
                                @if ($loop->parent->last)
                                    <th>{{ number_format($total_modification_cost, 2) }}</th>
                                    </tr>
                                @else
                                    <th></th>
                                    </tr>
                                @endif
                            @endif
                        @endforeach


                        @php
                            $sum += $sellCollection->received_amount;
                        @endphp
                        @if ($loop->first)
                            <tr>
                                <th colspan="3">
                                </th>
                                <th colspan="2" class="text-right">Total Payment Received

                                </th>
                                <th rowspan="" id="payment_received"></th>
                            </tr>
                        @endif
                        @endforeach
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th>{{ number_format($amount_refund - $total_modification_cost, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <thead>

                        <tr>
                            @php
                                $amount_demand = $csd_final_costing_demand->sum('amount');
                                $amount_refund = $csd_final_costing_refund->sum('amount_refund');
                                $total = $amount_demand - $amount_refund + $total_modification_cost;
                            @endphp


                            @if ($total > 0)
                                <th>Payable to Ranconfc</th>
                                <th colspan="2">{{ number_format(abs($total)) }}</th>
                            @else
                                <th>Payable to Client</th>
                                <th colspan="2">{{ number_format(abs($total)) }}</th>
                            @endif
                        </tr>
                        <tr>
                            <td>
                                <p style="text-align: left; padding-left:0px; font-size: 12px">In Words:
                                    <b>{{ ucfirst((new NumberFormatter('en', NumberFormatter::SPELLOUT))->format(round(abs($total)))) }}
                                        only</b></p>
                            </td>
                        </tr>
                        {{-- <tr>
                                <td><p style="text-align: left; padding-left:0px; font-size: 12px">In Words: <b>{{ ucfirst(getBanglaCurrency(round(abs($total)))) }} only</b></p></td>
                            </tr> --}}
                    </thead>
                </table>
            </div>
        </div>


    </div>
    @php
        function getBanglaCurrency(float $number)
        {
            $decimal = round($number - ($no = floor($number)), 2) * 100;
            $hundred = null;
            $digits_length = strlen($no);
            $i = 0;
            $str = [];
            $words = [0 => '', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty', 30 => 'thirty', 40 => 'forty', 50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'];
            $digits = ['', 'hundred', 'thousand', 'lakh', 'crore'];
            while ($i < $digits_length) {
                $divider = $i == 2 ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += $divider == 10 ? 1 : 2;
                if ($number) {
                    $plural = ($counter = count($str)) && $number > 9 ? 's' : null;
                    $hundred = $counter == 1 && $str[0] ? ' and ' : null;
                    $str[] = $number < 21 ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
                } else {
                    $str[] = null;
                }
            }
            $Rupees = implode('', array_reverse($str));
            $paise = $decimal > 0 ? '.' . ($words[$decimal / 10] . ' ' . $words[$decimal % 10]) . ' Paisa' : '';
            return ($Rupees ? $Rupees . 'Taka ' : '') . $paise;
        }
    @endphp
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
            $('#payment_received').html({{ $sum }});
        });
    </script>
@endsection
