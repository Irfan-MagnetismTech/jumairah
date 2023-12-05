@extends('layouts.backend-layout')
@section('title', 'Vendors Outstanding Statement')

@section('breadcrumb-title')
    Vendors Outstanding Statement
@endsection

    @section('content')
    <form action="{{ route('vendor-outstanding-report') }}" method="post">
        @csrf
        <div class="row px-2">
            <div class="col-md-3 px-1 my-1 my-md-0">
                {{Form::text('fromdate', old('fromdate') ? old('fromdate') : null,['class' => 'form-control form-control-sm','id' => 'fromdate', 'autocomplete'=>"off",'required','placeholder'=>"From Date", 'readonly'])}}
            </div>
            <div class="col-1 d-flex align-items-end justify-content-center pb-3">
                <i class="fa fa-exchange-alt"></i>
            </div>
            <div class="col-md-3 px-1 my-1 my-md-0">
                {{Form::text('todate', old('todate') ? old('todate') : null,['class' => 'form-control form-control-sm','id' => 'todate', 'autocomplete'=>"off",'required','placeholder'=>"To Date",'readonly'])}}
            </div>
            <div class="col-md-1 px-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>
    
    <hr class="bg-success">

    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Supplier Name</th>
                    <th>Amount</th>
                    <th>Payment</th>
                </tr>
            </thead>
            
            <tbody>
                @php
                    $grand_total_balance = 0;
                    $grand_total_payment = 0;
                    $total_balance = 0;
                @endphp
                @foreach($totalBillOutstanding as $data)
                @php
                    $total_balance += $data['total_amount'];
                @endphp
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $data['account_name'] }}</td>
                    <td>{{ $data['total_amount'] }}</td>
                    <td>{{ $data['total_amount'] * 0.80 }}</td>
                </tr>
                @endforeach
            </tbody>
            @php
                $grand_total_balance += $total_balance;
            @endphp
            <tfoot>
                <tr>
                    <th colspan="2">Outstanding Balance</th>
                    <th>{{ $grand_total_balance }}</th>
                    <th> {{ $grand_total_balance * 0.80}} </th>
                </tr>
            </tfoot>
        </table>
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
    </script>
@endsection