@extends('layouts.backend-layout')
@section('title', 'Material Ledger')

@section('style')
@endsection

@section('breadcrumb-title')
    Material Ledger
@endsection


@section('breadcrumb-button')
    <a href="{{ url('get-material-ledger-pdf') }}/{{ $cost_center_id }}/{{ $material_id }}" title="PDF" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a>
@endsection

@section('sub-title')

@endsection


@section('content')
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
    }

    #logo {
        margin-top: 2%;
        clear: both;
        width: 100%;
        text-align: center;
    }
.tableFixHead { overflow-y: auto; height: 80vh; }

/* Just common table stuff. */
table  { border-collapse: collapse; width: 100%; }
th, td { padding: 8px 16px; }
</style>

    <div id="tble" class="table-responsive tableFixHead">

              <table class="table table-bordered text-center">
                <thead style="background-color:white!important;">
                <tr style="font-size: 1rem;font-weight: bold;background-color:white!important;">
                    <td colspan="4" class="text-left"> Project Name: {{ $data_groups->first()->first()->costCenter->name }}</td>
                    <td colspan="4" class="text-left"> Material Name: {{ $data_groups->first()->first()->nestedMaterial->name }}</td>
                    <td colspan="4" class="text-left"> Unit: {{ $data_groups->first()->first()->nestedMaterial->unit->name }}</td>
                    <td colspan="4" class="text-left"> Total Estimated Quantity: {{ $TotalEstimatedQuantity }}</td>
                </tr>
                <tr style="height:2rem;border:none;background-color:white!important;">
                    <td colspan="16"></td>
                </tr>
                <tr style="background-color:white!important;">
                    <th rowspan="2">Date OF Ladger Entry</th>
                    <th colspan="2">Received From Purchase</th>
                    <th rowspan="2">Cumulative Received Purchase</th>
                    <th colspan="2">Received From Other Project</th>
                    <th rowspan="2">Cumulative Received (Other Site)</th>
                    <th rowspan="2">Cumulative Gross Received</th>
                    <th colspan="2">Transfer To Other Project</th>
                    <th rowspan="2">Cumulative Transfer To other project</th>
                    <th rowspan="2">Net Cumulative Received</th>
                    <th colspan="2">Issued For Work at site</th>
                    <th rowspan="2">Cumulative Issed for work at site</th>
                    <th rowspan="2">Balance Quantity</th>
                </tr>
                <tr style="background-color:white!important;">
                    <th>MRR NO</th>
                    <th>Quantity</th>
                    <th>MTI NO</th>
                    <th>Quantity</th>
                    <th>MTO No</th>
                    <th>Quantity</th>
                    <th>Sin No</th>
                    <th>Quantity</th>
                </tr>
                <tr style="background-color:white!important;">
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>
                    <td>7</td>
                    <td>8 = (4+7)</td>
                    <td>9 </td>
                    <td>10</td>
                    <td>11</td>
                    <td>12 = (8-11)</td>
                    <td>13</td>
                    <td>14</td>
                    <td>15</td>
                    <td>16 = (12-15)</td>
                </tr>
                </thead>
                @php
                    $cumulative_purchase = 0;
                    $cumulative_issued_for_worksite = 0;
                    $cumulative_movement_in = 0;
                    $cumulative_movement_out = 0;
                @endphp
                @foreach ($data_groups as $key => $value)
                @php
                    if (isset($receive_from_purchase[$key])){
                        $receiveFromPurchase = $receive_from_purchase[$key]['sum'];
                    }else{
                        $receiveFromPurchase = 0;
                    }
                    $cumulative_purchase += $receiveFromPurchase;

                    if (isset($issued_for_work_site[$key])){
                        $issuedForWorkSite = $issued_for_work_site[$key]['sum'];
                    }else{
                        $issuedForWorkSite = 0;
                    }

                    $cumulative_issued_for_worksite += $issuedForWorkSite;

                    if (isset($movement_In[$key])){
                        $movementIn = $movement_In[$key]['sum'];
                    }else{
                        $movementIn = 0;
                    }
                    $cumulative_movement_in += $movementIn;

                    if (isset($movement_out[$key])){
                        $movementout = $movement_out[$key]['sum'];
                    }else{
                        $movementout = 0;
                    }
                    $cumulative_movement_out += $movementout;
                @endphp
                <tr>
                    <td >{{ $key }}</td>
                    <td>
                        @if (isset($receive_from_purchase[$key]))
                            @forelse ($receive_from_purchase[$key]['item'] as $data)
                                {{ $data->MaterialReceive->mrr_no }} <br />
                            @empty
                                    0
                            @endforelse
                        @else
                                    0
                        @endif
                    </td>

                    <td>
                        @if (isset($receive_from_purchase[$key]))
                            @forelse ($receive_from_purchase[$key]['item'] as $data)
                            {{ $data->quantity }} <br />
                            @empty
                                    0
                            @endforelse
                        @else
                                    0
                        @endif

                    </td>
                    <td >{{ $cumulative_purchase }}</td>
                    <td>
                        @if (isset($movement_In[$key]))
                        @forelse ($movement_In[$key]['item'] as $kk =>$data)
                            {{ $data->movementin->mti_no ?? 'N/A'}}<br />
                        @empty
                                0
                        @endforelse
                    @else
                                0
                    @endif
                    </td>
                    <td>
                        @if (isset($movement_In[$key]))
                            @forelse ($movement_In[$key]['item'] as $data)
                            {{ $data->quantity }} <br />
                            @empty
                                    0
                            @endforelse
                        @else
                                    0
                        @endif
                    </td>
                    <td>{{ $cumulative_movement_in }}</td>
                    <td>{{ $cumulative_purchase + $cumulative_movement_in }}</td>
                    <td>
                        @if (isset($movement_out[$key]))
                            @forelse ($movement_out[$key]['item'] as $data)
                            {{ $data->movementout?->mto_no ?? ''}} <br />
                            @empty
                                    0
                            @endforelse
                        @else
                                    0
                        @endif
                    </td>
                    <td>
                        @if (isset($movement_out[$key]))
                        @forelse ($movement_out[$key]['item'] as $data)
                        {{ $data->quantity }} <br />
                        @empty
                                0
                        @endforelse
                    @else
                                0
                    @endif
                    </td>
                    <td>{{ $cumulative_movement_out }}</td>
                    <td>{{ $cumulative_purchase + $cumulative_movement_in - $cumulative_movement_out }}</td>
                    <td>
                        @if (isset($issued_for_work_site[$key]))
                            @forelse ($issued_for_work_site[$key]['item'] as $data)
                                {{ $data->storeIssue->sin_no }} <br />
                            @empty
                                   N/A
                            @endforelse
                        @else
                                   N/A
                        @endif
                    </td>
                    <td>
                    @if (isset($issued_for_work_site[$key]))
                        @forelse ($issued_for_work_site[$key]['item'] as $data)
                        {{ $data->quantity }} <br />
                        @empty
                                0
                        @endforelse
                    @else
                                0
                    @endif
                    </td>
                    <td>{{ $cumulative_issued_for_worksite }}</td>
                    <td>{{  $cumulative_purchase + $cumulative_movement_in - $cumulative_movement_out - $cumulative_issued_for_worksite }}</td>
                </tr>
                @endforeach
         


            </table>
        </div>

    




@endsection

@section('script')
    <script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(window).scroll(function () {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function () {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function () {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
        function tableFixHead (e) {
            const el = e.target,
                sT = el.scrollTop;
            el.querySelectorAll("thead").forEach(th => 
            th.style.transform = `translateY(${sT}px)`
            );
        }
        document.querySelectorAll(".tableFixHead").forEach(el => 
            el.addEventListener("scroll", tableFixHead)
        );
    </script>
@endsection
