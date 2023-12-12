<!DOCTYPE html>
<html>

<head>
    @php
        $user = Auth::user();
        $companyData = DB::table('company_infos')
            ->where('com_id', $user->com_id)
            ->first();

        $totalQty = 0;

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

        .job-card-table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;

        }

        .delivery-order-details-table{
            border-collapse: collapse;
            width:100%;
        }

        .job-card-table td {
            /* text-align: right; */
        }


        .job-card-table td,
        .job-card-table th {
            border: 1px solid black;
            padding: 5px;
        }

        .job-card-table tr:nth-child(even) {
            /* background-color: #f2f2f2; */
        }

        .job-card-table tr:hover {
            background-color: #ddd;
        }

        .job-card-table th {
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

        .job-card-table,
        .job-card-table td,
        .job-card-table th {
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

        .search-criteria-container{
            font-size: 12px;
        }
        .search-criteria-container h6{
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
    <title>Job Card</title>
</head>

<body>
    <htmlpageheader name="page-header">
        <div>
            &nbsp;
        </div>
        <div style="width: 24%; float:left;">
            <img class="float-right" style="height: 50px;"
                src="{{ asset('images/company/' . $companyData->company_logo) }}" alt="Golden ispat Logo">
        </div>
        <div style="width: 50%; float:left;">
            <div style="margin-top: 20px;">
                <h1 style="font-size: 20px;  text-align: center">{{ $companyData->company_name }}</h1>
                <p style="font-size: 12px; text-align: center">{{ $companyData->primary_address }}</p>
                <p style="font-size: 12px; text-align: center">Phone: {{ $companyData->company_phone_1 }}</p>
                <p style="font-size: 12px; text-align: center; font-weight: bold;text-transform: uppercase; ">
                    Job Card
                    {{-- date('d-m-Y', strtotime($user->from_date)); --}}
                </p>
                <p style="font-size: 12px; text-align: center; font-weight: bold; ">
                    Report of {{ \Carbon\Carbon::parse($month)->format('M-Y') }}
                </p>

            </div>
        </div>
        <div style="width: 25%; float:left;">
            {{-- Print: {{ date('d-M-Y H:i:s', strtotime($print_date_time)) }} --}}
            Print: {{ $print_date_time }}
            <div class="search-criteria-container">
                <h6>Search Criteria:</h6>
                <div>
                    @foreach ($search_criteria as $key=>$sc)
                        <p>{{ $key }} : {{ $sc }}</p>
                    @endforeach
                </div>
            </div>

        </div>
    </htmlpageheader>

    <html-separator />


    <div class="container" >
        @php
            $flag = 0;
        @endphp
        @if(count($reportData))
            @foreach ($reportData as $data)
                @if ($flag != 0)
                    <pagebreak>
                @endif
                {{-- {{ dd($data->first()?->designation) }} --}}
                <div style="margin-bottom: 25px;">
                    <table class="job-card-table">
                        <tr>
                            <th style="width: 8%">Name:</th>
                            <td colspan="4" style="width: 67%;">{{ $data->first()?->employee?->emp_name }}</td>
                            <td style="width: 1%"></td>
                            <th style="width: 8%">Code:</th>
                            <td style="width: 16%">{{ $data->first()?->employee?->emp_code }}</td>
                            <td style="width: 1%"></td>
                            <th style="width: 8%">Designation:</th>
                            <td style="width: 16%">{{ $data->first()?->designation}}</td>

                        </tr>
                        <tr>
                            <th style="width: 8%">Department:</th>
                            <td style="width: 17%">{{ $data->first()?->department?->name }}</td>
                            <td style="width: 1%"></td>
                            <th style="width: 8%">Section:</th>
                            <td style="width: 16%">{{ $data->first()?->section?->name }}</td>
                            <td style="width: 1%"></td>
                            <th style="width: 8%">Sub Section:</th>
                            <td style="width: 16%">{{ $data->first()?->sub_section?->name }}</td>
                            <td style="width: 1%"></td>

                            <th style="width: 8%">Type:</th>
                            <td style="width: 16%">{{ $data->first()?->employeeType?->name }}</td>


                        </tr>
                    </table>
                </div>
                <h3>Attendance:</h3>
                <table class="job-card-table">
                    <thead>
                        <tr>
                            <th style="width: 10%">Date</th>
                            <th style="width: 12%">Shift</th>
                            <th style="width: 12%">In Time</th>
                            <th style="width: 12%">Out Time</th>
                            <th style="width: 12%">Late</th>
                            <th style="width: 12%">OT</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 20%">Remarks</th>
                        </tr>

                    </thead>
                    <tbody>
                        {{-- {{ dd($reportData) }} --}}
                        {{-- {{ dd($data) }} --}}
                        @foreach ($data as $key => $dt)
                            <tr>
                                <td class="text-center">{{ date('d-M-Y', strtotime($dt->punch_date)) }}</td>

                                <td>{{ $dt->shift?->name }}</td>

                                <td class="text-center">{{ $dt->time_in ? Carbon\Carbon::parse($dt->time_in)->format('h:i:s A') : '' }}</td>
                                <td class="text-center">{{ $dt->time_out ? Carbon\Carbon::parse($dt->time_out)->format('h:i:s A') : '' }}</td>

                                <td class="text-center">{{ $dt->late }}</td>
                                <td class="text-center">{{ $dt->ot_hour }}</td>

                                <td>
                                    @switch($dt->status)
                                        @case('p')
                                            {{ 'Present' }}
                                            @break
                                        @case('a')
                                            {{ 'Absent' }}
                                            @break
                                        @case('l')
                                            {{ 'Late' }}
                                            @break
                                        @case('w')
                                            {{ 'Weekend' }}
                                            @break
                                        @case('h')
                                            {{ 'Weekend' }}
                                            @break

                                        @default
                                            {{ \Modules\HR\Entities\LeaveType::whereRaw('LOWER(short_name) = ?', [strtolower($dt->status)])->first()?->name }}
                                    @endswitch
                                </td>
                                <td>{{ $dt->remarks }}</td>




                            </tr>
                            @if ($key == 14)
                                @break
                            @endif
                        @endforeach

                    </tbody>

                </table>

                @if (count($data) > 15)
                    <pagebreak>
                @endif
                @if (count($data->slice(15)))
                <div style="margin-bottom: 25px;">
                    <table class="job-card-table">
                        <tr>
                            <th style="width: 8%">Name:</th>
                            <td colspan="4" style="width: 67%;">{{ $data->first()?->employee?->emp_name }}</td>
                            <td style="width: 1%"></td>
                            <th style="width: 8%">Code:</th>
                            <td style="width: 16%">{{ $data->first()?->employee?->emp_code }}</td>
                            <td style="width: 1%"></td>
                            <th style="width: 8%">Designation:</th>
                            <td style="width: 16%">{{ $data->first()?->designation}}</td>

                        </tr>
                        <tr>
                            <th style="width: 8%">Department:</th>
                            <td style="width: 17%">{{ $data->first()?->department?->name }}</td>
                            <td style="width: 1%"></td>
                            <th style="width: 8%">Section:</th>
                            <td style="width: 16%">{{ $data->first()?->section?->name }}</td>
                            <td style="width: 1%"></td>
                            <th style="width: 8%">Sub Section:</th>
                            <td style="width: 16%">{{ $data->first()?->sub_section?->name }}</td>
                            <td style="width: 1%"></td>

                            <th style="width: 8%">Type:</th>
                            <td style="width: 16%">{{ $data->first()?->employeeType?->name }}</td>


                        </tr>
                    </table>
                </div>
                <h3>Attendance:</h3>
                <table class="job-card-table">
                    <thead>
                        <tr>
                            <th style="width: 10%">Date</th>
                            <th style="width: 12%">Shift</th>
                            <th style="width: 12%">In Time</th>
                            <th style="width: 12%">Out Time</th>
                            <th style="width: 12%">Late</th>
                            <th style="width: 12%">OT</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 20%">Remarks</th>
                        </tr>

                    </thead>
                    <tbody>
                        {{-- {{ dd($reportData) }} --}}
                        @foreach ($data->slice(15) as $key => $dt)
                            <tr>
                                <td class="text-center">{{ date('d-M-Y', strtotime($dt->punch_date)) }}</td>

                                <td>{{ $dt->shift?->name }}</td>

                                <td class="text-center">{{ $dt->time_in ? Carbon\Carbon::parse($dt->time_in)->format('h:i:s A') : '' }}</td>
                                <td class="text-center">{{ $dt->time_out ? Carbon\Carbon::parse($dt->time_out)->format('h:i:s A'): '' }}</td>

                                <td class="text-center">{{ $dt->late }}</td>
                                <td class="text-center">{{ $dt->ot_hour }}</td>

                                <td>
                                    @switch($dt->status)
                                        @case('p')
                                            {{ 'Present' }}
                                            @break
                                        @case('a')
                                            {{ 'Absent' }}
                                            @break
                                        @case('l')
                                            {{ 'Late' }}
                                            @break
                                        @case('w')
                                            {{ 'Weekend' }}
                                            @break
                                        @case('h')
                                            {{ 'Weekend' }}
                                            @break

                                        @default
                                            {{ \Modules\HR\Entities\LeaveType::whereRaw('LOWER(short_name) = ?', [strtolower($dt->status)])->first()?->name }}
                                    @endswitch
                                </td>
                                <td>{{ $dt->remarks }}</td>




                            </tr>
                            @if ($key == 14)
                                @break
                            @endif
                        @endforeach

                    </tbody>

                </table>
                @endif


                @php
                    $flag = 1;
                @endphp

            @endforeach
        @else
            <div style="padding-top: 150px;">
                <h1 class="text-center" >No results found</h1>
            </div>
        @endif



    </div>

    <htmlpagefooter name="page-footer">
        <div class=" text-xs justify-between">
            <div>
                <div style="width:24%; float:left; margin-left: 5px; border: 1px solid black; padding: 50px 0px 5px 0px;">
                    <div>
                        <div class="text-center">Prepared By</div>
                    </div>
                </div>
                <div style="width:24%; float:left; margin-left: 5px; border: 1px solid black; padding: 50px 0px 5px 0px;">
                    <div>
                        <div class="text-center">General Manager</div>
                    </div>
                </div>
                <div style="width:24%; float:left; margin-left: 5px; border: 1px solid black; padding: 50px 0px 5px 0px;">
                    <div>
                        <div class="text-center">Director</div>
                    </div>
                </div>
                <div style="width:24%; float:left; margin-left: 5px; border: 1px solid black; padding: 50px 0px 5px 0px;">
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
