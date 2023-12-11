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
            font-size: 10px;
        }

        #detailsTable {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #detailsTable td,
        #detailsTable th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        #detailsTable tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #detailsTable tr:hover {
            background-color: #ddd;
        }

        #detailsTable th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #5387db;
            color: white;
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
            margin: 10px;
        }

        .row {
            clear: both;
        }

        .head1 {
            width: 45%;
            float: left;
            margin: 0;
        }

        .head2 {
            width: 55%;
            float: right;
            margin: 0;
        }

        .head3 {
            width: 45%;
            float: left;
            padding-bottom: 20px;
        }

        .head4 {
            width: 45%;
            float: right;
            padding-bottom: 20px;
        }

        .textarea {
            width: 100%;
            float: left;
        }

        .customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .customers td, .customers th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        .customers tr:nth-child(even){
            background-color: #f2f2f2;
        }

        .customers tr:hover {
            background-color: #ddd;
        }

        .customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #ddd;
            color: black;
        }

        .approval {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .approval td, .approval th {
            border: 1px solid #fff;
            padding: 5px;
        }

        /*header - position: fixed */
        #fixed_header {
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            right: 0;
        }

        /*fixed_footer - position: fixed */
        #fixed_footer {
            position: fixed;
            width: 94.4%;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .page_break {
            page-break-before: always;
        }

    </style>
</head>

<body>
    @php
        $iteration = 1;
        $itemCount = 0;
    @endphp
    @foreach ( $requisitions[0]->requisitiondetails->chunk(15) as $chunk )

    <div>
        <div class="container" id="fixed_header">
            <div class="row">
                <div class="head1" style="padding-left: 180px; text-align: center">
                    <img src="{{ asset(config('company_info.logo')) }}" alt="{!! htmlspecialchars(config('company_info.altText')) !!}">
                    <p>
                        {!! htmlspecialchars(config('company_info.company_address')) !!}<br>
                        Phone: {!! htmlspecialchars(config('company_info.company_phone')) !!}<br>
                        <a style="color:#000;" target="_blank">{!! htmlspecialchars(config('company_info.company_email')) !!}</a>
                    </p>
                    <h3>
                        MATERIAL PURCHASE REQUISITION(MPR)
                    </h3>
                </div>
                <div style="padding:50 0 0 50; ">
                    <h4 >
                        MPR No: {{ $requisitions[0]->mpr_no }}
                    </h4>
                    <h4>
                        Date: {{ $requisitions[0]->applied_date }}
                    </h4>
                </div>
            </div>
        </div>

        <div style="clear: both"></div>

        <div class="container">
            <p>
                Project Name: {{ $requisitions[0]->costCenter->name }}
            </p><br>
            <p>
                Note: {{ $requisitions[0]->note }}
            </p>
        </div>
    </div>


    <div class="container" style="margin-top: 25px;">
        <table class="customers">
            <thead>
                <tr>
                    <th>SL No.</th>
                    <th>Materials Name</th>
                    <th>Unit</th>
                    <th>Total<br>Estimated<br>Requirement</th>
                    <th>Net<br>Cumulative<br>Received</th>
                    <th>Present<br>Stock</th>
                    <th>Required<br>Presently</th>
                    <th>Required<br>Delivery<br>Date</th>
                </tr>
            </thead>
            <tbody style="text-align: center">

                @foreach ($chunk as $requisitiondetail)
                @php
                    $boqMaterial = App\Procurement\NestedMaterial::whereHas('boqSupremeBudgets')->whereAncestorOrSelf($requisitiondetail->material_id)->orderBy('id','desc')->first();

                    if (!empty($requisitiondetail->floor_id)) {
                        $floorNo = $requisitiondetail->boqFloors->where('project_id', $requisitiondetail->requisition->costCenter->project_id)->first();
                        $boq_quantity = App\Procurement\BoqSupremeBudget::
                                where('project_id',$requisitiondetail->requisition->costCenter->project_id)
                            ->where('floor_id', $floorNo->boq_floor_project_id)
                            ->where('material_id', $boqMaterial->id)
                            ->first();

                    }else{
                        $boq_quantity = App\Procurement\BoqSupremeBudget::
                            where('project_id',$requisitiondetail->requisition->costCenter->project_id)
                            ->where('material_id', $boqMaterial->id)
                            ->first();
                    }

                    $present_stock_in_stock_history = App\Procurement\StockHistory::
                        where('cost_center_id', $requisitiondetail->requisition->cost_center_id)
                        ->where('material_id', $requisitiondetail->material_id)
                        ->latest()
                        ->get();
                    $material_receive_project_id = App\Procurement\MaterialReceive::
                        where('cost_center_id', $requisitiondetail->requisition->cost_center_id)
                        ->groupBy('cost_center_id')
                        ->first();

                    if(!empty($material_receive_project_id)){
                        $material_receive_details_quantity_sum = App\Procurement\Materialreceiveddetail::with('materialreceive')
                            ->whereHas('materialreceive', function ($query) use ($material_receive_project_id){
                                return $query->where('cost_center_id', $material_receive_project_id->cost_center_id);
                            })
                            ->where('material_id', $requisitiondetail->material_id)
                            ->get()
                            ->sum('quantity');
                    }

                    $budgeted_quantity = $boq_quantity->quantity ?? 0;
                    $taken_quantity = $material_receive_details_quantity_sum ?? 0;
                    $present_stock = $present_stock_in_stock_history[0]->present_stock ?? 0;
                @endphp

                <tr>
                    <td> {{$iteration++}} </td>
                    <td> {{ $requisitiondetail->nestedMaterial->name }} </td>
                    <td> {{ $requisitiondetail->nestedMaterial->unit->name }} </td>
                    <td> {{ $budgeted_quantity }} </td>
                    <td> {{ $taken_quantity }} </td>
                    <td> {{ $present_stock }} </td>
                    <td> {{ $requisitiondetail->quantity }} </td>
                    <td> {{ $requisitiondetail->required_date }} </td>
                </tr>
                @endforeach
            </tbody>

        </table>
        <div   id="fixed_footer" style="margin-top:30px; padding-left: 10px; width: 97%;">
            <div  style="margin-top: 30px;">
                <table class="customers">
                    <tr>
                        <td >
                            <p>Remarks from Project/Site: {{ $requisitions[0]->remarks }} </p>
                        </td>
                    </tr>
                </table>
            </div>
            <div  style="margin-top: 30px;">
                <table class="customers">
                    <tr>
                        <td >
                            <p>Remarks by Inventory Management: </p>
                        </td>
                        <td >
                            <p>Remarks by Construction Department: </p>
                        </td>
                    </tr>
                </table>
            </div>
            <div  style="margin-top: 30px;">
                <table class="customers">
                    <tr>
                        <td >
                            <p>Remarks by Inventory Management: </p>
                        </td>
                        <td >
                            <p>Remarks by Construction Department: </p>
                        </td>
                    </tr>
                </table>
            </div>
            <div  style="margin-top: 30px;">
                <table class="approval" style="text-align: center; border:none!important">
                    <tr>
                        <td >
                            <p style="margin-top: 50px;">---------------------</p>
                            <p>store in-charge</p>
                        </td>
                        <td >
                            <p style="margin-top: 50px;">---------------------</p>
                            <p>store in-charge</p>
                        </td>
                        <td >
                            <p style="margin-top: 50px;">---------------------</p>
                            <p>store in-charge</p>
                        </td>
                        <td >
                            <p style="margin-top: 50px;">---------------------</p>
                            <p>store in-charge</p>
                        </td>
                        <td >
                            <p style="margin-top: 50px;">---------------------</p>
                            <p>store in-charge</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @if (!$loop->last)
            <div class="page_break"></div>
        @endif
    @endforeach

</body>
</html>
