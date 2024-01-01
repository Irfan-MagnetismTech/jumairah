@extends('layouts.backend-layout')
@section('title', 'Construction Bill Details')

@section('breadcrumb-title')
   Construction Bill Details
@endsection

@section('breadcrumb-button')
    <a href="{{ url('construction-bills') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    {{--    <span class="text-danger">*</span> Marked are required.--}}
@endsection

@section('content-grid',null)

@section('content')

    <div class="row">
        <div class="col-lg-12">
            {{-- <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                    <tr style="background-color: #0C4A77;color: white"><td> <strong>Project Name</strong> </td> <td> <strong>{{$constructionBill->project->name}}</strong></td></tr>
                    <tr><td> <strong>Date</strong> </td> <td>{{$constructionBill->bill_received_date}}</td></tr>
                    <tr><td> <strong>Title</strong> </td> <td>{{$constructionBill->title}}</td></tr>
                    <tr><td> <strong>Supplier Name</strong> </td> <td>{{$constructionBill->supplier->name}}</td></tr>
                    <tr><td> <strong>Security Money</strong> </td> <td>{{$constructionBill->percentage}} %</td></tr>
                    <tr><td> <strong>Bill No</strong> </td> <td>{{$constructionBill->bill_no}}</td></tr>
                    <tr><td> <strong>Bill Amount</strong> </td> <td>{{$constructionBill->bill_amount}}</td></tr>
                    <tr><td> <strong>Work Type</strong> </td> <td>{{$constructionBill->work_type}}</td></tr>
                    <tr><td> <strong>Remarks</strong> </td> <td>{{$constructionBill->remarks}}</td></tr>
                    <tr><td> <strong>Status</strong> </td> <td class="text-c-orenge"><strong>{{ $constructionBill->status}}</strong></td></tr>
                    </tbody>
                </table>
            </div> --}}
            <div class="container" style= "width:100%; margin-top:8px;">
                <div class="text-left" style="float:left; width:80%;">
                    <p>{{$constructionBill->date}}</p>
                </div>
                <div class="text-center float-right" style="float: right; width:20%;">
                    <p> Bill Sl. No. {{ $constructionBill?->bill_no }} </p>
                </div>

            </div>
                <p style="text-align: center; margin-top: 40px;padding-left: 30%!important;" class="text-center pl-5"><strong>Supplier Name: {{$constructionBill?->supplier?->name}}</strong></p>
                <P style="text-align: center;">Project Name: {{$constructionBill?->project?->name}} </P>
                <P style="text-align: center;">Type of Work: {{ $constructionBill->title }}</P><br>
                <div class="table-responsive">
                    <table style="margin-top: 5px; margin-bottom: 20px; width: 100%;" id="payment_schedule" class="table table-striped table-bordered">
                        <thead>
                            <tr style="background-color: #0C4A77!important;color: white!important;">
                                <th style="width: 15%;">No. of Bill</th>
                                <th style="width: 13%;">Unit</th>
                                <th style="width: 18%;">Bill Amount</th>
                                <th style="width: 18%;">Cumulative bill <br> Amount</th>
                                <th style="width: 18%;">Paid Amount</th>
                                <th style="width: 18%;">Due <br> Payable Amount</th>
                                <th style="width: 18%;">Adjusted <br>Amount</th>
                            </tr>
                        </thead>

                        @php
                            $cumulitive_bill = 0;
                            $paid_amount = 0;
                            $security = 0;
                            $due_payable = 0;
                            $adjusted_amount = 0;
                            $bill_no = 1;
                            $security_percent = [];
                            function addOrdinalNumberSuffix($num) {
                                if (!in_array(($num % 100),array(11,12,13))){
                                    switch ($num % 10) {
                                        // Handle 1st, 2nd, 3rd
                                        case 1:  return $num.'st';
                                        case 2:  return $num.'nd';
                                        case 3:  return $num.'rd';
                                    }
                                }
                                return $num.'th';
                            }
                        @endphp
                        <tbody>
                        @foreach ($All_dates as $key => $value)

                            @if (isset($advance[$value]))
                                @foreach ($advance[$value] as $key2 => $value2)
                                    <tr>
                                        <td class="textCenter">Advanced</td>
                                        <td class="textCenter">Tk.</td>
                                        <td class="textRight" style="padding-right:5px"></td>
                                        @php
                                            $paid_amount += $value2->dr_amount;
                                        @endphp
                                        <td class="textRight" style="padding-right:5px">@money($cumulitive_bill)</td>
                                        <td class="textRight" style="padding-right:5px">@money($value2->dr_amount)</td>
                                        <td class="textRight" style="padding-right:5px"></td>
                                        <td class="textRight" style="padding-right:5px"></td>
                                    </tr>
                                @endforeach
                            @endif
                            @if(isset($allConstructionBill[$value]))
                                @foreach ($allConstructionBill[$value] as $key3 => $value3)
                                    <tr>
                                        <td class="textCenter">{{addOrdinalNumberSuffix($bill_no)}} Bill ( {{$value3?->workorderRates?->work_level ?? ''}}) </td>
                                        <td class="textCenter">Tk.</td>
                                        <td class="textRight" style="padding-right:5px">@money($value3->bill_amount)</td>
                                        @php
                                            $cumulitive_bill += $value3->bill_amount;
                                            $security += $value3->bill_amount * $value3->percentage / 100;
                                            $paid_amount += $value3->paidBill;
                                            $adjusted_amount += $value3->adjusted_amount;
                                            $bill_no++;
                                            array_push($security_percent,$value3->workorderRates->work_level.'_'.$value3->percentage);
                                        @endphp
                                        <td class="textRight" style="padding-right:5px">@money($cumulitive_bill)</td>
                                        <td class="textRight" style="padding-right:5px">@money($value3->paidBill)</td>

                                        @if ($loop->last)
                                            <td class="textRight" style="padding-right:5px">0.00</td>
                                        @else
                                            @if ($value3->paidBill == 0)
                                                <td class="textRight" style="padding-right:5px">@money($value3->due_payable)</td>
                                                @php
                                                    $due_payable += $value3->due_payable;
                                                @endphp
                                            @else
                                                <td class="textRight" style="padding-right:5px">0.00</td>
                                            @endif


                                        @endif
                                        <td class="textRight" style="padding-right:5px">@money($value3->adjusted_amount)</td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="hide_all">
                            <td class="hide_all" style="width: 90%">Total Bill Amount</td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" style="width: 10%" class="textRight">@money($cumulitive_bill)</td>
                            <td class="hide_all" ></td>
                            <td class="textRight" style="padding-right:5px">@money($paid_amount)</td>
                            <td class="textRight">@money($due_payable)</td>
                            <td class="textRight">@money($adjusted_amount)</td>
                        </tr>
                        @php
                            $dddd = array_unique($security_percent);
                        @endphp
                        <tr class="hide_all" style="width: 100%;">
                            <td class="hide_all" style="width: 90%">Less: security money
                                <br /> (
                                @foreach ($dddd as $security_percen)
                                    @php
                                        $data = explode("_",$security_percen);
                                    @endphp
                                      {{ $data[1] }}% on {{ $data[0] }}
                                      @if (!$loop->last)
                                          ,
                                      @endif
                                @endforeach
                                )
                            </td>
                            <td class="hide_all" ></td>
                            <td style="width: 10%" class="textRight">@money($security)</td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                        </tr>
                        <tr  class="hide_all" style="width: 100%;">
                            <td class="hide_all"  style="width: 90%"><strong>Net total bill amount</strong></td>
                            <td class="hide_all" ></td>
                            <td style="width: 10%" class="textRight"><strong>@money($cumulitive_bill - $security)</strong></td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                        </tr>
                        <tr  class="hide_all" class="blank_row" style="width: 100%;">
                            <td bgcolor="#FFFFFF" colspan="2">&nbsp;</td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                        </tr>
                        <tr  class="hide_all" style="width: 100%;">
                            <td style="width: 90%;">Less: Total paid amount (with advance)</td>
                            <td class="hide_all" ></td>
                            <td style="width: 10%" class="textRight">@money($paid_amount)</td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                        </tr>
                        <tr  class="hide_all" style="width: 100%;">
                            <td style="width: 90%">Less: Total Due payable amount</td>
                            <td class="hide_all" ></td>
                            <td style="width: 10%" class="textRight">@money($due_payable)</td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                        </tr>
                        <tr  class="hide_all" style="width: 100%;">
                            <td style="width: 90%">Less: Total adjusted Amount</td>
                            <td class="hide_all" ></td>
                            <td style="width: 10%" class="textRight">@money($adjusted_amount)</td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                            <td class="hide_all" ></td>
                        </tr>
                        <tr style="width: 100%;" class="hide_all">
                            <td style="width: 90%" class="hide_all">
                                <strong>Bill payable against this {{ addOrdinalNumberSuffix($bill_no - 1) }} no.bill</strong>
                                <strong>(After Advance adustment)</strong>
                            </td>
                            <td class="hide_all"></td>
                            <td style="width: 10%" class="textRight hide_all">@money($cumulitive_bill - $security - $paid_amount - $adjusted_amount - $due_payable)</td>
                            <td class="hide_all"></td>
                            <td class="hide_all"></td>
                            <td class="hide_all"></td>
                            <td class="hide_all"></td>
                        </tr>
                    </tfoot>
                    </table>
                </div>





        </div>
    </div>

@endsection
