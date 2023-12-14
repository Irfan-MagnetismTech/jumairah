@extends('layouts.backend-layout')
@section('title', 'MIR')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection




@section('breadcrumb-button')
    <a href="{{route('mirPdf',['attn'=>$qr])}}" title="PDF" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a>
@endsection
@section('breadcrumb-title')
    Material Inventory Report(MIR)
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
        {{-- <div class="row bg-secondary" style="background-color:#323942cc!important;">
            <div class="text-white col-8 offset-md-3 mb-3 pt-3">
                <h5>Search Between Date</h5>
            </div>
            <div class="col-8 offset-md-3">
                <form action="{{ route('mir-get-report') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="input-group-sm input-group-primary col-3">
                            <label class="text-white" for="fromdate">From</label>
                            {{Form::text('fromdate', old('fromdate') ? old('fromdate') : null,['class' => 'form-control','id' => 'fromdate', 'autocomplete'=>"off",'required','placeholder'=>"From Date",])}}
                        </div>
                        <div class="col-1 d-flex align-items-end justify-content-center pb-2">
                            <i class="fa fa-exchange-alt text-white"></i>
                        </div>
                        <div class="input-group-sm input-group-primary col-3">
                            <label class="text-white" for="todate">To</label>
                            {{Form::text('todate', old('todate') ? old('todate') : null,['class' => 'form-control','id' => 'todate', 'autocomplete'=>"off",'required','placeholder'=>"To Date",])}}
                        </div>

                    </div>
                    <div class="row mb-0">

                        <div class="col-md-7 mt-1">
                            <!-- end row -->
                            <hr class="bg-success">
                        </div>
                    </div>
                    <div class="row">
                        <div class="offset-md-4 col-md-3">
                            <div class="input-group input-group-sm ">
                                <button class="btn btn-success btn-round btn-block py-2">Search</button>
                            </div>
                        </div>
                    </div> <!-- end row -->

                </form>
            </div>

        </div> --}}

        <form action="{{ route('mir-get-report') }}" method="post">
            @csrf
            <div class="row px-2">
                <div class="col-md-3 px-1 my-1 my-md-0">
                    {{Form::text('fromdate', old('fromdate') ? old('fromdate') : null,['class' => 'form-control form-control-sm','id' => 'fromdate', 'autocomplete'=>"off",'required','placeholder'=>"From Date",])}}
                </div>
                <div class="col-1 d-flex align-items-end justify-content-center pb-3">
                    <i class="fa fa-exchange-alt"></i>
                </div>
                <div class="col-md-3 px-1 my-1 my-md-0">
                    {{Form::text('todate', old('todate') ? old('todate') : null,['class' => 'form-control form-control-sm','id' => 'todate', 'autocomplete'=>"off",'required','placeholder'=>"To Date",])}}
                </div>
                    {{Form::hidden('cost_center_id', old('cost_center_id') ? old('cost_center_id') : (isset($cost_center_id) ? $cost_center_id : null),['class' => 'form-control','autocomplete'=>"off",'required'])}}
                <div class="col-md-1 px-1 my-1 my-md-0">
                    <div class="input-group input-group-sm">
                        <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div><!-- end row -->
        </form>
        <hr class="bg-success">
        <div class="row">
            <div class="col-4"><h6>Project Name :{{ $totals->first()->first()->costCenter->name }}</h6></div>
            <div class="col-4"></div>
            <div class="col-4 text-right">
                @if (isset($fromdate) && isset($todate))
                    <h6>Period From {{ date('d-m-Y', strtotime($fromdate)) }} to {{ date('d-m-Y', strtotime($todate)) }}</h6>
                @endif
            </div>
        </div>
        <div class="row ">
            <div class="table-responsive tableFixHead">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th >SL No.</th>
                            <th>Material name</th>
                            <th >Unit</th>
                            <th>Opening Stock</th>
                            <th>Received From Purchase <br/>(Column 3 of) Store ledger</th>
                            <th >Received From Other Site <br/>(Column 7 of) Store ledger</th>
                            <th>Transfer To other site <br/>(Column 12 of) Store ledger</th>
                            <th>Issued To work at site <br/>(Column 16 of) Store ledger</th>
                            <th>Closing Stock <br/>(Column 18 of) Store ledger</th>
                            {{-- <th >Physical Stock as<br/> on above Date</th>
                            <th>Physical (shortage)<br/> Or Excess</th>
                            <th>Remarks</th> --}}
                            <th >Total Estimated Quantity</th>
                            <th>Net Cumulative Received <br/>(Column 14 of) store ledger</th>
                            <th>Cumulative Issue to work site <br/>(Column 14 of) store ledger</th>
                            <th >Remaining Required Quantity Total <br/>Estimated Quantity less Net Cumin Quantity</th>
                        </tr>
                    </thead>
                    @php
                        $ncr = [];
                    @endphp
                    @foreach ($totals as $key => $total)
                        @php
                                $count_parent = $total->first()->nestedMaterial->ancestors->count();
                                if($count_parent == 2){
                                    $r_span = $total->first()->nestedMaterial->id;
                                }else{
                                    $r_span = $total->first()->nestedMaterial->parent->id;
                                }
                                if (!array_key_exists($r_span, $ncr)){
                                    $ncr[$r_span] = 0;
                                }
                                if(isset($cumulitive_receive[$key])){
                                    $cumulitiveReceive = $cumulitive_receive[$key]->first()->total;
                                }else{
                                    $cumulitiveReceive = 0;
                                }
                                $ncr[$r_span] += $cumulitiveReceive;
                        @endphp
                    @endforeach
                    @php
                        $cb = $TotalEstimatedQuantity->countBy(function ($item) {
                    return $item['parent_id'];
                });
                        $netCumulitiveIssue = 0;
                        $netCumulitivePurchase = 0;
                        $netmovementin = 0;
                        $netmovementout = 0;
                        $chek= [];
                    @endphp
                    @foreach ($totals as $key => $total)
                    @php
                        $count_parent = $total->first()->nestedMaterial->ancestors->count();
                        if($count_parent == 2){
                            $r_span = $total->first()->nestedMaterial->id;
                        }else{
                            $r_span = $total->first()->nestedMaterial->parent->id;
                        }
                       
                        if(isset($opening_inventory[$key])){
                            $openingInventory = $opening_inventory[$key]->first()->previous_stock;
                         }else{
                            $openingInventory = 0;
                         }

                         if(isset($total_purchase[$key])){
                            $ReceivedFromPurchase = $total_purchase[$key]->first()->total;
                         }else{
                            $ReceivedFromPurchase = 0;
                         }

                         if(isset($total_sale[$key])){
                            $IssuedTowork = $total_sale[$key]->first()->total;
                         }else{
                            $IssuedTowork = 0;
                         }

                         if(isset($cumulitive_receive[$key])){
                            $cumulitiveReceive = $cumulitive_receive[$key]->first()->total;
                         }else{
                            $cumulitiveReceive = 0;
                         }

                         if(isset($cumulitive_issue[$key])){
                            $cumulitiveIssue = $cumulitive_issue[$key]->first()->total;
                         }else{
                            $cumulitiveIssue = 0;
                         }

                         if(isset($TotalEstimatedQuantity[$key])){
                            $total_estimated_quantity = $TotalEstimatedQuantity[$key]['value'];
                         }else{
                            $total_estimated_quantity = 0;
                         }


                         if(isset($total_movementin[$key])){
                            $totalMovementin = $total_movementin[$key]->first()->total;
                         }else{
                            $totalMovementin = 0;
                         }

                         if(isset($total_movementout[$key])){
                            $totalMovementout = $total_movementout[$key]->first()->total;
                         }else{
                            $totalMovementout = 0;
                         }

                        $closingStock = $openingInventory + $ReceivedFromPurchase + $totalMovementin - $IssuedTowork - $totalMovementout;
                        $netCumulitiveIssue += $IssuedTowork;
                        $netCumulitivePurchase += $ReceivedFromPurchase;
                        $netmovementin += $totalMovementin;
                        $netmovementout += $totalMovementout;
                    @endphp

                    <tr>
                        <td >{{ $loop->iteration }}</td>
                        <td>
                            {{$total->first()->nestedMaterial->name}}
                        </td>
                        <td >{{$total->first()->nestedMaterial->unit->name}}</td>
                        <td>
                            {{ $openingInventory }}
                        </td>
                        <td>
                            {{ $ReceivedFromPurchase }}
                        </td>
                        <td >
                           {{ $totalMovementin }}
                        </td>
                        <td>
                            {{ $totalMovementout }}
                        </td>
                        <td>
                            {{ $IssuedTowork }}
                        </td>
                        <td>
                            {{  $closingStock }}
                        </td>
                        {{-- <td>
                            0
                        </td>
                        <td>
                            0
                        </td>
                        <td>
                            0
                        </td> --}}
                         @if (!array_key_exists($r_span, $chek))
                         <td rowspan = "{{ $cb[$r_span] }}">
                            {{ $total_estimated_quantity }}
                        </td>
                        @endif
                       
                        
                        <td>
                            {{ $cumulitiveReceive }}
                        </td>
                        <td>
                            {{ $cumulitiveIssue }}
                        </td>
                        @if (!array_key_exists($r_span, $chek))
                         <td rowspan = "{{ $cb[$r_span] }}">
                           {{ $total_estimated_quantity -  $ncr[$r_span] }}
                        </td>
                        @endif
                        @php
                             $chek[$r_span] = 1;
                             
                        @endphp
                    </tr>
                    @endforeach

                </table>
            </div>

        </div>

    @endsection

    @section('script')
    <script>

        // Date picker formatter
        $('#fromdate').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        });
        $('#todate').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        });



        $(function() {

        }) // Document.Ready
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






