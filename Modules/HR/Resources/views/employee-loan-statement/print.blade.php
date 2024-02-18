<!DOCTYPE html>
<html>

<head>
    @php

        function getBangladeshCurrency($number)
        {
            $decimal = round($number - ($no = floor($number)), 2) * 100;
            $hundred = null;
            $digits_length = strlen($no);
            $i = 0;
            $str = [];
            $words = [
                0 => '',
                1 => 'one',
                2 => 'two',
                3 => 'three',
                4 => 'four',
                5 => 'five',
                6 => 'six',
                7 => 'seven',
                8 => 'eight',
                9 => 'nine',
                10 => 'ten',
                11 => 'eleven',
                12 => 'twelve',
                13 => 'thirteen',
                14 => 'fourteen',
                15 => 'fifteen',
                16 => 'sixteen',
                17 => 'seventeen',
                18 => 'eighteen',
                19 => 'nineteen',
                20 => 'twenty',
                30 => 'thirty',
                40 => 'forty',
                50 => 'fifty',
                60 => 'sixty',
                70 => 'seventy',
                80 => 'eighty',
                90 => 'ninety',
            ];
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
            $Taka = implode('', array_reverse($str));
            $poysa = $decimal ? ' and ' . ($words[$decimal / 10] . ' ' . $words[$decimal % 10]) . ' poysa' : '';
            return ($Taka ? $Taka . 'taka ' : '') . $poysa;
        }
    @endphp
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 20px !important;
            padding: 20px !important;
        }


        table {
            font-size: 10px;
        }

        .ot_status_table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;

        }

        .delivery-order-details-table {
            border-collapse: collapse;
            width: 100%;
        }

        .ot_status_table td {
            /* text-align: right; */
        }


        .ot_status_table td,
        .ot_status_table th {
            border: 1px solid black;
            padding: 5px;
        }

        .ot_status_table tr:nth-child(even) {
            /* background-color: #f2f2f2; */
        }

        .ot_status_table tr:hover {
            background-color: #ddd;
        }

        .ot_status_table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #ffffff;
        }

        /* table tfoot td {
            font-weight: bold;
            border: 1px solid #ffffff;
            background-color: #ffffff !important;
        } */

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
            float: left;
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

        .text-center {
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-4xl {
            font-size: 1.5rem;
        }

        .font-semibold {
            font-weight: 600;
        }

        .text-base {
            font-size: 0.875rem;
        }

        .text-sm {
            font-size: 0.75rem;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .flex {
            display: flex;
        }

        .mt-12 {
            margin-top: 3rem;
        }

        .justify-between {
            justify-content: space-between;
        }

        .flex-col {
            flex-direction: column;
        }

        .flex-wrap {
            flex-wrap: wrap;
        }

        .justify-between {
            justify-content: space-between;
        }

        .font-semibold {
            font-weight: 600;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        #ot_status_table,
        #ot_status_table td,
        #ot_status_table th {
            padding: 5px;
            border-collapse: collapse;
            border: 1px solid black;

        }



        .text-4xl {
            font-size: 24px;

        }

        #orderinfo-table tr td {
            border: 1px solid #ffffff;
        }

        #orderinfo-table2 tr td {
            border: 1px solid #ffffff;
            text-align: left;
        }

        .search-criteria-container {
            font-size: 12px;
        }

        .search-criteria-container h6 {
            font-size: 12px;
            margin: 0;
        }




        @page {
            header: page-header;
            footer: page-footer;
            /* margin: 120px 50px 50px 50px; */
            margin: 150px 50px 90px 50px;
        }
    </style>
    <title>Loan Statement</title>
</head>

<body>
    <htmlpageheader name="page-header">
        <div>
            &nbsp;
        </div>
        <div style="width: 24%; float:left;">
            <img class="float-right" style="height: 50px;" src="{{ asset(config('company_info.logo')) }}"
                alt="Golden ispat Logo">
        </div>
        <div style="width: 50%; float:left;">
            <div style="margin-top: 20px;">
                <h1 style="font-size: 20px;  text-align: center">{{ config('company_info.company_name') }}</h1>
                <p style="font-size: 12px; text-align: center">{{ config('company_info.company_address') }}</p>
                <p style="font-size: 12px; text-align: center">Phone: {{ config('company_info.company_phone') }}</p>
                <p style="font-size: 12px; text-align: center; font-weight: bold;text-transform: uppercase; ">
                    Employee Loan Statement
                    {{-- date('d-m-Y', strtotime($user->from_date)); --}}
                </p>
                <p style="font-size: 12px; text-align: center; font-weight: bold; ">


                </p>

            </div>
        </div>

    </htmlpageheader>

    <html-separator />




    <div class="container">
        @if ($loanApplication)
            <h2>Loan Information: </h2>
            <table class="ot_status_table">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Department</th>
                        <th>Loan Type</th>
                        <th>Loan Amount</th>
                        <th>Loan Release Date</th>
                    </tr>

                </thead>
                <tbody>
                    <tr>
                        <td>{{ $loanApplication->employee->emp_name }}</td>
                        <td>{{ $loanApplication->employee->department->department_name }}</td>
                        <td>{{ $loanApplication->loan_type->name }}</td>
                        <td>@money($loanApplication->loan_amount)</td>
                        <td>{{ date('d-M-Y', strtotime($loanApplication->loan_date)) }}</td>
                    </tr>

                </tbody>

            </table>


            <h2>Loan Installment Information: </h2>

            <table class="ot_status_table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Installment Amount</th>
                        <th>Left Amount</th>

                    </tr>

                </thead>
                <tbody>
                    @foreach ($loanApplication->loanPayments as $installment)
                        <tr>
                            <td>{{ date('d-M-Y', strtotime($installment->payment_date)) }}</td>
                            <td>@money($installment->payment_amount)</td>
                            <td>{{ $loanApplication->left_amount - $installment->payment_amount }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        @else
            <div style="padding-top: 150px;">
                <h1 class="text-center">No results found</h1>
            </div>
        @endif
    </div>

    <htmlpagefooter name="page-footer">
        <div class=" text-xs justify-between">
            <div>
                <div
                    style="width:24%; float:left; margin-left: 5px; border: 1px solid black; padding: 50px 0px 5px 0px;">
                    <div>
                        <div class="text-center">Prepared By</div>
                    </div>
                </div>
                <div
                    style="width:24%; float:left; margin-left: 5px; border: 1px solid black; padding: 50px 0px 5px 0px;">
                    <div>
                        <div class="text-center">General Manager</div>
                    </div>
                </div>
                <div
                    style="width:24%; float:left; margin-left: 5px; border: 1px solid black; padding: 50px 0px 5px 0px;">
                    <div>
                        <div class="text-center">Director</div>
                    </div>
                </div>
                <div
                    style="width:24%; float:left; margin-left: 5px; border: 1px solid black; padding: 50px 0px 5px 0px;">
                    <div>
                        <div class="text-center">Managing Director</div>
                    </div>
                </div>

            </div>
            <div>
                &nbsp;
            </div>
        </div>
    </htmlpagefooter>
</body>

</html>