@extends('layouts.backend-layout')
@section('title', 'Employee Details')

@section('breadcrumb-title')
    Employee Details
@endsection

@section('breadcrumb-button')
    <a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('employee-masters.index') }}">
        <i class="fas fa-database"></i>
    </a>
@endsection
@section('content-grid', 'col-md-12 col-lg-12 ')

@section('content')
    <style>

        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;

        }

        #table td,
        #table th {
            border: 1px solid black;
            padding: 5px;
        }

        #table tr:nth-child(even) {
            /* background-color: #f2f2f2; */
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #ffffff;
        }


        .text-center {
            text-align: center;
        }

        .text-center {
            text-align: center;
        }


        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        #table,
        #table td,
        #table th {
            padding: 5px;
            border-collapse: collapse;
            border: 1px solid black;

        }

        td{
            text-align: left;
        }
        .nowrap {
            white-space: nowrap !important;
        }

    </style>
    <div id="main" class="container">
        {{-- <div class="container"> --}}
        <table id="table">
            <thead>
                <tr>
                    <th colspan="6" style="background-color: #f0f5f5; color:black">Personal Information</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th style="text-align: left">Code:</th>
                    <td> {{ $employeeData->emp_code }} </td>
                    <th style="text-align: left">Name:</th>
                    <td>{{ $employeeData->emp_name }}</td>
                    <td rowspan="3" colspan="2" style="width:72px; height: 72px; text-align:center">
                        <img src="/emp_img/{{ $employeeData->emp_img_url }}" alt="Employee Profile Image" width="70px"
                            height="70px">
                    </td>
                </tr>
                <tr>
                    <th style="text-align: left">Department:</th>
                    <td>{{ $employeeData->department?->name }}</td>
                    <th style="text-align: left">Designation:</th>
                    <td>{{ $employeeData->designation->name }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Job Location:</th>
                    <td>{{ $employeeData->jobLocation?->name }}</td>
                    <th style="text-align: left">Employee Type:</th>
                    <td>{{ $employeeData->employee_type?->name }}</td>

                </tr>
                <tr>
                    <th style="text-align: left">Shift:</th>
                    <td>{{ $employeeData->shift?->name }}</td>
                    <th style="text-align: left">Section:</th>
                    <td>{{ $employeeData->section?->name }}</td>
                    <th style="text-align: left">Sub Section:</th>
                    <td>{{ $employeeData->sub_section?->name }}</td>
                    {{-- <th style="text-align: left">Phone:</th>
                        <td>
                            {{ $employeeData->phone_1 }}{{ $employeeData->phone_2 ? ', ' . $employeeData->phone_2 : '' }}
                        </td> --}}
                    {{-- <th style="text-align: left">Join Date:</th>
                        <td>{{ $employeeData->birth_date }}</td> --}}
                </tr>
                <tr>
                    <th style="text-align: left">Unit:</th>
                    <td>{{ $employeeData->unit?->name }}</td>
                    <th style="text-align: left">Floor:</th>
                    <td>{{ $employeeData->floor?->name }}</td>
                    <th style="text-align: left">Line:</th>
                    <td>{{ $employeeData->line?->name }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Date of Birth:</th>
                    <td>{{ $employeeData->birth_date }}</td>
                    <th style="text-align: left">Join Date:</th>
                    <td>{{ $employeeData->join_date }}</td>
                    <th style="text-align: left">Increment Date:</th>
                    <td>{{ $employeeData->increment_date }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Promotion Date:</th>
                    <td>{{ $employeeData->promotion_date }}</td>
                    <th style="text-align: left">Confirmation Date:</th>
                    <td>{{ $employeeData->confirm_date }}</td>
                    <th style="text-align: left">Grade</th>
                    <td>{{ $employeeData->employee_detail?->grade?->name }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Nationality:</th>
                    <td>{{ $employeeData->employee_detail?->nationality }}</td>
                    <th style="text-align: left">Gender:</th>
                    <td>{{ $employeeData->gender?->name }}</td>
                    <th style="text-align: left">Religion:</th>
                    <td>{{ $employeeData->religion?->name }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Blood Group</th>
                    <td>{{ $employeeData->bllod_group }}</td>
                    <th style="text-align: left">Height:</th>
                    <td>{{ $employeeData->employee_detail?->height }}</td>
                    <th style="text-align: left">Weight:</th>
                    <td>{{ $employeeData->employee_detail?->weight }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">NID:</th>
                    <td>{{ $employeeData->nid_no }}</td>
                    <th style="text-align: left">Chairman Certificate No :</th>
                    <td>{{ $employeeData->employee_detail?->chairman_certificate_no }}</td>
                    <th style="text-align: left">Birth Certificate</th>
                    <td>{{ $employeeData->employee_detail?->birth_certificate }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Passport No :</th>
                    <td>{{ $employeeData->employee_detail?->passport_no }}</td>
                    <th style="text-align: left">Tin No.</th>
                    <td>{{ $employeeData->employee_detail?->tin_no }}</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <th style="text-align: left">Email :</th>
                    <td>{{ $employeeData->email }}</td>
                    <th style="text-align: left">Phone 1</th>
                    <td>{{ $employeeData->phone_1 }}</td>
                    <th style="text-align: left">Phone 2</th>
                    <td>{{ $employeeData->phone_2 }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Emergency Contact Name :</th>
                    <td>{{ $employeeData->employee_detail?->emergency_contact_name }}</td>
                    <th style="text-align: left">Emergency Contact No. </th>
                    <td>{{ $employeeData->employee_detail?->emergency_contact_number }}</td>
                    {{-- <th style="text-align: left"></th>
                        <td>{{ $employeeData->phone_2 }}</td> --}}
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <th style="text-align: left">Over Time :</th>
                    <td>{{ $employeeData->is_ot_allow == 1 ? 'YES' : 'NO' }}</td>
                    <th style="text-align: left">Bonus:</th>
                    <td>{{ $employeeData->is_bonus == 1 ? 'YES' : 'NO' }}</td>
                    <th style="text-align: left">Holiday:</th>
                    <td>{{ $employeeData->is_holiday == 1 ? 'YES' : 'NO' }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Night Shift :</th>
                    <td>{{ $employeeData->is_night_allow == 1 ? 'YES' : 'NO' }}</td>
                    <th style="text-align: left">Providant Fund:</th>
                    <td>{{ $employeeData->employee_detail?->is_allow_pf == 1 ? 'YES' : 'NO' }}</td>
                    <th style="text-align: left">Police Varified:</th>
                    <td>{{ $employeeData->is_police_verify == 1 ? 'YES' : 'NO' }}</td>
                </tr>
            </tbody>
        </table>
        <br><br>
        @php
            $employeeData->employee_address = collect($employeeData->employee_address)->groupBy('address_type');
        @endphp
        <table id="table">
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #f0f5f5; color:black">Employee Address</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th colspan="2">Permanent Address</th>
                    <th colspan="2">Present Address</th>
                </tr>
                <tr>
                    <th style="text-align: left">Division: </th>
                    <td>{{ $employeeData->employee_address['permanent'][0]['division']['name'] ?? '' }}</td>
                    <th style="text-align: left">Division: </th>
                    <td>{{ $employeeData->employee_address['present'][0]['division']['name'] ?? ' ' }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">District: </th>
                    <td>{{ $employeeData->employee_address['permanent'][0]['district']['name'] ?? '' }}</td>
                    <th style="text-align: left">District: </th>
                    <td>{{ $employeeData->employee_address['present'][0]['district']['name'] ?? '' }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Post Office: </th>
                    <td>{{ $employeeData->employee_address['permanent'][0]['post_office']['name']?? ''  }}</td>
                    <th style="text-align: left">Post Office: </th>
                    <td>{{ $employeeData->employee_address['present'][0]['post_office']['name']?? ''  }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Police Station: </th>
                    <td>{{ $employeeData->employee_address['permanent'][0]['police_station']['name']?? ''  }}</td>
                    <th style="text-align: left">Police Station: </th>
                    <td>{{ $employeeData->employee_address['present'][0]['police_station']['name']?? ''  }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Address Detail: </th>
                    <td>{{ $employeeData->employee_address['permanent'][0]['address'] ?? '' }}</td>
                    <th style="text-align: left">Address Detail: </th>
                    <td>{{ $employeeData->employee_address['present'][0]['address'] ?? '' }}</td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        <table id="table">
            <thead>
                <tr>
                    <th colspan="2" style="background-color: #f0f5f5; color:black">Employee Bank Information</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th style="text-align: left; width: 50%; ">Pay Mode: </th>
                    <td style="width: 50%;">{{ $employeeData->employee_bank_info?->paymode?->name }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Bank: </th>
                    <td>{{ $employeeData->employee_bank_info?->bank?->name }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Branch: </th>
                    <td>{{ $employeeData->employee_bank_info?->branch?->name }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Routing Number: </th>
                    <td>{{ $employeeData->employee_bank_info?->routing_number }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Account Number: </th>
                    <td>{{ $employeeData->employee_bank_info?->account_number }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Account Name: </th>
                    <td>{{ $employeeData->employee_bank_info?->account_name }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Account Type: </th>
                    <td>{{ $employeeData->employee_bank_info?->account_type }}</td>
                </tr>
            </tbody>
        </table>

        <br> <br>
        <table id="table">
            <thead>
                <tr>
                    <th style="background-color: #f0f5f5; color:black" colspan="6">Employee Family Information</th>
                </tr>
            </thead>
            <tbody>
                {{-- <tr>
                        <th colspan="6" style="text-align: center;">Father Information</th>
                    </tr> --}}
                <tr>
                    <th style="text-align: left;">Father Name: </th>
                    <td>{{ $employeeData->employee_family_info?->father_name }}</td>
                    <th style="text-align: left;">Father NID: </th>
                    <td>{{ $employeeData->employee_family_info?->father_nid }}</td>
                    <th style="text-align: left;">Father Mobile: </th>
                    <td>{{ $employeeData->employee_family_info?->father_mobile }}</td>
                </tr>
                {{-- <tr>
                        <th colspan="6" style="text-align: center;">Mother Information</th>
                    </tr> --}}
                <tr>
                    <th style="text-align: left;">Mother Name: </th>
                    <td>{{ $employeeData->employee_family_info?->mother_name }}</td>
                    <th style="text-align: left;">Mother NID: </th>
                    <td>{{ $employeeData->employee_family_info?->mother_nid }}</td>
                    <th style="text-align: left;">Mother Mobile: </th>
                    <td>{{ $employeeData->employee_family_info?->mother_mobile }}</td>
                </tr>
                {{-- <tr>
                        <th colspan="6" style="text-align: center;">Mother Information</th>
                    </tr> --}}
                <tr>
                    <th style="text-align: left;">Married Status</th>
                    <td>
                        @if ($employeeData->employee_family_info?->is_married == 1)
                            {{'Married'}}
                        @elseif($employeeData->employee_family_info?->is_married == 0)
                           {{"Unmarried"}}
                        @endif
                    </td>
                    <th style="text-align: left;">Number of Children</th>
                    <td>{{ $employeeData->employee_family_info?->child_number }}</td>
                </tr>
                @if ($employeeData->employee_family_info?->is_married == 1)
                    <tr>
                        <th style="text-align: left;">Spouse Name: </th>
                        <td>{{ $employeeData->employee_family_info?->spouse_name }}</td>
                        <th style="text-align: left;">Spouse NID: </th>
                        <td>{{ $employeeData->employee_family_info?->spouse_nid }}</td>
                        <th style="text-align: left;">Spouse Mobile: </th>
                        <td>{{ $employeeData->employee_family_info?->spouse_mobile }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <br><br>
        <table id="table">
            <thead>
                <tr>
                    <th style="background-color: #f0f5f5; color:black" colspan="4">Employee Nominee Information</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employeeData->employee_nominee_info as $key => $nominee)
                    <tr>
                        <th colspan="4">Nominee No {{ $key + 1 }}</th>
                    </tr>
                    <tr>
                        <th style="text-align: left">Name</th>
                        <td>{{ $nominee->nominee_name }}</td>
                        <th style="text-align: left">Date of Birth</th>
                        <td>{{ $nominee->nominee_dob }}</td>
                    </tr>
                    <tr>
                        <th style="text-align: left">Profession</th>
                        <td>{{ $nominee->nominee_profession }}</td>
                        <th style="text-align: left">Mobile</th>
                        <td>{{ $nominee->nominee_mobile }}</td>
                    </tr>
                    <tr>
                        <th style="text-align: left">NID</th>
                        <td>{{ $nominee->nominee_nid }}</td>
                        <th style="text-align: left">Relation</th>
                        <td>{{ $nominee->nominee_relation }}</td>
                    </tr>
                    <tr>
                        <th style="text-align: left">Nominee Percentage</th>
                        <td>{{ $nominee->nominee_percentage }}</td>
                        <th style="text-align: left">Address</th>
                        <td>{{ $nominee->nominee_address }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br><br>
        <table id="table">
            <thead>
                <tr>
                    <th style="background-color: #f0f5f5; color:black" colspan="6">Employee Education</th>
                </tr>
                <tr>
                    <th>Exam</th>
                    <th>Grade</th>
                    <th>Board</th>
                    <th>Institute</th>
                    <th>Passing Year</th>
                    <th>Major</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employeeData->employee_education as $key => $education)
                    <tr>
                        <td style="text-align: center">{{ $education->exam_name }}</td>
                        <td style="text-align: center">{{ $education->exam_result }}</td>
                        <td style="text-align: center">{{ $education->board_name }}</td>
                        <td style="text-align: center">{{ $education->institute_name }}</td>
                        <td style="text-align: center">{{ $education->passing_year }}</td>
                        <td style="text-align: center">{{ $education->major }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br><br>
        <table id="table">
            <thead>
                <tr>
                    <th style="background-color: #f0f5f5; color:black" colspan="5">Employee Experience</th>
                </tr>
                <tr>
                    <th>Company Name</th>
                    <th>Designation</th>
                    <th>Salary</th>
                    <th>From</th>
                    <th>To</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employeeData->employee_experience as $key => $experience)
                    <tr>
                        <td style="text-align: center">{{ $experience->company_name }}</td>
                        <td style="text-align: center">{{ $experience->designation }}</td>
                        <td style="text-align: center">{{ $experience->salary }}</td>
                        <td style="text-align: center">{{ $experience->from_date }}</td>
                        <td style="text-align: center">{{ $experience->to_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- </div> --}}
    </div>

@endsection
