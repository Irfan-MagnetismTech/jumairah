<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        table {
            font-size: 12px;
        }


        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
        }
        #tableLeft {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
        }
        #tableRight {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        #tableBottom {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
         #table td,
        #table th {
            padding: 5px 0px;
        }
        #tableLeft td,
        #tableLeft th {
            border: 1px solid rgb(2, 1, 1);
            padding: 5px 0px;
        }


        #tableRight td,
        #tableRight th {
            border: 1px solid rgb(2, 1, 1);
            padding: 5px 0px;
        }

        #tableBottom td,
        #tableBottom th {
             border: 1px solid rgb(65, 61, 61);
            padding: 5px;
        }


        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        #tableLeft tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        #tableRight tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        #tableBottom tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #tableLeft tr:hover {
            background-color: #ddd;
        }
        #tableRight tr:hover {
            background-color: #ddd;
        }

        #tableBottom tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 4px;
            padding-bottom: 4px;
            text-align: center;
        }


        #tableLeft th {
            padding-top: 4px;
            padding-bottom: 4px;
            text-align: center;
        }
        #tableRight th {
            padding-top: 4px;
            padding-bottom: 4px;
            text-align: center;
        }

        #tableBottom th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
        }

        .tableHead {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }

        p {
            margin: 0;
        }

        h1 {
            margin: 0;
        }

        h2 {
            margin: 0;
        }

         .container {
            margin: 2px;
        }

        #logo {
            clear: both;
            width: 100%;
            display: block;
            text-align: center;
            position: relative;
        }

        #client {
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            top: 0;
            line-height: 18px;
            padding: 5px;
        }


        .infoTable {
            font-size: 14px;
            width: 100%;
        }

        .infoTableTable td:nth-child(2) {
            text-align: center;
            width: 20px;
        }

        .pdflogo a {
            font-size: 18px;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        @page {
            margin-top: 34px;
            margin-bottom: 34px;
        }

        .page_num::after{
            content: counter(page);
        }
        .forward_from::after{
            counter-increment: section;
            content: counter(section);
        }

        header { position: fixed; top: 0px; left: 0px; right: 0px;  height: 150px; }
        footer { position: fixed; bottom: 13%; left: 0px; right: 0px;  height: 50px; }
        /* .grid-container {
            display: grid;
            grid-template-columns: auto auto auto;
            background-color: #2196F3;
            padding: 10px;
            }

            .grid-item {
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.8);
            padding: 20px;
            font-size: 30px;
            text-align: center;
            } */
            .page_break {
            page-break-before: always;
        }
    </style>
</head>

<body>


                <header>
                    <div id="logo" class="pdflogo">
                        <img src="{{ asset(config('company_info.logo')) }}" alt="Logo" class="pdfimg">
                        <div class="clearfix"></div>
                        <h5>JHL Address.</h5>
                    </div>
                    <div class="table-responsive" style="width:100%; margin-left:400px">
                        {{-- <table id="table" class="table table-striped table-bordered text-left">
                            <thead>
                                <tr>
                                    <td><b>Owner Name: </b></td>
                                    <td style="text-align: left; "></td>
                                </tr>
                            </thead>
                        </table> --}}
                    </div>
                    <div class="container">
                        <div class="table-responsive" style="max-width:33%">
                            <table id="table" class="table table-striped table-bordered text-center">
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: left"></td>
                                    </tr>
                                </thead>
                                {{-- <tbody>
                                    <td>Apartment No: </td>
                                    <td style="text-align: left"></td>
                                </tbody> --}}
                            </table>
                        </div>
                        <div class="table-responsive" style="max-width:33%; float:right; margin-top:-10px">
                            <table id="table" class="table table-striped table-bordered text-left">
                                <thead>
                                    <tr>
                                        <td>Page: <span class="page_num"></span></td>
                                    </tr>
                                    <tr style="background-color:white;">
                                        <td>
                                                @if (isset($fromdate) && isset($todate))
                                                    Period From {{ date('d-m-Y', strtotime($fromdate)) }} to {{ date('d-m-Y', strtotime($todate)) }}
                                                @endif
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </header>

                <div class="container" style="clear: both; width: 100%;">


                    <div class="row ">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center" id="tableLeft">
                          <tr style="font-size: 1rem;font-weight: bold;">
                              <td colspan="8" class="text-left"> Material Name: {{ $data_groups->first()->first()->nestedMaterial->name }}</td>
                              <td colspan="4" class="text-left"> Unit: {{ $data_groups->first()->first()->nestedMaterial->unit->name }}</td>
                              <td colspan="4" class="text-left"> Total Estimated Quantity: {{ $TotalEstimatedQuantity }}</td>
                          </tr>
                          <tr style="height:2rem;border:none">
                              <td colspan="16"></td>
                          </tr>
                          <tr>
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
                          <tr>
                              <th>MRR NO</th>
                              <th>Quantity</th>
                              <th>MTI NO</th>
                              <th>Quantity</th>
                              <th>MTO No</th>
                              <th>Quantity</th>
                              <th>Sin No</th>
                              <th>Quantity</th>
                          </tr>
                          <tr>
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
                                      @forelse ($receive_from_purchase[$key]['item'] as $dddd)
                                          {{ $dddd->MaterialReceive->mrr_no }} <br />
                                      @empty
                                              0
                                      @endforelse
                                  @else
                                              0
                                  @endif
                              </td>

                              <td>
                                  @if (isset($receive_from_purchase[$key]))
                                      @forelse ($receive_from_purchase[$key]['item'] as $dddd)
                                      {{ $dddd->quantity }} <br />
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
                                  @forelse ($movement_In[$key]['item'] as $dddd)
                                  {{ $dddd->movementin->mti_no ?? 'N/A'}} <br />
                                  @empty
                                          0
                                  @endforelse
                              @else
                                          0
                              @endif
                              </td>
                              <td>
                                  @if (isset($movement_In[$key]))
                                      @forelse ($movement_In[$key]['item'] as $dddd)
                                      {{ $dddd->quantity }} <br />
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
                                      @forelse ($movement_out[$key]['item'] as $dddd)
                                      {{ $dddd->movementout->mto_no }} <br />
                                      @empty
                                              0
                                      @endforelse
                                  @else
                                              0
                                  @endif
                              </td>
                              <td>
                                  @if (isset($movement_out[$key]))
                                  @forelse ($movement_out[$key]['item'] as $dddd)
                                  {{ $dddd->quantity }} <br />
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
                                      @forelse ($issued_for_work_site[$key]['item'] as $dddd)
                                          {{ $dddd->storeIssue->sin_no }} <br />
                                      @empty
                                             N/A
                                      @endforelse
                                  @else
                                             N/A
                                  @endif
                              </td>
                              <td>
                              @if (isset($issued_for_work_site[$key]))
                                  @forelse ($issued_for_work_site[$key]['item'] as $dddd)
                                  {{ $dddd->quantity }} <br />
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






                </div>



</body>
</html>
