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
            width: 100%;
        }

        #table td,
        #table th {
            border: 1px solid ;
            padding: 5px;
        }

        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            /* background-color: #227447; */
            color: black;
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
            margin: 20px;
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

        #apartment {
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            right: 20px;
            top: 20px;
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
            margin: 40px 0 0 0;
        }

    </style>
</head>

<body>

    <div id="logo" class="pdflogo">
        <img src="{{ asset(config('company_info.logo')) }}" alt="Logo" class="pdfimg">
        <div class="clearfix"></div>
        <h5>JHL Address.</h5>
    </div>



    <div class="container" style="margin-top: 10px; clear: both; display: block; width: 100%;">



        <div class="table-responsive">
            <table id="table" class="table table-striped table-bordered text-center" style="border-collapse: collapse">
                <thead>
                    <tr>
                        <th colspan="10">Ranks FC Properties Ltd.</th>
                    </tr>
                    <tr>
                        <th colspan="4">Project Name: {{ $currentYearPlans[0]->materialPlan->projects->name }}</th>
                        <th colspan="6">Duration: {{ date_format(date_create($currentYearPlans[0]->materialPlan->from_date),"d.m.Y")  }} To {{  date_format(date_create($currentYearPlans[0]->materialPlan->to_date),"d.m.Y") }}</th>
                    </tr>
                    <tr>
                        <th >SL No</th>
                        <th >Name of Materials</th>
                        <th >Unit</th>
                        <th >Week-1</th>
                        <th >Week-2</th>
                        <th >Week-3</th>
                        <th >Week-4</th>
                        <th >Remarks</th>
                        <th >Total<br>Quantity</th>
                        <th >Remarks</th>
                    </tr>

                </thead>

                <tbody>
                    @foreach ($currentYearPlans as $currentYearPlan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $currentYearPlan->nestedMaterials->name }}</td>
                            <td>{{ $currentYearPlan->nestedMaterials->unit->name }}</td>
                            <td>{{ $currentYearPlan->week_one }}</td>
                            <td>{{ $currentYearPlan->week_two }}</td>
                            <td>{{ $currentYearPlan->week_three }}</td>
                            <td>{{ $currentYearPlan->week_four }}</td>
                            <td>{{ $currentYearPlan->remarks }}</td>
                            <td>{{ $currentYearPlan->total_quantity }}</td>
                            <td></td>
                        </tr>
                   @endforeach
                </tbody>

            </table>
        </div>





        <br><br><br>
        <div style="display: block; width: 100%;">
            <table style="text-align: center; width: 100%;">
                <tr>
                    <td>
                        <span>---------------------------------</span>
                        <p>Project In Charge</p>
                    </td>
                    <td>
                        <span>---------------------------------</span>
                        <p>Project Co-Ordinator</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
