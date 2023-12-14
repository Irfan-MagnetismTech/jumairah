@extends('layouts.backend-layout')
@section('title', 'Materials')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
    <style>
        .material_text{ padding-left:60px;  text-align: left; }
        .balanceLineStyle{display: none;}
        .parentAccountStyle{display: none;}
    </style>
@endsection

@section('breadcrumb-title')
    Account List
@endsection


@section('breadcrumb-button')
    <a href="{{ url('accounts/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
{{--    Total: {{ count($accounts) }}--}}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="" class=" table  table-bordered" width="100%">
            <thead>
            <tr>
                <th>SL</th>
                <th>Particular</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($balanceIncomeHeaders as $key => $balanceIncomeHeader)
                <tr style="background-color: #dbecdb">
                    <td class="text-left" style="padding-left: 15px!important;">{{ $floop = $loop->iteration}}</td>
                    <td class="text-left balance_header" id="{{$balanceIncomeHeader->id}}"> {{ $balanceIncomeHeader->line_text }}</td>
                    <td> </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ url("balance-and-income-lines/$balanceIncomeHeader->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "balance-and-income-lines/$balanceIncomeHeader->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                {!! Form::close() !!}
                            </nobr>
                        </div>
                    </td>
                </tr>
                @php $balanceLines = $balanceIncomeHeader->descendants()->where('parent_id',$balanceIncomeHeader->id)->get();
                @endphp
                @foreach($balanceLines as $akey => $balanceLine)
                    <tr style="background-color: #f0f5f5" class="balanceLineStyle balance_line_{{$balanceIncomeHeader->id}}">
                        <td class="text-left " style="padding-left: 15px!important;">{{$sloop = $floop .'.'.  $loop->iteration}}</td>
                        <td class="text-left balance_line" id="{{$balanceLine->id}}" style="padding-left: 30px!important; " > {{ $balanceLine->line_text }}</td>
                        <td> </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("balance-and-income-lines/$balanceLine->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {!! Form::open(array('url' => "balance-and-income-lines/$balanceLine->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    {!! Form::close() !!}
                                </nobr>
                            </div>
                        </td>
                    </tr>
                    @php $parentAccounts = $balanceLine->accounts()->whereNull('parent_account_id')->get(); @endphp
                    @foreach($parentAccounts as $skey => $parentAccount)
                        <tr style="background-color: #dfddf5" class="balanceLineStyle  parent_account_{{$balanceLine->id}} hide_parent_account_{{$balanceIncomeHeader->id}} ">
                            <td  class="text-left" style="padding-left: 15px!important;">{{ $ssloop = $sloop .'.'.$loop->iteration}}</td>
                            <td class="text-left parent_account" id="{{$parentAccount->id}}" style="padding-left: 60px!important;"> {{ $parentAccount->account_name }}</td>
                            <td> </td>
                            <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("accounts/$parentAccount->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {!! Form::open(array('url' => "accounts/$parentAccount->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    {!! Form::close() !!}
                                </nobr>
                            </div>
                            </td>
                        </tr>
                        @php $chiledAccounts = $parentAccount->accountChilds()->get();  @endphp
                        @foreach($chiledAccounts as $tkey => $chiledAccount)
                            <tr style="background-color: #d8e4f3" class="balanceLineStyle child_account_{{$parentAccount->id}} hide_parent_account_{{$balanceIncomeHeader->id}}
                                hide_balance_line_{{$balanceLine->id}}">

                                <td class="text-left" style="padding-left: 15px!important;">{{ $accloop = $ssloop .'.'.$loop->iteration}}</td>
                                <td class="text-left child_account" id="{{$chiledAccount->id}}" style="padding-left: 90px!important;"> {{ $chiledAccount->account_name }}</td>
                                <td> </td>
                                <td>
                                    <div class="icon-btn">
                                        <nobr>
                                            <a href="{{ url("accounts/$chiledAccount->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                            {!! Form::open(array('url' => "accounts/$chiledAccount->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                            {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                            {!! Form::close() !!}
                                        </nobr>
                                    </div>
                                </td>
                            </tr>
                            @php $accounts = $chiledAccount->accountChilds()->get(); @endphp
                            @foreach($accounts as $ackey => $account)
                                <tr class="balanceLineStyle account_{{$chiledAccount->id}} hide_parent_account_{{$balanceIncomeHeader->id}}
                                    hide_balance_line_{{$balanceLine->id}} hide_parent_account_{{$parentAccount->id}}">
                                    <td class="text-left" style="padding-left: 15px!important;">{{ $accloop .'.'.$loop->iteration}}</td>
                                    <td class="text-left " style="padding-left: 120px!important;"> {{ $account->account_name }}</td>
                                    <td> </td>
                                    <td>
                                        <div class="icon-btn">
                                            <nobr>
                                                <a href="{{ url("accounts/$account->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                                {!! Form::open(array('url' => "accounts/$account->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                                {!! Form::close() !!}
                                            </nobr>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
{{--            {{die()}}--}}
            </tbody>
        </table>
{{--        {{ $accounts->withQueryString()->links() }}--}}
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            $(document).on('click', '.balance_header', function(){
                let header = $(this).attr('id');
                $(".balance_line_"+header).toggle();
                $(".hide_parent_account_"+header).hide();
            });

            $(document).on('click', '.balance_line', function(){
                let currentLine = $(this).attr('id');
                $(".parent_account_"+currentLine).toggle();
                $(".hide_balance_line_"+currentLine).hide();
            });
            $(document).on('click', '.parent_account', function(){
                let parentAccount = $(this).attr('id');
                $(".child_account_"+parentAccount).toggle();
                $(".hide_parent_account_"+parentAccount).hide();
            });
            $(document).on('click', '.child_account', function(){
                let childAccount = $(this).attr('id');
                $(".account_"+childAccount).toggle();
            });
        });//document.ready
    </script>
@endsection
