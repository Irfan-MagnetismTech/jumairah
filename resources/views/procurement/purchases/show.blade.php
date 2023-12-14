@extends('layouts.backend-layout')
@section('title', 'Purchases')

@section('breadcrumb-title')
    Show LC Purchase
@endsection

@section('breadcrumb-button')
    <a href="{{ url('purchases') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
{{--    <span class="text-danger">*</span> Marked are required.--}}
@endsection

@section('content-grid',null)

@section('content')


    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <td class="text-right">Supplier Name :</td>
                <th class="text-left">{{$purchase->supplier->name ?? ''}}</th>
                <td class="text-right">Date :</td>
                <th class="text-left">{{ $purchase->date ? date('d-m-Y',strtotime($purchase->date)):'' }}</th>
            </tr>

            <tr>
                <td class="text-right">Remarks :</td>
                <th class="text-left">{{$purchase->remarks }}</th>
                <td class="text-right">Warehouse  :</td>
                <th class="text-left">{{$purchase->warehouse->name ?? ''}}</th>
            </tr>

        </table>
        <h4> Purchase Details </h4>
        <table class="table table-bordered">
            <tr>
                <th >Row Material Name  </th>
                <th class="text-right">Quantity  </th>
                <th class="text-right">Unit Price  </th>
                <th class="text-right">Total Price </th>
            </tr>
            <?php  $TotalProductPrice = 0;  ?>
            @foreach($purchase->purchaseDetails as $purchaseDtl)
                <tr>
                    <td class="text-left">{{$purchaseDtl->rowMetarials->name}}</td>
                    <td class="text-right">
                        {{$purchaseDtl->quantity}} {{$purchaseDtl->rowMetarials->unit->name ?? ''}}<br>
                    </td>
                    <td class="text-right">{{$purchaseDtl->unite_price}}</td>
                    <td class="text-right">{{$TotalProductPrice += $purchaseDtl->totalPrice}}</td>
                </tr>
            @endforeach
            <tr>
                <th class="text-right" colspan="3"> Total</th>
                <th class="text-right" > {{$TotalProductPrice}}</th>
            </tr>
            <tr>
                <th class="text-right" colspan="3"> VAT</th>
                <th class="text-right" > {{$TotalProductPrice}}</th>
            </tr>
        </table>
    </div>

@endsection

@section('script')

@endsection
