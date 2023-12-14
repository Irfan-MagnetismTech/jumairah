<!DOCTYPE html>
<html>

<head>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            margin: 20px !important;
            padding: 20px !important;
        }


        table {
            font-size: 10px;
        }

        #allowances {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;

        }

        .delivery-order-details-table {
            border-collapse: collapse;
            width: 100%;
        }

        #allowances td {
            /* text-align: right; */
        }


        #allowances td,
        #allowances th {
            border: 1px solid black;
            padding: 5px;
        }

        #allowances tr:nth-child(even) {
            /* background-color: #f2f2f2; */
        }

        #allowances tr:hover {
            background-color: #ddd;
        }

        #allowances th {
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

        #allowances,
        #allowances td,
        #allowances th {
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
            margin: 130px 50px 90px 50px;
        }
    </style>
    <title>Employee Appointment Letter</title>
</head>

<body>
    <div class="container">

        <div>
            <p>{{$appointment_letter->letter_no}}</p>
            <br>
            <p>{{$appointment_letter->letter_issue_date}}</p>
            <br>
            <p>To,</p>
            <p><strong>{{ $appointment_letter->employee_name }}</strong></p>
            <p>{!! $appointment_letter->employee_address !!} </p>


            <p style="text-align: center;text-decoration:underline; line-height:13px"><strong>Sub: Appointment
                    Letter.</strong></p>

            <p>Dear {{ $appointment_letter->employee_name }},</p>
            <br>
            <p>
                With reference to your application and subsequent interview with us, we are happy to appoint you as
                {{ $appointment_letter->employee_designation }} and posted to Golden Ispat Limited., Your job area in
                following locations: {{ $appointment_letter->employee_job_location }} from {{ $appointment_letter->employee_joining_date }} under the following terms & condition.
            </p>
            <br>

            {!! $appointment_letter->terms_and_conditions !!}

            <p>
                If you agree to the above terms and conditions, please sign the duplicate copy of the appointment letter
                and send us the copy to our corporate office.
            </p>
            <br>

            <p>Thanking you,</p>
            <p>{{ $appointment_letter->letter_issuer_name }}</p>
            <p>{{ $appointment_letter->letter_issuer_designation }}</p>
            <br>
            C.C. to:
             <br>
            @if ($appointment_letter->letter_carbon_copu_to)
            {!! $appointment_letter->letter_carbon_copu_to !!}
            @else
            @endif
            1. Honorable Chairman- for kind information. <br>
            2. Honorable Managing Director- for kind information. <br>
            3. General Manager (Group) - for information. <br>
            4. AGM (M&S)- for information & Necessary action. <br>
            5. Accounts Division (Head Office). <br>
            6. Office Copy.
             <br>


        </div>
    </div>
</body>

</html>
